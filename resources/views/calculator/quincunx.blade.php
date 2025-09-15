<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quincunx Planting Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2e7d32;
            --secondary-color: #7cb342;
            --accent-color: #c5e1a5;
            --dark-color: #1b5e20;
            --light-color: #f1f8e9;
        }
        
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .calculator-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 2rem auto;
            padding: 2rem;
            max-width: 1000px;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .input-group {
            margin-bottom: 1.2rem;
        }
        
        .btn-calculate {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 2rem;
            font-weight: 600;
        }
        
        .btn-calculate:hover {
            background-color: var(--dark-color);
            border-color: var(--dark-color);
        }
        
        .results-container {
            background-color: var(--light-color);
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .result-value {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .visualization {
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
        }
        
        .plant-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-gap: 15px;
        }
        
        .plant {
            width: 40px;
            height: 40px;
            background-color: var(--secondary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            box-shadow: 0 3px 5px rgba(0,0,0,0.2);
        }
        
        .plant.alternating {
            background-color: var(--primary-color);
        }
        
        .info-icon {
            color: var(--primary-color);
            cursor: pointer;
            margin-left: 5px;
        }
        
        footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1rem;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .calculator-container {
                padding: 1rem;
                margin: 1rem;
            }
            
            .visualization {
                height: 200px;
            }
            
            .plant {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container calculator-container">
        <div class="header text-center">
            <h1>Quincunx Planting System Calculator</h1>
            <p class="mb-0">Optimize your planting layout with the quincunx pattern</p>
        </div>
        
        <form id="quincunxForm" action="{{ route('quincunx.calculate') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="areaLength" class="form-label">Area Length</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="areaLength" name="areaLength" step="0.01" min="0.01" required value="{{ old('areaLength', $inputs['areaLength'] ?? '') }}">
                            <select class="form-select" id="lengthUnit" name="lengthUnit">
                                <option value="m" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? 'm') == 'm') ? 'selected' : '' }}>Meters (m)</option>
                                <option value="ft" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? 'm') == 'ft') ? 'selected' : '' }}>Feet (ft)</option>
                                <option value="cm" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? 'm') == 'cm') ? 'selected' : '' }}>Centimeters (cm)</option>
                                <option value="in" {{ (old('lengthUnit', $inputs['lengthUnit'] ?? 'm') == 'in') ? 'selected' : '' }}>Inches (in)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="areaWidth" class="form-label">Area Width</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="areaWidth" name="areaWidth" step="0.01" min="0.01" required value="{{ old('areaWidth', $inputs['areaWidth'] ?? '') }}">
                            <select class="form-select" id="widthUnit" name="widthUnit">
                                <option value="m" {{ (old('widthUnit', $inputs['widthUnit'] ?? 'm') == 'm') ? 'selected' : '' }}>Meters (m)</option>
                                <option value="ft" {{ (old('widthUnit', $inputs['widthUnit'] ?? 'm') == 'ft') ? 'selected' : '' }}>Feet (ft)</option>
                                <option value="cm" {{ (old('widthUnit', $inputs['widthUnit'] ?? 'm') == 'cm') ? 'selected' : '' }}>Centimeters (cm)</option>
                                <option value="in" {{ (old('widthUnit', $inputs['widthUnit'] ?? 'm') == 'in') ? 'selected' : '' }}>Inches (in)</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="plantSpacing" class="form-label">Plant Spacing</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="plantSpacing" name="plantSpacing" step="0.01" min="0.01" required value="{{ old('plantSpacing', $inputs['plantSpacing'] ?? '') }}">
                            <select class="form-select" id="spacingUnit" name="spacingUnit">
                                <option value="m" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? 'm') == 'm') ? 'selected' : '' }}>Meters (m)</option>
                                <option value="ft" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? 'm') == 'ft') ? 'selected' : '' }}>Feet (ft)</option>
                                <option value="cm" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? 'm') == 'cm') ? 'selected' : '' }}>Centimeters (cm)</option>
                                <option value="in" {{ (old('spacingUnit', $inputs['spacingUnit'] ?? 'm') == 'in') ? 'selected' : '' }}>Inches (in)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="borderSpacing" class="form-label">Border Spacing</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="borderSpacing" name="borderSpacing" step="0.01" min="0" value="{{ old('borderSpacing', $inputs['borderSpacing'] ?? 0) }}" required>
                            <select class="form-select" id="borderUnit" name="borderUnit">
                                <option value="m" {{ (old('borderUnit', $inputs['borderUnit'] ?? 'm') == 'm') ? 'selected' : '' }}>Meters (m)</option>
                                <option value="ft" {{ (old('borderUnit', $inputs['borderUnit'] ?? 'm') == 'ft') ? 'selected' : '' }}>Feet (ft)</option>
                                <option value="cm" {{ (old('borderUnit', $inputs['borderUnit'] ?? 'm') == 'cm') ? 'selected' : '' }}>Centimeters (cm)</option>
                                <option value="in" {{ (old('borderUnit', $inputs['borderUnit'] ?? 'm') == 'in') ? 'selected' : '' }}>Inches (in)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-calculate btn-lg">Calculate</button>
            </div>
        </form>
        
        @if(isset($results))
        <div class="results-container">
            <h3 class="mb-4">Calculation Results</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Number of Plants:</span>
                        <span class="result-value">{{ $results['totalPlants'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Plants per Row:</span>
                        <span class="result-value">{{ $results['plantsPerRow'] }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Number of Rows:</span>
                        <span class="result-value">{{ $results['numberOfRows'] }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Effective Area:</span>
                        <span class="result-value">{{ number_format($results['effectiveArea'], 2) }} m²</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Planting Density:</span>
                        <span class="result-value">{{ number_format($results['plantingDensity'], 2) }} plants/m²</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Space Utilization:</span>
                        <span class="result-value">{{ number_format($results['spaceUtilization'], 1) }}%</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="visualization">
            <div class="plant-grid">
                @for($i = 0; $i < min(25, $results['totalPlants']); $i++)
                    <div class="plant {{ $i % 2 == 0 ? 'alternating' : '' }}">{{ $i+1 }}</div>
                @endfor
            </div>
        </div>
        @else
        <div class="visualization" id="visualization">
            <div class="text-center text-muted">
                <p>Visualization will appear here after calculation</p>
                <p class="small">The quincunx pattern arranges plants in a staggered pattern for optimal space utilization</p>
            </div>
        </div>
        @endif
    </div>
    
    <footer>
        <p>Quincunx Planting System Calculator &copy; 2023</p>
    </footer>

    <script>
        document.getElementById('quincunxForm').addEventListener('submit', function(e) {
            // Client-side validation
            const areaLength = parseFloat(document.getElementById('areaLength').value);
            const areaWidth = parseFloat(document.getElementById('areaWidth').value);
            const plantSpacing = parseFloat(document.getElementById('plantSpacing').value);
            const borderSpacing = parseFloat(document.getElementById('borderSpacing').value);
            
            if (areaLength <= 0 || areaWidth <= 0 || plantSpacing <= 0 || borderSpacing < 0) {
                e.preventDefault();
                alert('Please enter valid positive values for all fields.');
                return false;
            }
            
            if (borderSpacing * 2 >= areaLength || borderSpacing * 2 >= areaWidth) {
                e.preventDefault();
                alert('Border spacing is too large. It must be less than half of the area length and width.');
                return false;
            }
            
            return true;
        });
    </script>
</body>
</html>