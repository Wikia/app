( function( $ ) {
	'use strict';

	var TransparentOut = function() {
		var $domNode,
			initialize = function() {
				$domNode = $('<div class="transparent-out" />');
				$('body').append($domNode);
			};

		this.show = function() {
			if (!$domNode) {
				initialize();
			}

			$domNode.addClass('visible');
		};

		this.hide = function() {
			if ($domNode) {
				$domNode.removeClass('visible');
			}
		};

		this.bindClick = function(callback) {
			if (!$domNode) {
				initialize();
			}

			$domNode.on('click touchstart', $.proxy(function(e) {
				e.preventDefault();
				e.stopPropagation();

				callback(this);
			}, this));
		};
	};

	window.transparentOut = new TransparentOut();
} )(jQuery);
