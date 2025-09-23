<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triangular Planting Calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2e7d32; /* Darker green */
            --secondary-color: #4caf50; /* A shade of green */
            --accent-color: #388e3c; /* A slightly darker accent green */
            --dark-color: #1b5e20; /* Very dark green */
            --light-color: #e8f5e9; /* Light green for backgrounds */
            --plant-color: #66bb6a;
            --plant-alt-color: #a5d6a7;
        }
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
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
        
        .visualization-container {
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 1px solid #ddd;
        }
        
        .visualization {
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto;
            position: relative;
        }
        
        .plant {
            position: absolute;
            width: 30px;
            height: 30px;
            background-color: var(--plant-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.7rem;
            box-shadow: 0 3px 5px rgba(0,0,0,0.2);
            transform: translate(-50%, -50%);
            z-index: 2;
        }
        
        .plant.alternating {
            background-color: var(--plant-alt-color);
        }
        
        .planting-area {
            position: relative;
            border: 2px dashed #ccc;
            background-color: #f9f9f9;
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
        
        .pattern-info {
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary-color);
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 0 4px 4px 0;
        }
        
        .controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        
        .zoom-controls button {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            padding: 0.25rem 0.5rem;
            margin-left: 0.5rem;
            border-radius: 4px;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .calculator-container {
                padding: 1rem;
                margin: 1rem;
            }
            
            .visualization {
                height: 300px;
            }
            
            .plant {
                width: 20px;
                height: 20px;
                font-size: 0.6rem;
            }
        }
        
        .triangle-connectors {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }
        
        .connector {
            stroke: rgba(76, 175, 80, 0.3);
            stroke-width: 1;
            fill: none;
        }
        
        .row-label {
            position: absolute;
            left: -30px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.8rem;
            color: #666;
        }
        
        .col-label {
            position: absolute;
            bottom: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.8rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container calculator-container">
        <div class="header text-center">
            <h1>Triangular Planting System Calculator</h1>
            <p class="mb-0">Optimize your planting layout with triangular spacing pattern</p>
        </div>
        
        <form id="triangleForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="areaLength" class="form-label">Area Length</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="areaLength" name="areaLength" step="0.01" min="0.01" required value="10">
                            <select class="form-select" id="lengthUnit" name="lengthUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="areaWidth" class="form-label">Area Width</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="areaWidth" name="areaWidth" step="0.01" min="0.01" required value="8">
                            <select class="form-select" id="widthUnit" name="widthUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="plantSpacing" class="form-label">Plant Spacing</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="plantSpacing" name="plantSpacing" step="0.01" min="0.01" required value="1.5">
                            <select class="form-select" id="spacingUnit" name="spacingUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="borderSpacing" class="form-label">Border Spacing</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="borderSpacing" name="borderSpacing" step="0.01" min="0" value="0.5" required>
                            <select class="form-select" id="borderUnit" name="borderUnit">
                                <option value="m" selected>Meters (m)</option>
                                <option value="ft">Feet (ft)</option>
                                <option value="cm">Centimeters (cm)</option>
                                <option value="in">Inches (in)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <button type="button" id="calculateBtn" class="btn btn-calculate btn-lg">Calculate</button>
            </div>
        </form>
        
        <div class="results-container" id="resultsContainer" style="display: none;">
            <h3 class="mb-4">Calculation Results</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Number of Plants:</span>
                        <span class="result-value" id="totalPlants">0</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Plants per Row:</span>
                        <span class="result-value" id="plantsPerRow">0</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Number of Rows:</span>
                        <span class="result-value" id="numberOfRows">0</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Effective Area:</span>
                        <span class="result-value" id="effectiveArea">0 m²</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Planting Density:</span>
                        <span class="result-value" id="plantingDensity">0 plants/m²</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>Space Utilization:</span>
                        <span class="result-value" id="spaceUtilization">0%</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="visualization-container" id="visualizationContainer" style="display: none;">
            <div class="controls">
                <div>
                    <label for="showConnectors">
                        <input type="checkbox" id="showConnectors" checked> Show triangular connections
                    </label>
                </div>
                <div class="zoom-controls">
                    <button id="zoomIn">Zoom In</button>
                    <button id="zoomOut">Zoom Out</button>
                    <button id="resetView">Reset View</button>
                </div>
            </div>
            <div class="visualization" id="visualization">
                <!-- Visualization will be generated here -->
            </div>
        </div>
        
        <div class="pattern-info">
            <h5>About Triangular Planting Pattern</h5>
            <p class="mb-0">The triangular planting pattern arranges plants in offset rows, creating equilateral triangles between plants. This pattern maximizes space utilization and allows each plant to have equal access to resources like sunlight, water, and nutrients.</p>
        </div>
    </div>
    
    <footer>
        <p>Triangular Planting System Calculator &copy; 2023</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calculateBtn = document.getElementById('calculateBtn');
            const form = document.getElementById('triangleForm');
            const resultsContainer = document.getElementById('resultsContainer');
            const visualizationContainer = document.getElementById('visualizationContainer');
            const showConnectorsCheckbox = document.getElementById('showConnectors');
            const zoomInBtn = document.getElementById('zoomIn');
            const zoomOutBtn = document.getElementById('zoomOut');
            const resetViewBtn = document.getElementById('resetView');
            
            let currentScale = 1;
            let currentOffsetX = 0;
            let currentOffsetY = 0;
            let isDragging = false;
            let startX, startY;
            
            // Conversion factors to meters
            const conversionRates = {
                'm': 1,
                'ft': 0.3048,
                'cm': 0.01,
                'in': 0.0254
            };
            
            calculateBtn.addEventListener('click', calculate);
            showConnectorsCheckbox.addEventListener('change', toggleConnectors);
            zoomInBtn.addEventListener('click', zoomIn);
            zoomOutBtn.addEventListener('click', zoomOut);
            resetViewBtn.addEventListener('click', resetView);
            
            // Add panning functionality
            const visualization = document.getElementById('visualization');
            visualization.addEventListener('mousedown', startDragging);
            visualization.addEventListener('mousemove', drag);
            visualization.addEventListener('mouseup', stopDragging);
            visualization.addEventListener('mouseleave', stopDragging);
            
            function calculate() {
                // Get input values
                const areaLength = parseFloat(document.getElementById('areaLength').value);
                const areaWidth = parseFloat(document.getElementById('areaWidth').value);
                const plantSpacing = parseFloat(document.getElementById('plantSpacing').value);
                const borderSpacing = parseFloat(document.getElementById('borderSpacing').value);
                
                // Get selected units
                const lengthUnit = document.getElementById('lengthUnit').value;
                const widthUnit = document.getElementById('widthUnit').value;
                const spacingUnit = document.getElementById('spacingUnit').value;
                const borderUnit = document.getElementById('borderUnit').value;
                
                // Validate inputs
                if (areaLength <= 0 || areaWidth <= 0 || plantSpacing <= 0 || borderSpacing < 0) {
                    alert('Please enter valid positive values for all fields.');
                    return;
                }
                
                if (borderSpacing * 2 >= areaLength || borderSpacing * 2 >= areaWidth) {
                    alert('Border spacing is too large. It must be less than half of the area length and width.');
                    return;
                }
                
                // Convert all values to meters
                const areaLengthM = areaLength * conversionRates[lengthUnit];
                const areaWidthM = areaWidth * conversionRates[widthUnit];
                const plantSpacingM = plantSpacing * conversionRates[spacingUnit];
                const borderSpacingM = borderSpacing * conversionRates[borderUnit];
                
                // Calculate effective planting area
                const effectiveLength = Math.max(0, areaLengthM - 2 * borderSpacingM);
                const effectiveWidth = Math.max(0, areaWidthM - 2 * borderSpacingM);
                
                if (effectiveLength <= 0 || effectiveWidth <= 0) {
                    alert('Border spacing is too large for the given area.');
                    return;
                }
                
                // Calculate plants per row and number of rows (triangular pattern)
                const plantsPerRow = Math.floor(effectiveLength / plantSpacingM) + 1;
                const rowSpacing = plantSpacingM * Math.sqrt(3) / 2; // Height of equilateral triangle
                const numberOfRows = Math.floor(effectiveWidth / rowSpacing) + 1;
                
                const totalPlants = plantsPerRow * numberOfRows;
                const effectiveArea = effectiveLength * effectiveWidth;
                const plantingDensity = effectiveArea > 0 ? totalPlants / effectiveArea : 0;
                const spaceUtilization = areaLengthM * areaWidthM > 0 ? (effectiveArea / (areaLengthM * areaWidthM)) * 100 : 0;
                
                // Update results
                document.getElementById('totalPlants').textContent = totalPlants;
                document.getElementById('plantsPerRow').textContent = plantsPerRow;
                document.getElementById('numberOfRows').textContent = numberOfRows;
                document.getElementById('effectiveArea').textContent = effectiveArea.toFixed(2) + ' m²';
                document.getElementById('plantingDensity').textContent = plantingDensity.toFixed(2) + ' plants/m²';
                document.getElementById('spaceUtilization').textContent = spaceUtilization.toFixed(1) + '%';
                
                // Show results and visualization
                resultsContainer.style.display = 'block';
                visualizationContainer.style.display = 'block';
                
                // Generate visualization
                generateVisualization(plantsPerRow, numberOfRows, plantSpacingM, rowSpacing, effectiveLength, effectiveWidth);
            }
            
            function generateVisualization(plantsPerRow, numberOfRows, plantSpacing, rowSpacing, areaLength, areaWidth) {
                const visualization = document.getElementById('visualization');
                visualization.innerHTML = '';
                
                // Create SVG for connectors
                const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                svg.classList.add('triangle-connectors');
                svg.setAttribute('width', '100%');
                svg.setAttribute('height', '100%');
                visualization.appendChild(svg);
                
                // Create planting area container
                const plantingArea = document.createElement('div');
                plantingArea.classList.add('planting-area');
                visualization.appendChild(plantingArea);
                
                // Calculate scale to fit visualization
                const containerWidth = visualization.clientWidth - 60; // Account for labels
                const containerHeight = visualization.clientHeight - 60;
                
                const scaleX = containerWidth / areaLength;
                const scaleY = containerHeight / areaWidth;
                const scale = Math.min(scaleX, scaleY) * 0.9; // 90% to add some padding
                
                plantingArea.style.width = (areaLength * scale) + 'px';
                plantingArea.style.height = (areaWidth * scale) + 'px';
                
                // Create plants
                const plants = [];
                
                for (let row = 0; row < numberOfRows; row++) {
                    const isEvenRow = row % 2 === 0;
                    const rowOffset = isEvenRow ? plantSpacing / 2 : 0;
                    
                    for (let col = 0; col < plantsPerRow; col++) {
                        const plant = document.createElement('div');
                        plant.classList.add('plant');
                        if (col % 2 === 0) plant.classList.add('alternating');
                        
                        plant.textContent = (row * plantsPerRow + col + 1);
                        
                        // Position plant
                        const x = (col * plantSpacing + rowOffset) * scale;
                        const y = (row * rowSpacing) * scale;
                        
                        plant.style.left = x + 'px';
                        plant.style.top = y + 'px';
                        
                        plantingArea.appendChild(plant);
                        plants.push({x: x, y: y, element: plant, row: row, col: col});
                    }
                }
                
                // Create row and column labels
                createLabels(plantingArea, plantsPerRow, numberOfRows, plantSpacing, rowSpacing, scale);
                
                // Draw connectors between plants to form triangles
                drawConnectors(plants, plantsPerRow, numberOfRows, svg, scale);
                
                // Reset view
                resetView();
            }
            
            function createLabels(plantingArea, plantsPerRow, numberOfRows, plantSpacing, rowSpacing, scale) {
                // Add row labels
                for (let row = 0; row < numberOfRows; row++) {
                    const label = document.createElement('div');
                    label.classList.add('row-label');
                    label.textContent = `Row ${row + 1}`;
                    label.style.top = (row * rowSpacing * scale) + 'px';
                    plantingArea.appendChild(label);
                }
                
                // Add column labels
                for (let col = 0; col < plantsPerRow; col++) {
                    const label = document.createElement('div');
                    label.classList.add('col-label');
                    label.textContent = `Col ${col + 1}`;
                    label.style.left = (col * plantSpacing * scale) + 'px';
                    plantingArea.appendChild(label);
                }
            }
            
            function drawConnectors(plants, plantsPerRow, numberOfRows, svg, scale) {
                // Clear previous connectors
                svg.innerHTML = '';
                
                if (!showConnectorsCheckbox.checked) return;
                
                // Draw lines to form triangles
                for (let i = 0; i < plants.length; i++) {
                    const plant = plants[i];
                    
                    // Connect to plant to the right (if exists)
                    if (plant.col < plantsPerRow - 1) {
                        const rightPlant = plants[i + 1];
                        drawLine(svg, plant.x, plant.y, rightPlant.x, rightPlant.y);
                    }
                    
                    // Connect to plant below (if exists)
                    if (plant.row < numberOfRows - 1) {
                        const belowPlant = plants[i + plantsPerRow];
                        drawLine(svg, plant.x, plant.y, belowPlant.x, belowPlant.y);
                        
                        // Connect diagonally based on row parity
                        if (plant.row % 2 === 0 && plant.col > 0) {
                            // Even row: connect to bottom-left plant
                            const diagPlant = plants[i + plantsPerRow - 1];
                            drawLine(svg, plant.x, plant.y, diagPlant.x, diagPlant.y);
                        } else if (plant.row % 2 === 1 && plant.col < plantsPerRow - 1) {
                            // Odd row: connect to bottom-right plant
                            const diagPlant = plants[i + plantsPerRow + 1];
                            drawLine(svg, plant.x, plant.y, diagPlant.x, diagPlant.y);
                        }
                    }
                }
            }
            
            function drawLine(svg, x1, y1, x2, y2) {
                const line = document.createElementNS('http://www.w3.org/2000/svg', 'line');
                line.setAttribute('x1', x1);
                line.setAttribute('y1', y1);
                line.setAttribute('x2', x2);
                line.setAttribute('y2', y2);
                line.classList.add('connector');
                svg.appendChild(line);
            }
            
            function toggleConnectors() {
                const plantsPerRow = parseInt(document.getElementById('plantsPerRow').textContent) || 5;
                const numberOfRows = parseInt(document.getElementById('numberOfRows').textContent) || 4;
                const plantSpacing = 1.5; // Default value
                const rowSpacing = plantSpacing * Math.sqrt(3) / 2;
                
                const svg = document.querySelector('.triangle-connectors');
                if (svg) {
                    const plants = Array.from(document.querySelectorAll('.plant')).map(plant => {
                        const rect = plant.getBoundingClientRect();
                        const containerRect = document.getElementById('visualization').getBoundingClientRect();
                        return {
                            x: rect.left - containerRect.left + rect.width / 2,
                            y: rect.top - containerRect.top + rect.height / 2,
                            element: plant,
                            row: parseInt(plant.textContent) % numberOfRows,
                            col: Math.floor(parseInt(plant.textContent) / numberOfRows)
                        };
                    });
                    
                    drawConnectors(plants, plantsPerRow, numberOfRows, svg, 1);
                }
            }
            
            function startDragging(e) {
                isDragging = true;
                startX = e.clientX - currentOffsetX;
                startY = e.clientY - currentOffsetY;
                visualization.style.cursor = 'grabbing';
            }
            
            function drag(e) {
                if (!isDragging) return;
                e.preventDefault();
                
                currentOffsetX = e.clientX - startX;
                currentOffsetY = e.clientY - startY;
                
                const plantingArea = document.querySelector('.planting-area');
                if (plantingArea) {
                    plantingArea.style.transform = `translate(${currentOffsetX}px, ${currentOffsetY}px) scale(${currentScale})`;
                }
            }
            
            function stopDragging() {
                isDragging = false;
                visualization.style.cursor = 'grab';
            }
            
            function zoomIn() {
                currentScale *= 1.2;
                updateTransform();
            }
            
            function zoomOut() {
                currentScale /= 1.2;
                updateTransform();
            }
            
            function resetView() {
                currentScale = 1;
                currentOffsetX = 0;
                currentOffsetY = 0;
                updateTransform();
            }
            
            function updateTransform() {
                const plantingArea = document.querySelector('.planting-area');
                if (plantingArea) {
                    plantingArea.style.transform = `translate(${currentOffsetX}px, ${currentOffsetY}px) scale(${currentScale})`;
                }
            }
            
            // Calculate on page load with default values
            calculate();
        });
    </script>
</body>
</html>