<html>
	<head>
		<title><?= wfMsg('photopop-title-tag-playgame', $wg->Sitename, $categoryReadable) ?></title>
		<meta name="viewport" content = "width=device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, user-scalable = no" />

	<!-- TODO: MOVE TO A SEPARATE FILE SO THE DEVICE CAN CACHE IT?  At least move the parts that don't depend on variables. -->
		<style>
<?php
	$SCORE_BAR_WIDTH = "10";
	$NUM_ANSWER_CHOICES = 4;
	$CONTINUE_FONT_SIZE_PX = 24;
	$TIME_UP_FONT_SIZE_PX = ($CONTINUE_FONT_SIZE_PX * 2);
	$END_GAME_BORDER_RADIUS = 15;

	// TODO: REFACTOR: If front-end team has a sec, it would be nice to have them take a look over it and see what we can clean up.

	// TODO: REFACTOR: Figure out how to get as much of this CSS out of the PHP and into an external file (so it can be cached).  Most of the templates in this extension need this refactoring (home screen was done right though).
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
				overflow:hidden;
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

				z-index: 20; /* show up on top of the background image */
			}
			.opacityTransition{
				-webkit-transition: opacity .33s ease-in-out;
				-moz-transition: opacity .33s ease-in-out;
				-o-transition: opacity .33s ease-in-out;
				-ms-transition: opacity .33s ease-in-out;
				transition: opacity .33s ease-in-out;
			}
			.noTransition{
				-webkit-transition: none;
				-moz-transition: none;
				-o-transition: none;
				-ms-transition: none;
				transition: none;
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
			#answerButton_toOpen, #answerButton_toClose{
				top:50%;
				margin-top:-<?= floor($answerButtonWidth/2) ?>px;
				width:<?= $answerButtonWidth ?>px;
				height:<?= $answerButtonWidth ?>px;
				cursor:pointer;
				z-index:30;
			}
			#continueButton{
				top:50%;
				margin-top:-<?= floor($continueButtonWidth/2) ?>px;
				width:<?= $continueButtonWidth ?>px;
				height:<?= $continueButtonWidth ?>px;
				cursor:pointer;
				z-index:30;

				right:0px;
				display:none;
			}
			#answerButton_toClose{ /* start closed... will toggle when needed */
				display:none;
			}
			#continueText, #timeUpText{
				top:50%;
				white-space:nowrap;
				color:#fff;

				display:none;
				z-index:30;
			}
			#continueText{
				background-color:rgba(51,51,51,0.7);
				font-size:<?= $CONTINUE_FONT_SIZE_PX ?>px;
				height:<?= $CONTINUE_FONT_SIZE_PX ?>px;
				line-height:<?= $CONTINUE_FONT_SIZE_PX ?>px;
				right: <?= $continueButtonWidth ?>px; /* start to the left of the continue button */

				margin-top:-<?= floor($continueButtonWidth/2) ?>px;
				padding:<?= floor(($continueButtonWidth - $CONTINUE_FONT_SIZE_PX) / 2) ?>px;
				padding-right:<?= floor(($continueButtonWidth - $CONTINUE_FONT_SIZE_PX) / 2) + floor($continueButtonWidth / 2) ?>px; /* make space for the background to cover half of the continue button */
				margin-right:-<?= floor($continueButtonWidth / 2); ?>px; /* make the background attach to the left hand side of the button */
				
				cursor:pointer;
				border-top-left-radius: 15px;
				border-bottom-left-radius: 15px;
			}
			#timeUpText{
				left:0px;
				width:100%;
				text-align:center;
				height:<?= $TIME_UP_FONT_SIZE_PX ?>px;
				margin-top:-<?= $TIME_UP_FONT_SIZE_PX ?>px;
			}
			#timeUpText .timeUpTextInner{
				background-color:rgba(51,51,51,0.7);
				font-size:<?= $TIME_UP_FONT_SIZE_PX ?>px;
				line-height:<?= $TIME_UP_FONT_SIZE_PX ?>px;
				padding:<?= floor($TIME_UP_FONT_SIZE_PX / 2) ?>px;
				display:inline-block;
				position:static;

				margin-left:auto;
				margin-right:auto;

				border-radius: 15px;
			}
			#answerListWrapper{
				height:100%;
				width:<?= ($answerDrawerWidth + floor($answerButtonWidth/2)) ?>px;
				margin-left:<?= floor($answerButtonWidth/2) ?>px;

				display:none; /* Starts hidden and is toggled by the answer-button */

				z-index:29; /* below the question mark, but above everything else */
			}
			#answerListFalseEdge{ /* We added this edge late in the game, so just fake the edge of the Wrapper */
				height:100%;
				width:<?= floor($answerButtonWidth / 2) ?>px;
				margin-right:-<?= $answerButtonWidth ?>px;
				right:0px;
				border-top-left-radius: 15px;
				border-bottom-left-radius: 15px;

				opacity:0.8;filter:alpha(opacity=80);
				color:#215B68;
				background-color:#adff2f;

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
				border-bottom:1px solid #fff;
				line-height: <?= floor($answerDrawerHeight / $NUM_ANSWER_CHOICES) ?>px;
				overflow:hidden;
				cursor:pointer;
			}
			#answerListWrapper ul li.incorrect{
				color:white;
				/* GRADIENT BACKGROUND */<?php /* Props to http://ie.microsoft.com/testdrive/graphics/cssgradientbackgroundmaker/default.html */ ?>
					/* IE10 */ 
					background-image: -ms-linear-gradient(top, #B60000 32%, #D72828 47%, #B60000 83%);
					/* Mozilla Firefox */ 
					background-image: -moz-linear-gradient(top, #B60000 32%, #D72828 47%, #B60000 83%);
					/* Opera */ 
					background-image: -o-linear-gradient(top, #B60000 32%, #D72828 47%, #B60000 83%);
					/* Webkit (Safari/Chrome 10) */ 
					background-image: -webkit-gradient(linear, left top, left bottom, color-stop(.32, #B60000), color-stop(.47, #D72828), color-stop(.83, #B60000));
					/* Webkit (Chrome 11+) */ 
					background-image: -webkit-linear-gradient(top, #B60000 32%, #D72828 47%, #B60000 83%);
					/* Proposed W3C Markup */ 
					background-image: linear-gradient(top, #B60000 32%, #D72828 47%, #B60000 83%);
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

				background-color: rgba(204, 204, 204, 0.4);

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
			#hud{
				position:absolute;
				bottom: 0;
				width:100%;
				text-align:left;
				
				background-color: rgba(0, 0, 0, 0.4);
				padding-left: <?= ($SCORE_BAR_WIDTH * 3) ?>px;
				padding-top: 2px;
				padding-bottom:2px;

				height: <?= $homeButtonHeight ?>px;

				z-index:22;
			}
			#hud .home, #hud div a:hover{
				width: <?= $homeButtonWidth ?>px;
				height: <?= $homeButtonHeight ?>px;
				padding-right: 15px;
				background-color:transparent;
			}
			#hud div{
				color:white;
				position:static;
				float:left;
				width:30%;
				line-height: <?= $homeButtonHeight ?>px;
				height: <?= $homeButtonHeight ?>px;
			}
			#hud span{
				margin-left:2px;
				color:#adff2f;
			}
			.transparent{
				opacity: 0;
			}
			
		/** END-GAME SCREEN-OVERLAY - BEGIN **/
			#endGameOuterWrapper{
				display:none;

				width:100%;
				height:100%;
				background-color: rgba(0, 0, 0, 0.5);
				z-index:50; /* overlays all previous elements when shown */
			}
			#endGameInnerWrapper{
				position:relative;
				top:50%;
				margin-top:-<?= (floor($endGame_overlayHeight/2) + $endGame_highScoreHeight) ?>px;
				left:50%;
				margin-left:-<?= floor($endGame_overlayWidth/2) ?>px;
				width:<?= $endGame_overlayWidth ?>px;
				height:<?= $endGame_overlayHeight + $endGame_highScoreHeight ?>px;
			}
			
			#endGameInnerWrapper #highScore{
				color:white;
				background-color:#043C6F;
				display:inline-block;
				height:<?= $endGame_highScoreHeight ?>px;
				line-height:<?= $endGame_highScoreHeight ?>px;
				font-weight:normal;
				padding:0 10px 0 10px;
				border: 1px solid #156290;
				border-top-left-radius:5px;
				border-top-right-radius:5px;
				right:<?= $END_GAME_BORDER_RADIUS ?>px;
				font-size:14px;
			}
			
			#endGameInnerWrapper #summaryWrapper{
				margin-top:<?= $endGame_highScoreHeight ?>px;
				height:<?= $endGame_overlayHeight ?>px;
				width:<?= $endGame_overlayWidth ?>px;
				width:100%;
				color:white;
				background-color: #89c440;
				border-radius:<?= $END_GAME_BORDER_RADIUS ?>px;
			}
			#endGameInnerWrapper #summaryWrapper #endGameSummary{
				width:<?= $endGame_overlayWidth ?>px;
				height:<?= $endGame_overlayHeight ?>px;


			}
			#endGameInnerWrapper #summaryWrapper #endGameSummary *{
				position:static;
			}
				#endGameInnerWrapper #summaryWrapper #endGameSummary .headingText{
					width:100%;
					text-align:center;
					color:#00396d;
					padding:10px;
					font-size:2.5em;
				}
				#endGameInnerWrapper #summaryWrapper #endGameSummary .summaryTextWrapper{
					width:100%;
				}
				#endGameSummary .summaryTextWrapper .summaryText_completion{
				}
				#endGameSummary .summaryTextWrapper .summaryText_score{
					margin-top:10px;
					font-size:1.25em;
				}
			#playAgain, #goHome, #goToHighScores, #summaryWrapper a:hover{
				width:<?= $endGameButtonSize ?>px;
				height:<?= $endGameButtonSize ?>px;
				bottom:0px;
				margin-bottom: -<?= floor($endGameButtonSize/2) ?>px;
				background-color:transparent; /* so the link hover doesn't show up */
			}
			#playAgain{
				left:<?= $END_GAME_BORDER_RADIUS ?>px;
			}
			#goHome{
				left:50%;
				margin-left:-<?= floor($endGameButtonSize/2) ?>px;
			}
			#goToHighScores{
				right:<?= $END_GAME_BORDER_RADIUS ?>px;
			}
		/** END-GAME SCREEN-OVERLAY - END **/
			
