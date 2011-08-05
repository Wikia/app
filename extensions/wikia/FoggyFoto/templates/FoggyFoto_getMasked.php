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
		#gameBoard{
			width: <?= $boardWidth ?>;
			height: <?= $boardHeight ?>;
			background: url(<?= $backImageSrc ?>) no-repeat;
		}
		#gameBoard *{
			-webkit-tap-highlight-color: rgba( 0,0,0,0 );
			-webkit-focus-ring-color: rgba( 0,0,0,0 );
		}
		#gameBoard div{
			margin: 0;
			padding: 0;
			position: absolute;
			width: <?= $tileWidth ?>;
			height: <?= $tileHeight ?>;
			-webkit-transition: opacity .75s ease-in-out;
			-moz-transition: opacity .75s ease-in-out;
			-o-transition: opacity .75s ease-in-out;
			-ms-transition: opacity .75s ease-in-out;
			transition: opacity .75s ease-in-out;
		}
		#gameBoard a:hover{
			background-color:#00f;
			display:block;
			width: 100%;
			height: <?= $tileHeight ?>;
		}
		.transparent{
			opacity: 0;
		}
		<?php
			// Create the CSS rules to position the tiles and sprite the frontImage over them.
			for($row = 0;  $row < $numRows; $row++){
				$top = ($row * $tileHeight);
				for($col = 0; $col < $numCols; $col++){
					$left = ($col * $tileWidth);
					print "\t\t#sprite_{$row}_{$col}{"; // intentionally no trailing linebreak here
					print "top: {$top}px; ";
					print "left: {$left}px; ";
					print "background: transparent url({$frontImageSrc}) -{$left}px -{$top}px; ";
					print "}\n";
				}
			}
		?>
	</style>
	
	<!-- TODO: Serve from our own servers using AssetsManager -->
	<script>
		wgScriptPath = '<?= $wgScriptPath; ?>';
	</script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script type="text/javascript" src="<?= $mwJsApiUrl ?>"></script>
  </head>
  <body>
    <script src="<?= $gameJs ?>"></script>
	<div id='gameBoard'>
		<?php
			for($row = 0;  $row < $numRows; $row++){
				for($col = 0; $col < $numCols; $col++){
					print "<div id='sprite_{$row}_{$col}'></div>";
				}
				print "<br/>\n";
			}
		?>
	</div>
  </body>
</html>
