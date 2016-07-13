/* VET Loader
 *
 * @author Hyun Lim, Liz Lee
 *
 * Final callback should include vet.close() in success case.
 * Sample input json for options:
 *	{
 *		// callback after video is selected (first screen).  If it returns false, second screen will not show.
 *		callbackAfterSelect: function() {},
 *		// callback after video formating (second screen).
 *		callbackAfterEmbed: function() {},
 *		embedPresets: {
 *			align: "right"
 *			caption: ""
 *			thumb: true
 *			width: 335
 *		},
 *		insertFinalVideoParams: [], // tell the back end anything extra when inserting the video at the end
 *		startPoint: 1 | 2, // display first or second screen when VET opens
 *		searchOrder: "newest" // Used in EditHub
 *	}
 */

(function (window, $) {
	'use strict';

	if (window.vetLoader) {
		return;
	}

	var resourcesLoaded = false,
		modalOnScreen = false,
		vetLoader = {},
		template = '';

	/**
	 * Load template, js, scss, and messages. Only called the first time VET is opened.
	 * @returns {Array}
	 */
	function loadResources() {
		var deferredList = [];

		// Get modal template HTML
		// Keep this deferred first because the output is used in the promise
		deferredList.push(
			$.nirvana.sendRequest({
				controller: 'VideoEmbedToolController',
				method: 'modal',
				type: 'get',
				format: 'html'
			})
		);

		// Get JS and CSS
		deferredList.push(
			$.getResources([
				$.getAssetManagerGroupUrl('VET_js'),
				$.getSassCommonURL('/extensions/wikia/VideoEmbedTool/css/VET.scss'),
				$.getSassCommonURL('/extensions/wikia/WikiaStyleGuide/css/Dropdown.scss')
			])
		);

		// Get messages
		deferredList.push(
			$.getMessages('VideoEmbedTool')
		);

		return deferredList;
	}

	/*
	 * @param {Object} options Control options sent to VET from extensions
	 * @param {jQuery} $elem Element that was clicked on to open the VET modal
	 */
	vetLoader.load = function (options, $elem) {
		var resourceList = [];

		$elem = $elem || $();

		if (window.wgUserName === null && !window.UserLogin.forceLoggedIn && window.wgAction === 'edit') {
			// handle login on edit page
			window.UserLogin.rteForceLogin();
			$elem.stopThrobbing();
			return;
		} else if (window.wgUserName === null && !window.UserLogin.forceLoggedIn) {
			// handle login on article page
			window.wikiaAuthModal.load({
				forceLogin: true,
				url: '/signin?redirect=' + encodeURIComponent(window.location.href),
				origin: 'vet',
				onAuthSuccess: function () {
					window.UserLogin.forceLoggedIn = true;
					vetLoader.load(options);
				}
			});
			$elem.stopThrobbing();
			return;
		}

		// if modal is already on screen or is about to be, don't do anything
		if (modalOnScreen) {
			$elem.stopThrobbing();
			return;
		}

		// modal is now loading
		modalOnScreen = true;

		if (!resourcesLoaded) {
			resourceList = loadResources();
		}

		$.when.apply($, resourceList).done(function (templateResp) {
			// If this is the first time resources are loaded, cache the template string
			if (!resourcesLoaded) {
				template = templateResp[0];
			}

			$elem.stopThrobbing();

			// now that VET is loaded, require it.
			require(['wikia.vet'], function (vet) {

				vetLoader.modal = $(template).makeModal({
					width: 939,
					onClose: function () {
						vet.close();
					},
					onAfterClose: function () {
						// release modal lock
						modalOnScreen = false;
					}
				});

				vet.show(options);

				// resources are now officially loaded
				resourcesLoaded = true;
			});
		});

	};

	/* Extends jQuery to make any element an add video button
	 *
	 * @param object options - options to be passed to vetLoader.load(). See above for example.
	 */
	$.fn.addVideoButton = function (options) {
		$.preloadThrobber();

		return this.each(function () {
			var $this = $(this);

			$this.off('click.VETLoader').on('click.VETLoader', function (e) {
				e.preventDefault();

				// Provide immediate feedback once button is clicked
				$this.startThrobbing();

				vetLoader.load(options, $this);
			});
		});
	};

	window.vetLoader = vetLoader;

})(window, jQuery);
