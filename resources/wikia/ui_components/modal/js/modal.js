define( 'wikia.ui.modal', [ 'jquery' ], function( $ ) {
	"use strict";

	var BLACKOUT_ID = 'blackout',
		$body = $('body');

	function Modal() {
		var that = this;

		this.$element = $( '#' + id );
		this.$blackout = getBlackout();

		function getBlackout() {
			var $blackout = $('#blackout');

			if( !$blackout.exists() ) {
				$blackout = $('<div id="' + BLACKOUT_ID + '" />');
				$body.append( $blackout );
			}

			$blackout.click( $.proxy(function() {
				if( this.isShown() ) {
					this.hide();
				}
			}, that) );

			return $blackout;
		}
	}

	Modal.prototype.show = function() {
		this.$element.addClass( 'shown' );
		this.$blackout.addClass( 'visible' );
	};

	Modal.prototype.hide = function() {
		this.$element.removeClass( 'shown' );
		this.$blackout.removeClass( 'visible' );
	};

	Modal.prototype.isShown = function() {
		return this.$element.hasClass( 'shown' );
	};

	Modal.prototype.close = function() {
		$(this).remove();
	};

	/** Public API */
	return {
		init: function() {
			return new Modal();
		}
	}
});
