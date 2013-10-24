define( 'wikia.ui.modal', [ 'jquery' ], function( $ ) {
	'use strict';

	var BLACKOUT_CLASS = 'blackout',
		CLOSE_CLASS = 'close',
		$html = $('html'),
		destroyOnClose = true;

	function Modal( id, modalMarkup ) {
		var that = this;

		this.$element = $( '#' + id );
		if( !this.$element.exists() && typeof( modalMarkup ) !== 'undefined' ) {
			$( 'body' ).append( modalMarkup );
			this.$element = $( '#' + id );
		}

		function getBlackout() {
			var blackoutId = BLACKOUT_CLASS + '_' + id,
				$blackout = $('#' + blackoutId );

			$blackout.click( $.proxy(function( event ) {
				event.preventDefault();

				if( this.isShown() ) {
					this.close();
				}
			}, that) );

			return $blackout;
		}

		this.$blackout = getBlackout();
		this.$close = this.$element.find( '.' + CLOSE_CLASS );

		this.$close.click( $.proxy( function( event ) {
			event.preventDefault();
			this.close();
		}, that ) );

		destroyOnClose = this.$element.data( 'destroy-on-close' ) || true;
	}

	Modal.prototype.show = function() {
		$html.addClass( 'modal-shown' );
		this.$element.addClass( 'shown' );
		this.$blackout.addClass( 'visible' );
	};

	Modal.prototype.close = function() {
		if( destroyOnClose ) {
			this.$element.removeClass( 'shown' );
			this.$blackout.removeClass( 'visible' );
		}

		this.$element.remove();
		this.$blackout.remove();

		$html.removeClass( 'modal-shown' );
	};

	Modal.prototype.isShown = function() {
		return this.$element.hasClass( 'shown' );
	};

	/** Public API */
	return {
		init: function( id, modalMarkup ) {
			return new Modal( id, modalMarkup );
		}
	};
});
