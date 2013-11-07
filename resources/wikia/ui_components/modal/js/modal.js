define( 'wikia.ui.modal', [ 'jquery', 'wikia.window' ], function( $, w ) {
	'use strict';

	var BLACKOUT_ID = 'blackout',
		CLOSE_CLASS = 'close',
		INACTIVE_CLASS = 'inactive',
		destroyOnClose;


	/**
	 * IE 9 doesn't support flex-box. IE-10 and IE-11 has some bugs in implementation:
	 *
	 * https://connect.microsoft.com/IE/feedback/details/802625/
	 * min-height-and-flexbox-flex-direction-column-dont-work-together-in-ie-10-11-preview
	 *
	 * This is a fallback for IE which based on window 'height' and sets 'max-height' modal section
	 *
	 * @param {Object} modal - Wikia modal object
	 */

	function ieFlexboxFallback( modal ) {
		var element = modal.$element,
			HEADER_AND_FOOTER_HEIGHT = 120, // modal header and footer have 60px fixed height
			winHeight = parseInt( $( w ).height(), 10 ),
			modalMaxHeight = ( 90 / 100 ) * winHeight - HEADER_AND_FOOTER_HEIGHT; // 90% viewport - (header + footer)

		element.children( 'section' ).css( 'maxHeight', modalMaxHeight );
	}

	/**
	 * Initializes a modal
	 *
	 * Checks if element with given id exists in DOM and if not creates it
	 * and appends it to body; adds event handlers for blackout and close button;
	 * sets flags depending on data- attributes:
	 * - data-destroy-on-close -- if false value passed the modal will remain in DOM after closing it
	 *
	 * @param {String} id
	 * @param {Object} modalMarkup (optional) jQuery wrapper for existing in DOM modal markup
	 * @constructor
	 */

	function Modal( id, modalMarkup ) {
		var that = this,
			jQuerySelector = '#' + id;

		this.$element = $( jQuerySelector );
		if( !this.$element.exists() && typeof( modalMarkup ) !== 'undefined' ) {
			$( 'body' ).append( modalMarkup );
			this.$element = $( jQuerySelector );
		}

		/**
		 * Wraps with jQuery blackout div, adds click event handler and returns it
		 *
		 * @returns {Object} jQuery wrapped blackout markup
		 */

		function getBlackout() {
			var blackoutId = BLACKOUT_ID + '_' + id,
				$blackout = $('#' + blackoutId );

			$blackout.click( $.proxy(function( event ) {
				event.preventDefault();

				if( this.isShown() && this.isActive() ) {
					this.close();
				}
			}, that) );

			return $blackout;
		}

		this.$element.click( function( event ) {
			// when click happens inside the modal, stop the propagation so it won't be handled by the blackout
			event.stopPropagation();
		} );

		this.$blackout = getBlackout();
		this.$close = this.$element.find( '.' + CLOSE_CLASS );

		this.$close.click( $.proxy( function( event ) {
			event.preventDefault();

			this.close();
		}, that ) );

		destroyOnClose = this.$element.data( 'destroy-on-close' );
		destroyOnClose = ( typeof(destroyOnClose) === 'undefined' ) ? true : destroyOnClose;
	}

	/**
	 * Shows modal; adds shown class to modal and visible class to blackout
	 */

	Modal.prototype.show = function() {
		this.$blackout.addClass( 'visible' );

		// IE flex-box fallback for small and medium modals
		if ( this.$element.hasClass('large') === false && ( navigator.appName === 'Microsoft Internet Explorer' ||
			( navigator.appName === 'Netscape' && navigator.userAgent.indexOf('Trident/') !== -1 ) ) ) {

			this.$blackout.addClass( 'IE-flex-fix' );
			ieFlexboxFallback( this );

			// update modal section max-height on window resize
			$( w ).on( 'resize', $.proxy( function() {
				ieFlexboxFallback( this );
			}, this ) );
		}
	};

	/**
	 * Closes the modal; removes it from dom or just removes classes - it depends on destroyOnClose flag
	 */

	Modal.prototype.close = function() {
		if( !destroyOnClose ) {
			this.$blackout.removeClass( 'visible' );
		} else {
			this.$blackout.remove();
		}
	};

	/**
	 * Disables all modal's buttons, adds inactive class to the modal
	 * and runs jQuery $.startThrobbing() method on it
	 */

	Modal.prototype.deactivate = function() {
		var dialog = this.$element;

		dialog.addClass( INACTIVE_CLASS ).find( 'button' ).attr( 'disabled', true );
		dialog.startThrobbing();
	};

	/**
	 * Runs jQuery $.stopThrobbing() on modal, removes inactive class from it and
	 * sets disabled attribute for all modal's buttons to false
	 */

	Modal.prototype.activate = function() {
		var dialog = this.$element;

		dialog.stopThrobbing();
		dialog.removeClass( INACTIVE_CLASS )
			.find( 'button' ).attr( 'disabled', false );
	};

	/**
	 * Returns true if modal has shown class and false otherwise
	 *
	 * @returns {Boolean}
	 */

	Modal.prototype.isShown = function() {
		return this.$blackout.hasClass( 'visible' );
	};

	/**
	 * Returns true if modal hasn't inactive class and false otherwise
	 *
	 * @returns {boolean}
	 */

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
