$(function () {
	'use strict';

	require(['jquery', 'wikia.nirvana', 'wikia.querystring'], function($, nirvana, Querystring){

		var menuLoaded = false;

		function getMenuItems() {
			var lang = Querystring().getVal('uselang');

			$.when(
				nirvana.sendRequest({
					controller: 'GlobalNavigationController',
					method: 'lazyLoadHubsMenu',
					format: 'json',
					type: 'GET',
					data: {
						lang: lang
					}
				})
			).done(function(menuItems){
				var sections = '',
					item,
					submenu,
					link,
					links,
					i;

				for(i = 0; i < menuItems.length; i++) {
					submenu = menuItems[i].children;
					sections += '<section class="'+ menuItems[i].specialAttr +'-links">';
					for(item = 0; item < submenu.length; item++) {
						links = submenu[item].children;
						sections += '<h2>' + submenu[item].text + '</h2>';
						for(link = 0; link < links.length; link++) {
							sections += '<a href="'+ links[link].href +'">' + links[link].text + '</a>';
						}
					}
					sections += '</section>';
				}

				$('.hubs-menu > .hub-links').append(sections);
				menuLoaded = true;
			});
		}

		$('.wikia-logo').on('mouseenter', function(){
			if( !menuLoaded ) {
				getMenuItems();
			}
		});

		$('#hubs').on('mouseenter', 'nav', function(){
			var links = $('.hub-links'),
				active = $('> .active', links),
				vertical = $(this).attr('class');

			active.removeClass('active');
			$('.' + vertical + '-links', links).addClass('active');
		});
	});
});
