$(function ($) {
	'use strict';
	var track, $globalNavigation;

	$globalNavigation = $('#globalNavigation');

	track = Wikia.Tracker.buildTrackingFunction({
		action: Wikia.Tracker.ACTIONS.CLICK,
		category: 'top-nav',
		trackingMethod: 'ga'
	});

	function clickTrackingHandler(ev) {
		var element = $(ev.target);
		debugger;
		if (element.closest('.wikia-logo').length > 0) { // wikia logo
			track({
				label: 'wikia-logo'
			});
		} else if (element.closest('.hub-links').length > 0 || element.closest('.hub-list').length > 0) { // hub link
			track({
				label: 'hub-item'
			});
		} else if (element.data('id') === 'logout') {
			track({
				label: 'user-menu-logout'
			});
		} else if (element.data('id') === 'help') {
			track({
				label: 'user-menu-help'
			});
		} else if (element.hasClass('message-wall')) {
			track({
				label: 'user-menu-message-wall'
			});
		} else if (element.closest('.start-wikia').length > 0) { //start a wikia button
			track({
				label: 'start-wiki'
			});
		} else if (element.hasClass('login-button')) { // log in button
			track({
				label: 'login'
			});
		} else if (element.closest('.ajaxLogin').attr('accesskey') === '.') { //user menu profile
			track({
				label: 'user-menu-profile'
			});
		}
	}

	$globalNavigation.on('mousedown touchstart', clickTrackingHandler);
});
