var exports = exports || {};

define.call(exports, {

	mainPage: "<div id='wrapper'>\
			<div id='logoWrapper'>\
				<div id='photopop_logo'>\
					<img src='{{#image}}PHOTOPOP_LOGO{{/image}}'/><br/>\
					<img src='{{#image}}POWERED_BY_LOGO{{/image}}'>\
				</div>\
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
			<div class='sliderContent' data-scroll='x'>\
				<ul>{{#games}}\
					<li class='gameIcon' data-gameurl='{{gameUrl}}'>\
						<img src ='{{#image}}gameicon_{{name}}{{/image}}'><br/>\
						<div class='gameName'>\
							{{gameName}}\
						</div>\
					</li>\
				{{/games}}</ul> \
			</div>\
		</div>",
	
	gameScreen: "<div id='scoreBarWrapper'>\
			<div id='scoreBar'></div>\
		</div>\
		<div id='bgWrapper'>\
			<div id='bgPic'><img src='{{path}}'></div>\
		</div>\
		<div id='gameBoard'>\
			<div id='endGameOuterWrapper'>\
				<div id='endGameInnerWrapper'>\
					<div id='highScore'>\
				HIGH SCORE SUMMARY\
					</div>\
					<div id='summaryWrapper'>\
						<div id='endGameSummary'>\
							<div class='headingText'>\
								FINISHED\
							</div>\
							<div class='summaryTextWrapper'>\
								<div class='summaryText_completion'>\
								</div>\
								<div class='summaryText_score'>\
								</div>\
							</div>\
						</div>\
						<a id='playAgain' href=''><img src='{{#image}}buttonSrc_play{{/image}}'/></a>\
						<a id='goHome' href=''><img src='{{#image}}buttonSrc_home{{/image}}'/></a>\
						<a id='goToHighScores' href=''><img src='{{#image}}buttonSrc_scores{{/image}}'/></a>\
					</div>\
				</div>\
			</div>\
			<div id='timeUpText'>\
				<div class='timeUpTextInner'>\
					CONTINUE TIME UP\
				</div>\
			</div>\
			<div id='continueText'>\
				CONTINUE CORRECT\
			</div>\
			<div id='continueButton'>\
				<img src='{{#image}}buttonSrc_contiunue{{/image}}'/>\
			</div>\
			<div id='answerDrawerWrapper'>\
				<div id='answerDrawer'>\
					<div class='answerButton' id='answerButton_toOpen'>\
						<img src='{{#image}}buttonSrc_answerOpen{{/image}}'/>\
					</div>\
					<div class='answerButton' id='answerButton_toClose'>\
						<img src='{{#image}}buttonSrc_answerOpen{{/image}}'/>\
					</div>\
					<div id='answerListFalseEdge'>\
					</div>\
					<div id='answerListWrapper'>\
						<ul>\
							<li class='first'></li>\
							<li></li>\
							<li></li>\
							<li class='last'></li>\
						</ul>\
					</div>\
				</div>\
			</div>\
			<div id='hud'>\
				<div class='home'>\
					<a href=''><img src='{{#image}}buttonSrc_home{{/image}}'/></a>\
				</div>\
				<div class='score'>\
					SCORE\
				</div>\
				<div class='progress'>\
					PROGRESS\
				</div>\
			</div><table id='tilesWrapper'></table>\
		</div>",
	
	tutorialOverlap: "<div id='instructionsWrapper' class='triangle-isosceles right'>\
				<div>\
					TUTORIAL\
				</div>\
				<div class='buttonBar'>\
					<a href=''><img src='{{#image}}buttonSrc_tutorial{{/image}}' /></a>\
				</div>\
			</div>"
});
