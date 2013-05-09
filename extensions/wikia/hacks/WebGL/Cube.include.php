<script id="shader-fs" type="x-shader/x-fragment">
    #ifdef GL_ES
    precision highp float;
    #endif

    varying vec2 vTextureCoord;

    uniform sampler2D uSampler;

    void main(void) {
        gl_FragColor = texture2D(uSampler, vec2(vTextureCoord.s, vTextureCoord.t));
    }
</script>

<script id="shader-vs" type="x-shader/x-vertex">
    attribute vec3 aVertexPosition;
    attribute vec2 aTextureCoord;

    uniform mat4 uMVMatrix;
    uniform mat4 uPMatrix;

    varying vec2 vTextureCoord;


    void main(void) {
        gl_Position = uPMatrix * uMVMatrix * vec4(aVertexPosition, 1.0);
        vTextureCoord = aTextureCoord;
    }
</script>


<script type="text/javascript">
var gl; // global WebGL object
var shaderProgram;

//var pics_names=['1.png', '2.png', '3.png', '4.png', '5.png', '6.png', '7.png'];
var pics_num=pics_names.length;

// diffirent initializations

function initGL(canvas) {
    try {
        gl = canvas.getContext('experimental-webgl');
        gl.viewportWidth = canvas.width;
        gl.viewportHeight = canvas.height;
    } catch (e) {}
    if (! gl) {
        alert('Can`t initialise WebGL, not supported');
    }
}

function getShader(gl, type) {
    var str = '';
    var shader;

    if (type == 'x-fragment') {
        str = "#ifdef GL_ES\n"+
"precision highp float;\n"+
"#endif\n"+
"varying vec2 vTextureCoord;\n"+
"uniform sampler2D uSampler;\n"+
"void main(void) {\n"+
"    gl_FragColor = texture2D(uSampler, vec2(vTextureCoord.s, vTextureCoord.t));\n"+
"}\n";
        shader = gl.createShader(gl.FRAGMENT_SHADER);
    } else if (type == 'x-vertex') {
        str = "attribute vec3 aVertexPosition;\n"+
"attribute vec2 aTextureCoord;\n"+
"uniform mat4 uMVMatrix;\n"+
"uniform mat4 uPMatrix;\n"+
"varying vec2 vTextureCoord;\n"+
"void main(void) {\n"+
"    gl_Position = uPMatrix * uMVMatrix * vec4(aVertexPosition, 1.0);\n"+
"    vTextureCoord = aTextureCoord;\n"+
"}\n";
        shader = gl.createShader(gl.VERTEX_SHADER);
    } else {
        return null;
    }

    gl.shaderSource(shader, str);
    gl.compileShader(shader);

    if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
        alert(gl.getShaderInfoLog(shader));
        return null;
    }
    return shader;
}

function initShaders() {
    var fragmentShader = getShader(gl, 'x-fragment');
    var vertexShader = getShader(gl, 'x-vertex');

    shaderProgram = gl.createProgram();
    gl.attachShader(shaderProgram, vertexShader);
    gl.attachShader(shaderProgram, fragmentShader);
    gl.linkProgram(shaderProgram);

    if (!gl.getProgramParameter(shaderProgram, gl.LINK_STATUS)) {
        alert('Can`t initialise shaders');
    }

    gl.useProgram(shaderProgram);

    shaderProgram.vertexPositionAttribute = gl.getAttribLocation(shaderProgram, 'aVertexPosition');
    gl.enableVertexAttribArray(shaderProgram.vertexPositionAttribute);

    shaderProgram.textureCoordAttribute = gl.getAttribLocation(shaderProgram, 'aTextureCoord');
    gl.enableVertexAttribArray(shaderProgram.textureCoordAttribute);

    shaderProgram.pMatrixUniform = gl.getUniformLocation(shaderProgram, 'uPMatrix');
    shaderProgram.mvMatrixUniform = gl.getUniformLocation(shaderProgram, 'uMVMatrix');
    shaderProgram.samplerUniform = gl.getUniformLocation(shaderProgram, 'uSampler');
}

var objVertexPositionBuffer=new Array();
var objVertexTextureCoordBuffer=new Array();
var objVertexIndexBuffer=new Array();

