@extends('layouts.dashboard')

@section('title', 'Planting Calculator')
@section('page-title', 'Square Planting System Calculator')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Planting Calculator</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-dashboard">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calculator text-success me-2"></i>Calculate Plant Spacing
                    </h5>
                </div>
                <div class="card-body">

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

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-1"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-plant">
                                <i class="fas fa-calculator me-1"></i>Calculate
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Panel -->
        <div class="col-lg-4">
            @if(isset($results))
            <div class="card card-dashboard">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Calculation Results
                    </h5>
                </div>
                <div class="card-body">
                    <div class="result-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Total Plants:</span>
                            <span class="h4 text-success mb-0">{{ $results['totalPlants'] }}</span>
                        </div>
                    </div>
                    
                    <div class="result-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Rows:</span>
                            <span class="h5 mb-0">{{ $results['rows'] }}</span>
                        </div>
                    </div>
                    
                    <div class="result-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Columns:</span>
                            <span class="h5 mb-0">{{ $results['columns'] }}</span>
                        </div>
                    </div>
                    
                    <div class="result-item mb-3">
                        <div class="text-muted mb-2">Effective Planting Area:</div>
                        <div class="small">
                            <strong>Length:</strong> {{ $results['effectiveLength'] }} (length unit)<br>
                            <strong>Width:</strong> {{ $results['effectiveWidth'] }} (width unit)
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-save me-1"></i>Save Calculation
                        </button>
                        <button class="btn btn-outline-info btn-sm">
                            <i class="fas fa-download me-1"></i>Export Results
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div class="card card-dashboard">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-info me-2"></i>Instructions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="instruction-item mb-3">
                        <h6><i class="fas fa-ruler text-primary me-2"></i>Area Dimensions</h6>
                        <p class="small text-muted">Enter the length and width of your planting area with appropriate units.</p>
                    </div>
                    
                    <div class="instruction-item mb-3">
                        <h6><i class="fas fa-arrows-alt text-success me-2"></i>Plant Spacing</h6>
                        <p class="small text-muted">Specify the distance between plants based on their mature size.</p>
                    </div>
                    
                    <div class="instruction-item mb-3">
                        <h6><i class="fas fa-border-style text-warning me-2"></i>Border Spacing</h6>
                        <p class="small text-muted">Optional space around the perimeter for maintenance access.</p>
                    </div>
                    
                    <div class="alert alert-light">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        <strong>Tip:</strong> Consider the mature size of your plants when setting spacing distances.
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
