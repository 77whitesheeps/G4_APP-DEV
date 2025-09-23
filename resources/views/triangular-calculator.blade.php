@extends('layouts.dashboard')

@section('title', 'Triangular Planting Calculator')
@section('page-title', 'Triangular Planting System Calculator')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Triangular Calculator</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-dashboard">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-play text-primary me-2"></i>Calculate Triangular Plant Layout
                    </h5>
                    <p class="text-muted small mb-0">Hexagonal packing pattern for optimal space utilization</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('calculate.triangular') }}" method="POST">
                        @csrf

                        {{-- Calculation Name --}}
                        <div class="mb-3 row align-items-center">
                            <label for="calculation_name" class="col-sm-3 col-form-label">Calculation Name:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="calculation_name" id="calculation_name"
                                       value="{{ old('calculation_name') }}" placeholder="e.g., Tomato Field A">
                            </div>
                        </div>

                        {{-- Plant Type --}}
                        <div class="mb-3 row align-items-center">
                            <label for="plant_type" class="col-sm-3 col-form-label">Plant Type:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="plant_type" id="plant_type"
                                       value="{{ old('plant_type') }}" placeholder="e.g., Tomato, Lettuce, Corn">
                            </div>
                        </div>

                        <hr class="my-4">

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
                                    <option value="cm" {{ old('plant_spacing_unit', 'cm') == 'cm' ? 'selected' : '' }}>cm</option>
                                    <option value="m" {{ old('plant_spacing_unit') == 'm' ? 'selected' : '' }}>m</option>
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
                                    <option value="cm" {{ old('border_spacing_unit', 'cm') == 'cm' ? 'selected' : '' }}>cm</option>
                                    <option value="m" {{ old('border_spacing_unit') == 'm' ? 'selected' : '' }}>m</option>
                                    <option value="ft" {{ old('border_spacing_unit') == 'ft' ? 'selected' : '' }}>ft</option>
                                </select>
                            </div>
                        </div>

                        {{-- Notes --}}
                        <div class="mb-3 row align-items-start">
                            <label for="notes" class="col-sm-3 col-form-label">Notes:</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="notes" id="notes" rows="3" 
                                          placeholder="Optional notes about this planting calculation">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-calculator me-2"></i>Calculate Triangular Layout
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Results Panel --}}
        <div class="col-lg-4">
            @if(isset($results))
            <div class="card card-dashboard">
                <div class="card-header bg-primary text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Triangular Layout Results
                    </h6>
                </div>
                <div class="card-body">
                    <div class="result-item">
                        <strong>Total Plants:</strong>
                        <span class="text-primary fs-4 fw-bold">{{ number_format($results['totalPlants']) }}</span>
                    </div>
                    
                    <div class="result-item">
                        <strong>Number of Rows:</strong>
                        <span>{{ $results['rows'] }}</span>
                    </div>
                    
                    <div class="result-item">
                        <strong>Full Row Plants:</strong>
                        <span>{{ $results['plantsPerFullRow'] }}</span>
                    </div>
                    
                    <div class="result-item">
                        <strong>Offset Row Plants:</strong>
                        <span>{{ $results['plantsPerOffsetRow'] }}</span>
                    </div>
                    
                    <div class="result-item">
                        <strong>Avg Plants/Row:</strong>
                        <span>{{ $results['averagePlantsPerRow'] }}</span>
                    </div>
                    
                    <div class="result-item">
                        <strong>Effective Length:</strong>
                        <span>{{ $results['effectiveLength'] }} {{ old('area_length_unit', 'm') }}</span>
                    </div>
                    
                    <div class="result-item">
                        <strong>Effective Width:</strong>
                        <span>{{ $results['effectiveWidth'] }} {{ old('area_width_unit', 'm') }}</span>
                    </div>
                    
                    <div class="result-item">
                        <strong>Row Height:</strong>
                        <span>{{ round($results['rowHeight'], 4) }} m</span>
                    </div>

                    @if($results['spaceEfficiency'] > 0)
                    <div class="alert alert-success mt-3">
                        <strong><i class="fas fa-leaf me-1"></i>Space Efficiency:</strong><br>
                        {{ $results['spaceEfficiency'] }}% vs square pattern<br>
                        <small>{{ $results['spacingSaved'] > 0 ? '+' : '' }}{{ $results['spacingSaved'] }} plants vs square</small>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Pattern Visualization --}}
            <div class="card card-dashboard mt-3">
                <div class="card-header bg-success text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>Pattern Preview
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="pattern-display">
                        <div class="pattern-title mb-2">Triangular (Hexagonal) Pattern</div>
                        <div class="pattern-visual">
                            <div class="triangular-pattern">
                                {{-- Full row --}}
                                <div class="pattern-row">
                                    <span class="plant-dot">●</span>
                                    <span class="plant-dot">●</span>
                                    <span class="plant-dot">●</span>
                                    <span class="plant-dot">●</span>
                                    <span class="plant-dot">●</span>
                                </div>
                                {{-- Offset row --}}
                                <div class="pattern-row offset">
                                    <span class="plant-dot offset">●</span>
                                    <span class="plant-dot offset">●</span>
                                    <span class="plant-dot offset">●</span>
                                    <span class="plant-dot offset">●</span>
                                </div>
                                {{-- Full row --}}
                                <div class="pattern-row">
                                    <span class="plant-dot">●</span>
                                    <span class="plant-dot">●</span>
                                    <span class="plant-dot">●</span>
                                    <span class="plant-dot">●</span>
                                    <span class="plant-dot">●</span>
                                </div>
                                {{-- Offset row --}}
                                <div class="pattern-row offset">
                                    <span class="plant-dot offset">●</span>
                                    <span class="plant-dot offset">●</span>
                                    <span class="plant-dot offset">●</span>
                                    <span class="plant-dot offset">●</span>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted">
                            Alternating full and offset rows<br>
                            for optimal space utilization
                        </small>
                    </div>
                </div>
            </div>
            @else
            <div class="card card-dashboard">
                <div class="card-header bg-info text-white">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>About Triangular Planting
                    </h6>
                </div>
                <div class="card-body">
                    <p>Triangular planting uses a hexagonal packing pattern where plants are arranged in offset rows.</p>
                    
                    <h6 class="fw-bold">Benefits:</h6>
                    <ul class="small">
                        <li>Higher plant density</li>
                        <li>Better space utilization</li>
                        <li>Improved air circulation</li>
                        <li>More efficient water usage</li>
                        <li>Natural growth pattern</li>
                    </ul>
                    
                    <h6 class="fw-bold">Best for:</h6>
                    <ul class="small">
                        <li>Leafy greens</li>
                        <li>Herbs</li>
                        <li>Small vegetables</li>
                        <li>Ornamental plants</li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.result-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.result-item:last-child {
    border-bottom: none;
}

.pattern-visual {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 10px 0;
}

.triangular-pattern {
    font-size: 16px;
    line-height: 1.2;
}

.pattern-row {
    margin-bottom: 8px;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.pattern-row.offset {
    margin-left: 12px;
}

.plant-dot {
    color: #28a745;
    font-size: 14px;
}

.plant-dot.offset {
    color: #17a2b8;
}

.pattern-title {
    font-weight: bold;
    color: #495057;
}
</style>
@endsection