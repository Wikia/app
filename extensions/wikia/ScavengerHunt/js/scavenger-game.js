var ScavengerHunt = {
	articleData: null,
	goodbyeData: null,

	MODAL_WIDTH: 588,

	//console logging
	log: function(msg) {
		$().log(msg, 'ScavengerHunt');
	},

	//track events
	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('scavengerhunt/' + fakeUrl);
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
		ScavengerHunt.track('start/showButton');

		$('<div class="scavenger-start-button" />').append(
			$('<input type="button">')
				.val(ScavengerHuntStartMsg)
				.click(ScavengerHunt.onStartClick)
			)
			.prependTo('#WikiaArticle');
	},

	//init article page
	initGame: function(gameId) {
		//current article is taking part in the game that user is playing atm
		if (gameId == window.ScavengerHuntArticleGameId) {
			//prepare data to show immediately when user click image
			var data = {
				action: 'ajax',
				articleId: wgArticleId,
				gameId: gameId,
				method: 'getArticleData',
				rs: 'ScavengerHuntAjax'
			};
			$.getJSON(wgScript, data, function(json) {
				ScavengerHunt.articleData = json;

				if (!json.status) {
					ScavengerHunt.log('cannot show hidden image - got broken data from server');
					return;
				}

				ScavengerHunt.track('game/hiddenImage/show/' + wgPageName);

				//display image and attach handler to it
				$('<img>')
					.attr('src', json.hiddenImage)
					.click(ScavengerHunt.onHiddenImgClick)
					.addClass('scavenger-hidden-image')
					.css({left: json.hiddenImageOffset.left + 'px', top: json.hiddenImageOffset.top + 'px'})
					.appendTo('#WikiaPage');
			});
		}
	},

	//handler start button
	onStartClick: function(e) {
		ScavengerHunt.track('start/clickButton');

		$.cookies.set('ScavengerHuntInProgress', window.ScavengerHuntStart, {hoursToLive:24*7});
		$.showModal(
			window.ScavengerHuntStartClueTitle,
			window.ScavengerHuntStartClueHtml,
			{
				id: 'scavengerClueModal',
				showCloseButton: false,
				width: ScavengerHunt.MODAL_WIDTH,
				callback: function() {
					$('#scavengerClueModal').find('a.button').click(function(e) {
						ScavengerHunt.track('start/modalClue/clickButton');
						if (!$(this).attr('href')) {
							$('#scavengerClueModal').closest('.modalWrapper').closeModal();
						}
					});
				}
			}
		);
	},

	//handler hidden article image
	onHiddenImgClick: function(e) {
		$(this).remove();
		ScavengerHunt.track('game/hiddenImage/click');

		ScavengerHunt.log(ScavengerHunt.articleData.visitedIds);
		if (!ScavengerHunt.articleData.completed) {
			// next article found, game not finished
			ScavengerHunt.showClue();
		} else {
			// game has been finished
			ScavengerHunt.showEntryForm();
		}
	},

	showClue: function() {
		$.cookies.set('ScavengerHuntArticlesFound', ScavengerHunt.articleData.visitedIds, {hoursToLive:24*7});
		ScavengerHunt.track('game/modalClue/show');
		$.showModal(
			ScavengerHunt.articleData.clueTitle,
			ScavengerHunt.articleData.clueContent,
			{
				id: 'scavengerClueModal',
				showCloseButton: false,
				width: ScavengerHunt.MODAL_WIDTH,
				callback: function() {
					$('#scavengerClueModal').find('a.button').click(function(e) {
						ScavengerHunt.track('game/modalClue/clickButton');
						if (!$(this).attr('href')) {
							$('#scavengerClueModal').closest('.modalWrapper').closeModal();
						}
					});
				}
			}
		);
	},

	showEntryForm: function() {
		ScavengerHunt.track('game/modalEntryForm/show');
		$.showModal(
			ScavengerHunt.articleData.entryFormTitle,
			ScavengerHunt.articleData.entryFormContent,
			{
				id: 'scavengerEntryFormModal',
				showCloseButton: false,
				closeOnBlackoutClick: false,
				width: ScavengerHunt.MODAL_WIDTH,
				callback: function() {
					var w = $('#scavengerEntryFormModal').closest('.modalWrapper');
					var b = w.find('.scavenger-clue-button input[type=submit]');
					var inputs = w.find('.scavenger-entry-form').find('input, textarea').not('input[type=submit]')
					var inputsChange = function() {
						var ok = true;
						inputs.each(function(i,v){ if (!$(v).val()) ok = false; });
						b.attr('disabled',ok?'':'disabled');
					};
					inputs.blur(inputsChange);
					inputs.keyup(inputsChange);
					b.attr('disabled','disabled');
					b.click(function(e) {
						ScavengerHunt.track('game/modalEntryForm/clickButton');
						e.preventDefault();
						b.attr('disabled','disabled');
						var ids = $.cookies.get('ScavengerHuntArticlesFound');
						var formdata = {
							action: 'ajax',
							rs: 'ScavengerHuntAjax',
							method: 'pushEntry',
							gameId: window.ScavengerHuntArticleGameId,
							visitedIds: ids ? ids + ',' + window.wgArticleId : '' + window.wgArticleId,

							name: w.find('input[name=name]').val(),
							email: w.find('input[name=email]').val(),
							answer: w.find('textarea[name=answer]').val()
						};
						$.getJSON(wgScript, formdata, function(json) {
							ScavengerHunt.goodbyeData = json;
							if (json.status) {
								ScavengerHunt.track('game/modalEntryForm/saveOk');
								w.closeModal();
								// XXX: clear game cookies if entry is saved
								ScavengerHunt.showGoodbyeForm();
							} else {
								ScavengerHunt.track('game/modalEntryForm/saveError');
								ScavengerHunt.log('entryForm error: ' + json.error);
								b.attr('disabled', '');
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
		if (!ScavengerHunt.goodbyeData) {
			ScavengerHunt.log('cannot show goodbye popup - no data available');
			return false;
		}

		ScavengerHunt.track('game/modalGoodbye/show');
		$.showModal(
			ScavengerHunt.goodbyeData.goodbyeTitle,
			ScavengerHunt.goodbyeData.goodbyeContent,
			{
				id: 'scavengerGoodbyeModal',
				width: ScavengerHunt.MODAL_WIDTH,
				callback: function() {
					var w = $('#scavengerEntryFormModal').closest('.modalWrapper');
					w.find('.scavenger-clue-button a').click(function(e) {
						ScavengerHunt.track('game/modalGoodbye/clickButton');
						e.preventDefault();
						w.closeModal();
					});
					if (typeof FB == "object") {
						var share = $('.scavenger-share-button');
						if (share.exists()) {
							FB.XFBML.parse(share.get(0));
						}
					}
				}
			}
		);
	}
};

//on content ready
wgAfterContentAndJS.push(ScavengerHunt.init);