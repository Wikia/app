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
			background-color:#00396D;
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
		}
		#sliderWrapper{
			height: <?= $iconHeight + ($PADDING_AROUND_ICONS * 2) ?>px;
			position:absolute;
			bottom:0px;
		}
		
		
		.ui-content.ui-scrollview-clip {
			padding: 0;
		}
		.ui-content.ui-scrollview-clip > div.ui-scrollview-view {
			margin: 0;
			padding: 15px;
		}
		.ui-content.ui-scrollview-clip > .ui-listview.ui-scrollview-view {
			margin: 0;
		}
		.gameIcon {
			width: <?= $iconWidth ?>px;
			height: <?= $iconHeight ?>px;
			padding: <?= $PADDING_AROUND_ICONS ?>px;
			text-align: center;
			margin:0px;
		}
		.gameIcon img{
			box-shadow:10px 10px 20px #000;
			-webkit-box-shadow:10px 10px 20px #000;
			-moz-box-shadow: 10px 10px 20px #000;
		}
		.sliderContent {
			background-color:transparent;
			overflow: hidden;
			width: <?= $boardWidth ?>px;
			height: <?= $iconHeight + ($PADDING_AROUND_ICONS * 2) ?>px;
		}
		.sliderContent > .ui-scrollview-view {
			width: <?= $numItems * ($iconWidth + ($PADDING_AROUND_ICONS * 2))?>px;
			background-color: white;
		}
		.sliderContent .gameIcon {
			float: left;
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
				<div class='sliderContent' data-scroll='x'>
					<?php
					foreach($games as $game){
						print "\t\t\t\t\t<div class='gameIcon'><img src ='{$game->iconSrc}'></div>";
					}
					?>
				</div>
			</div>
		</div>
	</body>
</html>