jQuery('.WikiNav .nav-item').on('mouseenter', function (e) {
	window.optimizely.push(['trackEvent', 'nav-item_hover']);
	window.trackClick('wiki-nav', 'nav-item_hover');
});

jQuery('.WikiaSearch').on('submit', function(){
	window.trackClick('top-nav', 'local_search_submits');
	window.optimizely.push( [ 'trackEvent', 'local_search_submits' ] );
});

jQuery('.GlobalNavigation .subnav a').on('mousedown', 'section a', function(){
	window.trackClick('top-nav', 'hubs_subitem_clicks');
	window.optimizely.push(['trackEvent', 'hubs_subitem_clicks']);
});

jQuery('.start-a-wiki a').on('mousedown', function(){
	window.trackClick('top-nav', 'cnw_click');
	window.optimizely.push(['trackEvent', 'cnw_click']);
});

jQuery('GlobalNavigation')
	.on('mouseenter', '.topNav', function() {
		window.trackClick('top-nav', 'hamburger_entry_point_clicks');
		window.optimizely.push(['trackEvent', 'hamburger_entry_point_clicks']);
	})
	.on('click', '.topNav', function() {
		window.trackClick('top-nav', 'hamburger_entry_point_clicks');
		window.optimizely.push(['trackEvent', 'hamburger_entry_point_clicks']);
	});

jQuery('.AccountNavigation')
	.on('mouseenter', 'li:first', function(){
		window.trackClick('top-nav', 'login_dropdown_opens');
		window.optimizely.push(['trackEvent', 'login_dropdown_opens']);
	})
	.on('mousedown', '.ajaxRegister', function() {
		window.trackClick('top-nav', 'signup_clicks');
		window.optimizely.push(['trackEvent', 'signup_clicks']);
	});

jQuery('.WallNotifications').on('mouseover', '.notificationsEntry', function(){
	window.trackClick('top-nav', 'notifications_menu_opens');
	window.optimizely.push(['trackEvent', 'notifications_menu_opens']);
});

jQuery('.WikiaLogo a').on('mousedown', function(){
	window.trackClick('top-nav', 'wikia_logo_clicks');
	window.optimizely.push(['trackEvent', 'wikia_logo_clicks']);
});

jQuery(function(){
	// tracking
	window['optimizely'] = window['optimizely'] || [];
	jQuery('.nav-item').on('mouseenter', function () {
		window.optimizely.push(['trackEvent', 'nav-item_hover']);
		window.trackClick('wiki-nav', 'nav-item_hover');
	});

	jQuery('#WikiHeader').on('mousedown', 'a', function(e) {

		var label,
			el = $(e.target);

		// Primary mouse button only
		if (e.which !== 1) {
			return;
		}

		if (el.closest('.wordmark').length > 0) {
			label = 'wordmark';
		} else if (el.closest('.WikiNav').length > 0) {
			var canonical = el.data('canonical');
			if (canonical !== undefined) {
				switch(canonical) {
					case 'wikiactivity':
						label = 'on-the-wiki-activity';
						break;
					case 'random':
						label = 'on-the-wiki-random';
						break;
					case 'newfiles':
						label = 'on-the-wiki-new-photos';
						break;
					case 'chat':
						label = 'on-the-wiki-chat';
						break;
					case 'forum':
						label = 'on-the-wiki-forum';
						break;
					case 'videos':
						label = 'on-the-wiki-videos';
						break;
				}
			} else if (el.parent().hasClass('nav-item')) {
				label = 'custom-level-1';
			} else if (el.hasClass('subnav-2a')) {
				label = 'custom-level-2';
			} else if (el.hasClass('subnav-3a')) {
				label = 'custom-level-3';
			}
		}

		if (label !== undefined) {
			window.optimizely.push(['trackEvent', label + '_clicks']);
		}
	});
});
