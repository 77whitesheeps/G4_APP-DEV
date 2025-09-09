<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;


class PlanController extends Controller
{
    public function savePlan(Request $request)
    {
        //validate input
        $request->validate([
            'plan_name' => 'required|string|max:255',
            'area_shape' => 'required|string|max:50',
            'planting_system' => 'required|string|max:50',
            'plant_spacing' => 'nullable|numeric',
            'num_plants' => 'nullable|integer',
        ]);

        //save plan
        $plan = Plan::create([
            'user_id' => Auth::id(),  // current logged-in user
            'plan_name' => $request->plan_name,
            'area_shape' => $request->area_shape,
            'planting_system' => $request->planting_system,
            'plant_spacing' => $request->plant_spacing,
            'num_plants' => $request->num_plants,
        ]);

        return redirect()->back()->with('success', 'Plan saved successfully!');
}
}