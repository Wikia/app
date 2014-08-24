(function(){
	var $hubLinks;

	$hubLinks = $('.hub-links');

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
			lazyLoad.getMenuItems(subMenuSelector);
		}
		else {
			$(subMenuSelector, $hubLinks).addClass('active');
		}
	}

	function deactivateSubmenu (row) {
		$('.hub-links > section').add(row).removeClass('active');
	}

})();
