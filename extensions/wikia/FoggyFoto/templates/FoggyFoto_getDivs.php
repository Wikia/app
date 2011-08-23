<html>
	<head>
		<title>Simple game with HTML5 Canvas</title>
		<meta name="viewport" content = "width=device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, user-scalable = no" />
		
	<!-- TODO: MOVE TO A SEPARATE FILE SO THE DEVICE CAN CACHE IT?  At least move the parts that don't depend on variables. -->
		<style>
<?php
	$SCORE_BAR_WIDTH = "10";
	$NUM_ANSWER_CHOICES = 4;
	$CONTINUE_FONT_SIZE_PX = 24;
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
			
		/** ANSWER DRAWER - BEGIN **/
			#answerDrawerWrapper{
				position:static;
				float:right;
				right:0px;
				height: 100%;
				width:<?= $answerButtonWidth ?>px;
			}
			#answerDrawer{
				top: 50%;
				margin-top: -<?= floor($answerDrawerHeight / 2) ?>px;
				height: <?= $answerDrawerHeight ?>px;
			}
			#answerButton, #continueButton{
				top:50%;
				margin-top:-<?= floor($answerButtonWidth/2) ?>px;
				width:<?= $answerButtonWidth ?>px;
				height:<?= $answerButtonWidth ?>px;
				cursor:pointer;
				z-index:30;
			}
			#continueButton{
				background-color:#333;
				opacity:0.7;filter:alpha(opacity=70);
				display:none;
			}
			#continueText{
				top:50%;
				margin-top:-<?= floor($answerButtonWidth/2) ?>px;
				font-size:<?= $CONTINUE_FONT_SIZE_PX ?>px;
				padding:<?= floor(($answerButtonWidth - $CONTINUE_FONT_SIZE_PX) / 2) ?>px;
				height:<?= $CONTINUE_FONT_SIZE_PX ?>px;
				line-height:<?= $CONTINUE_FONT_SIZE_PX ?>px;
				right: 0px; /* start to the left of the continue button */
				cursor:pointer;
				
				color:#fff;
				background-color:#333;
				opacity:0.7;filter:alpha(opacity=70);
				border-top-left-radius: 15px;
				border-bottom-left-radius: 15px;
				
				display:none;
				z-index:30;
			}
			#answerListWrapper{
				height:100%;
				width:<?= ($answerDrawerWidth + floor($answerButtonWidth/2)) ?>px;
				margin-left:<?= floor($answerButtonWidth/2) ?>px;

				display:none; /* Starts hidden and is toggled by the answer-button */

				z-index:29; /* below the question mark, but above everything else */
			}
			#answerListWrapper *{
				position:static;
			}
			#answerListWrapper ul{
				list-style-type:none;
				height:100%;
			}
			#answerListWrapper ul li{
				height:25%;
				opacity:0.8;filter:alpha(opacity=80);
				color:#215B68;
				background-color:#adff2f;
				border-bottom:1px solid #cdff5f;
				line-height: <?= floor($answerDrawerHeight / $NUM_ANSWER_CHOICES) ?>px;
				cursor:pointer;
			}
			#answerListWrapper ul li.incorrect{
				background-color:#ff8080;
			}
			#answerListWrapper ul li.first{
				border-top-left-radius: 15px;
			}
			#answerListWrapper ul li.last{
				border-bottom:0px;
				border-bottom-left-radius: 15px;
			}
		/** ANSWER DRAWER - END **/
			
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
	This makes the actual score-bar semi-transparent too. Would have to take it out of the wrapper & make it a sibling to fix that... which we'll have to do since we don't know what color the background images or watermarks will be.
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
				bottom: 0;
				width:100%;
				text-align:left;
				left: <?= ($SCORE_BAR_WIDTH * 2) ?>px;

				height:1em;
				padding-bottom:0.25em;

				z-index:25;
			}
			#hud div{
				color:white;
				position:static;
				float:left;
				width:30%
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
			boardWidth = <?= $boardWidth ?>;
			boardHeight = <?= $boardHeight ?>;
		</script>
<!-- TODO: Serve from our own servers using AssetsManager -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
		<?= $globalVariablesScript ?>
		<script src="<?= $jsMessagesUrl ?>"></script>
		<script src="<?= $mwJsApiUrl ?>"></script>
	</head>
	<body>
		<script src="<?= $gameJs_FlipBoard ?>"></script>
		<script src="<?= $gameJs ?>"></script>
		<div id='scoreBarWrapper'>
			<div id='scoreBar'></div>
		</div>
		<div id='bgWrapper'>
			<div id='bgPic'></div>
		</div>
		<div id='gameBoard'>
			<div id='answerDrawerWrapper'>
				<div id='answerDrawer'>
					<div id='answerButton'>
						<img src='<?= $answerButtonSrc ?>'/>
					</div>
					<div id='continueText'>
						<?= wfMsg('foggyfoto-continue') ?>
					</div>
					<div id='continueButton'>
						<img src='<?= $continueButtonSrc ?>'/>
					</div>
					<div id='answerListWrapper'>
						<ul>
							<li class='first'></li>
							<li></li>
							<li></li>
							<li class='last'></li>
						</ul>
					</div>
				</div>
			</div>
			<div id='hudBg'></div>
			<div id='hud'>
					<div class='score'>
						<?= wfMsg('foggyfoto-score', 0) ?>
					</div>

					<div class='progress'>
						<?= wfMsg('foggyfoto-progress', wfMsg('foggyfoto-progress-numbers', 0, $photosPerGame)) ?>
					</div>
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
