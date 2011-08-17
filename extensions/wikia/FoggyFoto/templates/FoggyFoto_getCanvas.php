<html>
  <head>
    <title>Simple game with HTML5 Canvas</title>
	<meta name="viewport" content = "width=device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, user-scalable = no" />
	
<!-- TODO: MOVE TO A SEPARATE FILE SO THE DEVICE CAN CACHE IT. -->
	<style>
		html {
			margin:0px;
			padding:0px;
		}
		body {
			margin:0px;
			padding:0px;
			text-align:center;
			background-color:#333;
		}
		canvas{
			outline:0;
			border:0px;
			position:absolute;
			top:0px;
			left:0px;
			background-color:#000;
		}
	</style>
  </head>
  <body onload="initGame()">
    <canvas id='foggyCanvas' width="<?= $canvasWidth ?>" height="<?= $canvasHeight ?>"></canvas>
    <script src="<?= $gameJs ?>"></script>
  </body>
</html>