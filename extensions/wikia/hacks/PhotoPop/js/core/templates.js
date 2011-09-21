var templates = {
	mainPage: "<div id='wrapper'>\
			<div id='logoWrapper'>\
				<div id='photopop_logo'>\
					<img src='{{#image}}PHOTOPOP_LOGO{{/image}}'/><br/>\
					<img src='{{#image}}POWERED_BY_LOGO{{/image}}'/>\
				</div>\
			</div>\
			<div id='playWrapper'>\
				<a href='{{#image}}playButtonUrl{{/image}}'><img src='{{#image}}buttonSrc_play{{/image}}'/></a>\
			</div>\
			<div id='buttonWrapper'>\
				<div id='button_scores'>\
					<img src='{{#image}}buttonSrc_scores{{/image}}'/>\
				</div>\
			<div id='button_tutorial'>\
				<a href='{{#image}}tutorialButtonUrl{{/image}}'><img src='{{#image}}buttonSrc_tutorial{{/image}}'/></a>\
			</div>\
			<div id='button_volume'>\
				<img class='on' src='{{#image}}buttonSrc_volumeOn{{/image}}'/>\
				<img class='off' src='{{#image}}buttonSrc_volumeOff{{/image}}'/>\
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