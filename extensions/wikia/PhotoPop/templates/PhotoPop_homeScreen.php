<html>
	<head>
		<title><?= wfMsg('photopop-title-tag-homescreen') ?></title>
		<meta name="viewport" content = "width=device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, user-scalable = no" />
		<style>
		html {
			margin:0px;
			padding:0px;
		}
		body {
			margin:0px;
			padding:0px;
			background:#333;
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
		
		#logoWrapper{
			margin-top:5px;
			width:100%;
			text-align:center;
background-color:blue;
		}
		#photopop_logo{
			margin:auto;
			text-align:right;
background-color:green;
		}
		
		#buttonWrapper{
			bottom:0px;
			width:100%;
background-color:orange;
		}
		#buttonWrapper div{
			padding:5px;
		}
		#button_scores, #button_tutorial{
			float:left;
		}
		#button_volume{
			float:right;
		}
		</style>
	</head>
	<body>
		<div id='wrapper'>
			<div id='logoWrapper'>
				<div id='photopop_logo'>
					<img src='<?= $PHOTOPOP_LOGO ?>'/><br/>
					<img src='<?= $POWERED_BY_LOGO ?>'/>
				</div>
			</div>
			
			<div id='buttonWrapper'>
				<div id='button_scores'>
					<img src='<?= $buttonSrc_scores ?>'/>
				</div>
				<div id='button_tutorial'>
					<img src='<?= $buttonSrc_tutorial ?>'/>
				</div>
				<div id='button_volume'>
					<img src='<?= $buttonSrc_volumeOn ?>'/>
				</div>
			</div>
		</div>
	</body>
</html>
