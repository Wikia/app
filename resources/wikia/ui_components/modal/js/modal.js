define( 'wikia.ui.modal', [
	'jquery',
	'wikia.window',
	'wikia.browserDetect'
], function(
	$,
	w,
	browserDetect
) {
	'use strict';

	// constants for modal component
	var BLACKOUT_ID = 'blackout',
		BLACKOUT_VISIBLE_CLASS = 'visible',
		CLOSE_CLASS = 'close',
		INACTIVE_CLASS = 'inactive',
		PRIMARY_BUTTON_DATA = 'primary',
		SECONDARY_BUTTON_DATA = 'secondary',

		// default modal rendering params
		modalDefaults = {
			type: 'default',
			vars: {
				closeText: $.msg( 'close' )
			}
		},
		// default modal buttons rendering params
		btnConfig = {
			type: 'button',
			vars: {
				type: 'button',
				classes: [ 'normal', 'secondary' ]
			}
		},
		
		// reference to UI component instance
		uiComponent;

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
	 * TODO: need description
	 * @param params
	 * @param component
	 * @returns {Modal}
	 */

	function init( params, component ) {
		uiComponent = component;

		return new Modal( params );
	}

	/**
	 * Initializes a modal
	 *
	 * TODO: update the description !!!!
	 *
	 * Checks if element with given id exists in DOM and if not creates it
	 * and appends it to body; adds event handlers for blackout and close button;
	 * sets flags depending on data- attributes:
	 *
	 * - data-destroy-on-close -- if false value passed the modal will remain in DOM after closing it
	 *
	 * @constructor
	 *
	 * @param {Object} uiComponent - UI Component configured for creating modals
	 * @param {Object} params - Mustache parameters for rendering modal
	 */

	function Modal( params ) {
		var that = this,
			id = (typeof params === 'object') ? params.vars.id : params, // modal ID
			jQuerySelector = '#' + id,
			buttons, // array of objects with params for rendering modal buttons
			blackoutId = BLACKOUT_ID + '_' + id;

		// In case the modal already exists in DOM - skip rendering part
		if ( $( jQuerySelector ).length === 0 && typeof( uiComponent ) !== 'undefined' ) {

			buttons = params.vars.buttons;

			// Create buttons
			buttons.forEach(function( button, index ) {
				if ( typeof button === 'object' ) {
					if ( typeof button.vars.classes !== 'undefined' ) {
						$.merge( button.vars.classes, btnConfig.vars.classes );
					}
					buttons[ index ] = uiComponent.getSubComponent( 'button' ).render(
						$.extend( true, {}, btnConfig, button )
					);
				}
			});

			// extend default modal params with the one passed in constructor call
			params = $.extend( true, {}, modalDefaults, params );

			// render modal markup and append to DOM
			$( 'body' ).append( uiComponent.render( params ) );

		}

		// link modal instance with DOM element
		this.$element = $( jQuerySelector );

		this.$element.click( function( event ) {
			// when click happens inside the modal, stop the propagation so it won't be handled by the blackout
			event.stopPropagation();
		} );

		this.$element.find( 'footer button' ).click( $.proxy( function( event ) {
			var modalEventName = $( event.target ).data( 'event' );
			if ( modalEventName ) {
				this.trigger( modalEventName, event );
			}
		}, that ) );

		this.$content = this.$element.children( 'section' );
		this.$close = this.$element.find( '.' + CLOSE_CLASS );
		this.$blackout = $( '#' + blackoutId );

		// clicking outside modal triggers the close action
		this.$blackout.click( $.proxy(function( event ) {
			event.preventDefault();

			if ( this.isShown() && this.isActive() ) {
				this.trigger( 'close', event );
			}
		}, that ) );

		this.$close.click( $.proxy( function( event ) {
			event.preventDefault();
			this.trigger( 'close', event );
		}, that ) );

		// allow to override the default value
		if ( ( typeof( this.$element.data( 'destroy-on-close' ) ) !== 'undefined' ) ) {
			this.destroyOnClose = this.$element.data( 'destroy-on-close' );
		}

		this.listeners = {
			'close': [ $.proxy(this.close, that) ]
		};
	}

	/**
	 * When set to true (default), destroys the modal when close action is triggered
	 * @type {boolean}
	 */
	Modal.prototype.destroyOnClose = true;

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
		if( !this.destroyOnClose ) {
			this.$blackout.removeClass( BLACKOUT_VISIBLE_CLASS );
		} else {
			this.$blackout.remove();
		}

		this.onClose();
	};

	Modal.prototype.trigger = function ( eventName ) {

		var i, args =  [].slice.call( arguments, 1 );
		if ( typeof( this.listeners[ eventName ] ) !== 'undefined' ) {
			for ( i = 0 ; i < this.listeners[ eventName ].length ; i++ ) {
				// @TODO - add support for promise
				this.listeners[ eventName ][ i ].apply(undefined, args );
			}
		}
	};

	Modal.prototype.bind = function( eventName, callback ) {
		if ( typeof( this.listeners[ eventName ] ) === 'undefined' ) {
			this.listeners[ eventName ] = [];
		}
		this.listeners[ eventName ].push( callback );
	};

	/**
	 * Hook method
	 * @TODO - do we need this?
	 */

	Modal.prototype.onClose = function() {};

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
		init: init
	};
});
