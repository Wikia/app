<html>
	<head>
		<title>Simple game with HTML5 Canvas</title>
		<meta name="viewport" content = "width=device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, user-scalable = no" />
		
	<!-- TODO: MOVE TO A SEPARATE FILE SO THE DEVICE CAN CACHE IT. -->
		<style>
<?php
	$SCORE_BAR_WIDTH = "10";
?>
			html {
				margin:0px;
				padding:0px;
			}
			body {
				margin:0px;
				padding:0px;
				text-align:center;
				background-color:#333;
				
				font-family:helvetica;
				font-weight:bold;
			}
			#gameBoard{
				width: <?= $boardWidth ?>px;
				height: <?= $boardHeight ?>px;
			}
			#bgWrapper{
				position:absolute;
				top: 0;
				left: 0;
				width: <?= $boardWidth ?>px;
				height: <?= $boardHeight ?>px;
				margin: 0;
				padding: 0;
				overflow:hidden;
				z-index: 10; /* hide it in the back */
			}
			#bgPic{
				position:absolute;
			}
			#gameBoard, #gameBoard *{
				-webkit-tap-highlight-color: rgba( 0,0,0,0 );
				-webkit-focus-ring-color: rgba( 0,0,0,0 );

				margin: 0;
				padding: 0;
				position: absolute;
			}
			#gameBoard .tile{
				width: <?= $tileWidth ?>px;
				height: <?= $tileHeight ?>px;
				-webkit-transition: opacity .75s ease-in-out;
				-moz-transition: opacity .75s ease-in-out;
				-o-transition: opacity .75s ease-in-out;
				-ms-transition: opacity .75s ease-in-out;
				transition: opacity .75s ease-in-out;
				
				z-index: 20; /* show up on top of the background image */
			}
			#gameBoard a:hover{
				background-color:#00f;
				display:block;
				width: 100%;
				height: <?= $tileHeight ?>px;
			}
			#scoreBarWrapper{
				position:absolute;
				left:0;
				top:0;
				height: <?= $boardHeight ?>px;
				width: <?= $SCORE_BAR_WIDTH ?>px;
				border-left: 1px solid black;
				border-right: 1px solid black;
				padding: 0 2px 0 2px;

/*
	This makes the actual score-bar semi-transparent too. Would have to take it out of the wrapper to fix that.
	background-color:#ccc;
	opacity:0.4;filter:alpha(opacity=40);
*/

				z-index:23;
			}
			#scoreBar{
				background-color: #0f0;
				position:absolute;
				bottom:0px;
				margin: 0;
				padding: 0;
				width: <?= $SCORE_BAR_WIDTH ?>px;
/* TODO: Start at 100% and make sure we can change this programatically based on the score. */
height: 100%;

				z-index:24;
			}
			#hudBg{
				position:absolute;
				bottom:0;
				width:100%;
				background-color:#000;
				opacity:0.4;filter:alpha(opacity=40);
				height: 1.5em;
				z-index:22; /* below the scoreBarWrapper but above the frontImage */
			}
			#hud{
				position:absolute;
				bottom: 0;
				width:100%;
				text-align:left;
/* Twice the width of the prog-bar? */
left: 20px;

				height:1em;
				padding-bottom:0.25em;
				color:white;

				z-index:25;
			}
			#hud span{
				margin-left:2px;
				color:#adff2f;
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
						print "\t\t\t#sprite_{$row}_{$col}{"; // intentionally no trailing linebreak here
						print "top: {$top}px; ";
						print "left: {$left}px; ";
						print "background: transparent url({$frontImageSrc}) -{$left}px -{$top}px; ";
						print "}\n";
					}
				}
			?>
		</style>

		<script>
			wgScriptPath = '<?= $wgScriptPath; ?>';
		</script>
<!-- TODO: Serve from our own servers using AssetsManager -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
		<script type="text/javascript" src="<?= $mwJsApiUrl ?>"></script>
	</head>
	<body>
		<script src="<?= $gameJs ?>"></script>
		<div id='scoreBarWrapper'>
			<div id='scoreBar'></div>
		</div>
		<div id='bgWrapper'>
			<div id='bgPic'></div>
		</div>
		<div id='gameBoard'>
			<div id='hudBg'></div>
			<div id='hud'>
				<?= wfMsg('foggyfoto-score', 0) ?>

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?= wfMsg('foggyfoto-progress', wfMsg('foggyfoto-progress-numbers', 0, $photosPerGame)) ?>

			</div>
<?php
				for($row = 0;  $row < $numRows; $row++){
					for($col = 0; $col < $numCols; $col++){
						print "\t\t\t<div class='tile' id='sprite_{$row}_{$col}'></div>\n";
					}
					print "\t\t\t<br/>\n";
				}
			?>
		</div>
	</body>
</html>
