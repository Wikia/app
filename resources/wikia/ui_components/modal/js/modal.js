define( 'wikia.ui.modal', [ 'jquery' ], function( $ ) {
	'use strict';

	var BLACKOUT_CLASS = 'blackout',
		CLOSE_CLASS = 'close',
		INACTIVE_CLASS = 'inactive',
		destroyOnClose;

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

				if( this.isShown() && this.isActive() ) {
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

		destroyOnClose = this.$element.data( 'destroy-on-close' );
		destroyOnClose = ( typeof(destroyOnClose) === 'undefined' ) ? true : destroyOnClose;
	}

	Modal.prototype.show = function() {
		this.$element.addClass( 'shown' );
		this.$blackout.addClass( 'visible' );
	};

	Modal.prototype.close = function() {
		if( !destroyOnClose ) {
			this.$element.removeClass( 'shown' );
			this.$blackout.removeClass( 'visible' );
		} else {
			this.$element.remove();
			this.$blackout.remove();
		}
	};

	Modal.prototype.deactivate = function() {
		var inactiveLayer = document.createElement('div'),
			dialog = this.$element;

		$( inactiveLayer ).addClass( INACTIVE_CLASS );
		dialog.append( inactiveLayer )
			.addClass( INACTIVE_CLASS )
			.find( 'button' ).attr( 'disabled', true );
	};

	Modal.prototype.activate = function() {
		var dialog = this.$element;

		dialog.find( INACTIVE_CLASS ).remove();
		dialog.removeClass( INACTIVE_CLASS )
			.find( 'button' ).attr( 'disabled', false );
	};

	Modal.prototype.isShown = function() {
		return this.$element.hasClass( 'shown' );
	};

	Modal.prototype.isActive = function() {
		return !this.$element.hasClass( INACTIVE_CLASS );
	};

	/** Public API */
	return {
		init: function( id, modalMarkup ) {
			return new Modal( id, modalMarkup );
		}
	};
});
