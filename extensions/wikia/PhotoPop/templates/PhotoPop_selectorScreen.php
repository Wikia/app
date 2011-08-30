<html>
	<head>
		<title><?= wfMsg('photopop-title-tag-selectorscreen') ?></title>
		<meta name="viewport" content = "width=device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, user-scalable = no" />
		<style><?php
	$PADDING_AROUND_ICONS = 15;
?>
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
			width: <?= $iconWidth + ($PADDING_AROUND_ICONS * 2) ?>px;
			height: <?= $iconHeight + ($PADDING_AROUND_ICONS * 2) ?>px;
			padding: <?= $PADDING_AROUND_ICONS ?>px;
			text-align: center;
		}
		.gameIcon img{
			box-shadow:10px 10px 20px #000;
			-webkit-box-shadow:10px 10px 20px #000;
			-moz-box-shadow: 10px 10px 20px #000;
		}
		.ui-scrollview-clip .ui-scrollview-clip .gameIcon {
			background-color: #3CF;
		}
		.ui-scrollview-clip .ui-scrollview-clip .ui-scrollview-clip .gameIcon {
			background-color: #F39;
		}
		.ui-scrollview-clip .ui-scrollview-clip .ui-scrollview-clip .ui-scrollview-clip .gameIcon {
			background-color: #0F6;
		}
		.ui-scrollview-clip .ui-scrollview-clip .ui-scrollview-clip .ui-scrollview-clip .ui-scrollview-clip .gameIcon {
			background-color: #FF6;
		}
		.sliderContent {
			border: solid 1px black;
			background-color: #999;
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