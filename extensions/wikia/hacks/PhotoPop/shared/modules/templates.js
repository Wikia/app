var exports = exports || {};

define.call(exports, {

	mainPage: "<div id='wrapper'>\
			<div id='logoWrapper'>\
				<div id='photopop_logo'>\
					<img src='{{#image}}PHOTOPOP_LOGO{{/image}}'/><br/>\
					<img src='{{#image}}POWERED_BY_LOGO{{/image}}'/>\
				</div>\
			</div>\
			<div id='playWrapper'>\
				<div><img src='{{#image}}buttonSrc_play{{/image}}'/></div>\
			</div>\
			<div id='buttonWrapper'>\
				<div id='button_scores'>\
					<img src='{{#image}}buttonSrc_scores{{/image}}'/>\
				</div>\
			<div id='button_tutorial'>\
				<a href='{{#url}}tutorialButtonUrl{{/url}}'><img src='{{#image}}buttonSrc_tutorial{{/image}}'/></a>\
			</div>\
			<div id='button_volume'>\
				<img class='on' src='{{#image}}buttonSrc_volumeOn{{/image}}'/>\
				<img class='off' src='{{#image}}buttonSrc_volumeOff{{/image}}'/>\
			</div>\
		</div>\
	</div>",
	
	selectorScreen: "<div id='sliderWrapper'>\
				<div id='closeButton'>\
					<img src='{{#image}}buttonSrc{{/image}}'/>\
				</div>\
				<ul class='sliderContent' data-scroll='x'>\
					{{#games}}\
						<li class='gameIcon' data-gameurl='{{gameUrl}}'>\
							<img src ='{{#image}}gameicon_{{name}}{{/image}}'><br/>\
							<div class='gameName'>\
								{{gameName}}\
							</div>\
						</li>\
					{{/games}}\
				</ul>\
			</div>"

});
