<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Designer</title>
    <style>
        html,
        body {
            margin: 0;
            height: 100%;
            box-sizing: border-box;
        }

        .order-designer {
            width: 100%;
            height: 100%;
        }

        .head {
            background: #333;
            color: #fff;
            padding: 0 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 48px;
        }

        .head button {
            background: #04AA6D;
            border: none;
            color: white;
            padding: 4px 12px;
            margin: 2px;
            cursor: pointer;
            font-size: 12px;
        }

        .canvas-holder {
            width: 100%;
            height: calc(100% - 72px);
            background: #f5f5f5;
            overflow: auto;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 10px;
        }

        .canvas-holder canvas {
            width: 100%;
            height: 100%;
        }
    </style>

    <!-- Load Fabric.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
</head>

<body>
    <div class="overlay design-tool" style="display: none;">
        <div class="container h-100 py-3 position-relative">
            <div class="close">X</div>
            <div class="order-designer">
                <div class="head">
                    <div>
                        <input type="color" id="color-picker" value="#000000">
                        <input type="range" id="line-width" min="1" max="72" value="3">
                        <label id="line-width-value">3</label> Px
                    </div>
                    <div>
                        <button id="draw">Draw</button>
                        <button id="text">Text</button>
                        <button id="square">Square</button>
                        <button id="circle">Circle</button>
                        <button id="insert-image">Insert Image</button>
                        <button id="erase">Erase</button>
                        <button id="clear">Clear</button>
                        <button id="download">Download</button>
                    </div>
                </div>
                <div class="canvas-holder">
                    <canvas id="myCanvas"></canvas>
                </div>
                <input type="file" id="img-file" accept="image/*" style="display:none">
            </div>
        </div>
    </div>

    <script>
        const canvas = new fabric.Canvas('myCanvas', {
            backgroundColor: '#fff',
            selection: true
        });

        // Initialize drawing brush
        canvas.freeDrawingBrush = new fabric.PencilBrush(canvas);
        canvas.freeDrawingBrush.color = "#000000";
        canvas.freeDrawingBrush.width = 3;

        function resizeCanvas() {
            canvas.setWidth(window.innerWidth);
            canvas.setHeight(window.innerHeight - 48);
            canvas.renderAll();
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        // UI Elements
        const colorPicker = document.getElementById('color-picker');
        const lineWidth = document.getElementById('line-width');
        const lineWidthValue = document.getElementById('line-width-value');
        const drawBtn = document.getElementById('draw');
        const textBtn = document.getElementById('text');
        const squareBtn = document.getElementById('square');
        const circleBtn = document.getElementById('circle');
        const eraseBtn = document.getElementById('erase');
        const clearBtn = document.getElementById('clear');
        const downloadBtn = document.getElementById('download');
        const insertImageBtn = document.getElementById('insert-image');
        const imgFileInput = document.getElementById('img-file');

        // Update brush width
        lineWidth.addEventListener('input', () => {
            lineWidthValue.textContent = lineWidth.value;
            canvas.freeDrawingBrush.width = parseInt(lineWidth.value, 10);
        });

        // Update brush color and object fill color
        colorPicker.addEventListener('change', () => {
            if (canvas.isDrawingMode) {
                canvas.freeDrawingBrush.color = colorPicker.value;
            }
            const obj = canvas.getActiveObject();
            if (obj && obj.set) {
                if ('fill' in obj) obj.set('fill', colorPicker.value);
                if ('stroke' in obj) obj.set('stroke', colorPicker.value);
                canvas.renderAll();
            }
        });

        function setMode(mode) {
            canvas.isDrawingMode = false;
            canvas.selection = true;
            canvas.forEachObject(obj => obj.selectable = true);

            switch (mode) {
                case 'draw':
                    canvas.isDrawingMode = true;
                    canvas.freeDrawingBrush.color = colorPicker.value;
                    canvas.freeDrawingBrush.width = parseInt(lineWidth.value, 10);
                    break;
                case 'erase':
                    canvas.selection = false;
                    canvas.forEachObject(obj => obj.selectable = false);
                    canvas.on('mouse:down', eraseHandler);
                    break;
            }
        }

        function eraseHandler(opt) {
            const target = canvas.findTarget(opt.e, false);
            if (target) canvas.remove(target);
        }

        function cleanupHandlers() {
            canvas.off('mouse:down', eraseHandler);
        }

        drawBtn.addEventListener('click', () => {
            cleanupHandlers();
            setMode('draw');
        });

        eraseBtn.addEventListener('click', () => {
            cleanupHandlers();
            setMode('erase');
        });

        textBtn.addEventListener('click', () => {
            cleanupHandlers();
            setMode(null);
            const text = new fabric.IText('Edit me', {
                left: 50, top: 50,
                fill: colorPicker.value,
                fontSize: 30
            });
            canvas.add(text).setActiveObject(text);
        });

        squareBtn.addEventListener('click', () => {
            cleanupHandlers();
            setMode(null);
            const rect = new fabric.Rect({
                left: 60, top: 60,
                fill: colorPicker.value,
                width: 100,
                height: 100
            });
            canvas.add(rect).setActiveObject(rect);
        });

        circleBtn.addEventListener('click', () => {
            cleanupHandlers();
            setMode(null);
            const circle = new fabric.Circle({
                left: 80, top: 80,
                fill: colorPicker.value,
                radius: 50
            });
            canvas.add(circle).setActiveObject(circle);
        });

        insertImageBtn.addEventListener('click', () => imgFileInput.click());
        imgFileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (f) => {
                fabric.Image.fromURL(f.target.result, img => {
                    img.set({ left: 100, top: 100, scaleX: 0.5, scaleY: 0.5 });
                    canvas.add(img).setActiveObject(img);
                });
            };
            reader.readAsDataURL(file);
        });

        clearBtn.addEventListener('click', () => {
            canvas.clear();
            canvas.backgroundColor = '#fff';
        });

        downloadBtn.addEventListener('click', () => {
            const link = document.createElement('a');
            link.href = canvas.toDataURL({ format: 'png', quality: 1 });
            link.download = 'canvas_design.png';
            link.click();
        });
    </script>
</body>

</html>