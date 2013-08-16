define('wikia.uifactory.drawer', function drawer(){
	//'use strict';

	var drawer = function(side) {
		this.element = $('#drawer-' + side);

		this.open = function() {
			this.element.addClass('open');
		}
		this.close = function() {
			this.element.removeClass('open');
		}
	};

	function init(side) {
		return new drawer(side);
	}

	//Public API
	return {
		init: init
	}
});