define('wikia.articleVideo.featuredVideo.autoplay', [
	'wikia.articleVideo.featuredVideo.cookies',
	require.optional('ext.wikia.adEngine3.api')
], function (featuredVideoCookieService, adsApi) {
	'use strict';

	function isDisabledByAdEngine() {
		return adsApi && adsApi.isAutoPlayDisabled();
	}

	return {
		isAutoplayEnabled: function () {
			return featuredVideoCookieService.getAutoplay() !== '0' &&
				!isDisabledByAdEngine();
		},
		inNextVideoAutoplayEnabled: function () {
			return true;
		},
		isAutoplayToggleShown: function () {
			return !isDisabledByAdEngine()
			;
		}
	};
});
