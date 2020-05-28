define('wikia.articleVideo.featuredVideo.autoplay', [
	'wikia.articleVideo.featuredVideo.cookies',
], function (featuredVideoCookieService) {
	'use strict';

	return {
		isAutoplayEnabled: function (adEngineAutoplayDisabled) {
			return featuredVideoCookieService.getAutoplay() !== '0' &&
				!adEngineAutoplayDisabled;
		},
		inNextVideoAutoplayEnabled: function () {
			return true;
		},
		isAutoplayToggleShown: function (adEngineAutoplayDisabled) {
			return !adEngineAutoplayDisabled;
		}
	};
});
