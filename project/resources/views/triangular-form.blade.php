<!DOCTYPE html>
<html>
<head>
    <title>Triangular Planting Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4 text-center">🌱 Triangular Planting Calculator</h2>

        <form method="POST" action="/triangular-planting">
            @csrf

            {{-- Length --}}
            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">Length</label>
                    <input type="number" step="0.01" class="form-control" name="length"
                           value="{{ old('length', $inputs['length'] ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Unit</label>
                    <select class="form-select" name="length_unit">
                        <option value="m">Meters</option>
                        <option value="cm">Centimeters</option>
                        <option value="ft">Feet</option>
                    </select>
                </div>
            </div>

            {{-- Width --}}
            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">Width</label>
                    <input type="number" step="0.01" class="form-control" name="width"
                           value="{{ old('width', $inputs['width'] ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Unit</label>
                    <select class="form-select" name="width_unit">
                        <option value="m">Meters</option>
                        <option value="cm">Centimeters</option>
                        <option value="ft">Feet</option>
                    </select>
                </div>
            </div>

            {{-- Border --}}
            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">Plant Border</label>
                    <input type="number" step="0.01" class="form-control" name="border"
                           value="{{ old('border', $inputs['border'] ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Unit</label>
                    <select class="form-select" name="border_unit">
                        <option value="m">Meters</option>
                        <option value="cm">Centimeters</option>
                        <option value="ft">Feet</option>
                    </select>
                </div>
            </div>

            {{-- Spacing --}}
            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label">Plant Spacing</label>
                    <input type="number" step="0.01" class="form-control" name="spacing"
                           value="{{ old('spacing', $inputs['spacing'] ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Unit</label>
                    <select class="form-select" name="spacing_unit">
                        <option value="m">Meters</option>
                        <option value="cm">Centimeters</option>
                        <option value="ft">Feet</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100">Calculate</button>
        </form>

        @isset($plants)
            <div class="alert alert-info mt-4">
                ✅ Usable Field Size: <strong>{{ $area }} m²</strong><br>
                ✅ Approx. Number of Plants (Triangular Planting): <strong>{{ number_format($plants) }}</strong>
            </div>
        @endisset
    </div>
</div>
</body>
</html>
