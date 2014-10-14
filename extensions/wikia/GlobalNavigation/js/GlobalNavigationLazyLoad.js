define(
	'wikia.globalnavigation.lazyload',
	['jquery', 'wikia.nirvana', 'wikia.querystring'],
	function lazyLoad( $, nirvana, Querystring ) {
		'use strict';

		var menuLoading = false,
			menuLoaded = false,
			getHubLinks,
			getMenuItemsDone,
			errorHandler,
			isMenuWorking,
			subMenuSelector;

		/**
		 * @desc callback to handle request that come back with success (Creation of submenus)
		 * @param {Object} menuItems JSON object with all submenu for Global Nav data
		 */
		getMenuItemsDone = function( menuItems ) {
			var $sections = $( $.parseHTML( menuItems ) ).removeClass( 'active' ),
				$hubs = $( '#hubs' ),
				$verticals = $( '> .hub-list', $hubs ),
				$hubLinks = $( '> .hub-links', $hubs );

			$( '> .active', $hubLinks ).removeClass( 'active' );

			subMenuSelector = '.' + $( '.active', $verticals ).data( 'vertical' ) + '-links';

			$hubLinks.append( $sections );
			$hubLinks.find( subMenuSelector ).addClass( 'active' );

			menuLoading = false;
			menuLoaded = true;
		};

		/**
		 * Callback to handle request when there is some error...
		 */
		errorHandler = function() {
			menuLoading = false;
			menuLoaded = false;
		};

		getHubLinks = function() {
			var lang,
				data = {};

			if (menuLoaded || menuLoading) {
				return;
			}

			menuLoading = true;

			lang = new Querystring().getVal( 'uselang' );
			if ( lang ) {
				data.uselang = lang;
			}

			$.when(
				nirvana.sendRequest({
					controller: 'GlobalNavigationController',
					method: 'lazyLoadHubsMenu',
					format: 'html',
					type: 'GET',
					data: data
				})
			).then(
				getMenuItemsDone,
				errorHandler
			);
		};

		isMenuWorking = function() {
			return ( menuLoading || menuLoaded );
		};

		return {
			getHubLinks: getHubLinks,
			isMenuWorking: isMenuWorking
		};
	}
);
