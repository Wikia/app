$(function(){
	require(['wikia.uifactory'], function(uiFactory) {
		uiFactory.init('drawer').then(function(elem){
			$('#WikiaHeader').append(elem.render({type:"default", vars: {side: 'left', content: 'test content'}}));
			require(['wikia.uifactory.drawer'], function(drawer){
				var leftDrawer = drawer.init('left'),
					browseEntry = $('#BrowseEntry');
				leftDrawer
					.getHTMLElement()
					.on('drawer-open', function(){
						browseEntry.addClass('active');
					})
					.on('drawer-close', function(){
						browseEntry.removeClass('active');
					});
				browseEntry.click(function(){
					if (leftDrawer.isOpen()) {
						$(this).removeClass('active');
						leftDrawer.close();
					} else {
						$(this).addClass('active');
						leftDrawer.open();
					}

					return false;
				});
			})
		})
	});

	var GLOBAL_NAV_SAMPLING_RATIO = 10, // integer (0-100): 0 - no tracking, 100 - track everything */
		track = Wikia.Tracker.buildTrackingFunction({
			category: 'global-navigation',
			trackingMethod: 'ga'
		});

	function clickTrackingHandler(ev) {
		var element = ev.target;
		if (element.classList.contains('sprite')) { // wikia logo
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE,
				label: 'wikia-logo'
			});
		} else if (element.classList.contains('wikia-button')) { //start a wiki button
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON,
				label: 'start-wiki'
			});
		} else if (element.classList.contains('ajaxRegister')) { // sign up link
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
				label: 'signup'
			});
		} else if (element.classList.contains('login-button')) { // log in button
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_BUTTON,
				label: 'login'
			});
		} else if (element.parentNode.classList.contains('topNav')) { // hub link
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
				label: 'hub-name-link'
			});
		} else if (element.parentNode.parentNode.classList.contains('catnav') || element.parentNode.parentNode.classList.contains('subnav')) { // link in hub menu
			track({
				action: Wikia.Tracker.ACTIONS.CLICK_LINK_TEXT,
				label: 'hub-submenu-link'
			});
		}
	}

	function hoverMenuTrackingHandler(ev) {
		var element = ev.target;
		if (element.parentNode.parentNode.id == 'GlobalNavigation') { // hubs menu
			track({
				action: Wikia.Tracker.ACTIONS.HOVER,
				label: 'hubs-menu-open'
			});
		} else if (element.parentNode.parentNode.id == 'AccountNavigation') { // user menu
			track({
				action: Wikia.Tracker.ACTIONS.HOVER,
				label: 'user-menu-open'
			});
		} else if (element.parentNode.parentNode.id == 'WallNotifications') { // notifications
			track({
				action: Wikia.Tracker.ACTIONS.HOVER,
				label: 'notifications-menu-open'
			});
		}
	}

	function isSampledPV() {
		return GLOBAL_NAV_SAMPLING_RATIO >= Math.floor((Math.random() * 100 + 1));
	};

	if (isSampledPV()) {
		Wikia.log( 'Global nav tracking enabled', 'info', 'GlobalNav' );
		document.getElementById('WikiaHeader').addEventListener('click', clickTrackingHandler, true);
		document.getElementById('WikiaHeader').addEventListener('hover-menu-shown', hoverMenuTrackingHandler, true);
	} else {
		Wikia.log( 'Global nav tracking disabled', 'info', 'GlobalNav' );
	}
});
