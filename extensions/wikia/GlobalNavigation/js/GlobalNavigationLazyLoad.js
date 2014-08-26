define(
	'wikia.globalnavigation.lazyload',
	['jquery', 'wikia.nirvana', 'wikia.querystring'],
	function lazyLoad($, nirvana, Querystring) {
		'use strict';

		var getHubLinks, getMenuItemsDone, errorHandler, isMenuWorking, menuLoading,
			menuLoaded, subMenuSelector;

		menuLoaded = false;
		menuLoading = false;

		/**
		 * Callback to handle request that come back with success (Creation of submenus)
		 * @param  {object} menuItems JSON object with all submenu for Global Nav data
		 */
		getMenuItemsDone = function (menuItems) {
			var $sections, $subMenu,
				$hubs = $('#hubs'),
				$verticals = $('> .hubs', $hubs),
				$hubLinks = $('> .hub-links', $hubs);

			$sections = $($.parseHTML(menuItems)).removeClass('active');
			$subMenu = $sections.filter(subMenuSelector);
			$('> .active', $hubLinks).removeClass('active');

			if($subMenu.length) {
				$subMenu.addClass('active');
			} else {
				subMenuSelector = '.' + $('> .active', $verticals).data('vertical') + '-links';
				$sections.filter(subMenuSelector).addClass('active');
			}


			$hubLinks.append($sections);

			menuLoading = false;
			menuLoaded = true;
		};

		/**
		 * Callback to handle request when there is some error...
		 */
		errorHandler = function () {
			menuLoading = false;
			menuLoaded = false;
		};

		getHubLinks = function (selector) {
			var lang;

			if (menuLoaded || menuLoading) {
				return;
			}

			menuLoading = true;

			lang = new Querystring().getVal('uselang');
			subMenuSelector = selector;

			$.when(
				nirvana.sendRequest({
					controller: 'GlobalNavigationController',
					method: 'lazyLoadHubsMenu',
					format: 'html',
					type: 'GET',
					data: {
						lang: lang
					}
				})
			).then(
				getMenuItemsDone,
				errorHandler
			);
		};

		isMenuWorking = function () {
			return (menuLoading || menuLoaded);
		};

		return {
			getHubLinks: getHubLinks,
			isMenuWorking: isMenuWorking
		};
	}
);
