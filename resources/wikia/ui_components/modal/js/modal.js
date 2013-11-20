define( 'wikia.ui.modal', [ 'jquery', 'wikia.window', 'wikia.browserDetect' ], function( $, w, browserDetect ) {
	'use strict';

	var BLACKOUT_ID = 'blackout',
		BLACKOUT_VISIBLE_CLASS = 'visible',
		CLOSE_CLASS = 'close',
		INACTIVE_CLASS = 'inactive',
		PRIMARY_BUTTON_DATA = 'primary',
		SECONDARY_BUTTON_DATA = 'secondary',
		primaryBtnConfig = {
			type: 'button',
			vars: {
				type: 'button',
				classes: [ 'normal', 'primary' ],
				data: [ { key: PRIMARY_BUTTON_DATA, value: 1 } ]
			}
		},
		secondBtnConfig = {
			type: 'button',
			vars: {
				type: 'button',
				classes: [ 'normal', 'secondary' ],
				data: [ { key: SECONDARY_BUTTON_DATA, value: 1 } ]
			}
		},
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
			winHeight = $( w ).height(),
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

	function Modal( id, uiComponent, params ) {
		var that = this,
			jQuerySelector = '#' + id;

		this.$element = $( jQuerySelector );
		if ( !this.$element.exists() && typeof( uiComponent ) !== 'undefined' ) {

			if ( typeof uiComponent === 'object' && typeof params !== 'undefined' ) {
				if ( typeof params.vars.primaryBtn === 'object' ) {
					params.vars.primaryBtn = uiComponent.getSubComponent( 'button' )
						.render( $.extend( true, primaryBtnConfig, params.vars.primaryBtn ) );
				} else {
					delete( params.vars.primaryBtn );
				}
				if ( typeof params.vars.secondBtn === 'object' ) {
					params.vars.secondBtn = uiComponent.getSubComponent( 'button' )
						.render( $.extend( true, secondBtnConfig, params.vars.secondBtn ) );
				} else {
					delete( params.vars.secondBtn );
				}
				uiComponent = uiComponent.render( params );
			}

			$( 'body' ).append( uiComponent );
			this.$element = $( jQuerySelector );
		}

		/**
		 * Wraps with jQuery blackout div, adds click event handler and returns it
		 *
		 * @returns {Object} jQuery wrapped blackout markup
		 */

		function getBlackout() {
			var blackoutId = BLACKOUT_ID + '_' + id,
				$blackout = $( '#' + blackoutId );

			$blackout.click( $.proxy(function( event ) {
				event.preventDefault();

				if ( this.isShown() && this.isActive() ) {
					this.close();
				}
			}, that ) );

			return $blackout;
		}

		this.$element.click(function( event ) {
			// when click happens inside the modal, stop the propagation so it won't be handled by the blackout
			event.stopPropagation();
		});

		this.$blackout = getBlackout();
		this.$content = this.$element.children().eq( 1 );
		this.$close = this.$element.find( '.' + CLOSE_CLASS );
		this.$primaryButton = this.$element.find( 'footer [data-' + PRIMARY_BUTTON_DATA + '=1]' );
		this.$secondaryButton = this.$element.find( 'footer [data-' + SECONDARY_BUTTON_DATA + '=1]' );

		this.$close.click( $.proxy( function( event ) {
			event.preventDefault();

			this.close();
		}, that ) );

		this.$primaryButton.click( $.proxy( function ( event ) {
			this.$element.trigger( 'onPrimaryBtnClick', [ event ] );
		}, that ) );

		this.$secondaryButton.click( $.proxy( function( event ) {
			this.$element.trigger( 'onSecondaryBtnClick', [ event ] );
		}, that ) );

		destroyOnClose = this.$element.data( 'destroy-on-close' );
		destroyOnClose = ( typeof( destroyOnClose ) === 'undefined' ) ? true : destroyOnClose;
	}

	/**
	 * Shows modal; adds shown class to modal and visible class to blackout
	 */

	Modal.prototype.show = function() {
		// fix iOS Safari position: fixed - virtual keyboard bug
		if ( browserDetect.isIPad() ) {
			$( w ).scrollTop( $ ( w ).scrollTop() );
		}

		this.$blackout.addClass( BLACKOUT_VISIBLE_CLASS );

		// IE flex-box fallback for small and medium modals
		if ( this.$element.hasClass( 'large' ) === false && browserDetect.isIE() ) {

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
			this.$blackout.removeClass( BLACKOUT_VISIBLE_CLASS );
		} else {
			this.$blackout.remove();
		}

		this.onClose();
	};

	/**
	 * Hook method
	 */

	Modal.prototype.onClose = function() {};

	/**
	 * Add onPrimaryButtonClick handler
	 * @param {function} callback
	 */
	Modal.prototype.onPrimaryBtnClick = function( callback ) {
		this.$element.on( 'onPrimaryBtnClick', callback );
	};

	/**
	 * Add onSecondaryButtonClick handler
	 * @param {function} callback
	 */
	Modal.prototype.onSecondaryBtnClick = function( callback ) {
		this.$element.on( 'onSecondaryBtnClick', callback );
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
		return this.$blackout.hasClass( BLACKOUT_VISIBLE_CLASS );
	};

	/**
	 * Returns true if modal hasn't inactive class and false otherwise
	 *
	 * @returns {boolean}
	 */

	Modal.prototype.isActive = function() {
		return !this.$element.hasClass( INACTIVE_CLASS );
	};

	/**
	 * Sets modal's content
	 * @param content HTML text
	 */
	Modal.prototype.setContent = function( content ) {
		this.$content.html( content );
	};

	/** Public API */
	
	return {
		init: function( id, uiComponent, params ) {
			return new Modal( id, uiComponent, params );
		}
	};
});
