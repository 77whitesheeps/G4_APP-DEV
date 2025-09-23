<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuincunxCalculatorController extends Controller
{
    public function index()
    {
        return view('calculator.quincunx');
    }

    public function calculate(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'areaLength' => 'required|numeric|min:0.01',
            'areaWidth' => 'required|numeric|min:0.01',
            'plantSpacing' => 'required|numeric|min:0.01',
            'borderSpacing' => 'required|numeric|min:0',
            'lengthUnit' => 'required|in:m,ft,cm,in',
            'widthUnit' => 'required|in:m,ft,cm,in',
            'spacingUnit' => 'required|in:m,ft,cm,in',
            'borderUnit' => 'required|in:m,ft,cm,in',
        ]);

        // Convert all to meters for calculation
        $conversionRates = [
            'm' => 1,
            'ft' => 0.3048,
            'cm' => 0.01,
            'in' => 0.0254
        ];

        $lengthM = $validated['areaLength'] * $conversionRates[$validated['lengthUnit']];
        $widthM = $validated['areaWidth'] * $conversionRates[$validated['widthUnit']];
        $plantSpacingM = $validated['plantSpacing'] * $conversionRates[$validated['spacingUnit']];
        $borderSpacingM = $validated['borderSpacing'] * $conversionRates[$validated['borderUnit']];

        // Calculate effective planting area
        $effectiveLength = max(0, $lengthM - 2 * $borderSpacingM);
        $effectiveWidth = max(0, $widthM - 2 * $borderSpacingM);

        if ($effectiveLength <= 0 || $effectiveWidth <= 0 || $plantSpacingM <= 0) {
            return back()->withErrors('Invalid input values. Please check your measurements.')->withInput();
        }

        // Calculate number of plants using quincunx pattern
        $plantsPerRow = floor($effectiveLength / $plantSpacingM) + 1;
        $numberOfRows = floor($effectiveWidth / ($plantSpacingM * sqrt(3)/2)) + 1;
        $totalPlants = $plantsPerRow * $numberOfRows;

        // Calculate additional metrics
        $effectiveArea = $effectiveLength * $effectiveWidth;
        $plantingDensity = $totalPlants / $effectiveArea;
        $spaceUtilization = ($totalPlants * pi() * pow($plantSpacingM/2, 2)) / $effectiveArea * 100;

        // Prepare results
        $results = [
            'totalPlants' => $totalPlants,
            'plantsPerRow' => $plantsPerRow,
            'numberOfRows' => $numberOfRows,
            'effectiveArea' => $effectiveArea,
            'plantingDensity' => $plantingDensity,
            'spaceUtilization' => $spaceUtilization
        ];

        return view('calculator.quincunx', [
            'results' => $results,
            'inputs' => $validated
        ]);
    }
}