@extends('layouts.app')

@section('content')
<style>
    body {
        background: #eaf5e1;
    }
    .btn-plant {
        background-color: #68af2C;
        border-color: #68af2C;
        color: white;
    }
    .btn-plant:hover {
        background-color: #5a9625;
        border-color: #5a9625;
        color: white;
    }
</style>

<div class="container">

    <!-- Centered Card Layout -->
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9 col-md-10">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-5">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h4 text-success font-weight-bold">Square Planting System Calculator</h1>
                    </div>

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Calculator Form -->
                    <form action="{{ route('calculate.plants') }}" method="POST">
                        @csrf

                        {{-- Area Length --}}
                        <div class="mb-3 row align-items-center">
                            <label for="area_length" class="col-sm-4 col-form-label">Area Length:</label>
                            <div class="col-sm-4">
                                <input type="number" step="0.01" min="0.01" required
                                    class="form-control form-control-user" name="area_length" id="area_length"
                                    value="{{ old('area_length') }}">
                            </div>
                            <div class="col-sm-4">
                                <select name="area_length_unit" class="form-select">
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
                            <label for="area_width" class="col-sm-4 col-form-label">Area Width:</label>
                            <div class="col-sm-4">
                                <input type="number" step="0.01" min="0.01" required
                                    class="form-control form-control-user" name="area_width" id="area_width"
                                    value="{{ old('area_width') }}">
                            </div>
                            <div class="col-sm-4">
                                <select name="area_width_unit" class="form-select">
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
                            <label for="plant_spacing" class="col-sm-4 col-form-label">Plant Spacing:</label>
                            <div class="col-sm-4">
                                <input type="number" step="0.01" min="0.01" required
                                    class="form-control form-control-user" name="plant_spacing" id="plant_spacing"
                                    value="{{ old('plant_spacing') }}">
                            </div>
                            <div class="col-sm-4">
                                <select name="plant_spacing_unit" class="form-select">
                                    <option value="cm" {{ old('plant_spacing_unit') == 'cm' ? 'selected' : '' }}>cm</option>
                                    <option value="m" {{ old('plant_spacing_unit', 'm') == 'm' ? 'selected' : '' }}>m</option>
                                    <option value="ft" {{ old('plant_spacing_unit') == 'ft' ? 'selected' : '' }}>ft</option>
                                </select>
                            </div>
                        </div>

                        {{-- Border Spacing --}}
                        <div class="mb-3 row align-items-center">
                            <label for="border_spacing" class="col-sm-4 col-form-label">Border Spacing:</label>
                            <div class="col-sm-4">
                                <input type="number" step="0.01" min="0"
                                    class="form-control form-control-user" name="border_spacing" id="border_spacing"
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

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-plant btn-user btn-block">
                            Calculate
                        </button>
                    </form>

                    <!-- Results -->
                    @if(isset($results))
                        <div class="mt-4 p-4 border rounded bg-light">
                            <h5 class="mb-3 text-success">Results</h5>
                            <p><strong>Total Plants:</strong> {{ $results['totalPlants'] }}</p>
                            <p><strong>Rows:</strong> {{ $results['rows'] }}</p>
                            <p><strong>Columns:</strong> {{ $results['columns'] }}</p>
                            <p><strong>Effective Planting Area:</strong>
                                {{ $results['effectiveLength'] }} (length unit) x {{ $results['effectiveWidth'] }} (width unit)
                            </p>
                        </div>
                    @endif

                </div>
            </div>

            <!-- Logout button -->
            <div class="text-center mb-5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm shadow">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