function initObjBuffers() {
    for (var i=0;i<pics_num;i=i+1) {
        objVertexPositionBuffer[i] = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, objVertexPositionBuffer[i]);
	switch(i){
        case 0:vertices = [
            // Front face
            -1.0, -1.0,  1.0,
             1.0, -1.0,  1.0,
             1.0,  1.0,  1.0,
            -1.0,  1.0,  1.0,
		]; 
		break;
        case 1:vertices = [
            // Back face
            -1.0, -1.0, -1.0,
            -1.0,  1.0, -1.0,
             1.0,  1.0, -1.0,
             1.0, -1.0, -1.0,
		]; 
		break;
        case 2:vertices = [
            // Top face
            -1.0,  1.0, -1.0,
            -1.0,  1.0,  1.0,
             1.0,  1.0,  1.0,
             1.0,  1.0, -1.0,
		]; 
		break;
        case 3:vertices = [
            // Bottom face
            -1.0, -1.0, -1.0,
             1.0, -1.0, -1.0,
             1.0, -1.0,  1.0,
            -1.0, -1.0,  1.0,
		]; 
		break;
        case 4:vertices = [
            // Right face
             1.0, -1.0, -1.0,
             1.0,  1.0, -1.0,
             1.0,  1.0,  1.0,
             1.0, -1.0,  1.0,
		]; 
		break;
        case 5:vertices = [
            // Left face
            -1.0, -1.0, -1.0,
            -1.0, -1.0,  1.0,
            -1.0,  1.0,  1.0,
            -1.0,  1.0, -1.0,
		];
	};
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertices), gl.STATIC_DRAW);
        objVertexPositionBuffer[i].itemSize = 3;
        objVertexPositionBuffer[i].numItems = 4;

        objVertexTextureCoordBuffer[i] = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER,  objVertexTextureCoordBuffer[i] );
        var textureCoords = [
            0.0, 0.0,
            1.0, 0.0,
            1.0, 1.0,
            0.0, 1.0,
        ];
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(textureCoords), gl.STATIC_DRAW);
        objVertexTextureCoordBuffer[i].itemSize = 2;
        objVertexTextureCoordBuffer[i].numItems = 4;

        objVertexIndexBuffer[i] = gl.createBuffer();
        gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, objVertexIndexBuffer[i]);
        var objVertexIndices = [
            0, 1, 2,
            0, 2, 3,  
        ];
        gl.bufferData(gl.ELEMENT_ARRAY_BUFFER, new Uint16Array(objVertexIndices), gl.STATIC_DRAW);
        objVertexIndexBuffer[i].itemSize = 1;
        objVertexIndexBuffer[i].numItems = 6;
    }
}

function handleLoadedTexture(texture) {
    gl.bindTexture(gl.TEXTURE_2D, texture);
    gl.pixelStorei(gl.UNPACK_FLIP_Y_WEBGL, true);
    gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, texture.image);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
    gl.bindTexture(gl.TEXTURE_2D, null);
}


var crateTextures = Array();
function initTexture(image) {
    var crateImage = new Image();

    var texture = gl.createTexture();
    texture.image = crateImage;
    crateImage.src = image;

    crateImage.onload = function () {
        handleLoadedTexture(texture)
    }
    return texture;
}

function initTextures() {
    for (var i=0; i < pics_num; i++) {
        crateTextures[i]=initTexture(pics_names[i]);
    }
}

var mvMatrix = mat4.create();
var mvMatrixStack = [];
var pMatrix = mat4.create();

function setMatrixUniforms() {
    gl.uniformMatrix4fv(shaderProgram.pMatrixUniform, false, pMatrix);
    gl.uniformMatrix4fv(shaderProgram.mvMatrixUniform, false, mvMatrix);
}

function degToRad(degrees) {
    return degrees * Math.PI / 180;
}


// mouse and keyboard handlers

var xRot = 0;
var xSpeed = 0;
var yRot = 0;
var ySpeed = 10;
var z = -3.0;

var currentlyPressedKeys = {};
function handleKeyDown(event) {
    currentlyPressedKeys[event.keyCode] = true;
}

function handleKeyUp(event) {
    currentlyPressedKeys[event.keyCode] = false;
}

