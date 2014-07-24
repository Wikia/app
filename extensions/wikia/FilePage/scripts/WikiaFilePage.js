require(['wikia.videoBootstrap', 'jquery', 'wikia.window', 'wikia.geo'], function (VideoBootstrap, jquery, window) {

	'use strict';

	/*
	 * Use VideoBootstrap to create a video instance
	 */
	function initVideo() {
		if(window.playerParams) {
			var filePageVideoWidth = 670,
				element = $('#file'),
				clickSource = 'filePage',
				videoInstance = new VideoBootstrap(element[0], window.playerParams, clickSource);

			$(window).on('lightboxOpened', function() {
				videoInstance.reload(window.wgTitle, filePageVideoWidth, false, clickSource);
			});
		}
	}

	function initRestrictions() {
		var viewableRestrictions = $('#restricted-content-viewable');
		if (viewableRestrictions) {
		    var data = eval(viewableRestrictions.attr('data-regional-restrictions'));
			var userRegion = Wikia.geo.getCountryCode().toLowerCase();

			var restrictMessage;
			if (data.indexOf(userRegion) != -1) {
				restrictMessage = viewableRestrictions;
			} else {
				restrictMessage = $('#restricted-content-unviewable');
			}
			restrictMessage.show();
		}
	}

	$(initVideo);
	$(initRestrictions());

});