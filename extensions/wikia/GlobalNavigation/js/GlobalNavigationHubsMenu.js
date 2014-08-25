(function(){
	'use strict';
	var $hubLinks, $verticals;

	$hubLinks = $('#hubs > .hub-links');
	$verticals = $('#hubs > .hubs');

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

	function activateSubmenu (row) {
		var subMenuSelector, vertical;

		vertical = $(row).addClass('active').data('vertical');
		subMenuSelector = '.' + vertical + '-links';


		// TODO:
		// this (lazyLoad) should finally go to the hamburger button click event
		if (window.lazyLoad === undefined) {
			throw("There isn't lazyLoad object loaded!");
		}

		if (!lazyLoad.isMenuWorking()) {
			$('.active', $verticals).not($(row)).removeClass('active');
			lazyLoad.getMenuItems(subMenuSelector);
		}
		else {
			$(subMenuSelector, $hubLinks).addClass('active');
		}
	}

	function deactivateSubmenu (row) {
		$('> section', $hubLinks).add(row).removeClass('active');
	}

})();
