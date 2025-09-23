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
        <div class="col-lg-8">
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
                        
                        <!-- Area Length -->
                        <div class="mb-3 row align-items-center">
                            <label for="areaLength" class="col-sm-3 col-form-label">Area Length:</label>
                            <div class="col-sm-5">
                                <input type="number" step="0.01" min="0.01" required
                                       class="form-control" name="areaLength" id="areaLength"
                                       value="{{ old('areaLength') }}">
                            </div>
                            <div class="col-sm-4">
                                <select name="lengthUnit" class="form-select" required>
                                    <option value="m" {{ old('lengthUnit', 'm') == 'm' ? 'selected' : '' }}>Meters</option>
                                    <option value="ft" {{ old('lengthUnit') == 'ft' ? 'selected' : '' }}>Feet</option>
                                    <option value="cm" {{ old('lengthUnit') == 'cm' ? 'selected' : '' }}>Centimeters</option>
                                </select>
                            </div>
                        </div>

                        <!-- Area Width -->
                        <div class="mb-3 row align-items-center">
                            <label for="areaWidth" class="col-sm-3 col-form-label">Area Width:</label>
                            <div class="col-sm-5">
                                <input type="number" step="0.01" min="0.01" required
                                       class="form-control" name="areaWidth" id="areaWidth"
                                       value="{{ old('areaWidth') }}">
                            </div>
                            <div class="col-sm-4">
                                <select name="widthUnit" class="form-select" required>
                                    <option value="m" {{ old('widthUnit', 'm') == 'm' ? 'selected' : '' }}>Meters</option>
                                    <option value="ft" {{ old('widthUnit') == 'ft' ? 'selected' : '' }}>Feet</option>
                                    <option value="cm" {{ old('widthUnit') == 'cm' ? 'selected' : '' }}>Centimeters</option>
                                </select>
                            </div>
                        </div>

                        <!-- Plant Spacing -->
                        <div class="mb-3 row align-items-center">
                            <label for="plantSpacing" class="col-sm-3 col-form-label">Plant Spacing:</label>
                            <div class="col-sm-5">
                                <input type="number" step="0.01" min="0.01" required
                                       class="form-control" name="plantSpacing" id="plantSpacing"
                                       value="{{ old('plantSpacing') }}">
                            </div>
                            <div class="col-sm-4">
                                <select name="spacingUnit" class="form-select" required>
                                    <option value="cm" {{ old('spacingUnit', 'cm') == 'cm' ? 'selected' : '' }}>Centimeters</option>
                                    <option value="m" {{ old('spacingUnit') == 'm' ? 'selected' : '' }}>Meters</option>
                                    <option value="ft" {{ old('spacingUnit') == 'ft' ? 'selected' : '' }}>Feet</option>
                                </select>
                            </div>
                        </div>

                        <!-- Border Spacing -->
                        <div class="mb-3 row align-items-center">
                            <label for="borderSpacing" class="col-sm-3 col-form-label">Border Spacing:</label>
                            <div class="col-sm-5">
                                <input type="number" step="0.01" min="0"
                                       class="form-control" name="borderSpacing" id="borderSpacing"
                                       value="{{ old('borderSpacing', 0) }}">
                            </div>
                            <div class="col-sm-4">
                                <select name="borderUnit" class="form-select">
                                    <option value="cm" {{ old('borderUnit', 'cm') == 'cm' ? 'selected' : '' }}>Centimeters</option>
                                    <option value="m" {{ old('borderUnit') == 'm' ? 'selected' : '' }}>Meters</option>
                                    <option value="ft" {{ old('borderUnit') == 'ft' ? 'selected' : '' }}>Feet</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-calculator me-2"></i>Calculate Quincunx Pattern
                            </button>
                        </div>
                    </form>

                    @if(isset($results))
                    <div class="mt-5">
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
                                            <strong>Total Plants:</strong>
                                            <span class="badge bg-primary fs-6">{{ number_format($results['totalPlants']) }}</span>
                                        </div>
                                        <div class="result-item mb-3">
                                            <strong>Plants per Row:</strong>
                                            <span>{{ $results['plantsPerRow'] }}</span>
                                        </div>
                                        <div class="result-item mb-3">
                                            <strong>Number of Rows:</strong>
                                            <span>{{ $results['numberOfRows'] }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="result-item mb-3">
                                            <strong>Effective Area:</strong>
                                            <span>{{ round($results['effectiveArea'], 2) }} m²</span>
                                        </div>
                                        <div class="result-item mb-3">
                                            <strong>Planting Density:</strong>
                                            <span>{{ $results['plantingDensity'] }} plants/m²</span>
                                        </div>
                                        <div class="result-item mb-3">
                                            <strong>Space Utilization:</strong>
                                            <span>{{ $results['spaceUtilization'] }}%</span>
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

<style>
.result-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.result-item:last-child {
    border-bottom: none;
}
</style>
@endsection