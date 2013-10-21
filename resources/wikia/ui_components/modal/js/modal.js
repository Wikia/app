define( 'wikia.ui.modal', [ 'jquery' ], function( $ ) {
	"use strict";

	var BLACKOUT_CLASS = 'blackout',
		CLOSE_CLASS = 'close',
		$html = $('html');

	function Modal( id ) {
		var that = this;

		this.$element = $( '#' + id );
		this.$blackout = getBlackout();
		this.$close = this.$element.find( '.' + CLOSE_CLASS );

		this.$close.click( $.proxy( function( event ) {
			event.preventDefault();
			this.close();
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
		$html.addClass( 'modal-shown' );
		this.$element.addClass( 'shown' );
		this.$blackout.addClass( 'visible' );
	};

	Modal.prototype.hide = function() {
		this.$element.removeClass( 'shown' );
		this.$blackout.removeClass( 'visible' );
		$html.removeClass( 'modal-shown' );
	};

	Modal.prototype.isShown = function() {
		return this.$element.hasClass( 'shown' );
	};

	Modal.prototype.close = function() {
		this.onClose();
		$(this).remove();
	};

	Modal.prototype.onClose = function() {
	// "hook"
	}

	/** Public API */
	return {
		init: function( id ) {
			return new Modal( id );
		}
	}
});
