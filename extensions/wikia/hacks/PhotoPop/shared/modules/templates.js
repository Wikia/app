var exports = exports || {};

define.call(exports, {
	mainPage:
		"<div id='wrapper'>\
		</div>",
	selectorScreen: "<div id='logoWrapper'>\
				<img id='logoPhotopop' src='{{#image}}PHOTOPOP_LOGO{{/image}}'/><br/>\
				<img id='logoWikia' src='{{#image}}POWERED_BY_LOGO{{/image}}'>\
			</div>\
		<div id='sliderWrapper' class='composite transition-all'>\
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
			<div id='sliderContent' data-scroll='x'>\
				<span class='progress'>Loading...</span>\
			</div>\
		</div>",
	gameSelector:
		"<ul id='gamesList'>{{#games}}\
			<li class='gameIcon' data-idx='{{index}}'>\
				<img src ='{{image}}'><br/>\
				<div class='gameName'>\
					{{name}}\
				</div>\
			</li>\
		{{/games}}</ul>",
	gameScreen:
		"<div id='gameScreen' class='composite transition-all'><div id='scoreBarWrapper'  class='composite transition-all'>\
			<div id='scoreBar' class='composite transition-all'></div>\
		</div>\
		<div id='bgWrapper'>\
			<div id='bgPic'><img src=''></div>\
		</div>\
		<div id='gameBoard'>\
			<div id='endGameOuterWrapper'>\
				<div id='endGameInnerWrapper'>\
					<div id='highScore'>\
						highscore: <span>10000</span>\
					</div>\
					<div id='summaryWrapper'>\
						<div id='endGameSummary'>\
							<h1>Finished</h1>\
							<div class='summaryTextWrapper'>\
								<div class='summaryText_completion'>\
								</div>\
								<div class='summaryText_score'>\
								</div>\
							</div>\
						</div>\
						<div id='endGameButtons'>\
							<img id='playAgain' src='{{#image}}buttonSrc_endReplay{{/image}}'/>\
							<img id='goHome' src='{{#image}}buttonSrc_endHome{{/image}}'/>\
							<img id='goToHighScores' src='{{#image}}buttonSrc_endScores{{/image}}'/>\
						</div>\
					</div>\
				</div>\
			</div>\
			<div id='timeUpText'>\
				CONTINUE TIME UP\
			</div>\
			<div id='continue'>\
				<span id='continueText'>CONTINUE</span>\
				<img src='{{#image}}buttonSrc_contiunue{{/image}}'/>\
			</div>\
			<div id='answerDrawer'>\
			<div id='answerButton' class='closed'>\
				<img src='{{#image}}buttonSrc_answerOpen{{/image}}' />\
				<img src='{{#image}}buttonSrc_answerClose{{/image}}' />\
			</div>\
				<ul id='answerList'>\
					<li id='answer0'></li>\
					<li id='answer1'></li>\
					<li id='answer2'></li>\
					<li id='answer3'></li>\
				</ul>\
			</div>\
			<div id='hud'>\
				<div id='home'>\
					<img src='{{#image}}buttonSrc_home{{/image}}'/>\
				</div>\
				<div id='score'>\
					Points: <span id='roundPoints'>0</span> Total: <span id='totalPoints'>0</span>\
				</div>\
				<div id='progress'>\
					Progress: <span>1/5</span>\
				</div>\
			</div><table id='tilesWrapper'></table>\
			<div id='modalWrapper'><div id='modal'></div></div>\
		</div></div>",
});
