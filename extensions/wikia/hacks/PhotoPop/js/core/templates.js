var templates = {
	mainPage: "<div id='wrapper'>\
			<div id='logoWrapper'>\
				<div id='photopop_logo'>\
					<img src='{{PHOTOPOP_LOGO}}'/><br/>\
					<img src='{{POWERED_BY_LOGO}}'/>\
				</div>\
			</div>\
			<div id='playWrapper'>\
				<a href='{{playButtonUrl}}'><img src='{{buttonSrc_play}}'/></a>\
			</div>\
			<div id='buttonWrapper'>\
				<div id='button_scores'>\
					<img src='{{buttonSrc_scores}}'/>\
				</div>\
			<div id='button_tutorial'>\
				<a href='{{tutorialButtonUrl}}'><img src='{{buttonSrc_tutorial}}'/></a>\
			</div>\
			<div id='button_volume'>\
				<img class='on' src='{{buttonSrc_volumeOn}}'/>\
				<img class='off' src='{{buttonSrc_volumeOff}}'/>\
			</div>\
		</div>\
	</div>",
	
	selectorScreen: "<div id='sliderWrapper'>\
				<div id='closeButton'>\
					<a href='{{backHomeUrl}}'><img src='{{buttonSrc}}'/></a>\
				</div>\
				<div class='sliderContent' data-scroll='x'>\
					{{#games}}\
						<div class='gameIcon' data-gameurl='{{gameUrl}}'>\
							<img src ='{{iconSrc}}'><br/>\
							<div class='gameName'>\
								{{gameName}}\
							</div>\
						</div>\
					{{/games}}\
				</div>\
			</div>"
}