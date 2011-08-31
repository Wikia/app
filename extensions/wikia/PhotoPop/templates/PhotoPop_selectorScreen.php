<html>
	<head>
		<title><?= wfMsg('photopop-title-tag-selectorscreen') ?></title>
		<meta name="viewport" content = "width=device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, user-scalable = no" />
		<style><?php
		
		$PADDING_AROUND_ICONS = 15;

		?>
		html {
			margin:0px;
			padding:0px;
		}
		body {
			margin:0px;
			padding:0px;
		}
		body div.ui-body-c{
			background:#333 !important;
		}
		#wrapper{
			width: <?= $boardWidth ?>px;
			height: <?= $boardHeight ?>px;
			overflow:hidden;
			background: #00396D url(<?= $BG_IMAGE ?>);
			position:absolute;
			left:0px;
			top:0px;
		}
		#photopop_logo{
			text-align:center;
			width:100%;
			margin-top:5px;
		}
		#sliderWrapper{
			height: <?=  $buttonHeight + $iconHeight + ($PADDING_AROUND_ICONS * 2) ?>px;
			position:absolute;
			bottom:0px;
			z-index:10;

			background-color:#fff;
		}
		#closeButton{
			left:50%;
			margin-left:-<?= floor($buttonWidth/2) ?>px;
			margin-top:-<?= floor($buttonHeight/2) ?>px;
			position:absolute;
			z-index:20;
		}
		.sliderContent {
			top:<?= (floor($buttonHeight/2) - 5) ?>px;
			bottom:0px;
			background-color:transparent;
			overflow: hidden;
			width: <?= $boardWidth ?>px;
		}

		.ui-content.ui-scrollview-clip {
			padding: 0;
		}
		.ui-content.ui-scrollview-clip > div.ui-scrollview-view {
			margin: 0;
		}
		.ui-content.ui-scrollview-clip > .ui-listview.ui-scrollview-view {
			margin: 0;
		}
		.gameIcon {
			width: <?= $iconWidth ?>px;
			height: <?= $iconHeight + $textHeight + $textOffset + ($PADDING_AROUND_ICONS * 2)?>px;
			padding: <?= $PADDING_AROUND_ICONS ?>px;
			text-align: center;
			margin:0px;
			font-weight:bold;
			color:#00396d;
		}
		.gameIcon img{
			box-shadow:0px 0px 15px #555;
			-webkit-box-shadow:0px 0px 15px #555;
			-moz-box-shadow:0px 0px 15px #555;
		}
		
		.sliderContent > .ui-scrollview-view {
			width: <?= $numItems * ($iconWidth + ($PADDING_AROUND_ICONS * 2))?>px;
		}
		.sliderContent .gameIcon {
			float: left;
		}
		.gameName{
			margin-top:<?= $textOffset ?>px;
		}
		</style>

		<?= $jQueryMobile ?>
	</head>
	<body>
		<div id='wrapper'>
			<div id='photopop_logo'>
				<img src='<?= $PHOTOPOP_LOGO ?>'/>
			</div>
			<div id='sliderWrapper'>
				<div id='closeButton'>
					<a href=''><img src='<?= $buttonSrc ?>'/></a>
				</div>
				<div class='sliderContent' data-scroll='x'>
					<?php
					foreach($games as $game){
						print "\t\t\t\t\t<div class='gameIcon' data-gameurl=\"{$game->gameUrl}\">
							<img src ='{$game->iconSrc}'><br/>
							<div class='gameName'>
								{$game->gameName}
							</div>
						</div>";
					}
					?>
				</div>
			</div>
		</div>
	</body>
</html>