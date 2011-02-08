var ScavengerHunt = {
	// console logging
	log: function(msg) {
		$().log(msg, 'ScavengerHunt');
	},

	//global init
	init: function() {
		//check if there is a need to initialize JS for start page
		if (typeof ScavengerHuntStart != 'undefined') {
			ScavengerHunt.initStart();
		}

		//check if there is a need to initialize JS for game
		var gameId = $.cookies.get('ScavengerHuntInProgress');
		if (gameId) {
			ScavengerHunt.initGame(gameId);
		}
	},

	//init starting page
	initStart: function() {
		var button = $('<input type="button">').val(ScavengerHuntStartMsg).click(ScavengerHunt.onStartClick).wrap('<div>').appendTo('#WikiaArticle');
	},

	//init article page
	initGame: function(gameId) {
		//current article is taking part in the game that user is playing atm
		if (gameId == window.ScavengerHuntArticleGameId) {
			//prepare data to show immediately when user click image
			var data = {
				action: 'ajax',
				article: wgArticleId,
				gameId: gameId,
				method: 'getArticleData',
				rs: 'ScavengerHuntAjax'
			};
			$.getJSON(wgScript, data, function(json) {
				window.ScavengerHuntArticleData = json;
			});

			//display image
			//attach handler to image
		}
	},

	//handler start button
	onStartClick: function(e) {
		$.cookies.set('ScavengerHuntInProgress', window.ScavengerHuntStart, {hoursToLive:24*7});
		$.showModal(
			window.ScavengerHuntStartTitle,
			//TODO: add nice layout here
			window.ScavengerHuntStartClue + '<img src="' + window.ScavengerHuntStartImg + '">'
		);
	}
};

//on content ready
wgAfterContentAndJS.push(ScavengerHunt.init);