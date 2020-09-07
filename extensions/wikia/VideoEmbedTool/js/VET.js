/* global BannerNotification */

/*
 * Author: Inez Korczynski, Bartek Lapinski, Hyun Lim, Liz Lee
 */

define('wikia.vet', [
	'wikia.videoBootstrap',
	'jquery',
	'wikia.window',
	'BannerNotification'
], function (VideoBootstrap, $, window, BannerNotification) {
	'use strict';

	var curSourceId = 0,
		jqXHR = {
			abort: function () {
				// empty function so if statements will not have to be embedded everywhere
			}
		},
		curScreen = 'Main',
		prevScreen = null,
		wysiwygStart = 1,
		// Show notifications for this long and then hide them
		notificationTimeout = 4000,
		vetOptions = {},
		embedPresets = false,
		callbackAfterSelect = $.noop,
		callbackAfterEmbed = $.noop,
		MAX_WIDTH = 670,
		MIN_WIDTH = 100,
		DEFAULT_WIDTH = 335,
		thumbSize = DEFAULT_WIDTH,
		videoInstance = null,
		bannerNotification = new BannerNotification('', 'error', null, notificationTimeout),
		tracking,
		VETExtended,
		VET;

	tracking = Wikia.Tracker.buildTrackingFunction(Wikia.trackEditorComponent, {
		action: Wikia.Tracker.ACTIONS.CLICK,
		category: 'vet',
		trackingMethod: 'analytics'
	});

	// ajax call for 2nd screen (aka embed screen)
	function editVideo() {
		var params = [],
			escTitle = '',
			callback;

		$('#VideoEmbedMain').hide();

		callback = function (data) {
			var presets = embedPresets;

			displayDetails(data.responseText, presets);

			$('#VideoEmbedBack').hide();

			setTimeout(function () {
				if (presets.align && presets.align === 'left') {
					$('#VideoEmbedLayoutLeft').attr('checked', 'checked').parent().addClass('selected');
				} else if (presets.align && presets.align === 'center') {
					$('#VideoEmbedLayoutCenter').attr('checked', 'checked').parent().addClass('selected');
				} else {
					$('#VideoEmbedLayoutRight').attr('checked', 'checked').parent().addClass('selected');
				}

				if (presets.width) {
					readjustSlider(presets.width);
					$('#VideoEmbedManualWidth').val(presets.width);
				}
			}, 200);

			if (presets.caption) {
				$('#VideoEmbedCaption').val(presets.caption);
			}

			// show alignment row
			$('#VideoEmbedLayoutRow').show();

			// make replace video link to open in new window / tab
			$('#VideoReplaceLink').find('a').first().attr('target', '_blank');
		};

		jqXHR.abort();
		if (typeof embedPresets.href === 'undefined') {
			escTitle = embedPresets.title;
		} else {
			escTitle = embedPresets.href;
		}
		escTitle = encodeURIComponent(escTitle);
		params.push('itemTitle=' + escTitle);

		jqXHR = $.ajax(
			window.wgScriptPath + '/index.php?action=ajax&rs=VET&method=editVideo&' + params.join('&'), {
				method: 'get',
				complete: callback,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
				}
			}
		);
	}

	// Collect embed settings from form and send to callbackAfterEmbed
	function doEditVideo() {
		var description = encodeURIComponent($('#VideoEmbedDescription').val());

		$.nirvana.sendRequest({
			controller: 'VideoEmbedTool',
			method: 'editDescription',
			type: 'POST',
			data: {
				title: $('#VideoEmbedName').val(),
				description: description,
				token: mw.user.tokens.get('editToken')
			}
		}).done(function (json) {
			var extraData, caption;

			if (json.status === 'fail') {
				bannerNotification.setContent(json.errMsg).show();
			} else {
				// setup metadata
				extraData = {};

				extraData.href = $('#VideoEmbedHref').val();
				extraData.width = $('#VideoEmbedManualWidth').val();

				if ($('#VideoEmbedLayoutLeft').is(':checked')) {
					extraData.align = 'left';
				} else if ($('#VideoEmbedLayoutCenter').is(':checked')) {
					extraData.align = 'center';
				} else {
					extraData.align = 'right';
				}

				caption = $('#VideoEmbedCaption').val();
				if (caption) {
					extraData.caption = caption;
				}

				if (callbackAfterEmbed) {
					// Callback from extensions
					callbackAfterEmbed(extraData);
				}
			}
		});
	}

	// macbre: move back button inside dialog content and add before provided selector (Oasis changes)
	function moveBackButton(selector) {
		var backButtonOriginal, backButton;

		// store back button
		if (!window.VETbackButton) {
			backButtonOriginal = $('#VideoEmbedBack');
			backButton = backButtonOriginal.clone();

			// keep the original one, but force it to be hidden
			backButtonOriginal.css('visibility', 'hidden');

			// remove an image and add button class
			backButton.removeAttr('id').remove();

			// keep reference to <a> tag
			backButton = backButton.children('a').addClass('wikia-button yui-back secondary v-float-right');
			window.VETbackButton = backButton;
		}

		// remove previous instances of .yui-back
		$('.yui-back').remove();

		// move button
		window.VETbackButton.clone().
		click(back).
		insertAfter(selector);
	}

	/*
	 * Functions/methods
	 */

	function manualWidthInput() {
		var val = parseInt(this.value); // jshint ignore:line
		if (isNaN(val)) {
			readjustSlider(0);
			return false;
		}
		if (val > MAX_WIDTH) {
			val = MAX_WIDTH;
			$('#VideoEmbedManualWidth').val(val);
		}
		readjustSlider(val);
		return true;
	}

	function readjustSlider(value) {
		var elem = $('#VideoEmbedSlider');

		if (elem.slider) {
			elem.slider({
				value: value
			});
		}
	}

	function show(options) {
		// set vars for this instance of VET
		vetOptions = options;
		embedPresets = options.embedPresets;
		wysiwygStart = options.startPoint || 1;
		callbackAfterSelect = options.callbackAfterSelect || $.noop;
		callbackAfterEmbed = options.callbackAfterEmbed || $.noop;

		// VET tracking
		tracking({
			action: Wikia.Tracker.ACTIONS.OPEN
		});

		// Any extra tracking
		if (options.track) {
			Wikia.Tracker.track({
				action: options.track.action || Wikia.Tracker.ACTIONS.OPEN,
				category: options.track.category || 'vet',
				label: options.track.label || '',
				value: options.track.value || null,
				trackingMethod: options.track.method || 'analytics'
			});
		}

		if (wysiwygStart === 2) {
			if (options.size) {
				thumbSize = options.size;
			}
			editVideo();
		} else {
			loadMain(options.searchOrder);
		}

		$('#VideoEmbedBack').click(back);
	}

	/* ajax call for first screen (aka video search) */
	function loadMain(searchOrder) {
		var callback = function (data) {
			$('#VideoEmbedMain').html(data.responseText);
			$('#VideoEmbedUrl').focusNoScroll();
			updateHeader();

			// Add suggestions and search to VET
			VETExtended.init({
				searchOrder: searchOrder
			});
		};
		$.ajax(
			window.wgScriptPath + '/index.php?action=ajax&rs=VET&method=loadMain', {
				method: 'get',
				complete: callback
			}
		);
		curSourceId = 0;
	}

	/*
	 * note: onVideoEmbedUrlKeypress is called from template
	 */
	function onVideoEmbedUrlKeypress(e) {
		if (e.which === 13) {
			e.preventDefault();
			preQuery();
			return false;
		}
		return true;
	}

	/*
	 * note: preQuery is called from a template, and from onVideoEmbedUrlKeypress
	 */
	function preQuery() {
		var $urlInput = $('#VideoEmbedUrl'),
			query;

		if (!$urlInput.val()) {
			bannerNotification.setContent($.msg('vet-warn2')).show();
			return false;
		} else {
			query = $urlInput.val();
			sendQueryEmbed(query);
			return false;
		}
	}

	/*
	 * renders the embed screen (aka 2nd screen)
	 */
	function displayDetails(responseText, dataFromEditMode) {
		var $videoThumb,
			element,
			value,
			$errorBox = $('#VET_error_box');

		switchScreen('Details');
		$('#VideoEmbedBack').css('display', 'inline');

		$('#VideoEmbedDetails').html(responseText);

		$videoThumb = $('#VideoEmbedThumb');
		element = $videoThumb.find('.video-embed');

		videoInstance = new VideoBootstrap(element[0], window.VETPlayerParams, 'vetDetails');

		updateHeader();

		value = thumbSize;

		if (dataFromEditMode) {
			if (dataFromEditMode.width) {
				value = dataFromEditMode.width;
			} else {
				value = '';
			}
		}

		// Init width slider
		$('.WikiaSlider').slider({
			min: MIN_WIDTH,
			max: MAX_WIDTH,
			value: value,
			slide: function (event, ui) {
				$('#VideoEmbedManualWidth').val(ui.value);
			},
			create: function () {
				$('#VideoEmbedManualWidth').val(value);
			}
		});

		if ($errorBox.length) {
			bannerNotification.setContent($errorBox.html()).show();
		}

		if ($('#VideoEmbedMain').html() === '') {
			loadMain();
		}

		$('#VideoEmbedCaption').placeholder();
	}

	function insertFinalVideo(e) {
		var params = [],
			$nameInput = $('#VideoEmbedName'),
			$metadataInput = $('#VideoEmbedMetadata'),
			metadata,
			i,
			callback;

		tracking({
			label: 'complete'
		});

		e.preventDefault();

		if (!$nameInput.length || $nameInput.val() === '') {
			bannerNotification.setContent($.msg('vet-warn3')).show();
			return;
		}

		params.push('id=' + $('#VideoEmbedId').val());
		params.push('provider=' + $('#VideoEmbedProvider').val());
		params.push('token=' + encodeURIComponent( mw.user.tokens.get('editToken') ));

		if ($metadataInput.length) {
			metadata = $metadataInput.val().split(',');
			for (i = 0; i < metadata.length; i++) {
				params.push('metadata' + i + '=' + metadata[i]);
			}
		}

		params.push('description=' + encodeURIComponent($('#VideoEmbedDescription').val()));
		params.push('oname=' + encodeURIComponent($('#VideoEmbedOname').val()));
		params.push('name=' + encodeURIComponent($nameInput.val()));

		if ($('#VideoEmbedThumb').length) {
			params.push('width=' + $('#VideoEmbedManualWidth').val());
			if ($('#VideoEmbedLayoutLeft').is(':checked')) {
				params.push('layout=left');
			} else if ($('#VideoEmbedLayoutCenter').is(':checked')) {
				params.push('layout=center');
			} else {
				params.push('layout=right');
			}
			params.push('caption=' + encodeURIComponent($('#VideoEmbedCaption').val()));
		}

		// Allow extensions to add extra params to ajax call
		params = params.concat(vetOptions.insertFinalVideoParams || []);

		callback = function (data, status) {
			var wikitext, options, screenType;

			if (status === 'error') {
				bannerNotification.setContent($.msg('vet-insert-error')).show();
			} else if (status === 'success') {
				screenType = jqXHR.getResponseHeader('X-screen-type');
				if (typeof screenType === 'undefined') {
					screenType = jqXHR.getResponseHeader('X-Screen-Type');
				}
				switch ($.trim(screenType)) {
					case 'error':
						data.responseText = data.responseText.replace(/<script.*script>/, '');
						bannerNotification.setContent(data.responseText).show();
						break;
					case 'summary':
						switchScreen('Summary');
						$('#VideoEmbedBack').hide();
						$('#VideoEmbed' + curScreen).html(data.responseText);
						updateHeader();

						if (!$('#VideoEmbedCreate').length && !$('#VideoEmbedReplace').length) {
							wikitext = $('#VideoEmbedTag').val();
							options = {};

							if (wikitext) {
								options.wikitext = wikitext;
							}
							if ($('#VideoEmbedLayoutLeft').is(':checked')) {
								options.align = 'left';
							} else if ($('#VideoEmbedLayoutCenter').is(':checked')) {
								options.align = 'center';
							} else {
								options.align = null;
							}

							options.caption = $('#VideoEmbedCaption').val();

							options.placeholderIndex = embedPresets.placeholderIndex;

							callbackAfterEmbed(options);
						} else {
							$('#VideoEmbedSuccess').hide();
							$('#VideoEmbedTag').hide();
							$('#VideoEmbedPageSuccess').show();
						}
						break;
					default:
						break;
					}
			}
		};

		jqXHR.abort();
		jqXHR = $.ajax(
			window.wgScriptPath + '/index.php?action=ajax&rs=VET&method=insertFinalVideo', {
				type: 'POST',
				data: params.join('&'),
				complete: callback
			}
		);
	}

	function switchScreen(to) {
		if (videoInstance) {
			videoInstance.clearTimeoutTrack();
		}
		prevScreen = curScreen;
		curScreen = to;
		$('#VideoEmbedBody').find('.VET_screen').hide();
		$('#VideoEmbed' + curScreen).show();
		updateHeader();

		// this is called in both cases - when hitting 'back' and when closing the dialog.
		// in any case we want to stop the video
		$('#VideoEmbedThumb').children().remove();
		if (curScreen === 'Main') {
			$('#VideoEmbedBack').hide();
		}

		// macbre: move back button on Oasis
		if (to === 'Details') {
			setTimeout(function () {
				moveBackButton($('.addVideoDetailsFormControls').find('input'));
			}, 50);
		}
	}

	function back(e) {
		e.preventDefault();

		tracking({
			label: 'button-' + curScreen.toLowerCase() + '-back'
		});

		if (curScreen === 'Details') {
			switchScreen('Main');
		} else if (curScreen === 'Conflict' && prevScreen === 'Details') {
			switchScreen('Details');
		}
	}

	function close() {
		window.VETbackButton = false;

		window.vetLoader.modal.closeModal();

		tracking({
			action: Wikia.Tracker.ACTIONS.CLOSE
		});

		if ($.isFunction(vetOptions.onClose)) {
			vetOptions.onClose();
		}

		switchScreen('Main');

		window.UserLogin.refreshIfAfterForceLogin();
	}

	/*
	 * transition from search to embed
	 * todo: rename this function, because it does not only send query to embed
	 */
	function sendQueryEmbed(query) {
		var searchType, callback, data;

		// If callbackAfterSelect returns false, end here. Otherwise, move on to the next screen.
		if (callbackAfterSelect(query, VET) !== false) {
			callback = function (data) {
				var screenType = jqXHR.getResponseHeader('X-screen-type');
				if (typeof screenType === 'undefined') {
					screenType = jqXHR.getResponseHeader('X-Screen-Type');
				}

				if ($.trim(screenType) === 'error') {
					bannerNotification.setContent(data.responseText).show();
				} else {
					// attach handlers - close preview on VET modal close (IE bug fix)
					VETExtended.cachedSelectors.closePreviewBtn.click();
					displayDetails(data.responseText);
				}

			};
			searchType = VETExtended.searchCachedStuff.searchType;
			data = 'action=ajax&rs=VET&method=insertVideo&url=' +
				encodeURIComponent(query) +
				'&searchType=' +
				searchType;

			jqXHR.abort();
			jqXHR = $.ajax(
				window.wgScriptPath + '/index.php', {
					method: 'post',
					data: data,
					complete: callback
				}
			);
		}
	}

	function updateHeader() {
		var $header = $('#VideoEmbed' + curScreen + ' h1:first');
		$('#VideoEmbedHeader').html($header.html());
		$header.hide();
	}

	//***********************************************
	//
	// New Features to VET - suggestions, search, preview etc.
	//
	// author: Rafal Leszczynski, Jacek Jursza
	//
	//***********************************************

	VETExtended = {
		canFatch: true, // flag for blocking fetching if it's in progress or no more items to fetch

		// object for caching stuff for suggestions
		suggestionsCachedStuff: {
			cashedSuggestions: [],
			fetchedResoultsCount: 0
		},

		// object for caching stuff for search
		searchCachedStuff: {
			inSearchMode: false,
			currentKeywords: '',
			fetchedResoultsCount: 0,
			searchType: 'premium',
			searchOrder: 'default'
		},

		init: function (searchSettings) {
			var self = this,
				$videoEmbedDetails;

			// reset cached stuff on init if some old values preserved
			this.searchCachedStuff.currentKeywords = '';
			this.searchCachedStuff.inSearchMode = false;
			this.suggestionsCachedStuff.cashedSuggestions = [];
			this.suggestionsCachedStuff.fetchedResoultsCount = 0;

			$.extend(this.searchCachedStuff, searchSettings);

			// load mustache as deferred object and then make request for suggestions
			$.loadMustache();

			// cache selectors
			this.cachedSelectors = {
				carousel: $('#VET-suggestions'),
				carouselWrapper: $('#VET-carousel-wrapper'),
				suggestionsWrapper: $('#VET-suggestions-wrapper'),
				previewWrapper: $('#VET-preview'),
				videoWrapper: $('#VET-video-wrapper'),
				searchForm: $('#VET-search-form'),
				resultCaption: $('#VET-carousel-wrapper > p.results strong'),
				backToSuggestions: $('#VET-carousel-wrapper > a.back-link'),
				closePreviewBtn: $('#VET-preview-close'),
				positionOptions: $('#VideoEmbedLayoutRow')
			};

			this.searchCachedStuff.searchType = 'local';

			// attach handlers - add video button
			this.cachedSelectors.carousel.on('click', 'li > a', function (event) {
				var node, trackData;

				event.preventDefault();
				sendQueryEmbed($(this).attr('href'));
				node = $(event.currentTarget).data();
				trackData = node.phrase + '[' + node.pos + ']';
				tracking({
					label: (self.carouselMode === 'search') ?
						'add-video-' + trackData : 'add-video-suggested-' + trackData
				});
			});

			// attach handlers - play button (open video preview)
			this.cachedSelectors.carousel.on('click', 'li a.video', function (event) {
				event.preventDefault();
				var videoTitle = $(this).find('[data-video-key]').attr('data-video-key');
				self.fetchVideoPlayer(videoTitle);

				tracking({
					label: 'carousel-thumbnail'
				});

				// remove in-preview class from previously check item if exists
				self.removeInPreview();

				// cache current in preview element in carousel
				self.cachedSelectors.inPreview = $(this).parents('li').addClass('in-preview');
			});

			// attach handlers - close preview
			this.cachedSelectors.previewWrapper.on('click', '#VET-preview-close', function (event) {
				event.preventDefault();

				// Closing a video instance, clear the tracking timeout
				if (videoInstance) {
					videoInstance.clearTimeoutTrack();
				}

				self.cachedSelectors.previewWrapper.stop().slideUp('slow', function () {
					self.cachedSelectors.videoWrapper.children().remove();
					self.removeInPreview();
				});
			});

			// attach handlers - add video button from preview
			this.cachedSelectors.previewWrapper.on('click', '#VET-add-from-preview', function (event) {
				event.preventDefault();
				self.cachedSelectors.inPreview.children('a').click();
			});

			// attach handlers - back to suggestions
			this.cachedSelectors.backToSuggestions.on('click', function () {

				self.searchCachedStuff.inSearchMode = false;

				if (self.requestInProgress) {
					self.requestInProgress.abort();
				}
				self.searchCachedStuff.currentKeywords = '';
				self.cachedSelectors.backToSuggestions.removeClass('show');
				self.cachedSelectors.carousel.find('p').removeClass('show');
				self.updateResultCaption();
				self.cachedSelectors.closePreviewBtn.click();
				self.cachedSelectors.carousel.find('li').remove();
				self.addSuggestions({
					searchQuery: self.suggestionsCachedStuff.suggestionQuery,
					items: self.suggestionsCachedStuff.cashedSuggestions
				});
				self.carouselMode = 'suggestion';
				if (self.cachedSelectors.carousel.resetPosition) {
					self.cachedSelectors.carousel.resetPosition();
				}

				self.isCarouselCheck();
			});

			// attach handlers - search
			this.cachedSelectors.searchForm.submit(function (event) {
				event.preventDefault();
				var keywords = mw.html.escape($(this).find('#VET-search-field').val());

				if (keywords !== '' && self.searchCachedStuff.currentKeywords !== keywords) {

					// switch fetch more handler to fetch search mode;
					self.searchCachedStuff.inSearchMode = true;

					// stop proccesing previous fetching request
					// (exp. using search when still loading suggestions on init)
					if (self.requestInProgress) {
						self.requestInProgress.abort();
					}

					// reset cached properties for new search query
					self.searchCachedStuff.fetchedResoultsCount = 0;
					self.searchCachedStuff.currentKeywords = keywords;
					self.canFatch = true;

					// cleanup carousel if new search phrase
					self.cachedSelectors.closePreviewBtn.click();
					self.cachedSelectors.carousel.find('li').remove();
					self.cachedSelectors.carousel.find('p').removeClass('show');

					self.cachedSelectors.suggestionsWrapper.startThrobbing();

					self.fetchSearch();

					tracking({
						label: (self.searchCachedStuff.searchType === 'local') ?
							'find-local-' + keywords : 'find-wikia-library-' + keywords
					});
				}
			});

			$videoEmbedDetails = $('#VideoEmbedDetails');
			// attach handlers - selection border around position options in video display options tab
			$videoEmbedDetails.on('click', '#VideoEmbedLayoutRow span', function () {
				var parent = $(this).parent();
				parent.find('span').removeClass('selected');
				$(this).addClass('selected');
			});

			// attach handler - submit display options tab
			$videoEmbedDetails.on('submit', '#VET-display-options', function (event) {
				event.preventDefault();
				insertFinalVideo(event);
			});
			$videoEmbedDetails.on('submit', '#VET-display-options-update', function (event) {
				event.preventDefault();

				tracking({
					label: 'button-update-video'
				});

				doEditVideo();
			});

			$('#vet-see-all').on('click', function () {
				tracking({
					label: 'link-see-all-help'
				});
			});
		},

		// METHOD: Remove selected state from in-preview thumbnail
		removeInPreview: function () {
			if (this.cachedSelectors.inPreview) {
				this.cachedSelectors.inPreview.removeClass('in-preview');
			}
		},

		// METHOD: Trim titles
		trimTitles: function (data) {
			var item, i;

			// trim video titles to two lines
			for (i in data.items) {
				item = data.items[i];
				if (item.fileTitle) {
					item.trimTitle = item.fileTitle.substr(0, 35);
					if (item.trimTitle.length < item.fileTitle.length) {
						item.trimTitle += '...';
					}
				}
			}
		},

		// METHOD: add items to carousel
		addSuggestions: function (data) {
			var html, template;

			template = '{{#items}}<li><figure>{{{thumbnail}}}<figcaption><strong>{{trimTitle}}</strong></figcaption>' +
				'</figure><a href="{{fileUrl}}" title="{{fileTitle}}" data-phrase="' +
				data.searchQuery + '" data-pos="{{pos}}">{{addMessage}}</a></li>{{/items}}';

			html = $.mustache(template, data);
			this.cachedSelectors.carousel.find('ul').append(html);
		},

		// METHOD: create carousel instance
		createCarousel: function () {
			var self = this,
				// items displayed per carousel slide
				itemsShown = 5,
				previousIndexStart;

			// show carousel if suggestions returned
			this.cachedSelectors.carouselWrapper.addClass('show');

			// create carousel instance
			this.carouselInstance = this.cachedSelectors.carousel.carousel({
				transitionSpeed: 500,
				itemsShown: itemsShown,
				nextClass: 'scrollright',
				prevClass: 'scrollleft',
				trackProgress: function (indexStart, indexEnd, totalItems) {
					// trackProgress gets called on init, we don't want to count that.
					if (previousIndexStart !== undefined) {
						tracking({
							label: 'results-carousel-' + (previousIndexStart < indexStart ? 'next' : 'previous')
						});
					}

					if (itemsShown * 2 > totalItems - indexEnd) {
						self.fetchSearch();
					}
					previousIndexStart = indexStart;
				}
			});
		},

		// METHOD: Update carousel after adding new items
		updateCarousel: function () {
			this.carouselInstance.updateCarouselItems();
			this.carouselInstance.updateCarouselWidth();
			this.carouselInstance.updateCarouselArrows();
		},

		// METHOD: update carousel after adding new items or create one if not already created
		isCarouselCheck: function () {
			if (this.cachedSelectors.carouselWrapper.hasClass('show')) {
				this.updateCarousel();
			} else {
				this.createCarousel();
			}
		},

		// METHOD: show preview of the selected video
		showVideoPreview: function (data) {
			var previewWrapper = this.cachedSelectors.previewWrapper,
				videoWrapper = this.cachedSelectors.videoWrapper,
				embedWrapper = $('<div class="Wikia-video-enabledEmbedCode">' + data.videoEmbedCode + '</div>')
					.appendTo(videoWrapper.html(''));

			videoInstance = new VideoBootstrap(embedWrapper[0], data.videoEmbedCode, 'vetPreview');

			// expand preview is hidden
			if (!previewWrapper.is(':visible')) {
				previewWrapper.stop().slideDown('slow');
			}
		},

		// METHOD: fech player embed code
		fetchVideoPlayer: function (title) {
			var self = this;

			$.nirvana.sendRequest({
				controller: 'VideoEmbedToolController',
				method: 'getEmbedCode',
				type: 'get',
				data: {
					fileTitle: title
				},
				callback: function (data) {
					self.showVideoPreview(data);

					// video play tracking
					Wikia.Tracker.track({
						action: Wikia.Tracker.ACTIONS.VIEW,
						category: 'Lightbox', // yeah, Lightbox so we can roll up all the data
						label: 'video-inline',
						title: title,
						provider: data.providerName,
						clickSource: (self.carouselMode === 'suggestion' ? 'VET-Suggestion' : 'VET-Search'),
						trackingMethod: 'internal'
					});
				}
			});
		},

		// METHOD: update caption
		updateResultCaption: function (txt) {
			if (!this.cachedResultCaption) {
				this.cachedResultCaption = this.cachedSelectors.resultCaption.text();
			}
			if (txt) {
				this.cachedSelectors.resultCaption.text(txt);
			} else {
				this.cachedSelectors.resultCaption.text(this.cachedResultCaption);
			}
		},

		// METHOD: fetch part of search results
		fetchSearch: function () {
			var self = this,
				svStart = this.searchCachedStuff.fetchedResoultsCount,
				svSize = 20, // number of requested items
				phrase = this.searchCachedStuff.currentKeywords;

			if (this.canFatch === true) {
				this.canFatch = false; // fetching in progress

				this.carouselMode = 'search';

				this.requestInProgress = $.nirvana.sendRequest({
					controller: 'VideoEmbedToolController',
					method: 'search',
					type: 'get',
					data: {
						svStart: svStart,
						svSize: svSize,
						phrase: phrase,
						type: self.searchCachedStuff.searchType,
						order: self.searchCachedStuff.searchOrder
					},
					callback: function (data) {
						var items = data.items,
							length = items.length;

						// show results count
						self.updateResultCaption(data.caption);

						if (length > 0) {

							// update results counter
							self.searchCachedStuff.fetchedResoultsCount = data.nextStartFrom;

							self.trimTitles(data);
							self.addSuggestions(data);

							// reset carousel container to the first slide position
							if (svStart === 0 && self.cachedSelectors.carousel.resetPosition) {
								self.cachedSelectors.carousel.resetPosition();
							}

						} else if (self.searchCachedStuff.fetchedResoultsCount === 0) {
							// show no results found for new search with not results returned from controller
							self.cachedSelectors.carousel.find('p').addClass('show');
						}

						if (self.suggestionsCachedStuff.cashedSuggestions.length > 0) {
							self.cachedSelectors.backToSuggestions.addClass('show');
						}

						self.isCarouselCheck();
						self.canFatch = true;
						self.cachedSelectors.suggestionsWrapper.stopThrobbing();
					}
				});
			}
		}
	};

	function handleLayout(e) {
		var label,
			$target = $(e.target);

		switch ($target.attr('id')) {
		case 'VideoEmbedLayoutCenter':
			label = 'center';
			break;
		case 'VideoEmbedLayoutLeft':
			label = 'left';
			break;
		case 'VideoEmbedLayoutRight':
			label = 'right';
			break;
		}

		if (label !== undefined) {
			tracking({
				label: 'display-position-' + label
			});
		}
	}

	function handleClose(e) {
		var $target = $(e.target),
			label = $target.attr('id') === 'VideoEmbedCloseButton' ? 'success-button-return' : 'button-close';

		e.preventDefault();
		tracking({
			label: label
		});
		close();
	}

	// event handlers taken from inline js.  TODO: integrate these better with rest of code
	$(document)
		.on(
			'click.VET',
			'#VideoEmbedLayoutLeft, #VideoEmbedLayoutCenter, #VideoEmbedLayoutRight',
			handleLayout
		)
		.on('change.VET, keyup.VET', '#VideoEmbedManualWidth', manualWidthInput)
		.on('keypress.VET', '#VideoEmbedUrl', onVideoEmbedUrlKeypress)
		.on('click.VET', '#VideoEmbedUrlSubmit', preQuery)
		.on(
			'click.VET',
			'#VideoEmbedRenameButton, #VideoEmbedExistingButton, #VideoEmbedOverwriteButton',
			insertFinalVideo
		)
		.on('click.VET', '.vet-close', handleClose);

	// globally available functions
	VET = {
		show: show,
		close: close
	};

	return VET;
});