function handleKeys() {
    if (currentlyPressedKeys[33]) { // Page Up
        z -= 0.05;
    }
    if (currentlyPressedKeys[34]) { // Page Down
        z += 0.05;
    }
    if (currentlyPressedKeys[37]) { // Left cursor key
        ySpeed -= 1;
    }
    if (currentlyPressedKeys[39]) { // Right cursor key
        ySpeed += 1;
    }
    if (currentlyPressedKeys[38]) { // Up cursor key
        xSpeed -= 1;
    }
    if (currentlyPressedKeys[40]) { // Down cursor key
        xSpeed += 1;
    }
}

var mouseDown = false;
var lastMouseX = null;
var lastMouseY = null;

var RotationMatrix = mat4.create();
mat4.identity(RotationMatrix);

function handleMouseDown(event) {
    mouseDown = true;
    lastMouseX = event.clientX;
    lastMouseY = event.clientY;
}

function handleMouseUp(event) {
    mouseDown = false;
}

function handleMouseMove(event) {
    if (!mouseDown) {
      return;
    }
    var newX = event.clientX;
    var newY = event.clientY;

    var deltaX = newX - lastMouseX;
    var newRotationMatrix = mat4.create();
    mat4.identity(newRotationMatrix);
    mat4.rotate(newRotationMatrix, degToRad(deltaX / 5), [0, 1, 0]);

    var deltaY = newY - lastMouseY;
    mat4.rotate(newRotationMatrix, degToRad(deltaY / 5), [1, 0, 0]);

    mat4.multiply(newRotationMatrix, RotationMatrix, RotationMatrix);

    lastMouseX = newX
    lastMouseY = newY;
}

// Draw scene and initialization

var MoveMatrix = mat4.create();
mat4.identity(MoveMatrix);

function drawScene() {
    gl.viewport(0, 0, gl.viewportWidth, gl.viewportHeight);
    gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

    mat4.perspective(95, gl.viewportWidth / gl.viewportHeight, 0.1, 100.0, pMatrix);

    mat4.identity(mvMatrix);

    mat4.translate(mvMatrix, [0.0, 0.0, z]);

    mat4.rotate(mvMatrix, degToRad(xRot), [1, 0, 0]);
    mat4.rotate(mvMatrix, degToRad(yRot), [0, 1, 0]);

    mat4.multiply(mvMatrix, MoveMatrix);
    mat4.multiply(mvMatrix, RotationMatrix);

    for (var i=0;i<pics_num;i=i+1) {
        gl.bindBuffer(gl.ARRAY_BUFFER, objVertexPositionBuffer[i]);
        gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, objVertexPositionBuffer[i].itemSize, gl.FLOAT, false, 0, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, objVertexTextureCoordBuffer[i]);
        gl.vertexAttribPointer(shaderProgram.textureCoordAttribute, objVertexTextureCoordBuffer[i].itemSize, gl.FLOAT, false, 0, 0);

        gl.activeTexture(gl.TEXTURE0);
        gl.bindTexture(gl.TEXTURE_2D, crateTextures[i]);
        gl.uniform1i(shaderProgram.samplerUniform, 0);

        gl.bindBuffer(gl.ELEMENT_ARRAY_BUFFER, objVertexIndexBuffer[i]);
        setMatrixUniforms();
        gl.drawElements(gl.TRIANGLES, objVertexIndexBuffer[i].numItems, gl.UNSIGNED_SHORT, 0);
    }
}

var lastTime = 0;
function animate() {
    var timeNow = new Date().getTime();
    if (lastTime != 0) {
        var elapsed = timeNow - lastTime;

        xRot += (xSpeed * elapsed) / 1000.0;
        yRot += (ySpeed * elapsed) / 1000.0;
    }
    lastTime = timeNow;
}

function drawFrame() {
    requestAnimFrame(drawFrame);
    handleKeys();
    drawScene();
    animate();
}

function webGLStart() {
    var canvas = document.getElementById('prosty');
    initGL(canvas);
    initShaders();
    initObjBuffers();
    initTextures();

        gl.clearColor(0.0, 0.0, 0.0, 1.0);
    gl.enable(gl.DEPTH_TEST);

    document.onkeydown = handleKeyDown;
    document.onkeyup = handleKeyUp;

    canvas.onmousedown = handleMouseDown;
    document.onmouseup = handleMouseUp;
    document.onmousemove = handleMouseMove;

    drawFrame();
}
</script>