<html>
	<head>
		<title><?= wfMsg('photopop-title-tag-homescreen') ?></title>
		<meta name="viewport" content = "width=device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, user-scalable = no" />
		<style>
		#wrapper{
			width: <?= $boardWidth ?>px;
			height: <?= $boardHeight ?>px;
			background: #00396D url(<?= $BG_IMAGE ?>);
		}
		</style>
		<?= $cssLink ?>
	</head>
	<body>
		<div id='wrapper'>
			<div id='logoWrapper'>
				<div id='photopop_logo'>
					<img src='<?= $PHOTOPOP_LOGO ?>'/><br/>
					<img src='<?= $POWERED_BY_LOGO ?>'/>
				</div>
			</div>

			<div id='playWrapper'>
				<a href='<?= $playButtonUrl ?>'><img src='<?= $buttonSrc_play ?>'/></a>
			</div>
			
			<div id='buttonWrapper'>
				<div id='button_scores'>
					<img src='<?= $buttonSrc_scores ?>'/>
				</div>
				<div id='button_tutorial'>
					<a href='<?= $tutorialButtonUrl ?>'><img src='<?= $buttonSrc_tutorial ?>'/></a>
				</div>
				<div id='button_volume'>
					<img class='on' src='<?= $buttonSrc_volumeOn ?>'/>
					<img class='off' src='<?= $buttonSrc_volumeOff ?>'/>
				</div>
			</div>
		</div>
	</body>
</html>
