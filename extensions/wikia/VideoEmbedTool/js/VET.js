/*global UserLogin, WikiaEditor*/

/*
 * Author: Inez Korczynski, Bartek Lapinski, Hyun Lim, Liz Lee
 */


/*
 * Variables
 */
(function($, window) {
	var VET_panel = null;
	var VET_curSourceId = 0;
	var VET_lastQuery = new Array();
	var VET_jqXHR = {
		abort: function() {
			// empty function so if statements will not have to be embedded everywhere
		}
	};
	var VET_curScreen = 'Main';
	var VET_prevScreen = null;
	var VET_slider = null;
	var VET_orgThumbSize = null;
	var VET_thumbSize = 335;
	var VET_height = null;
	var VET_wysiwygStart = 1;
	var VET_ratio = 1;
	var VET_shownMax = false;
	var VET_notificationTimout = 4000;
	var VET_embedPresets = false;
	var VET_callbackAfterSelect = false;
	var VET_callbackAfterEmbed = false;
	
	// macbre: show edit video screen (wysiwyg edit)
	function VET_editVideo() {
		$('#VideoEmbedMain').hide();
	
		var callback = function(o) {
			var data = VET_embedPresets;
	
			VET_displayDetails(o.responseText, data);
	
			$('#VideoEmbedBack').hide();
	
			setTimeout(function() {
				if ( data.thumb ) {
		             $("#VideoEmbedThumbOption").attr('checked', 'checked');
		             $('#VET_StyleThumb').addClass('selected');
		        }  else {
		        	 $('#VideoEmbedSizeRow > div').children('input').removeClass('show');
					 $('#VideoEmbedSizeRow > div').children('p').addClass('show');
		        	 $("#VideoEmbedThumbOption").attr('checked', '');
		             $("#VideoEmbedNoThumbOption").attr('checked', 'checked');
		             $('#VET_StyleThumb').removeClass('selected');
		             $('#VET_StyleNoThumb').addClass('selected');
		        }
	
				if(data.align && data.align == 'left') {
					$('#VideoEmbedLayoutLeft').attr('checked', 'checked').parent().addClass('selected');
				} else if (data.align && data.align == 'center') {
					$('#VideoEmbedLayoutCenter').attr('checked', 'checked').parent().addClass('selected');
				} else {
					$('#VideoEmbedLayoutRight').attr('checked', 'checked').parent().addClass('selected');
				}
	
				if(data.width) {
					VET_readjustSlider( data.width );
					$('#VideoEmbedManualWidth').val( data.width );
				}
	
			}, 200);
			if(data.caption) {
				$('#VideoEmbedCaption').val(data.caption);
			}
	
			// show width slider
			VET_toggleSizing(true);
	
			// show alignment row
			$( '#VideoEmbedLayoutRow' ).css('display', '');
	
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

		if ($('#VideoEmbedCaption').val()) {
			 extraData.caption = $('#VideoEmbedCaption').val();
		}

		if(VET_callbackAfterEmbed) {
			VET_callbackAfterEmbed(extraData);
		}
	}
	
	// macbre: move back button inside dialog content and add before provided selector (Oasis changes)
	function VET_moveBackButton(selector) {
		// store back button
		if (typeof window.VETbackButton == 'undefined') {
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
			$( '#VideoEmbedWidthRow' ).css('display', '');
			$( '#VideoEmbedSizeRow' ).css('display', '');
		} else {
			$( '#VideoEmbedThumbOption' ).attr('disabled', true);
			$( '#VideoEmbedNoThumbOption' ).css('disabled', true);
			$( '#VideoEmbedWidthRow' ).css('display', 'none');
			$( '#VideoEmbedSizeRow' ).css('display', 'none');
		}
	}
	
	function VET_manualWidthInput() {
	    var val = parseInt( this.value );
	    if ( isNaN( val ) ) {
			$( '#VideoEmbedManualWidth' ).val(VET_thumbSize);
			VET_readjustSlider( VET_thumbSize );
			return false;
	    }
		$( 'VideoEmbedManualWidth' ).val(val);
		VET_readjustSlider( val );
	}
	
	function VET_readjustSlider( value ) {
			if ( 670 < value ) { // too big, hide slider
				if ( $('#VideoEmbedSlider .ui-slider-handle').is(':visible') ) {
					$('#VideoEmbedSlider .ui-slider-handle').hide();
					$('#VideoEmbedSlider').slider && $('#VideoEmbedSlider').slider({
						value: VET_thumbSize
					});
				}
			} else {
				if ( !$('#VideoEmbedSlider .ui-slider-handle').is(':visible') ) {
					$('#VideoEmbedSlider .ui-slider-handle' ).show();
				}
	
				$('#VideoEmbedSlider').slider && $('#VideoEmbedSlider').slider({
					value: value
				});
			}
	}
	
	function VET_show( options ) {
		if (wgUserName == null && wgAction == 'edit') {
			// handle login on edit page
			UserLogin.rteForceLogin();
			return;
		} else if (UserLogin.isForceLogIn()) {
			// handle login on article page
			return;
		}
		
		// Handle MiniEditor focus
		// (BugId:18713)
		if (window.WikiaEditor) {
			var wikiaEditor = WikiaEditor.getInstance();
			if(wikiaEditor.config.isMiniEditor) {
				wikiaEditor.plugins.MiniEditor.hasFocus = true;
			}
		}

		/* set options */
		VET_embedPresets = options.embedPresets;
		VET_wysiwygStart = options.startPoint || 1;
		VET_callbackAfterSelect = options.callbackAfterSelect || false;
		VET_callbackAfterEmbed = options.callbackAfterEmbed || false;
	
		VET_tracking(WikiaTracker.ACTIONS.CLICK, 'open');
	
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
	
	function VET_loadMain(searchOrder) {
		var callback = function(o) {
			$('#VideoEmbedMain').html(o.responseText);
			$('#VideoEmbedUrl').focus();
	
			// macbre: RT #19150
			if ( window.wgEnableAjaxLogin == true && $('#VideoEmbedLoginMsg').exists() ) {
				$('#VideoEmbedLoginMsg').click(openLogin).css('cursor', 'pointer').log('VET: ajax login enabled');
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
	
		// wlee: responseText could include <script>. Use jQuery to parse
		// and execute this script
		$('#VideoEmbed' + VET_curScreen).html(responseText);
	
		if($('#VideoEmbedThumb').length) {
			VET_orgThumbSize = null;
			var image = $('#VideoEmbedThumb').children(':first');
			var thumbSize = [image.width, image.height];
			VET_orgThumbSize = null;
		}
	
		var value = VET_thumbSize;
	
		if (dataFromEditMode && dataFromEditMode.width) {
			value = dataFromEditMode.width;
		}
	
		function initSlider() {
	
			$('.WikiaSlider').slider({
				min: 100,
				max: 670,
				value: value,
				slide: function(event, ui) {
					$('#VideoEmbedManualWidth').val(ui.value);
				},
				create: function(event, ui) {
					$('#VideoEmbedManualWidth').val(value);
				}
			});
		}
	
		// VET uses jquery ui slider, lazy load it if needed
		if (!$.fn.slider) {
			$.when(
				$.getResources([
					wgResourceBasePath + '/resources/jquery.ui/jquery.ui.widget.js',
					wgResourceBasePath + '/resources/jquery.ui/jquery.ui.mouse.js',
					wgResourceBasePath + '/resources/jquery.ui/jquery.ui.slider.js'
				])
			).done(initSlider);
		} else {
			initSlider();
		}
	
		if ($( '#VET_error_box' ).length) {
			GlobalNotification.show( $( '#VET_error_box' ).html(), 'error', null, VET_notificationTimout );
		}
	
		if ( $('#VideoEmbedMain').html() == '' ) {
			VET_loadMain();
		}
	
		$('#VideoEmbedCaption').placeholder();
	}
	
	function VET_insertFinalVideo(e) {
		VET_tracking(WikiaTracker.ACTIONS.CLICK, 'complete');
		
		e.preventDefault();
	
		var params = new Array();

		if( !$('#VideoEmbedName').length || $('#VideoEmbedName').val() == '' ) {
	 		GlobalNotification.show( $.msg('vet-warn3'), 'error', null, VET_notificationTimout );
			return false;
		}
	
		params.push('id='+$('#VideoEmbedId').val());
		params.push('provider='+$('#VideoEmbedProvider').val());
	
		if( $( '#VideoEmbedMetadata' ).length ) {
			var metadata = new Array();
			metadata = $( '#VideoEmbedMetadata' ).val().split( "," );
			for( var i=0; i < metadata.length; i++ ) {
				params.push( 'metadata' + i  + '=' + metadata[i] );
			}
		}
		
		// Add article placeholder specific params to ajax call 
		$(window).trigger('VET_insertFinalParams', [params, VET_embedPresets.placeholderIndex]);
	
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
	
		var callback = function(o, status) {
			if(status == 'error') {
				GlobalNotification.show( $.msg('vet-insert-error'), 'error', null, VET_notificationTimout );
			} else if (status == 'success') {
				var screenType = VET_jqXHR.getResponseHeader('X-screen-type');
				if(typeof screenType == "undefined") {
					screenType = VET_jqXHR.getResponseHeader('X-Screen-Type');
				}
				switch($.trim(screenType)) {
					case 'error':
						o.responseText = o.responseText.replace(/<script.*script>/, "" );
						GlobalNotification.show( o.responseText, 'error', null, VET_notificationTimout );
						break;
					case 'summary':
						VET_switchScreen('Summary');
						$('#VideoEmbedBack').css('display', 'none');
						$('#VideoEmbed' + VET_curScreen).html(o.responseText);

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
	
							if(VET_callbackAfterEmbed) {
								VET_callbackAfterEmbed(options);
							}
							/* move to VET_Loader.load from editor 
							if (typeof window.VET_RTEVideo != 'undefined') {
								if (window.VET_RTEVideo && window.VET_RTEVideo.hasClass('media-placeholder')) {
									// replace "Add Video" placeholder
									RTE.mediaEditor.update(window.VET_RTEVideo, wikitag, options);
								}
								else {
									RTE.mediaEditor.addVideo(wikitag, options);
								}
							}*/
						} else {
							$( '#VideoEmbedSuccess' ).css('display', 'none');
							$( '#VideoEmbedTag' ).css('display', 'none');
							$( '#VideoEmbedPageSuccess' ).css('display', 'block');
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
		VET_prevScreen = VET_curScreen;
		VET_curScreen = to;
		$('#VideoEmbed' + VET_prevScreen).css('display', 'none');
		$('#VideoEmbed' + VET_curScreen).css('display', '');
		// this is called in both cases - when hitting 'back' and when closing the dialog.
		// in any case we want to stop the video
		$('#VideoEmbedThumb').children().remove();
		if(VET_curScreen == 'Main') {
			$('#VideoEmbedBack').css('display', 'none');
		}
	
		// macbre: move back button on Oasis
		setTimeout(function() {
			$().log(to, 'VET_switchScreen');
			switch(to) {
				case 'Details':
					VET_moveBackButton($('.VideoEmbedNoBorder.addVideoDetailsFormControls').find('input'));
					break;

				case 'Conflict':
					VET_moveBackButton($('#VideoEmbedConflictOverwriteButton'));
					break;
			}
		}, 50);
	}
	
	function VET_back(e) {
		e.preventDefault();
	
		if(VET_curScreen == 'Details') {
			VET_switchScreen('Main');
		} else if(VET_curScreen == 'Conflict' && VET_prevScreen == 'Details') {
			VET_switchScreen('Details');
		}
	}
	
	function VET_close() {
		VET_switchScreen('Main');
		
		VET_loader.modal.closeModal();

		// Handle MiniEditor focus
		// (BugId:18713)
		if (window.WikiaEditor) {
			var wikiaEditor = WikiaEditor.getInstance();
			if(wikiaEditor.config.isMiniEditor) {
				wikiaEditor.editorFocus();
				wikiaEditor.plugins.MiniEditor.hasFocus = false;
			}
		}
	}
	
	function VET_tracking(action, label, value) {
		WikiaTracker.trackEvent(null, {
			ga_category: 'vet',
			ga_action: action,
			ga_label: label || ''
		}, 'internal');
	}
	
	/*
	 * transition from search to embed
	 * todo: rename this function, because it does not only send query to embed
	 */
	function VET_sendQueryEmbed(query) {
		if(VET_callbackAfterSelect) {
			VET_callbackAfterSelect(query);
		} else {
			var callback = function(o) {
				var screenType = VET_jqXHR.getResponseHeader('X-screen-type');
				if(typeof screenType == "undefined") {
					screenType = VET_jqXHR.getResponseHeader('X-Screen-Type');
				}
	
				if( 'error' == $.trim(screenType) ) {
					GlobalNotification.show( o.responseText, 'error', null, VET_notificationTimout );
				} else {
					// attach handlers - close preview on VET modal close (IE bug fix)
					VETExtended.cachedSelectors.closePreviewBtn.click();
					VET_displayDetails(o.responseText);
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
	
		track: function(action, label, data) {
			window.WikiaTracker.trackEvent('trackingevent', $.extend({
				ga_category: 'vet',
				ga_action: action,
				ga_label: label
			}, data || {}), 'internal');
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
	
				// track event
				var label = that.carouselMode === 'search' ? 'add-video' : 'add-video-suggested';
				that.track(window.WikiaTracker.ACTIONS.CLICK, label);
			});
	
			// attach handlers - play button (open video preview)
			this.cachedSelectors.carousel.on('click', 'li a.video', function(event){
				event.preventDefault();
				var videoTitle = $(".Wikia-video-thumb", this).attr("data-video");
				that.fetchVideoPlayer(videoTitle);
	
				// remove in-preview class from previously check item if exists
				that.removeInPreview();
	
				// cache current in preview element in carousel
				that.cachedSelectors.inPreview = $(this).parents('li').addClass('in-preview');
			});
	
			// attach handlers - close preview
			this.cachedSelectors.previewWrapper.on('click', '#VET-preview-close', function(event) {
				event.preventDefault();
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
	            that.addSuggestions({items: that.suggestionsCachedStuff.cashedSuggestions});
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
	
					// tracking
					var label = that.searchCachedStuff.searchType === 'local' ? 'find-local' : 'find-wikia-library';
					that.track(window.WikiaTracker.ACTIONS.CLICK, label);
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
				VET_doEditVideo();
			});
	
	
			// create dropdown for search filters
			this.cachedSelectors.searchDropDown.wikiaDropdown({
				onChange: function(e, $target) {
					var currSort = this.$selectedItemsList.text(),
						newSort = $target.text();
	
					if(currSort != newSort) {
						var sort = $target.data('sort');
						that.searchCachedStuff.searchType = sort;
						that.searchCachedStuff.currentKeywords = '';
						that.cachedSelectors.closePreviewBtn.click();
						$('#VET-search-submit').click();
					}
				}
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
				template = '{{#items}}<li><figure>{{{thumbnail}}}<figcaption><strong>{{trimTitle}}</strong></figcaption></figure><a href="{{url}}" title="{{title}}">Add video</a></li>{{/items}}';
	
			html = $.mustache(template, data);
			this.cachedSelectors.carousel.find('ul').append(html);
	
		},
	
		// METHOD: create carousel instance
		createCarousel: function() {
	
			var that = this,
				itemsShown = 5; // items displayed per carousel slide
	
			// show carousel if suggestions returned
			this.cachedSelectors.carouselWrapper.addClass('show');
	
			// create carousel instance
			this.carouselInstance = this.cachedSelectors.carousel.carousel({
				transitionSpeed: 500,
				itemsShown: itemsShown,
				nextClass: "scrollright",
				prevClass: "scrollleft",
				trackProgress: function(indexStart, indexEnd, totalItems) {
					if (itemsShown * 2 > totalItems - indexEnd) {
						// depends on fetch mode send request to different controller
						if (!that.searchCachedStuff.inSearchMode) {
							that.fetchSuggestions();
						} else {
							that.fetchSearch();
						}
					}
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
				videoWrapper = this.cachedSelectors.videoWrapper;
			if ( data.playerAsset && data.playerAsset.length > 0 ) { // screenplay special case
				$.getScript(data.playerAsset, function() {
					videoWrapper.html( '<div id="'+data.videoEmbedCode.id+'" class="Wikia-video-enabledEmbedCode"></div>');
					$('body').append('<script>' + data.videoEmbedCode.script + ' loadJWPlayer(); </script>');
				});
			} else {
				videoWrapper.html('<div class="Wikia-video-enabledEmbedCode">'+data.videoEmbedCode+'</div>');
			}
	
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
					window.WikiaTracker.trackEvent('trackingevent', {
						ga_category: 'Lightbox',	// yeah, Lightbox so we can roll up all the data
						ga_action: window.WikiaTracker.ACTIONS.VIEW,
						ga_label: 'video-inline',
						title: title,
						provider: data.providerName,
						clickSource: (that.carouselMode === 'suggestion' ? 'VET-Suggestion' : 'VET-Search')
					}, 'internal');
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
	
							that.trimTitles(data);
							that.addSuggestions(data);
	
							// update results counter
							that.suggestionsCachedStuff.fetchedResoultsCount = data.nextStartFrom;
	
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
			var toggleTo = true;
			if($(e.target).is('#VideoEmbedLayoutGallery')) {
				toggleTo = false;
			}
			VET_toggleSizing(toggleTo);
		})
		.on('change.VET, keyup.VET', '#VideoEmbedManualWidth', VET_manualWidthInput)
		.on('keypress.VET', '#VideoEmbedUrl', VET_onVideoEmbedUrlKeypress)
		.on('click.VET', '#VideoEmbedUrlSubmit', VET_preQuery)
		.on('click.VET', '#VideoEmbedRenameButton, #VideoEmbedExistingButton, #VideoEmbedOverwriteButton', VET_insertFinalVideo)
		.on('click.VET', '.vet-close', function(e) {
			e.preventDefault();
			VET_close();
		});
	
	
	// globally available functions
	window.VET_show = VET_show;
	window.VET_close = VET_close;
	window.VETExtended = VETExtended;
})(jQuery, window);
