define('videosmodule.models.videos', [
	'wikia.nirvana',
	'wikia.geo'
], function (nirvana, geo) {
	'use strict';

	var VideosData = function () {
		this.data = null;
	};

	VideosData.prototype.fetch = function () {
		var ret,
			self = this;

		if (this.data !== null) {
			ret = this.data;
		} else {
			ret = nirvana.getJson('VideosModuleController', 'index', {
				userRegion: geo.getCountryCode()
			}).done(function (data) {
				self.data = data;
			});
		}

		return ret;
	};

	return VideosData;
});
