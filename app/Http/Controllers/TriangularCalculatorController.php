<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantCalculation;

class TriangularCalculatorController extends Controller
{
    public function index()
    {
        return view('calculator.triangular');
    }

    public function calculate(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'area_length' => 'required|numeric|min:0.01',
            'area_length_unit' => 'required|in:cm,m,ft',
            'area_width' => 'required|numeric|min:0.01',
            'area_width_unit' => 'required|in:cm,m,ft',
            'plant_spacing' => 'required|numeric|min:0.01',
            'plant_spacing_unit' => 'required|in:cm,m,ft',
            'border_spacing' => 'nullable|numeric|min:0',
            'border_spacing_unit' => 'nullable|in:cm,m,ft',
            'plant_type' => 'nullable|string|max:255',
            'calculation_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000'
        ]);

        // Convert all inputs to meters
        $lengthInMeters = $this->convertToMeters($validated['area_length'], $validated['area_length_unit']);
        $widthInMeters = $this->convertToMeters($validated['area_width'], $validated['area_width_unit']);
        $spacingInMeters = $this->convertToMeters($validated['plant_spacing'], $validated['plant_spacing_unit']);
        $borderInMeters = isset($validated['border_spacing']) && isset($validated['border_spacing_unit']) ? 
                            $this->convertToMeters($validated['border_spacing'], $validated['border_spacing_unit']) : 0;

        try {
            $plan = $this->calculateTriangularPlanting($lengthInMeters, $widthInMeters, $spacingInMeters, $borderInMeters);

            // Calculate total area in square meters
            $totalAreaSqMeters = $lengthInMeters * $widthInMeters;

            // Save calculation to database
            PlantCalculation::create([
                'user_id' => auth()->id(),
                'plant_type' => $validated['plant_type'] ?? 'Unknown',
                'area_length' => $validated['area_length'],
                'area_length_unit' => $validated['area_length_unit'],
                'area_width' => $validated['area_width'],
                'area_width_unit' => $validated['area_width_unit'],
                'plant_spacing' => $validated['plant_spacing'],
                'plant_spacing_unit' => $validated['plant_spacing_unit'],
                'border_spacing' => $validated['border_spacing'] ?? 0,
                'border_spacing_unit' => $validated['border_spacing_unit'] ?? 'm',
                'total_plants' => $plan['totalPlants'],
                'rows' => $plan['rows'],
                'columns' => $plan['averagePlantsPerRow'],
                'effective_length' => $plan['effectiveLength'],
                'effective_width' => $plan['effectiveWidth'],
                'total_area' => $totalAreaSqMeters,
                'calculation_name' => $validated['calculation_name'] ?? 'Triangular Planting',
                'notes' => $validated['notes'],
            ]);

            // Convert effective area dimensions back to original units
            $plan['effectiveLength'] = $this->convertFromMeters($plan['effectiveLength'], $validated['area_length_unit']);
            $plan['effectiveWidth'] = $this->convertFromMeters($plan['effectiveWidth'], $validated['area_width_unit']);

            return view('calculator.triangular')->with([
                'results' => $plan,
                'oldInput' => $request->all()
            ])->with('success', 'Triangular planting calculation completed and saved successfully!');
        } catch (\Exception $e) {
            return redirect()->route('triangular.calculator')
                             ->withInput()
                             ->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function calculateTriangularPlanting($length, $width, $spacing, $border = 0)
    {
        $effectiveLength = $length - (2 * $border);
        $effectiveWidth = $width - (2 * $border);

        if ($effectiveLength <= 0 || $effectiveWidth <= 0) {
            throw new \Exception("The border spacing is too large for the given area.");
        }

        if ($spacing > $effectiveLength || $spacing > $effectiveWidth) {
            throw new \Exception("Plant spacing is too large for the effective area.");
        }

        // For triangular (hexagonal) packing, rows are offset
        // Row height in triangular pattern = spacing * sqrt(3)/2
        $rowHeight = $spacing * sqrt(3) / 2;
        
        // Calculate number of rows
        $rows = floor($effectiveWidth / $rowHeight) + 1;
        
        // Calculate plants per row (alternating between full and offset rows)
        $plantsPerFullRow = floor($effectiveLength / $spacing) + 1;
        $plantsPerOffsetRow = floor(($effectiveLength - $spacing/2) / $spacing) + 1;
        
        // Ensure offset row doesn't have more plants than effective space allows
        if ($plantsPerOffsetRow < 0) {
            $plantsPerOffsetRow = 0;
        }
        
        // Calculate total plants considering alternating pattern
        $fullRows = ceil($rows / 2);
        $offsetRows = floor($rows / 2);
        
        $totalPlants = ($fullRows * $plantsPerFullRow) + ($offsetRows * $plantsPerOffsetRow);
        
        // Calculate average plants per row for display
        $averagePlantsPerRow = $rows > 0 ? round($totalPlants / $rows, 1) : 0;
        
        // Calculate space efficiency compared to square planting
        $squarePlants = (floor($effectiveLength / $spacing) + 1) * (floor($effectiveWidth / $spacing) + 1);
        $efficiency = $squarePlants > 0 ? round(($totalPlants / $squarePlants) * 100, 1) : 0;

        return [
            'totalPlants' => $totalPlants,
            'rows' => $rows,
            'plantsPerFullRow' => $plantsPerFullRow,
            'plantsPerOffsetRow' => $plantsPerOffsetRow,
            'averagePlantsPerRow' => $averagePlantsPerRow,
            'effectiveLength' => $effectiveLength,
            'effectiveWidth' => $effectiveWidth,
            'rowHeight' => $rowHeight,
            'spaceEfficiency' => $efficiency,
            'spacingSaved' => $squarePlants > 0 ? $totalPlants - $squarePlants : 0
        ];
    }

    private function convertToMeters($value, $unit)
    {
        switch ($unit) {
            case 'cm': return $value / 100;
            case 'm': return $value;
            case 'ft': return $value * 0.3048;
            default: throw new \Exception("Invalid unit: $unit");
        }
    }

    private function convertFromMeters($value, $unit)
    {
        switch ($unit) {
            case 'cm': return round($value * 100, 2);
            case 'm': return round($value, 2);
            case 'ft': return round($value / 0.3048, 2);
            default: return round($value, 2);
        }
    }
}