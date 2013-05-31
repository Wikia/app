/* VET_loader
 *
 * @author Hyun Lim, Liz Lee
 *
 * Final callback should include VET_loader.modal.closeModal() in success case.
 * Sample input json for options:
 *	{
 *		callbackAfterSelect: function() {}, // callback after video is selected (first screen).  If it returns false, second screen will not show.
 *		callbackAfterEmbed: function() {}, // callback after video formating (second screen).
 *		embedPresets: {
 *			align: "right"
 *			caption: ""
 *			thumb: true
 *			width: 335
 *		},
 *		insertFinalVideoParams: [], // tell the back end anything extra when inserting the video at the end
 *		startPoint: 1 | 2, // display first or second screen when VET opens
 *		searchOrder: "newest" // Used in MarketingToolbox
 *	}
 */

(function(window, $) {

	if( window.VET_loader ) {
		return;
	}

	var resourcesLoaded = false,
		modalOnScreen = false,
		templateHtml = '',
		VET_loader = {};

	VET_loader.load = function(options) {
		if (wgUserName == null && wgAction == 'edit') {
			// handle login on edit page
			UserLogin.rteForceLogin();
			$.stopThrobbing();
			return;
		} else if (wgUserName == null) {
			UserLoginModal.show({
				callback: function() {
					UserLogin.forceLoggedIn = true;
					window.VET_loader.load(options);
				}
			});
			$.stopThrobbing();
			// handle login on article page
			return;
		}

		// if modal is already on screen or is about to be, don't do anything
		if(modalOnScreen) {
			$.stopThrobbing();
			return;
		}

		modalOnScreen = true;	// modal is now loading

		var deferredList = [];

		if(!resourcesLoaded) {
			var templateDeferred = $.Deferred(),
				deferredMessages = $.Deferred();

			// Get modal template HTML
			$.nirvana.sendRequest({
				controller: 'VideoEmbedToolController',
				method: 'modal',
				type: 'get',
				format: 'html',
				callback: function(html) {
					templateHtml = html;
					templateDeferred.resolve();
				}
			});
			deferredList.push(templateDeferred);

			// Get JS and CSS
			var resourcePromise = $.getResources([
				$.getAssetManagerGroupUrl('VET_js'),
				$.getSassCommonURL('/extensions/wikia/VideoEmbedTool/css/VET.scss'),
				$.getSassCommonURL('/extensions/wikia/WikiaStyleGuide/css/Dropdown.scss')
			]);
			deferredList.push(resourcePromise);
		}

		$.when.apply(this, deferredList).done(function() {
			$.stopThrobbing();

			VET_loader.modal = $(templateHtml).makeModal({
				width: 939,
				onClose: function() {
					window.VET.close();
				},
				onAfterClose: function() {
					modalOnScreen = false;	// release modal lock
				}
			});

			window.VET.show(options);
			resourcesLoaded = true;

		});
	};

	/* Extends jQuery to make any element an add video button
	 *
	 * @param object options - options to be passed to VET_loader.load(). See above for example.
	 */
	$.fn.addVideoButton = function(options) {
		$.preloadThrobber();

		return this.each(function() {
			var $this = $(this);

			$this.on('click.VETLoader', function(e) {
				e.preventDefault();

				// Provide immediate feedback once button is clicked
				$this.startThrobbing();

				VET_loader.load(options);
			});
		});

	};

	$.fn.removeAddVideoButton = function() {
		return this.each(function() {
			$(this).off('click.VETLoader');
		});
	}

	window.VET_loader = VET_loader;

})(window, jQuery);