/**
 * @description This is a replacement 'router' or 'controller' file used to instantiate Backbone views.
 * Since we aren't using Backbone's router ATM due to time limitations and this just being an exploratory
 * exercise, we'll just inspect window.location to decide which modules to instantiate.
 * Note that the default section is featured videos.
 */
require([
	'wikia.querystring',
	'videopageadmin.views.featured',
	'videopageadmin.views.category'
], function (QueryString, FeaturedView, CategoryView) {
	'use strict';

	var qs = new QueryString(),
		section = qs.getVal('section'),
		view;

	$(function () {
		if (section === 'category') {
			view = new CategoryView({
				el: '#LatestVideos'
			});
		} else {
			// default is featured video form
			view = new FeaturedView({
				el: '.vpt-form'
			});
		}
	});
});
