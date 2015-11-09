(function () {
	'use strict';

	var VideosCollection = require('specialVideos.mobile.collections.videos'),
		SpecialVideosIndexView = require('specialVideos.mobile.views.index');

	return new SpecialVideosIndexView({
		collection: new VideosCollection(),
		el: '#special-videos',
		filterActiveClass: 'active'
	});
})();
