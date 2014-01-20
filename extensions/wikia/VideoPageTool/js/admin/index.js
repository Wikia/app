/**
 * @description This is a replacement 'router' or 'controller' file used to instantiate Backbone views.
 * Since we aren't using Backbone's router ATM due to time limitations and this just being an exploratory
 * exercise, we'll just inspect window.location to decide which modules to instantiate. Unfortunately,
 * this also reveals an inconsistency in our non-standard query string params. IE: all VideoPageAdmin
 * pages do not have a 'section' key in their query string, so the logic below looks inconsistent.
 */
require( [
	'wikia.querystring',
	'videopageadmin.views.dashboard',
	'videopageadmin.views.edit',
	'videopageadmin.views.category'
], function( queryString, DashboardView, EditView, CategoryPageView ) {
	'use strict';
	$( function() {
		var dashboard,
				editPage,
				categoryPage,
				params;

		params = queryString().cache;

		// TODO: in the absence of a useful route, we test for empty object to start this view
		if ( _.isEmpty( params ) ) {
			dashboard = new DashboardView();
			return;
		}

		// else we load the edit view, which the category view depends on for now
		// we can't check for EditView explicitly since it lacks a 'section' in the query string params
		editPage = new EditView();

		if ( params.section && params.section === 'category' ) {
			categoryPage = new CategoryPageView( {
				el: '#LatestVideos'
			} );
		}
	} );
} );
