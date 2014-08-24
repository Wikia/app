$(function () {
	'use strict';

	require(['jquery', 'wikia.nirvana', 'wikia.querystring'], function($, nirvana, Querystring){

		var getMenuItems, getMenuItemsDone, getMenuItemsFail, getMenuItemsProgress, isMenuWorking, lazyLoad, menuLoading,
			menuLoaded, subMenuSelector;

		menuLoaded = false;
		menuLoading = false;

		/**
		 * What is happen when request comes back with success (Creation of submenus)
		 * @param  {object} menuItems JSON object with all submenu for Global Nav data
		 */
		getMenuItemsDone = function (menuItems) {
			var $sections, i, item, link, links, submenu,
				sections = '';

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

			$sections = $($.parseHTML(sections));
			$sections.filter(subMenuSelector).addClass('active');

			$('.hubs-menu > .hub-links').append($sections);

			menuLoading = false;
			menuLoaded = true;
		};

		/**
		 * What is happen when there is some error with request...
		 */
		getMenuItemsFail = function () {
			menuLoading = false;
			menuLoaded = false;
		};

		getMenuItems = function (selector) {
			var lang;

			if (menuLoaded || menuLoading) {
				return;
			}

			menuLoading = true;

			lang = Querystring().getVal('uselang');
			subMenuSelector = selector;

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
			).then(
				getMenuItemsDone,
				getMenuItemsFail
			);
		};

		isMenuWorking = function () {
			return (menuLoading || menuLoaded);
		};

		/**
		 * Export of the public methods.
		 * TODO: maybe it should be done by sth like 'window.globNav.lazyLoad' object
		 * (with 'globNav' defined in the main GlobalNavigation module)...
		 * @type {Object}
		 */
		window.lazyLoad = {
			'getMenuItems': getMenuItems,
			'isMenuWorking': isMenuWorking
		};
	});
});
