<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canvas Drawing</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Fabric.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        #canvas {
            border: 2px solid #000;
            cursor: crosshair;
        }

        #controls {
            margin: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 15%; 
            height: 100%;
        }

        #canvas-container {
            display: flex;
        }

        .btn-icon {
            display: flex;
            align-items: center;
            text-align: center;
            margin-bottom: 5px;
        }
        .btn-icon i {
            margin-right: 5px;
            text-align: center;
        }

        .btn {
            width: 100%;
            text-align: center;
            align-items: center;
        }

        .colorPick {
            padding: 6px;
            margin-left: 30px;
            margin-bottom: 0px;
            border-radius: 5px;
            width: 13.5%;
            text-align: center;
            align-items: center;
            border: none !important;
        }

        .color-btn {
            width: 30px;
            height: 30px;
            border: none;
            margin: 2px;
            border-radius: 50%;
            cursor: pointer;
        }

        .colorBack {
            margin-left: 42px;
        }

    </style>
</head>
<body>
    <!-- Color Picker -->
    <div class="colorBack">
        console.log(Abi);
        <button class="color-btn" onclick="changeColor('#fff200')" style="background-color: #fff200;"></button>
        <button class="color-btn" onclick="changeColor('#ffaec9')" style="background-color: #ffaec9;"></button>
        <button class="color-btn" onclick="changeColor('#99d9ea')" style="background-color: #99d9ea;"></button>
        <button class="color-btn" onclick="changeColor('#b5e61d')" style="background-color: #b5e61d;"></button>
        <button class="color-btn" onclick="changeColor('#c3c3c3')" style="background-color: #c3c3c3;"></button>
    </div>
    <button class="colorPick btn-primary btn-icon btn-info" id="pickColorButton" onclick="pickColor()" style="color: white;">
        <i class="fas fa-palette"></i>Pick Color</button>
    <input type="color" id="colorPicker" value="#000000" onchange="changeColor(this.value)" style="display:none;">

    <buti>
    
    <div id="canvas-container">
        <div id="controls">
            <button class="btn btn-primary btn-icon" onclick="setTool('pen')"><i class="fas fa-pen"></i>Pen</button>
            <button class="btn btn-primary btn-icon" onclick="setTool('text')"><i class="fas fa-font"></i>Text</button>
            <button class="btn btn-primary btn-icon" onclick="setTool('square')"><i class="fas fa-square"></i>Square</button>
            <button class="btn btn-primary btn-icon" onclick="setTool('circle')"><i class="fas fa-circle"></i>Circle</button>
            <button class="btn btn-primary btn-icon" onclick="setTool('line')"><i class="fas fa-minus"></i>Line</button>
            <button class="btn btn-primary btn-icon" onclick="setTool('arrow')"><i class="fas fa-long-arrow-alt-right"></i>Arrow</button>
            <button class="btn btn-primary btn-icon" onclick="setTool('eraser')"><i class="fas fa-eraser"></i>Eraser</button>
            <button class="btn btn-danger btn-icon" onclick="clearCanvas()"><i class="fas fa-trash-alt"></i>Clear</button>
            <button class="btn btn-success btn-icon" onclick="saveImage()"><i class="fas fa-download"></i>Save Image</button>
            <button class="btn btn-success btn-icon" onclick="saveAsPDF()"><i class="fas fa-file-pdf"></i>Save as PDF</button><br><br><br>

            <input type="file" id="fileInput" accept="image/*" onchange="handleFileUpload(event)">
        </div>
        <canvas id="canvas" width="1000" height="600"></canvas>
    </div>
    

    


    <!-- Bootstrap JS and Fabric.js (Include at the end of the body for better performance) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

 
    <script>
        // const canvasElement = document.getElementById('canvas');
        const canvas = new fabric.Canvas('canvas', { preserveObjectStacking: true });
        let currentTool = '';
        let drawingObject = null;
        let isDrawing = false;
        let currentColor = '#000000'; // Default color is black

        document.addEventListener("DOMContentLoaded", function () {
            const initialColor = document.getElementById('colorPicker').value;
            document.getElementById('pickColorButton').style.backgroundColor = initialColor;
            updateDrawingColor(initialColor);
        });

        function changeColor(color) {
            currentColor = color;  // Update the current color

            // Update the button background color
            document.getElementById('pickColorButton').style.backgroundColor = currentColor;

            updateDrawingColor(currentColor);
        }

        function updateDrawingColor(color) {
            if (canvas.isDrawingMode) {
                canvas.freeDrawingBrush.color = color;
            }
        }

        function setTool(tool) {
            currentTool = tool;
            canvas.discardActiveObject(); // Deselect any active object
            canvas.isDrawingMode = false; // Disable drawing mode by default
            canvas.selection = false; // Disable selection when drawing shapes

            canvas.off('mouse:down');
            canvas.off('mouse:move');
            canvas.off('mouse:up');
        
            if (tool === 'pen') {
                canvas.isDrawingMode = true;
                canvas.freeDrawingBrush.width = 3; // Set brush width for freehand drawing
                canvas.freeDrawingBrush.color = currentColor;  // Use current color for pen
                
                } else {
                    canvas.isDrawingMode = false;
                    canvas.selection = true;
            }
        
            if (tool === 'eraser') {
                canvas.selection = true;
                canvas.forEachObject(obj => {
                    obj.hoverCursor = 'pointer'; // Set cursor to pointer for objects
                });

                canvas.on('mouse:down', function (o) {
                    const pointer = canvas.getPointer(o.e);
                    const obj = canvas.getActiveObject();
                    if (obj && obj.selectable) {
                        canvas.remove(obj);
                        canvas.renderAll();
                    }
                });
            }

            if (tool === 'circle' || tool === 'square' || tool === 'line' || tool === 'arrow') {
                canvas.selection = false; // Disable selection when drawing shapes

                canvas.on('mouse:down', function (o) {
                    var pointer = canvas.getPointer(o.e);
                    var properties = {
                        left: pointer.x,
                        top: pointer.y,
                        fill: '',
                        stroke: currentColor,  // Use current color for stroke
                        strokeWidth: 3,
                        originX: 'center',
                        originY: 'center'
                    };


                if (currentTool === 'circle') {
                    drawingObject = new fabric.Circle({...properties, radius: 1});

                    } else if (currentTool === 'square') {
                        properties.width = 1;
                        properties.height = 1;
                        drawingObject = new fabric.Rect(properties);

                    } else if (currentTool === 'line') {
                        properties.x1 = pointer.x;
                        properties.y1 = pointer.y;
                        properties.x2 = pointer.x;
                        properties.y2 = pointer.y;
                        drawingObject = new fabric.Line([properties.x1, properties.y1, properties.x2, properties.y2], properties);
                    
                    } else if (currentTool === 'arrow') {
                        const arrowWidth = 20; // Adjust the width of the arrow
                        const arrowLength = 100; 

                        // Calculate points for the arrow
                        const arrowEndX = pointer.x + arrowLength;
                        const arrowHeadYOffset = arrowWidth * 0.3;
                        const arrowHeadXOffset = arrowWidth * 0.6;

                        // Define points for the arrow with a triangle arrowhead
                        const arrowPoints = [
                            { x: pointer.x, y: pointer.y },
                            { x: arrowEndX - arrowHeadXOffset, y: pointer.y }, // Endpoint before arrowhead
                            { x: arrowEndX - arrowHeadXOffset, y: pointer.y - arrowHeadYOffset }, // Arrowhead top point
                            { x: arrowEndX, y: pointer.y }, // Duplicate the end point (right side)
                            { x: arrowEndX - arrowHeadXOffset, y: pointer.y + arrowHeadYOffset }, // Arrowhead bottom point
                            { x: arrowEndX - arrowHeadXOffset, y: pointer.y }, // Endpoint after arrowhead
                            { x: pointer.x, y: pointer.y } // Close the polyline (back to start)
                        ];

                        drawingObject = new fabric.Polyline(arrowPoints, {
                            strokeWidth: 3.5, // Adjust the stroke width of the arrow
                            stroke: currentColor,
                            fill: currentColor,
                            originX: 'center',
                            originY: 'center'
                                        });
                                }
                                canvas.add(drawingObject);
                        });

                        canvas.on('mouse:move', function (o) {
                            if (!drawingObject) return;
                            var pointer = canvas.getPointer(o.e);
                            if (currentTool === 'circle') {
                                var radius = Math.max(Math.abs(drawingObject.left - pointer.x), Math.abs(drawingObject.top - pointer.y)) / 2;
                                drawingObject.set({ radius: radius }).setCoords();
                            } else if (currentTool === 'square') {
                                var sideLength = Math.max(Math.abs(drawingObject.left - pointer.x), Math.abs(drawingObject.top - pointer.y));
                                drawingObject.set({ width: sideLength, height: sideLength }).setCoords();
                            } else {
                                drawingObject.set({ x2: pointer.x, y2: pointer.y }).setCoords();
                            }
                            canvas.renderAll();
                        });

                        canvas.on('mouse:up', function () {
                            drawingObject = null;
                            setTool(''); // Reset tool to disable continuous shape drawing
                        });
                    } else if (tool === 'text') {
                        canvas.selection = false; // Disable selection for text input
                        textToolActive = true; // Text tool is now active

                        canvas.on('mouse:down', function (o) {
                            if (textToolActive) {
                                var pointer = canvas.getPointer(o.e);

                            // Create a text input at the clicked position
                            drawingObject = new fabric.Textbox('', {
                                left: pointer.x,
                                top: pointer.y,
                                width: 200,
                                fontSize: 20,
                                fill: currentColor,
                                borderColor: 'black',
                                cornerColor: 'black',
                                cornerSize: 6,
                                transparentCorners: false,
                                hasControls: true,
                                hasBorders: true,
                                selectable: true,
                            
                            });

                        canvas.add(drawingObject);
                        canvas.setActiveObject(drawingObject); // Activate text input for editing

                        // Focus the text input for typing
                        const textboxEl = canvas.getObjects().find(obj => obj === drawingObject);
                        if (textboxEl) {
                            textboxEl.enterEditing(); // Enter editing mode to focus the text input
                            textboxEl.hiddenTextarea.focus(); // Focus the hidden textarea within the text input
                        }

                        textToolActive = false; // Deactivate text tool until button is clicked again
                    }
                });
            } else {
                canvas.selection = true; // Enable selection for other tools
                canvas.forEachObject(function (o) {
                    o.selectable = true; // Make objects selectable again
                });
                textToolActive = false; // Deactivate text tool for other tools
            }
        }

        function pickColor() {
            document.getElementById('colorPicker').click();
        }

        function handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                fabric.Image.fromURL(e.target.result, function(img) {
                    img.set({
                    left: 0,
                    top: 0,
                    selectable: false,
                    evented: false,
                });

                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                    scaleX: canvas.width / img.width,
                    scaleY: canvas.height / img.height
                });
                });
                };
                reader.readAsDataURL(file);
            }
        }

        function clearCanvas() {
            // Clear all objects from the canvas
            canvas.clear();

            // Remove any background image
            canvas.setBackgroundImage(null);
            canvas.renderAll(); // Render the canvas after clearing

            // Reset the file input element to clear the chosen file
            const fileInput = document.getElementById('fileInput');
            fileInput.value = ''; // Reset the file input value to clear the chosen file
        }

        function saveImage() {
            const image = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.href = image;
            link.download = 'canvas-image.png';
            link.click();
        }

        async function saveAsPDF() {
            const { jsPDF } = window.jspdf;
            const pdf = new jsPDF({
                orientation: 'landscape',
                unit: 'px',
                format: [canvas.width, canvas.height]
            });

            // Convert canvas to data URL
            const dataUrl = canvas.toDataURL('image/png');

            // Add image to PDF
            pdf.addImage(dataUrl, 'PNG', 0, 0, canvas.width, canvas.height);

            // Save the PDF
            pdf.save('download.pdf');
        }

    </script>
</body>
</html>