<?php
				// Create the CSS rules to position the tiles and sprite the frontImage over them.
				for($row = 0;  $row < $numRows; $row++){
					$top = ($row * $tileHeight);
					for($col = 0; $col < $numCols; $col++){
						$left = ($col * $tileWidth);
						print "\t\t\t#sprite_{$row}_{$col}{"; // intentionally no trailing linebreak here
						print "top: {$top}px; ";
						print "left: {$left}px; ";
						print "background: #6495ed url({$frontImageSrc}) -{$left}px -{$top}px; ";
						print "}\n";
					}
				}
			?>
		</style>

		<script>
			wgScriptPath = '<?= $wg->ScriptPath; ?>';
			boardWidth = <?= $boardWidth ?>;
			boardHeight = <?= $boardHeight ?>;
			photoPopCategory = '<?= $category ?>';
		</script>
<!-- TODO: Serve from our own servers using AssetsManager or convert to using jQuery Mobile (should help for the selector-screen) -->
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
			<div id='endGameOuterWrapper'>
				<div id='endGameInnerWrapper'>
					<div id='highScore'>
						<!-- Current high score will be filled in here by JSMessaging at the end of the game -->
<!-- TODO: MAKE THIS REAL, USING JSMessaging ... just here for now so that we can see if the design is right -->
<?= wfMsg('photopop-endgame-highscore-summary', number_format(38231)) ?>
<!-- TODO: MAKE THIS REAL, USING JSMessaging ... just here for now so that we can see if the design is right -->
					</div>
					<div id='summaryWrapper'>
						<div id='endGameSummary'>
							<div class='headingText'>
								<?= wfMsg('photopop-finished-heading') ?>
							</div>
							<div class='summaryTextWrapper'>
								<!-- Summary will be filled in here by JSMessaging at the end of the game -->
								<div class='summaryText_completion'>
								</div>
								<div class='summaryText_score'>
								</div>
							</div>
						</div>
						<a id='playAgain' href='javascript:location.reload(true)'><img src='<?= $endGame_playAgainSrc ?>'/></a>
						<a id='goHome' href='<?= $url_goHome ?>'><img src='<?= $endGame_goHomeSrc ?>'/></a>
						<a id='goToHighScores' href='<?php /* TODO: EMIT AN EVENT FOR THE TITANIUM WRAPPER TO CATCH */ ?>'><img src='<?= $endGame_goToHighScoresSrc ?>'/></a>
					</div>
				</div>
			</div>
			<div id='timeUpText'>
				<div class='timeUpTextInner'>
					<?= wfMsg('photopop-continue-timeup') ?>
				</div>
			</div>
			<div id='continueText'>
				<?= wfMsg('photopop-continue-correct') ?>
			</div>
			<div id='continueButton'>
				<img src='<?= $continueButtonSrc ?>'/>
			</div>
			<div id='answerDrawerWrapper'>
				<div id='answerDrawer'>
					<div class='answerButton' id='answerButton_toOpen'>
						<img src='<?= $answerButtonSrc_toOpen ?>'/>
					</div>
					<div class='answerButton' id='answerButton_toClose'>
						<img src='<?= $answerButtonSrc_toClose ?>'/>
					</div>
					<div id='answerListFalseEdge'>
						<!-- This is just for effect -->
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
			<div id='hud'>
				<div class='home'>
					<a href='<?= $url_goHome ?>'><img src='<?= $homeButtonSrc ?>'/></a>
				</div>

				<div class='score'>
					<?= wfMsg('photopop-score', 0) ?>
				</div>

				<div class='progress'>
					<?= wfMsg('photopop-progress', wfMsg('photopop-progress-numbers', 0, $photosPerGame)) ?>
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
