var ScavengerHunt = {
	// console logging
	log: function(msg) {
		$().log(msg, 'ScavengerHunt');
	},

	//global init
	init: function() {
		//check if there is a need to initialize JS for start page
		if (typeof window.ScavengerHuntStart != 'undefined') {
			ScavengerHunt.initStart();
		}

		//check if there is a need to initialize JS for game
		var gameId  $.cookies.get('ScavengerHuntInProgress');
		if (gameId) {
			ScavengerHunt.initGame(gameId);
		}
	},

	//init starting page
	initStart: function() {
		//check if user haven't already started this game - do not show start button again
		var gameInProgress = $.cookies.get('ScavengerHuntInProgress');
		if (window.ScavengerHuntStart == gameInProgress) {
			return;
		}

		$('<input type="button">')
			.val(ScavengerHuntStartMsg)
			.click(ScavengerHunt.onStartClick)
			.wrap('<div>')
			.appendTo('#WikiaArticle');
	},

	//init article page
	initGame: function(gameId) {
		//current article is taking part in the game that user is playing atm
		if (gameId == window.ScavengerHuntArticleGameId) {
			//check if user haven't already found this page - do not show it again
			var found = $.cookies.get('ScavengerHuntArticlesFound');
			if (found) {
				if ($.inArray(''+wgArticleId, found.split(',')) != -1) {
					return;
				}
			}
			//prepare data to show immediately when user click image
			var data = {
				action: 'ajax',
				articleId: wgArticleId,
				gameId: gameId,
				method: 'getArticleData',
				rs: 'ScavengerHuntAjax'
			};
			$.getJSON(wgScript, data, function(json) {
				window.ScavengerHuntArticleData = json;
				//TODO: check `ScavengerHuntArticlesFound` cookie and return confirmed articles + update the cookie

				//display image and attach handler to it
				$('<img>')
					.attr('src', window.ScavengerHuntArticleImg)
					.click(ScavengerHunt.onHiddenImgClick)
					.css({position:'absolute', top: '150px', left: '10px', 'z-index': 999})
					.appendTo('body');

			});
		}
	},

	//handler start button
	onStartClick: function(e) {
		$(this).remove();

		$.cookies.set('ScavengerHuntInProgress', window.ScavengerHuntStart, {hoursToLive:24*7});
		$.showModal(
			window.ScavengerHuntStartTitle,
			//TODO: add nice layout here
			window.ScavengerHuntStartText + '<img src="' + window.ScavengerHuntStartImage + '">'
		);
	},

	//handler hidden article image
	onHiddenImgClick: function(e) {
		$(this).remove();

		var found = $.cookies.get('ScavengerHuntArticlesFound');
		found = found ? found.split(',') : [];
		if ($.inArray(''+wgArticleId, found) == -1) {
			found.push(''+wgArticleId);
			$.cookies.set('ScavengerHuntArticlesFound', found.join(','), {hoursToLive:24*7});
		}
		ScavengerHunt.log(found);

		$.showModal(
			window.ScavengerHuntArticleData.clue.title,
			window.ScavengerHuntArticleData.clue.content,
			{
				id: 'scavengerClueModal',
				showCloseButton: false,
				width: 588
			}
		);
	},
	
	showEntryForm: function() {
		var data = window.ScavengerHuntArticleData;
		if (!data) {
			$.log('cannot show ebtry form popup - no data available', 'ScavengerHunt');
			return false;
		}
		
		$.loadModalJS(function(){
			var w = $(data.entryFormHtml).makeModal();
			w.find('input[type=submit]').click(function(e){
				e.preventDefault();
				var formdata = {
					action: 'ajax',
					rs: 'ScavengerHuntAjax',
					method: 'pushEntry',
					gameId: window.ScavengerHuntArticleGameId,
					
					name: w.find('input[name=name]').val(),
					email: w.find('input[name=email]').val(),
					answer: w.find('textarea[name=answer]').val()
				};
				$.getJSON(wgScript, formdata, function(json) {
					window.ScavengerHuntGoodbyeData = json;
					// XXX: clear game cookies if entry is saved
					ScavengerHunt.showGoodbyeForm();
				});
			});
		});
	},
	
	showGoodbyeForm: function() {
		var data = window.ScavengerHuntGoodbyeData;
		if (!data) {
			$.log('cannot show goodbye popup - no data available', 'ScavengerHunt');
			return false;
		}
		
		var w = $(data.goodbyeHtml);
		w.makeModal();
		w.find('.clue-button').click(function(){
			w.closeModal();
		});
	}
	
};

//on content ready
wgAfterContentAndJS.push(ScavengerHunt.init