@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Square Planting System Calculator</h1>
        <!-- Temporary Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-sign-out-alt me-1"></i> Logout (Temp Button)
            </button>
        </form>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('calculate.plants') }}" method="POST">
        @csrf

        {{-- Area Length --}}
        <div class="mb-3 row align-items-center">
            <label for="area_length" class="col-sm-3 col-form-label">Area Length:</label>
            <div class="col-sm-5">
                <input type="number" step="0.01" min="0.01" required
                       class="form-control" name="area_length" id="area_length"
                       value="{{ old('area_length') }}">
            </div>
            <div class="col-sm-4">
                <select name="area_length_unit" class="form-select" required>
                    <option value="cm" {{ old('area_length_unit') == 'cm' ? 'selected' : '' }}>cm</option>
                    <option value="m" {{ old('area_length_unit', 'm') == 'm' ? 'selected' : '' }}>m</option>
                    <option value="ft" {{ old('area_length_unit') == 'ft' ? 'selected' : '' }}>ft</option>
                    <option value="hectare" {{ old('area_length_unit') == 'hectare' ? 'selected' : '' }}>hectare</option>
                    <option value="acre" {{ old('area_length_unit') == 'acre' ? 'selected' : '' }}>acre</option>
                </select>
            </div>
        </div>

        {{-- Area Width --}}
        <div class="mb-3 row align-items-center">
            <label for="area_width" class="col-sm-3 col-form-label">Area Width:</label>
            <div class="col-sm-5">
                <input type="number" step="0.01" min="0.01" required
                       class="form-control" name="area_width" id="area_width"
                       value="{{ old('area_width') }}">
            </div>
            <div class="col-sm-4">
                <select name="area_width_unit" class="form-select" required>
                    <option value="cm" {{ old('area_width_unit') == 'cm' ? 'selected' : '' }}>cm</option>
                    <option value="m" {{ old('area_width_unit', 'm') == 'm' ? 'selected' : '' }}>m</option>
                    <option value="ft" {{ old('area_width_unit') == 'ft' ? 'selected' : '' }}>ft</option>
                    <option value="hectare" {{ old('area_width_unit') == 'hectare' ? 'selected' : '' }}>hectare</option>
                    <option value="acre" {{ old('area_width_unit') == 'acre' ? 'selected' : '' }}>acre</option>
                </select>
            </div>
        </div>

        {{-- Plant Spacing --}}
        <div class="mb-3 row align-items-center">
            <label for="plant_spacing" class="col-sm-3 col-form-label">Plant Spacing:</label>
            <div class="col-sm-5">
                <input type="number" step="0.01" min="0.01" required
                       class="form-control" name="plant_spacing" id="plant_spacing"
                       value="{{ old('plant_spacing') }}">
            </div>
            <div class="col-sm-4">
                <select name="plant_spacing_unit" class="form-select" required>
                    <option value="cm" {{ old('plant_spacing_unit') == 'cm' ? 'selected' : '' }}>cm</option>
                    <option value="m" {{ old('plant_spacing_unit', 'm') == 'm' ? 'selected' : '' }}>m</option>
                    <option value="ft" {{ old('plant_spacing_unit') == 'ft' ? 'selected' : '' }}>ft</option>
                </select>
            </div>
        </div>

        {{-- Border Spacing --}}
        <div class="mb-3 row align-items-center">
            <label for="border_spacing" class="col-sm-3 col-form-label">Border Spacing:</label>
            <div class="col-sm-5">
                <input type="number" step="0.01" min="0" 
                       class="form-control" name="border_spacing" id="border_spacing"
                       value="{{ old('border_spacing', 0) }}">
            </div>
            <div class="col-sm-4">
                <select name="border_spacing_unit" class="form-select">
                    <option value="cm" {{ old('border_spacing_unit') == 'cm' ? 'selected' : '' }}>cm</option>
                    <option value="m" {{ old('border_spacing_unit', 'm') == 'm' ? 'selected' : '' }}>m</option>
                    <option value="ft" {{ old('border_spacing_unit') == 'ft' ? 'selected' : '' }}>ft</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Calculate</button>
    </form>

    {{-- Results --}}
    @if(isset($results))
        <div class="mt-4 p-3 border rounded bg-light">
            <h4>Results</h4>
            <p><strong>Total Plants:</strong> {{ $results['totalPlants'] }}</p>
            <p><strong>Rows:</strong> {{ $results['rows'] }}</p>
            <p><strong>Columns:</strong> {{ $results['columns'] }}</p>
            <p><strong>Effective Planting Area:</strong> 
                {{ $results['effectiveLength'] }} (length unit) x {{ $results['effectiveWidth'] }} (width unit)
            </p>
        </div>
    @endif
</div>
@endsection
