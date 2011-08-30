<html>
	<head>
		<title><?= wfMsg('photopop-title-tag-selectorscreen') ?></title>
		<meta name="viewport" content = "width=device-width, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, user-scalable = no" />
		<style>
/*
		#wrapper{
background-color:blue;

width:480px;

			}
			#sliderWrapper{
background-color:white;


			}
			#sliderContent{
background-color:purple;


overflow: hidden;
			width: 300px;
			height: 300px;


}
			.gameIcon{
display:inline-block;
width:150px;
height:150px;
				padding:10px;
				background-color:red;
			}
*/		
			
			
			
			
			
			
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
		.square {
			width: 98px;
			height: 98px;
			border: solid 1px #333;
			text-align: center;
			line-height: 100px;
			font-size: 60px;
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
width: 300px;
height: 300px;
		}
		.sliderContent > .ui-scrollview-view {
width: 1300px;
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
					<div class='gameIcon'><img src ='<?= $iconSrc ?>'></div>
					<div class='gameIcon'><img src ='<?= $iconSrc ?>'></div>
					<div class='gameIcon'><img src ='<?= $iconSrc ?>'></div>
					<div class='gameIcon'><img src ='<?= $iconSrc ?>'></div>
					<div class='gameIcon'><img src ='<?= $iconSrc ?>'></div>
				</div>
			</div>
		</div>
	</body>
</html>