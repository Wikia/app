define('wikia.uifactory.drawer', function drawer(){
	'use strict';

	var drawer = function(side) {
		var getDrawerBackground = function() {
			var drawerBackground = $('#drawerBackground');
			if (!drawerBackground.exists()) {
				drawerBackground = $('<div id="drawerBackground" class="drawerBackground" />');
				$('body').append(drawerBackground);
			}
			drawerBackground.click($.proxy(function() {
				if (that.isOpen()) {
					that.close();
				}
			}, that));
			return drawerBackground;
		};

		this.open = function() {
			this.element.addClass('open');
			this.drawerBackground.addClass('visible');
		}
		this.close = function() {
			this.element.removeClass('open');
			this.drawerBackground.removeClass('visible');
		}

		this.isOpen = function() {
			return this.element.hasClass('open');
		}

		var that = this;
		this.element = $('#drawer-' + side);
		this.drawerBackground = getDrawerBackground();
	};

	function init(side) {
		return new drawer(side);
	}

	//Public API
	return {
		init: init
	}
});
