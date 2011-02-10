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
		var gameId = $.cookies.get('ScavengerHuntInProgress');
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
				
				if (!json.status) {
					$().log('cannot show hidden image - got broken data from server' ,'ScavengerHunt');
					return;
				}

				//display image and attach handler to it
				$('<img>')
					.attr('src', json.hiddenImage)
					.click(ScavengerHunt.onHiddenImgClick)
					//TODO: use ScavengerHuntArticleImgOffset and move rest to CSS
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
			window.ScavengerHuntStartClueTitle,
			window.ScavengerHuntStartClueHtml,
			{
				id: 'scavengerClueModal',
				showCloseButton: false,
				width: 588
			}
		);
	},

	//handler hidden article image
	onHiddenImgClick: function(e) {
		$(this).remove();

		var data = window.ScavengerHuntArticleData;
		ScavengerHunt.log(data.visitedIds);
		if (!data.completed) {
			// next article found, game not finished
			ScavengerHunt.showClue();
		} else {
			// game has been finished
			ScavengerHunt.showEntryForm();
		}
	},
	
	showClue: function() {
		var data = window.ScavengerHuntArticleData;
		$.cookies.set('ScavengerHuntArticlesFound',data.visitedIds, {hoursToLive:24*7});
		
		$.showModal(
			data.clueTitle,
			data.clueContent,
			{
				id: 'scavengerClueModal',
				showCloseButton: false,
				width: 588,
				callback: function() {
					var button = $('#scavengerClueModal').find('a.button');
					if (!button.attr('href')) {
						button.click(function(e){
							e.preventDefault();
							$('#scavengerClueModal').closest('.modalWrapper').closeModal();
						});
					}
				}
			}
		);
	},

	showEntryForm: function() {
		var data = window.ScavengerHuntArticleData;
		
		$.showModal(
			data.entryFormTitle,
			data.entryFormContent,
			{
				id: 'scavengerEntryFormModal',
				showCloseButton: false,
				closeOnBlackoutClick: false,
				width: 588,
				callback: function() {
					var w = $('#scavengerEntryFormModal').closest('.modalWrapper');
					var b = w.find('.scavenger-clue-button input[type=submit]');
					b.click(function(e){
						e.preventDefault();
						b.attr('disabled','disabled');
						var ids = $.cookies.get('ScavengerHuntArticlesFound');
						var formdata = {
							action: 'ajax',
							rs: 'ScavengerHuntAjax',
							method: 'pushEntry',
							gameId: window.ScavengerHuntArticleGameId,
							visitedIds: ids ? ids + ',' +window.wgArticleId : '' + window.wgArticleId,

							name: w.find('input[name=name]').val(),
							email: w.find('input[name=email]').val(),
							answer: w.find('textarea[name=answer]').val()
						};
						$.getJSON(wgScript, formdata, function(json) {
							window.ScavengerHuntGoodbyeData = json;
							if (json.status) {
								w.closeModal();
								// XXX: clear game cookies if entry is saved
								ScavengerHunt.showGoodbyeForm();
							} else {
								$().log('entryForm error: '+json.error,'ScavengerHunt');
								b.attr('disabled','');
							}
						});
					});
				}
			}
		);
	},

	showGoodbyeForm: function() {
		$.cookies.del('ScavengerHuntArticlesFound');
		$.cookies.del('ScavengerHuntInProgress');
		var data = window.ScavengerHuntGoodbyeData;
		if (!data) {
			$().log('cannot show goodbye popup - no data available', 'ScavengerHunt');
			return false;
		}

		$.showModal(
			data.goodbyeTitle,
			data.goodbyeContent,
			{
				id: 'scavengerGoodbyeModal',
				width: 588,
				callback: function() {
					var w = $('#scavengerEntryFormModal').closest('.modalWrapper');
					w.find('.scavenger-clue-button a').click(function(e){
						e.preventDefault();
						w.closeModal();
					});
				}
			}
		);
	}
};
window.ScavengerHunt = ScavengerHunt;

//on content ready
wgAfterContentAndJS.push(ScavengerHunt.init);