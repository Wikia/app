define(
	'wikia.globalnavigation.lazyload', ['jquery', 'wikia.nirvana', 'wikia.window'],
	function lazyLoad($, nirvana, win) {
		'use strict';

		var menuLoading = false,
			menuLoaded = false;

		/**
		 * @desc callback to handle request that come back with success (Creation of submenus)
		 * @param {Object} menuItems JSON object with all submenu for Global Nav data
		 */
		function getMenuItemsDone(menuItems) {
			var $sections = $($.parseHTML(menuItems)).removeClass('active'),
				$hubs = $('#hubs'),
				$verticals = $hubs.children('.hub-list'),
				$hubLinks = $hubs.children('.hub-links'),
				subMenuSelector = '.' + $('.active', $verticals).data('vertical') + '-links';

			$('> .active', $hubLinks).removeClass('active');

			$hubLinks.append($sections);
			$hubLinks.find(subMenuSelector).addClass('active');

			menuLoading = false;
			menuLoaded = true;
		}

		/**
		 * @desc Callback to handle request when there is some error...
		 */
		function errorHandler() {
			menuLoading = false;
			menuLoaded = false;
		}

		/**
		 * @desc checks if menu is loaded or is being loaded
		 * @returns {Boolean}
		 */
		function isMenuWorking() {
			return (menuLoading || menuLoaded);
		}

		/**
		 * @desc loads hub menu sections
		 */
		function getHubLinks() {
			var data = {
					cb: win.wgStyleVersion,
					uselang: win.wgUserLanguage
				};

			if (isMenuWorking()) {
				return;
			}

			menuLoading = true;

			nirvana.sendRequest({
				controller: 'GlobalNavigationController',
				method: 'lazyLoadHubsMenu',
				format: 'html',
				type: 'GET',
				data: data
			}).then(
				getMenuItemsDone,
				errorHandler
			);
		}

		return {
			getHubLinks: getHubLinks,
			isMenuWorking: isMenuWorking
		};
	}
);
