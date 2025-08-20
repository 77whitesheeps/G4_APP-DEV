<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlantingCalculatorController extends Controller
{
    public function index()
    {
        return view('planting-calculator');
    }

    public function calculate(Request $request)
    {
        // Validate inputs including units per field
        $validated = $request->validate([
            'area_length' => 'required|numeric|min:0.01',
            'area_length_unit' => 'required|in:cm,m,ft,hectare,acre',
            'area_width' => 'required|numeric|min:0.01',
            'area_width_unit' => 'required|in:cm,m,ft,hectare,acre',
            'plant_spacing' => 'required|numeric|min:0.01',
            'plant_spacing_unit' => 'required|in:cm,m,ft',
            'border_spacing' => 'nullable|numeric|min:0',
            'border_spacing_unit' => 'nullable|in:cm,m,ft'
        ]);

        // Convert all inputs to meters
        $lengthInMeters = $this->convertToMeters($validated['area_length'], $validated['area_length_unit']);
        $widthInMeters = $this->convertToMeters($validated['area_width'], $validated['area_width_unit']);
        $spacingInMeters = $this->convertToMeters($validated['plant_spacing'], $validated['plant_spacing_unit']);
        $borderInMeters = isset($validated['border_spacing']) && isset($validated['border_spacing_unit']) ? 
                            $this->convertToMeters($validated['border_spacing'], $validated['border_spacing_unit']) : 0;

        try {
            $plan = $this->calculateSquarePlanting($lengthInMeters, $widthInMeters, $spacingInMeters, $borderInMeters);

            // Convert effective area dimensions back to the respective units of length and width inputs
            $plan['effectiveLength'] = $this->convertFromMeters($plan['effectiveLength'], $validated['area_length_unit']);
            $plan['effectiveWidth'] = $this->convertFromMeters($plan['effectiveWidth'], $validated['area_width_unit']);

            return view('planting-calculator')->with([
                'results' => $plan,
                'oldInput' => $request->all()
            ]);
        } catch (\Exception $e) {
            return redirect()->route('planting.calculator')
                             ->withInput()
                             ->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function calculateSquarePlanting($length, $width, $spacing, $border = 0)
    {
        $effectiveLength = $length - (2 * $border);
        $effectiveWidth = $width - (2 * $border);

        if ($effectiveLength <= 0 || $effectiveWidth <= 0) {
            throw new \Exception("The border spacing is too large for the given area.");
        }

        if ($spacing > $effectiveLength || $spacing > $effectiveWidth) {
            throw new \Exception("Plant spacing is too large for the effective area.");
        }

        $plantsPerRow = floor($effectiveLength / $spacing) + 1;
        $plantsPerCol = floor($effectiveWidth / $spacing) + 1;
        $totalPlants = $plantsPerRow * $plantsPerCol;

        return [
            'totalPlants' => $totalPlants,
            'rows' => $plantsPerCol,
            'columns' => $plantsPerRow,
            'effectiveLength' => $effectiveLength,
            'effectiveWidth' => $effectiveWidth
        ];
    }

    private function convertToMeters($value, $unit)
    {
        switch ($unit) {
            case 'cm': return $value / 100;
            case 'm': return $value;
            case 'ft': return $value * 0.3048;
            case 'hectare': return sqrt($value * 10000);
            case 'acre': return sqrt($value * 4046.86);
            default: throw new \Exception("Invalid unit");
        }
    }

    private function convertFromMeters($value, $unit)
    {
        switch ($unit) {
            case 'cm': return round($value * 100, 2);
            case 'm': return round($value, 2);
            case 'ft': return round($value / 0.3048, 2);
            case 'hectare': return round(pow($value, 2) / 10000, 4);
            case 'acre': return round(pow($value, 2) / 4046.86, 4);
            default: return $value;
        }
    }
}
