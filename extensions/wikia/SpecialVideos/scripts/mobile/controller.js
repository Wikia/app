require([
	'specialVideos.mobile.collections.videos',
	'specialVideos.mobile.views.index'
], function (VideosCollection, SpecialVideosIndexView) {
	'use strict';
	return new SpecialVideosIndexView({
		collection: new VideosCollection(),
		el: '#special-videos',
		filterActiveClass: 'active'
	});
});
