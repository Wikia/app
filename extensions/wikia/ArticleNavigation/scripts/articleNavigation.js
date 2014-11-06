/* global require */
require([
	'wikia.document', 'wikia.stickyElement', 'venus.variables', 'wikia.dropdownNavigation',
	'wikia.nirvana', 'jquery', 'wikia.articleNavigationHelper'
], function(doc, stickyElement, v, DropdownNavigation, nirvana, $, helper) {
	'use strict';

	var navigationElement = doc.getElementsByClassName('article-navigation')[0],
		boundBoxElement = doc.getElementById('mw-content-text'),
		globalNavigationHeight = doc.getElementsByClassName('global-navigation')[0].offsetHeight,
		additionalTopOffset = 100,
		userToolsPromise;

	stickyElement.spawn().init(navigationElement, boundBoxElement, globalNavigationHeight + additionalTopOffset,
		v.breakpointSmallMin);

	//User tools handling
	userToolsPromise = nirvana.sendRequest({
		controller: 'ArticleNavigation',
		method: 'getUserTools',
		format: 'json',
		type: 'GET'
	});

	$.when(userToolsPromise).done(function(toolbarData) {
		var toolbarItems = toolbarData.data,
			filteredItems = helper.extractToolbarItems(toolbarItems);

		DropdownNavigation({
			data: filteredItems,
			trigger: 'articleNavSettings'
		});
	});
});
