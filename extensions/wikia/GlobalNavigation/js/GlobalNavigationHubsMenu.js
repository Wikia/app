require(['jquery', 'wikia.globalnavigation.lazyload'], function($, GlobalNavLazyLoad){
	'use strict';
	var $hubLinks, $verticals;

	$hubLinks = $('#hubs > .hub-links');
	$verticals = $('#hubs > .hubs');

	function activateSubmenu(row) {
		var subMenuSelector, vertical;

		vertical = $(row).addClass('active').data('vertical');
		subMenuSelector = '.' + vertical + '-links';

		if (!GlobalNavLazyLoad.isMenuWorking()) {
			$('.active', $verticals).not($(row)).removeClass('active');
			GlobalNavLazyLoad.getHubLinks(subMenuSelector);
		}
		else {
			$(subMenuSelector, $hubLinks).addClass('active');
		}
	}

	function deactivateSubmenu(row) {
		$('> section', $hubLinks).add(row).removeClass('active');
	}

	/**
	 * menuAim is a method from an external module to handle dropdown menus with very good user experience
	 * @see https://github.com/Wikia/js-menu-aim
	 */
	menuAim(
		document.querySelector('.hubs'), {
			rowSelector: 'nav',
			tolerance: 85,
			activate: activateSubmenu,
			deactivate: deactivateSubmenu
		});
});
