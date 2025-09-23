@extends('layouts.dashboard')

@section('title', 'Quincunx Planting Calculator')
@section('page-title', 'Quincunx Planting Calculator')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Quincunx Calculator</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-th-large me-2"></i>
                        Quincunx Planting Calculator
                    </h4>
                    <p class="mb-0 mt-2 opacity-75">
                        Calculate optimal plant spacing using the quincunx pattern for maximum space utilization
                    </p>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('calculate.quincunx') }}">
                        @csrf
                        <div class="row">
                            <!-- Area Dimensions -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-ruler-combined me-2"></i>Area Dimensions
                                </h5>
                                
                                <div class="row mb-3">
                                    <div class="col-8">
                                        <label for="areaLength" class="form-label">Length</label>
                                        <input type="number" step="0.01" min="0.01" class="form-control" 
                                               id="areaLength" name="areaLength" 
                                               value="{{ old('areaLength', $inputs['areaLength'] ?? '') }}" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="lengthUnit" class="form-label">Unit</label>
                                        <select class="form-select" id="lengthUnit" name="lengthUnit">
                                            <option value="m" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? '') == 'm') ? 'selected' : '' }}>Meters</option>
                                            <option value="ft" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? '') == 'ft') ? 'selected' : '' }}>Feet</option>
                                            <option value="cm" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? '') == 'cm') ? 'selected' : '' }}>Centimeters</option>
                                            <option value="in" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? '') == 'in') ? 'selected' : '' }}>Inches</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-8">
                                        <label for="areaWidth" class="form-label">Width</label>
                                        <input type="number" step="0.01" min="0.01" class="form-control" 
                                               id="areaWidth" name="areaWidth" 
                                               value="{{ old('areaWidth', $inputs['areaWidth'] ?? '') }}" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="widthUnit" class="form-label">Unit</label>
                                        <select class="form-select" id="widthUnit" name="widthUnit">
                                            <option value="m" {{ (old('widthUnit', $inputs['widthUnit'] ?? '') == 'm') ? 'selected' : '' }}>Meters</option>
                                            <option value="ft" {{ (old('widthUnit', $inputs['widthUnit'] ?? '') == 'ft') ? 'selected' : '' }}>Feet</option>
                                            <option value="cm" {{ (old('widthUnit', $inputs['widthUnit'] ?? '') == 'cm') ? 'selected' : '' }}>Centimeters</option>
                                            <option value="in" {{ (old('widthUnit', $inputs['widthUnit'] ?? '') == 'in') ? 'selected' : '' }}>Inches</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Plant Spacing -->
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-seedling me-2"></i>Plant Spacing
                                </h5>
                                
                                <div class="row mb-3">
                                    <div class="col-8">
                                        <label for="plantSpacing" class="form-label">Plant Spacing</label>
                                        <input type="number" step="0.01" min="0.01" class="form-control" 
                                               id="plantSpacing" name="plantSpacing" 
                                               value="{{ old('plantSpacing', $inputs['plantSpacing'] ?? '') }}" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="spacingUnit" class="form-label">Unit</label>
                                        <select class="form-select" id="spacingUnit" name="spacingUnit">
                                            <option value="m" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? '') == 'm') ? 'selected' : '' }}>Meters</option>
                                            <option value="ft" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? '') == 'ft') ? 'selected' : '' }}>Feet</option>
                                            <option value="cm" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? '') == 'cm') ? 'selected' : '' }}>Centimeters</option>
                                            <option value="in" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? '') == 'in') ? 'selected' : '' }}>Inches</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-8">
                                        <label for="borderSpacing" class="form-label">Border Spacing</label>
                                        <input type="number" step="0.01" min="0" class="form-control" 
                                               id="borderSpacing" name="borderSpacing" 
                                               value="{{ old('borderSpacing', $inputs['borderSpacing'] ?? '0') }}">
                                    </div>
                                    <div class="col-4">
                                        <label for="borderUnit" class="form-label">Unit</label>
                                        <select class="form-select" id="borderUnit" name="borderUnit">
                                            <option value="m" {{ (old('borderUnit', $inputs['borderUnit'] ?? '') == 'm') ? 'selected' : '' }}>Meters</option>
                                            <option value="ft" {{ (old('borderUnit', $inputs['borderUnit'] ?? '') == 'ft') ? 'selected' : '' }}>Feet</option>
                                            <option value="cm" {{ (old('borderUnit', $inputs['borderUnit'] ?? '') == 'cm') ? 'selected' : '' }}>Centimeters</option>
                                            <option value="in" {{ (old('borderUnit', $inputs['borderUnit'] ?? '') == 'in') ? 'selected' : '' }}>Inches</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Optional Fields -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Additional Information (Optional)
                                </h5>
                            </div>
                            <div class="col-md-4">
                                <label for="calculation_name" class="form-label">Calculation Name</label>
                                <input type="text" class="form-control" name="calculation_name" id="calculation_name"
                                       value="{{ old('calculation_name') }}" placeholder="e.g., Tomato Field A">
                            </div>
                            <div class="col-md-4">
                                <label for="plant_type" class="form-label">Plant Type</label>
                                <input type="text" class="form-control" name="plant_type" id="plant_type"
                                       value="{{ old('plant_type') }}" placeholder="e.g., Tomato, Lettuce, Corn">
                            </div>
                            <div class="col-md-4">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea class="form-control" name="notes" id="notes" rows="1" 
                                          placeholder="Optional notes">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-calculator me-2"></i>Calculate Quincunx Pattern
                            </button>
                        </div>
                    </form>
                    
                    @if(isset($results))
                    <div class="results-section mt-5">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-chart-bar me-2"></i>Calculation Results
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="result-item mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Total Plants:</span>
                                                <span class="badge bg-primary fs-6">{{ number_format($results['totalPlants']) }}</span>
                                            </div>
                                        </div>
                                        <div class="result-item mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Plants Per Row:</span>
                                                <span class="badge bg-info fs-6">{{ number_format($results['plantsPerRow']) }}</span>
                                            </div>
                                        </div>
                                        <div class="result-item mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Number of Rows:</span>
                                                <span class="badge bg-info fs-6">{{ number_format($results['numberOfRows']) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="result-item mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Effective Area:</span>
                                                <span class="badge bg-warning text-dark fs-6">{{ number_format($results['effectiveArea'], 2) }} m²</span>
                                            </div>
                                        </div>
                                        <div class="result-item mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Planting Density:</span>
                                                <span class="badge bg-success fs-6">{{ number_format($results['plantingDensity'], 2) }} plants/m²</span>
                                            </div>
                                        </div>
                                        <div class="result-item mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">Space Utilization:</span>
                                                <span class="badge bg-secondary fs-6">{{ number_format($results['spaceUtilization'], 1) }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Quincunx Pattern Visualization -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-eye me-2"></i>Quincunx Pattern Visualization
                                </h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="pattern-explanation mb-3">
                                    <p class="text-muted">
                                        The quincunx pattern staggers plants in alternating rows, optimizing space usage 
                                        compared to a standard grid pattern.
                                    </p>
                                </div>
                                
                                <div class="pattern-demo">
                                    <div class="row justify-content-center">
                                        <div class="col-auto">
                                            <div class="quincunx-demo">
                                                <!-- Row 1 -->
                                                <div class="demo-row d-flex justify-content-center mb-2">
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot"></div>
                                                </div>
                                                <!-- Row 2 (offset) -->
                                                <div class="demo-row d-flex justify-content-center mb-2" style="margin-left: 15px;">
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot"></div>
                                                </div>
                                                <!-- Row 3 -->
                                                <div class="demo-row d-flex justify-content-center mb-2">
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot me-3"></div>
                                                    <div class="plant-dot"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.result-item {
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
    border-left: 4px solid var(--plant-green);
}

.plant-dot {
    width: 20px;
    height: 20px;
    background-color: var(--plant-green);
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.quincunx-demo {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    border: 2px dashed #dee2e6;
    display: inline-block;
}

.pattern-explanation {
    max-width: 600px;
    margin: 0 auto;
}
</style>
@endpush