/*!
 * VisualEditor UserInterface MobileWindowManager class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Window manager for mobile windows.
 *
 * @class
 * @extends ve.ui.SurfaceWindowManager
 *
 * @constructor
 * @param {ve.ui.Surface} surface Surface this belongs to
 * @param {Object} [config] Configuration options
 * @cfg {ve.ui.Overlay} [overlay] Overlay to use for menus
 */
ve.ui.MobileWindowManager = function VeUiMobileWindowManager( surface, config ) {
	// Parent constructor
	ve.ui.MobileWindowManager.super.call( this, surface, config );

	// Events
	this.connect( this, { opening: 'onMobileOpening' } );

	// Initialization
	this.$element.addClass( 've-ui-mobileWindowManager' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MobileWindowManager, ve.ui.SurfaceWindowManager );

/* Static Properties */

ve.ui.MobileWindowManager.static.sizes = {
	full: {
		width: '100%',
		height: '100%'
	}
};
ve.ui.MobileWindowManager.static.defaultSize = 'full';

/* Methods */

/**
 * Handle window opening events
 */
ve.ui.MobileWindowManager.prototype.onMobileOpening = function ( win, opening ) {
	// HACK: un-frame buttons and convert 'back' buttons to icon only
	opening.done( function () {
		var i, l, list, action;
		if ( win instanceof OO.ui.ProcessDialog ) {
			list = win.actions.list;
			for ( i = 0, l = list.length; i < l; i++ ) {
				action = list[ i ];
				action.toggleFramed( false );
				if ( action.hasFlag( 'back' ) ) {
					action
						.setIcon( 'previous' )
						.setLabel( '' );
				}
			}
			win.fitLabel();
		}
	} );
};
