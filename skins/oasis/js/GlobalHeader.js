$(function () {
	'use strict';

	var GLOBAL_NAV_SAMPLING_RATIO = 100, // integer (0-100): 0 - no tracking, 100 - track everything */
		track = Wikia.Tracker.buildTrackingFunction({
			category: 'global-navigation',
			trackingMethod: 'ga'
		});

	function clickTrackingHandler(ev) {
		var element = $(ev.target);
		if (element.hasClass('sprite')) { // wikia logo
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE,
				label: 'wikia-logo'
			});
		} else if (element.hasClass('wikia-button')) { //start a wiki button
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON,
				label: 'start-wiki'
			});
		} else if (element.hasClass('ajaxRegister')) { // sign up link
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
				label: 'signup'
			});
		} else if (element.hasClass('login-button')) { // log in button
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON,
				label: 'login'
			});
		} else if (element.parents('.topNav').exists()) { // hub link
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
				label: 'hub-name-link'
			});
		} else if (element.parents('.catnav, .subnav').exists()) { // link in hub menu
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
				label: 'hub-submenu-link'
			});
		}
	}

	function hoverMenuTrackingHandler(ev) {
		var element = $(ev.target);

		if (element.parents('.GlobalNavigation').exists()) { // hubs menu
			track({
				action: Wikia.Tracker.ACTIONS.HOVER,
				label: 'hubs-menu-open'
			});
		} else if (element.parents('.AccountNavigation').exists()) { // user menu
			track({
				action: Wikia.Tracker.ACTIONS.HOVER,
				label: 'user-menu-open'
			});
		} else if (element.parents('.WallNotifications').exists()) { // notifications
			track({
				action: Wikia.Tracker.ACTIONS.HOVER,
				label: 'notifications-menu-open'
			});
		}
	}

	function isSampledPV() {
		return GLOBAL_NAV_SAMPLING_RATIO >= Math.floor((Math.random() * 100 + 1));
	}

	function isTrackedGroup() {
		var group = window.Wikia.AbTest ? Wikia.AbTest.getGroup( 'DAR_GLOBALNAVIGATIONFIXED' ) : undefined ;
		return group !== undefined;
	}

	if (isTrackedGroup() && isSampledPV()) {
		Wikia.log( 'Global nav tracking enabled', 'info', 'GlobalNav' );
		$('#WikiaHeader').on('click', clickTrackingHandler);
		$('#WikiaHeader').on('hovermenu-shown', hoverMenuTrackingHandler);
	} else {
		Wikia.log( 'Global nav tracking disabled', 'info', 'GlobalNav' );
	}
});
