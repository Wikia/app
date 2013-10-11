define( 'wikia.ui.modal', [ 'jquery' ], function( $ ) {
	"use strict";

	var BLACKOUT_CLASS = 'blackout',
		CLOSE_CLASS = 'close',
		$body = $('body');

	function Modal( id ) {
		var that = this;

		this.$element = $( '#' + id );
		this.$blackout = getBlackout();
		this.$close = this.$element.find( '.' + CLOSE_CLASS );

		this.$close.click( $.proxy( function( event ) {
			event.preventDefault();
			this.hide();
		}, that ) );

		function getBlackout() {
			var blackoutId = BLACKOUT_CLASS + '_' + id,
				$blackout = $('#' + blackoutId );

			$blackout.click( $.proxy(function( event ) {
				event.preventDefault();

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
		init: function( id ) {
			return new Modal( id );
		}
	}
});
