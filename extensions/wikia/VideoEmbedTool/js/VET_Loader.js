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
 *		searchOrder: "newest" // Used in MarketingToolbox
 *	}
 */

(function (window, $) {
	'use strict';

	if (window.vetLoader) {
		return;
	}

	var resourcesLoaded = false,
		modalOnScreen = false,
		templateHtml = '',
		vetLoader = {},
		UserLoginModal = window.UserLoginModal;

	function loadResources(options, $elem) {
		var resourcePromise,
			deferredList = [],
			templateDeferred = $.Deferred(),
			deferredMessages = $.Deferred();

		// Get modal template HTML
		$.nirvana.sendRequest({
			controller: 'VideoEmbedToolController',
			method: 'modal',
			type: 'get',
			format: 'html',
			callback: function (html) {
				templateHtml = html;
				templateDeferred.resolve();
			}
		});
		deferredList.push(templateDeferred);

		// Get JS and CSS
		resourcePromise = $.getResources([
			$.getAssetManagerGroupUrl('VET_js'),
			$.getSassCommonURL('/extensions/wikia/VideoEmbedTool/css/VET.scss'),
			$.getSassCommonURL('/extensions/wikia/WikiaStyleGuide/css/Dropdown.scss')
		]);
		deferredList.push(resourcePromise);

		return deferredList;
	}

	/*
	 * @param {Object} options Control options sent to VET from extensions
	 * @param {jQuery} $elem Element that was clicked on to open the VET modal
	 */
	vetLoader.load = function (options, $elem) {
		var resourceList = [];

		$elem = $elem || $();

		if (window.wgUserName === null && window.wgAction === 'edit') {
			// handle login on edit page
			window.UserLogin.rteForceLogin();
			$elem.stopThrobbing();
			return;
		} else if (window.wgUserName === null) {
			UserLoginModal.show({
				origin: 'vet',
				callback: function () {
					window.UserLogin.forceLoggedIn = true;
					vetLoader.load(options);
				}
			});
			$elem.stopThrobbing();
			// handle login on article page
			return;
		}

		// if modal is already on screen or is about to be, don't do anything
		if (modalOnScreen) {
			$elem.stopThrobbing();
			return;
		}

		modalOnScreen = true; // modal is now loading

		if (!resourcesLoaded) {
			resourceList = loadResources(options, $elem);
		}

		$.when.apply($, resourceList).done(function () {
			$elem.stopThrobbing();

			require(['wikia.vet'], function (vet) {

				vetLoader.modal = $(templateHtml).makeModal({
					width: 939,
					onClose: function () {
						vet.close();
					},
					onAfterClose: function () {
						modalOnScreen = false; // release modal lock
					}
				});

				vet.show(options);

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
