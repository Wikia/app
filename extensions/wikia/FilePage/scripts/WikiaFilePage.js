require(['wikia.videoBootstrap', 'jquery', 'wikia.window', 'wikia.geo'], function (VideoBootstrap, jquery, window, geo) {

	'use strict';

	/*
	 * Use VideoBootstrap to create a video instance
	 */
	function initVideo() {
		if (window.playerParams) {
			var filePageVideoWidth = 670,
				element = $('#file'),
				clickSource = 'filePage',
				videoInstance = new VideoBootstrap(element[0], window.playerParams, clickSource);

			$(window).on('lightboxOpened', function () {
				videoInstance.reload(window.wgTitle, filePageVideoWidth, false, clickSource);
			});
		}
	}

	function initRestrictions() {
		var $viewableRestrictions = $('#restricted-content-viewable'),
			data,
			userRegion,
			$restrictMessage;

		if ($viewableRestrictions.length) {
			data = JSON.parse($viewableRestrictions.attr('data-regional-restrictions'));
			userRegion = geo.getCountryCode().toLowerCase();

			if (data.indexOf(userRegion) !== -1) {
				$restrictMessage = $viewableRestrictions;
			} else {
				$restrictMessage = $('#restricted-content-unviewable');
			}
			$restrictMessage.removeClass('hidden');
		}
	}

	$(initVideo);
	$(initRestrictions);

});
