define('videosmodule.models.videos', [
	'wikia.nirvana',
	'wikia.geo',
	'bucky'
], function (nirvana, geo, bucky) {
	'use strict';

	bucky = bucky('videosmodule.models.videos');

	var VideosData = function () {
		this.data = null;
	};

	VideosData.prototype.fetch = function () {
		var ret,
			self = this;

		if (this.data !== null) {
			ret = this.data;
		} else {
			bucky.timer.start('fetch');
			ret = nirvana.getJson('VideosModuleController', 'index', {
				userRegion: geo.getCountryCode()
			}).done(function (data) {
				self.data = data;
				bucky.timer.stop('fetch');
			});
		}

		return ret;
	};

	return VideosData;
});
