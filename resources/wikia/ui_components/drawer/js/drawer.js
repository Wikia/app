define('wikia.ui.drawer', function drawer(){
	'use strict';

	function Drawer(side) {
		var that = this;
		this.element = $('#drawer-' + side);
		this.drawerBackground = getDrawerBackground();

		function getDrawerBackground() {
			var drawerBackground = $('#drawerBackground_' + side);
			drawerBackground.click($.proxy(function() {
				if (this.isOpen()) {
					this.close();
				}
			}, that));
			return drawerBackground;
		}
	}

	Drawer.prototype.open = function() {
		this.element.addClass('open');
		this.drawerBackground.addClass('visible');
	};
	Drawer.prototype.close = function() {
		this.element.removeClass('open');
		this.drawerBackground.removeClass('visible');
	};
	Drawer.prototype.isOpen = function() {
		return this.element.hasClass('open');
	};

	//Public API
	return {
		init: function(side) {
			return new Drawer(side);
		}
	}
});
