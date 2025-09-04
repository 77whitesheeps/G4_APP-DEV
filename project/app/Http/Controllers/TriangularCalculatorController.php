<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TriangularCalculatorController extends Controller
{
    private $unitConversions = [
        'm' => 1,
        'cm' => 0.01,
        'ft' => 0.3048,
    ];

    public function showForm()
    {
        return view('triangular-form');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'length' => 'required|numeric|min:0.1',
            'length_unit' => 'required|string',
            'width' => 'required|numeric|min:0.1',
            'width_unit' => 'required|string',
            'border' => 'required|numeric|min:0',
            'border_unit' => 'required|string',
            'spacing' => 'required|numeric|min:0.1',
            'spacing_unit' => 'required|string'
        ]);

        // Convert inputs to meters
        $length = $request->length * $this->unitConversions[$request->length_unit];
        $width = $request->width * $this->unitConversions[$request->width_unit];
        $border = $request->border * $this->unitConversions[$request->border_unit];
        $spacing = $request->spacing * $this->unitConversions[$request->spacing_unit];

        // Effective planting area (subtracting border on all sides)
        $usableLength = max(0, $length - 2 * $border);
        $usableWidth = max(0, $width - 2 * $border);
        $areaM2 = $usableLength * $usableWidth;

        // Triangular planting calculation
        $areaPerPlant = (sqrt(3) / 2) * pow($spacing, 2);
        $numPlants = $areaPerPlant > 0 ? $areaM2 / $areaPerPlant : 0;

        return view('triangular-form', [
            'inputs' => $request->all(),
            'area' => round($areaM2, 2),
            'plants' => round($numPlants)
        ]);
    }
}
