/*
 * Author: Inez Korczynski, Bartek Lapinski, Hyun Lim, Liz Lee
 */


define('wikia.vet', ['wikia.videoBootstrap', 'jquery', 'wikia.window'], function (VideoBootstrap, $, window) {

	var VET_panel = null;
	var VET_curSourceId = 0;
	var VET_lastQuery = [];
	var VET_jqXHR = {
		abort: function() {
			// empty function so if statements will not have to be embedded everywhere
		}
	};
	var VET_curScreen = 'Main';
	var VET_prevScreen = null;
	var VET_slider = null;
	var VET_orgThumbSize = null;
	var VET_height = null;
	var VET_wysiwygStart = 1;
	var VET_ratio = 1;
	var VET_shownMax = false;
	var VET_notificationTimout = 4000; // Show notifications for this long and then hide them
	var VET_options = {};
	var VET_embedPresets = false;
	var VET_callbackAfterSelect = $.noop;
	var VET_callbackAfterEmbed = $.noop;
	var VET_MAX_WIDTH = 670; // 670 max width on oasis
	var VET_MIN_WIDTH = 100;
	var VET_DEFAULT_WIDTH = 335;
	var VET_thumbSize = VET_DEFAULT_WIDTH;	// variable that can change later, defaulted to DEFAULT
	var VET_videoInstance = null;

	var VET_tracking = Wikia.Tracker.buildTrackingFunction( Wikia.trackEditorComponent, {
		action: Wikia.Tracker.ACTIONS.CLICK,
		category: 'vet',
		trackingMethod: 'both'
	});

	// ajax call for 2nd screen (aka embed screen)
	function VET_editVideo() {
		$('#VideoEmbedMain').hide();

		var callback = function(data) {
			var presets = VET_embedPresets;

			VET_displayDetails(data.responseText, presets);

			$('#VideoEmbedBack').hide();

			setTimeout(function() {
				if ( presets.thumb || presets.thumbnail ) {
		             $("#VideoEmbedThumbOption").prop('checked', true);
		             $('#VET_StyleThumb').addClass('selected');
		        }  else {
		        	 var sizeDiv = $('#VideoEmbedSizeRow > div');
		        	 sizeDiv.children('input').removeClass('show');
					 sizeDiv.children('p').addClass('show');
		        	 $("#VideoEmbedThumbOption").prop('checked', false);
		             $("#VideoEmbedNoThumbOption").prop('checked', true);
		             $('#VET_StyleThumb').removeClass('selected');
		             $('#VET_StyleNoThumb').addClass('selected');
		        }

				if(presets.align && presets.align == 'left') {
					$('#VideoEmbedLayoutLeft').attr('checked', 'checked').parent().addClass('selected');
				} else if (presets.align && presets.align == 'center') {
					$('#VideoEmbedLayoutCenter').attr('checked', 'checked').parent().addClass('selected');
				} else {
					$('#VideoEmbedLayoutRight').attr('checked', 'checked').parent().addClass('selected');
				}

				if(presets.width) {
					VET_readjustSlider( presets.width );
					$('#VideoEmbedManualWidth').val( presets.width );
				}

			}, 200);
			if(presets.caption) {
				$('#VideoEmbedCaption').val(presets.caption);
			}

			// show width slider
			VET_toggleSizing(true);

			// show alignment row
			$( '#VideoEmbedLayoutRow' ).show();

			// make replace video link to open in new window / tab
			$('#VideoReplaceLink a').first().attr('target', '_blank');
		};

		VET_jqXHR.abort();
		var params = [];
		var escTitle = "";
		if ( typeof(VET_embedPresets.href) == "undefined" ) {
			escTitle = VET_embedPresets.title;
		} else {
			escTitle = VET_embedPresets.href;
		}
		escTitle = encodeURIComponent(escTitle);
		params.push( 'itemTitle='+escTitle );

		VET_jqXHR = $.ajax(
			wgScriptPath + '/index.php?action=ajax&rs=VET&method=editVideo&' + params.join('&'),
			{
				method: 'get',
				complete: callback,
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
				}
			}
		);
	}

	// Collect embed settings from form and send to callbackAfterEmbed
	function VET_doEditVideo() {

		var description = encodeURIComponent($('#VideoEmbedDescription').val());

		$.nirvana.sendRequest({
			controller: 'VideoEmbedTool',
			method: 'editDescription',
			type: 'POST',
			format: 'json',
			data: {
				title: $('#VideoEmbedName').val(),
				description: description
			}
		}).done(function(json) {
			if(json.status == "fail") {
				GlobalNotification.show( json.errMsg, 'error', null, VET_notificationTimout );
			} else {
				// setup metadata
				var extraData = {};

				extraData.href = $('#VideoEmbedHref').val();
				extraData.width= $('#VideoEmbedManualWidth').val();

				if ($('#VideoEmbedThumbOption').is(':checked')) {
					extraData.thumb = 1;
				}

				if( $('#VideoEmbedLayoutLeft').is(':checked') ) {
					extraData.align = 'left';
				} else if ($('#VideoEmbedLayoutCenter').is(':checked') ) {
					extraData.align = 'center';
				} else {
					extraData.align = 'right';
				}

				var caption = $('#VideoEmbedCaption').val();
				if (caption) {
					 extraData.caption = caption;
				}

				if(VET_callbackAfterEmbed) {
					// Callback from extensions
					VET_callbackAfterEmbed(extraData);
				}
			}
		});

	}

	// macbre: move back button inside dialog content and add before provided selector (Oasis changes)
	function VET_moveBackButton(selector) {
		// store back button
		if (!window.VETbackButton) {
			var backButtonOriginal = $('#VideoEmbedBack');
			var backButton = backButtonOriginal.clone();

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
			click(VET_back).
			insertAfter(selector);
	}

	/*
	 * Functions/methods
	 */

	function VET_toggleSizing( enable ) {
		if( enable ) {
			$( '#VideoEmbedThumbOption' ).attr('disabled', false);
			$( '#VideoEmbedNoThumbOption' ).attr('disabled', false);
			$( '#VideoEmbedWidthRow' ).show();
			$( '#VideoEmbedSizeRow' ).show();
		} else {
			$( '#VideoEmbedThumbOption' ).attr('disabled', true);
			$( '#VideoEmbedNoThumbOption' ).attr('disabled', true);
			$( '#VideoEmbedWidthRow' ).hide();
			$( '#VideoEmbedSizeRow' ).hide();
		}
	}

	function VET_manualWidthInput() {
	    var val = parseInt( this.value );
	    if ( isNaN( val ) ) {
			VET_readjustSlider( 0 );
			return false;
	    }
	    if(val > VET_MAX_WIDTH) {
		    val = VET_MAX_WIDTH;
		    $( '#VideoEmbedManualWidth' ).val(val);
	    }
		VET_readjustSlider( val );
	}

	function VET_readjustSlider( value ) {
		var elem = $('#VideoEmbedSlider');
		elem.slider && elem.slider({
			value: value
		});
	}

	function VET_show( options ) {
		/* set vars for this instance of VET */
		VET_options = options;
		VET_embedPresets = options.embedPresets;
		VET_wysiwygStart = options.startPoint || 1;
		VET_callbackAfterSelect = options.callbackAfterSelect || $.noop;
		VET_callbackAfterEmbed = options.callbackAfterEmbed || $.noop;

		VET_tracking({
			action: Wikia.Tracker.ACTIONS.OPEN
		});

		if(VET_wysiwygStart == 2) {
			if(options.size) {
				VET_thumbSize = options.size;
			}
			VET_editVideo();
		} else {
			VET_loadMain(options.searchOrder);
		}

		$('#VideoEmbedBack').click(VET_back);
	}

	/* ajax call for first screen (aka video search) */
	function VET_loadMain(searchOrder) {
		var callback = function(data) {
			$('#VideoEmbedMain').html(data.responseText);
			$('#VideoEmbedUrl').focusNoScroll();
			VET_updateHeader();

			// macbre: RT #19150
			// TODO: figure out if this is being used anymore
			var loginMsg = $('#VideoEmbedLoginMsg');
			if ( window.wgEnableAjaxLogin == true && loginMsg.length ) {
				loginMsg.click(openLogin).css('cursor', 'pointer').log('VET: ajax login enabled');
			}

			// Add suggestions and search to VET
			VETExtended.init({
				searchOrder: searchOrder
			});
		};
		$.ajax(
			wgScriptPath + '/index.php?action=ajax&rs=VET&method=loadMain',
			{
				method: 'get',
				complete: callback
			}
		);
		VET_curSourceId = 0;
	}

	/*
	 * note: VET_onVideoEmbedUrlKeypress is called from template
	 */
	function VET_onVideoEmbedUrlKeypress(e) {
		if (e.which == 13){
			e.preventDefault();
			VET_preQuery(null);
			return false;
		}

	}

	/*
	 * note: VET_preQuery is called from a template, and from VET_onVideoEmbedUrlKeypress
	 */
	function VET_preQuery(e) {
		if(!$('#VideoEmbedUrl').val()) {
			GlobalNotification.show( $.msg('vet-warn2'), 'error', null, VET_notificationTimout );
			return false;
		} else {
			var query = $('#VideoEmbedUrl').val();
			VET_sendQueryEmbed( query );
			return false;
		}
	}

	/*
	 * renders the embed screen (aka 2nd screen)
	 */
	function VET_displayDetails(responseText, dataFromEditMode) {
		VET_switchScreen('Details');
		$('#VideoEmbedBack').css('display', 'inline');

		$('#VideoEmbedDetails').html(responseText);

		var element = $('#VideoEmbedThumb .video-embed');

		VET_videoInstance = new VideoBootstrap(element[0], window.VETPlayerParams, 'vetDetails');

		VET_updateHeader();


		if($('#VideoEmbedThumb').length) {
			VET_orgThumbSize = null;
			var image = $('#VideoEmbedThumb').children(':first');
			var thumbSize = [image.width, image.height];
			VET_orgThumbSize = null;
		}

		var value = VET_thumbSize;

		if (dataFromEditMode) {
			if(dataFromEditMode.width) {
				value = dataFromEditMode.width;
			} else {
				value = '';
			}
		}

		// Init width slider
		$('.WikiaSlider').slider({
			min: VET_MIN_WIDTH,
			max: VET_MAX_WIDTH,
			value: value,
			slide: function(event, ui) {
				$('#VideoEmbedManualWidth').val(ui.value);
			},
			create: function(event, ui) {
				$('#VideoEmbedManualWidth').val(value);
			}
		});

		if ($( '#VET_error_box' ).length) {
			GlobalNotification.show( $( '#VET_error_box' ).html(), 'error', null, VET_notificationTimout );
		}

		if ( $('#VideoEmbedMain').html() == '' ) {
			VET_loadMain();
		}

		$('#VideoEmbedThumbOption').on('change', function( e ) {
			VET_tracking({
				label: 'display-thumbnail-with-caption'
			});
		});

		$('#VideoEmbedNoThumbOption').on('change', function( e ) {
			VET_tracking({
				label: 'display-thumbnail-only'
			});
		});

		$('#VideoEmbedCaption').placeholder();
	}

	function VET_insertFinalVideo(e) {
		VET_tracking({
			label: 'complete'
		});

		e.preventDefault();

		var params = [];

		if( !$('#VideoEmbedName').length || $('#VideoEmbedName').val() == '' ) {
	 		GlobalNotification.show( $.msg('vet-warn3'), 'error', null, VET_notificationTimout );
			return false;
		}

		params.push('id='+$('#VideoEmbedId').val());
		params.push('provider='+$('#VideoEmbedProvider').val());

		if( $( '#VideoEmbedMetadata' ).length ) {
			var metadata = $( '#VideoEmbedMetadata' ).val().split( "," );
			for( var i=0; i < metadata.length; i++ ) {
				params.push( 'metadata' + i  + '=' + metadata[i] );
			}
		}

		params.push('description='+encodeURIComponent($('#VideoEmbedDescription').val()));
		params.push('oname='+encodeURIComponent( $('#VideoEmbedOname').val() ) );
		params.push('name='+encodeURIComponent( $('#VideoEmbedName').val() ) );

		if($('#VideoEmbedThumb').length) {
			params.push('size=' + ($('#VideoEmbedThumbOption').is(':checked') ? 'thumb' : 'full'));
			params.push( 'width=' + $( '#VideoEmbedManualWidth' ).val() );
			if( $('#VideoEmbedLayoutLeft').is(':checked') ) {
				params.push( 'layout=left' );
			} else if( $('#VideoEmbedLayoutGallery').is(':checked') ) {
				params.push( 'layout=gallery' );
			} else if ( $('#VideoEmbedLayoutCenter').is(':checked') ) {
				params.push( 'layout=center' )
			} else {
				params.push( 'layout=right' );
			}
			params.push('caption=' + encodeURIComponent( $('#VideoEmbedCaption').val() ) );
		}

		// Allow extensions to add extra params to ajax call
		params = params.concat(VET_options.insertFinalVideoParams || []);

		var callback = function(data, status) {
			if(status == 'error') {
				GlobalNotification.show( $.msg('vet-insert-error'), 'error', null, VET_notificationTimout );
			} else if (status == 'success') {
				var screenType = VET_jqXHR.getResponseHeader('X-screen-type');
				if(typeof screenType == "undefined") {
					screenType = VET_jqXHR.getResponseHeader('X-Screen-Type');
				}
				switch($.trim(screenType)) {
					case 'error':
						data.responseText = data.responseText.replace(/<script.*script>/, "" );
						GlobalNotification.show( data.responseText, 'error', null, VET_notificationTimout );
						break;
					case 'summary':
						VET_switchScreen('Summary');
						$('#VideoEmbedBack').hide();
						$('#VideoEmbed' + VET_curScreen).html(data.responseText);
						VET_updateHeader();

						if ( !$( '#VideoEmbedCreate'  ).length && !$( '#VideoEmbedReplace' ).length ) {
							var wikitext = $('#VideoEmbedTag').val();
							var options = {};

							if(wikitext) {
								options.wikitext = wikitext;
							}
							if($('#VideoEmbedThumbOption').is(':checked')) {
								options.thumb = 1;
							} else {
								options.thumb = null;
							}
							if($('#VideoEmbedLayoutLeft').is(':checked')) {
								options.align = 'left';
							} else if ($('#VideoEmbedLayoutCenter').is(':checked')) {
								options.align = 'center';
							} else {
								options.align = null;
							}

							options.caption = $('#VideoEmbedCaption').val();

							options.placeholderIndex = VET_embedPresets.placeholderIndex;

							VET_callbackAfterEmbed(options);
						} else {
							$( '#VideoEmbedSuccess' ).hide();
							$( '#VideoEmbedTag' ).hide();
							$( '#VideoEmbedPageSuccess' ).show();
						}
						break;
					default:
						break;
				}
			}
		};

		VET_jqXHR.abort();
		VET_jqXHR = $.ajax(
			wgScriptPath + '/index.php?action=ajax&rs=VET&method=insertFinalVideo&' + params.join('&'),
			{
				method: 'get',
				complete: callback
			}
		);
	}

	function VET_switchScreen(to) {
		if ( VET_videoInstance ) {
			VET_videoInstance.clearTimeoutTrack();
		}
		VET_prevScreen = VET_curScreen;
		VET_curScreen = to;
		$('#VideoEmbedBody').find('.VET_screen').hide();
		$('#VideoEmbed' + VET_curScreen).show();
		VET_updateHeader();

		// this is called in both cases - when hitting 'back' and when closing the dialog.
		// in any case we want to stop the video
		$('#VideoEmbedThumb').children().remove();
		if(VET_curScreen == 'Main') {
			$('#VideoEmbedBack').hide();
		}

		// macbre: move back button on Oasis
		if( to == "Details" ) {
			setTimeout(function() {
				VET_moveBackButton($('.addVideoDetailsFormControls').find('input'));
			}, 50);
		}
	}

	function VET_back(e) {
		e.preventDefault();

		VET_tracking({
			label: 'button-' + VET_curScreen.toLowerCase() + '-back'
		});

		if(VET_curScreen == 'Details') {
			VET_switchScreen('Main');
		} else if(VET_curScreen == 'Conflict' && VET_prevScreen == 'Details') {
			VET_switchScreen('Details');
		}
	}

	function VET_close() {
		window.VETbackButton = false;

		VET_loader.modal.closeModal();

		VET_tracking({
			action: Wikia.Tracker.ACTIONS.CLOSE
		});

		if ($.isFunction(VET_options.onClose)) {
			VET_options.onClose();
		}

		VET_switchScreen('Main');

		window.UserLogin.refreshIfAfterForceLogin();
	}

	/*
	 * transition from search to embed
	 * todo: rename this function, because it does not only send query to embed
	 */
	function VET_sendQueryEmbed(query) {
		// If callbackAfterSelect returns false, end here. Otherwise, move on to the next screen.
		if(VET_callbackAfterSelect(query, VET) !== false) {
			var callback = function(data) {
				var screenType = VET_jqXHR.getResponseHeader('X-screen-type');
				if(typeof screenType == "undefined") {
					screenType = VET_jqXHR.getResponseHeader('X-Screen-Type');
				}

				if( 'error' == $.trim(screenType) ) {
					GlobalNotification.show( data.responseText, 'error', null, VET_notificationTimout );
				} else {
					// attach handlers - close preview on VET modal close (IE bug fix)
					VETExtended.cachedSelectors.closePreviewBtn.click();
					VET_displayDetails(data.responseText);
				}

			};
			var searchType = VETExtended.searchCachedStuff.searchType;

			VET_jqXHR.abort();
			VET_jqXHR = $.ajax(
				wgScriptPath + '/index.php',
				{
					method: 'post',
					data: 'action=ajax&rs=VET&method=insertVideo&url=' + escape(query) + '&searchType=' + searchType,
					complete: callback
				}
			);
		}
	}

	function VET_updateHeader() {
		var $header = $('#VideoEmbed' + VET_curScreen + ' h1:first');
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

	var VETExtended = {

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

		init: function(searchSettings) {
			var that = this;

			// reset cached stuff on init if some old values preserved
			this.searchCachedStuff.currentKeywords = '';
			this.searchCachedStuff.inSearchMode = false;
			this.suggestionsCachedStuff.cashedSuggestions = [];
			this.suggestionsCachedStuff.fetchedResoultsCount = 0;

			$.extend(this.searchCachedStuff, searchSettings);

			// load mustache as deferred object and then make request for suggestions
			$.when(
				$.loadMustache()
			).done($.proxy(this.fetchSuggestions, this));

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
				positionOptions: $('#VideoEmbedLayoutRow'),
				searchDropDown: $('#VET-search-dropdown')
			};

			// set search type to local if premium disabled
			if (this.cachedSelectors.searchDropDown.attr('data-selected') === 'local') {
				this.searchCachedStuff.searchType = 'local';
			} else {
				this.searchCachedStuff.searchType = 'premium';
			}

			// attach handlers - add video button
			this.cachedSelectors.carousel.on('click', 'li > a', function(event) {
				event.preventDefault();
				VET_sendQueryEmbed($(this).attr('href'));
                var node = $(event.currentTarget).data();
                var trackData = node.phrase + '[' + node.pos + ']';
				VET_tracking({
					label: that.carouselMode === 'search' ? 'add-video-' + trackData  : 'add-video-suggested-' + trackData
				});
			});

			// attach handlers - play button (open video preview)
			this.cachedSelectors.carousel.on('click', 'li a.video', function(event){
				event.preventDefault();
				var videoTitle = $(".Wikia-video-thumb", this).attr("data-video-key");
				that.fetchVideoPlayer(videoTitle);

				VET_tracking({
					label: 'carousel-thumbnail'
				});

				// remove in-preview class from previously check item if exists
				that.removeInPreview();

				// cache current in preview element in carousel
				that.cachedSelectors.inPreview = $(this).parents('li').addClass('in-preview');
			});

			// attach handlers - close preview
			this.cachedSelectors.previewWrapper.on('click', '#VET-preview-close', function(event) {
				event.preventDefault();

				// Closing a video instance, clear the tracking timeout
				if ( VET_videoInstance ) {
					VET_videoInstance.clearTimeoutTrack();
				}

				that.cachedSelectors.previewWrapper.stop().slideUp('slow', function() {
					that.cachedSelectors.videoWrapper.children().remove();
					that.removeInPreview();
				});
			});

			// attach handlers - add video button from preview
			this.cachedSelectors.previewWrapper.on('click', '#VET-add-from-preview', function(event) {
				event.preventDefault();
				that.cachedSelectors.inPreview.children('a').click();
			});

			// attach handlers - back to suggestions
			this.cachedSelectors.backToSuggestions.on('click', function(e) {

	            that.searchCachedStuff.inSearchMode = false;

	            if(that.requestInProgress) {
	                that.requestInProgress.abort();
	            }
	            that.searchCachedStuff.currentKeywords = '';
	            that.cachedSelectors.backToSuggestions.removeClass('show');
	            that.cachedSelectors.carousel.find('p').removeClass('show');
	            that.updateResultCaption();
				that.cachedSelectors.closePreviewBtn.click();
	            that.cachedSelectors.carousel.find('li').remove();
	            that.addSuggestions({ searchQuery: that.suggestionsCachedStuff.suggestionQuery, items: that.suggestionsCachedStuff.cashedSuggestions });
                that.carouselMode = 'suggestion';
	            if (that.cachedSelectors.carousel.resetPosition) that.cachedSelectors.carousel.resetPosition();

	            that.isCarouselCheck();
			});

			// attach handlers - search
			this.cachedSelectors.searchForm.submit(function(event) {
				event.preventDefault();
				var keywords = $(this).find('#VET-search-field').val();
				if(keywords !== '' && that.searchCachedStuff.currentKeywords !== keywords) {

					// switch fetch more handler to fetch search mode;
					that.searchCachedStuff.inSearchMode = true;

					// stop proccesing previous fetching request (exp. using search when still loading suggestions on init)
					if(that.requestInProgress) {
						that.requestInProgress.abort();
					}

					// reset cached properties for new search query
					that.searchCachedStuff.fetchedResoultsCount = 0;
					that.searchCachedStuff.currentKeywords = keywords;
					that.canFatch = true;

					// cleanup carousel if new search phrase
					that.cachedSelectors.closePreviewBtn.click();
					that.cachedSelectors.carousel.find('li').remove();
					that.cachedSelectors.carousel.find('p').removeClass('show');

					that.cachedSelectors.suggestionsWrapper.startThrobbing();

					that.fetchSearch();

					VET_tracking({
						label: that.searchCachedStuff.searchType === 'local' ? 'find-local-' + keywords : 'find-wikia-library-' + keywords
					});
				}
			});

			// attach handlers - selection border around position options in video display options tab
			$('#VideoEmbedDetails').on('click', '#VideoEmbedLayoutRow span, #VideoEmbedSizeRow span', function() {

				var parent = $(this).parent();
				parent.find('span').removeClass('selected');
				$(this).addClass('selected');

				// show/hide caption input for "Style" option
				if ($(this).is('#VET_StyleThumb')) {
					parent.children('p').removeClass('show');
					parent.children('input').addClass('show');
				} else {
					parent.children('input').removeClass('show');
					parent.children('p').addClass('show');
				}
			});

			// attach handler - submit display options tab
			$('#VideoEmbedDetails').on('submit', '#VET-display-options', function(event) {
				event.preventDefault();
				VET_insertFinalVideo(event, 'details');
			});
			$('#VideoEmbedDetails').on('submit', '#VET-display-options-update', function(event) {
				event.preventDefault();

				VET_tracking({
					label: 'button-update-video'
				});

				VET_doEditVideo();
			});

			// create dropdown for search filters
			this.cachedSelectors.searchDropDown.wikiaDropdown({
				onChange: function(e, $target) {
					var currSort = this.$selectedItemsList.text(),
						newSort = $target.text();

					if(currSort != newSort) {
						var sort = $target.data('sort');
						VET_tracking({
							label: 'dropdown-search-filter-' + sort
						});
						that.searchCachedStuff.searchType = sort;
						that.searchCachedStuff.currentKeywords = '';
						that.cachedSelectors.closePreviewBtn.click();
						$('#VET-search-submit').click();
					}
				}
			});

			$('#vet-see-all').on('click', function( e ) {
				VET_tracking({
					label: 'link-see-all-help'
				});
			});
		},

		// METHOD: Remove selected state from in-preview thumbnail
		removeInPreview: function() {

			if (this.cachedSelectors.inPreview) {
				this.cachedSelectors.inPreview.removeClass('in-preview');
			}

		},

		// METHOD: Trim titles
		trimTitles: function(data) {

			var item;

			// trim video titles to two lines
			for ( var i in data.items ) {
				item = data.items[i];
				if (item.title) {
					item.trimTitle = item.title.substr(0, 35);
					if ( item.trimTitle.length < item.title.length ) {
						item.trimTitle += "...";
					}
				}
			}

		},

		// METHOD: add items to carousel
		addSuggestions: function(data) {

			var html,
				template = '{{#items}}<li><figure>{{{thumbnail}}}<figcaption><strong>{{trimTitle}}</strong></figcaption></figure><a href="{{url}}" title="{{title}}" data-phrase="' + data.searchQuery + '" data-pos="{{pos}}">Add video</a></li>{{/items}}';

			html = $.mustache(template, data);
			this.cachedSelectors.carousel.find('ul').append(html);

		},

		// METHOD: create carousel instance
		createCarousel: function() {

			var that = this,
				// items displayed per carousel slide
				itemsShown = 5,
				previousIndexStart;

			// show carousel if suggestions returned
			this.cachedSelectors.carouselWrapper.addClass('show');

			// create carousel instance
			this.carouselInstance = this.cachedSelectors.carousel.carousel({
				transitionSpeed: 500,
				itemsShown: itemsShown,
				nextClass: "scrollright",
				prevClass: "scrollleft",
				trackProgress: function(indexStart, indexEnd, totalItems) {
					// trackProgress gets called on init, we don't want to count that.
					if (previousIndexStart !== undefined) {
						VET_tracking({
							label: 'results-carousel-' + (previousIndexStart < indexStart ? 'next' : 'previous')
						});
					}

					if (itemsShown * 2 > totalItems - indexEnd) {
						// depends on fetch mode send request to different controller
						if (!that.searchCachedStuff.inSearchMode) {
							that.fetchSuggestions();
						} else {
							that.fetchSearch();
						}
					}

					previousIndexStart = indexStart;
				}
			});

		},

		// METHOD: Update carousel after adding new items
		updateCarousel: function() {
			this.carouselInstance.updateCarouselItems();
			this.carouselInstance.updateCarouselWidth();
			this.carouselInstance.updateCarouselArrows();
		},

		// METHOD: update carousel after adding new items or create one if not already created
		isCarouselCheck: function() {

			if (this.cachedSelectors.carouselWrapper.hasClass('show')) {
				this.updateCarousel();
			} else {
				this.createCarousel();
			}

		},


		// METHOD: show preview of the selected video
		showVideoPreview: function(data) {
			var previewWrapper = this.cachedSelectors.previewWrapper,
				videoWrapper = this.cachedSelectors.videoWrapper,
				embedWrapper = $('<div class="Wikia-video-enabledEmbedCode">'+data.videoEmbedCode+'</div>').appendTo(videoWrapper.html(""));

			VET_videoInstance = new VideoBootstrap(embedWrapper[0], data.videoEmbedCode, 'vetPreview');

			// expand preview is hidden
			if (!previewWrapper.is(':visible')) {
				previewWrapper.stop().slideDown('slow');
			}

		},

		// METHOD: fech player embed code
		fetchVideoPlayer: function(title) {

			var that = this;

			$.nirvana.sendRequest({
				controller: 'VideoEmbedToolController',
				method: 'getEmbedCode',
				type: 'get',
				data: {
					fileTitle: title
				},
				callback: function(data) {
					that.showVideoPreview(data);

					// video play tracking
					Wikia.Tracker.track({
						action: Wikia.Tracker.ACTIONS.VIEW,
						category: 'Lightbox',	// yeah, Lightbox so we can roll up all the data
						label: 'video-inline',
						title: title,
						provider: data.providerName,
						clickSource: (that.carouselMode === 'suggestion' ? 'VET-Suggestion' : 'VET-Search'),
						trackingMethod: 'internal'
					});
				}
			});

		},

		// METHOD: update caption
		updateResultCaption: function( txt ) {
		      if (!this.cachedResultCaption) this.cachedResultCaption = this.cachedSelectors.resultCaption.text();
		      if ( txt ) this.cachedSelectors.resultCaption.text( txt );
		      else this.cachedSelectors.resultCaption.text( this.cachedResultCaption );
		},

		// METHOD: fetch part of suggestions
		fetchSuggestions: function() {

			var that = this,
				svStart = this.suggestionsCachedStuff.fetchedResoultsCount, // index - start fetching from item number...
				svSize = 20; // number of requested items

			if (this.canFatch === true) {
				this.canFatch = false; // fetching in progress

				this.carouselMode = 'suggestion';

				this.requestInProgress = $.nirvana.sendRequest({
					controller: 'VideoEmbedToolController',
					method: 'getSuggestedVideos',
					type: 'get',
					data: {
						svStart: svStart,
						svSize: svSize,
						articleId: wgArticleId
					},
					callback: function(data) {
						var i,
							items = data.items,
							length = items.length;

						if (length > 0) {
                            VET_tracking({
                                label: 'suggestions-loaded-' + data.searchQuery
                            });

							that.trimTitles(data);
							that.addSuggestions(data);

							// update results counter
							that.suggestionsCachedStuff.fetchedResoultsCount = data.nextStartFrom;
							that.suggestionsCachedStuff.suggestionQuery = data.searchQuery;

							// cache fetched items
							for (i = 0; i < length; i += 1) {
								that.suggestionsCachedStuff.cashedSuggestions.push(items[i]);
							}

							that.isCarouselCheck();
							that.canFatch = true;
						}
					}
				});
			}

		},

		// METHOD: fetch part of search results
		fetchSearch: function() {

			var that = this,
				svStart = this.searchCachedStuff.fetchedResoultsCount,
				svSize = 20; // number of requested items
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
						type: that.searchCachedStuff.searchType,
						order: that.searchCachedStuff.searchOrder
					},
					callback: function(data) {

						var i,
							items = data.items,
							length = items.length;

						// show results count
						that.updateResultCaption( data.caption );

						if (length > 0) {

							// update results counter
							that.searchCachedStuff.fetchedResoultsCount = data.nextStartFrom;

							that.trimTitles(data);
							that.addSuggestions(data);

							// reset carousel container to the first slide position
							if (svStart === 0) {
								if (that.cachedSelectors.carousel.resetPosition) that.cachedSelectors.carousel.resetPosition();
							}

						} else if (that.searchCachedStuff.fetchedResoultsCount === 0) {
							// show no results found for new search with not results returned from controller
							that.cachedSelectors.carousel.find('p').addClass('show');
						}

						if (that.suggestionsCachedStuff.cashedSuggestions.length > 0)
							that.cachedSelectors.backToSuggestions.addClass('show');

						that.isCarouselCheck();
						that.canFatch = true;
						that.cachedSelectors.suggestionsWrapper.stopThrobbing();

					}
				});
			}

		}

	};


	// event handlers taken from inline js.  TODO: integrate these better with rest of code
	$(document)
		.on('click.VET', '#VideoEmbedLayoutLeft, #VideoEmbedLayoutCenter, #VideoEmbedLayoutRight, #VideoEmbedLayoutGallery', function(e) {
			var label,
				$target = $(e.target),
				toggleTo = true;

			if($target.is('#VideoEmbedLayoutGallery')) {
				toggleTo = false;
			}

			switch($target.attr('id')) {
				case 'VideoEmbedLayoutCenter': {
					label = 'center';
					break;
				}
				case 'VideoEmbedLayoutLeft': {
					label = 'left';
					break;
				}
				case 'VideoEmbedLayoutRight': {
					label = 'right';
					break;
				}
			}

			if (label !== undefined) {
				VET_tracking({
					label: 'display-position-' + label
				});
			}

			VET_toggleSizing(toggleTo);
		})
		.on('change.VET, keyup.VET', '#VideoEmbedManualWidth', VET_manualWidthInput)
		.on('keypress.VET', '#VideoEmbedUrl', VET_onVideoEmbedUrlKeypress)
		.on('click.VET', '#VideoEmbedUrlSubmit', VET_preQuery)
		.on('click.VET', '#VideoEmbedRenameButton, #VideoEmbedExistingButton, #VideoEmbedOverwriteButton', VET_insertFinalVideo)
		.on('click.VET', '.vet-close', function(e) {
			var $target = $(e.target),
				label = $target.attr('id') === 'VideoEmbedCloseButton' ? 'success-button-return' : 'button-close';

			e.preventDefault();

			VET_tracking({
				label: label
			});

			VET_close();
		});


	// globally available functions
	var VET = {
		show: VET_show,
		close: VET_close
	};

	return VET;
});
