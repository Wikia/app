/*!
 * VisualEditor UserInterface WindowAction class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Window action.
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.WindowAction = function VeUiWindowAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

OO.inheritClass( ve.ui.WindowAction, ve.ui.Action );

/* Static Properties */

ve.ui.WindowAction.static.name = 'window';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.WindowAction.static.methods = [ 'open', 'close', 'toggle' ];

/* Methods */

/**
 * Open a window.
 *
 * @method
 * @param {string} name Symbolic name of window to open
 * @param {Object} [data] Window opening data
 * @param {string} [action] Action to execute after opening, or immediately if the window is already open
 * @return {boolean} Action was executed
 */
ve.ui.WindowAction.prototype.open = function ( name, data, action ) {
	var currentInspector, inspectorWindowManager,
		windowType = this.getWindowType( name ),
		windowManager = windowType && this.getWindowManager( windowType ),
		currentWindow = windowManager.getCurrentWindow(),
		autoClosePromises = [],
		surface = this.surface,
		fragment = surface.getModel().getFragment( undefined, true ),
		dir = surface.getView().getDocument().getDirectionFromSelection( fragment.getSelection() ) ||
			surface.getModel().getDocument().getDir();

	if ( !windowManager ) {
		return false;
	}

	data = ve.extendObject( { dir: dir }, data, { fragment: fragment } );
	if ( windowType === 'toolbar' || windowType === 'inspector' ) {
		data = ve.extendObject( data, { surface: surface } );
		// Auto-close the current window if it is different to the one we are
		// trying to open.
		// TODO: Make auto-close a window manager setting
		if ( currentWindow && currentWindow.constructor.static.name !== name ) {
			autoClosePromises.push( windowManager.closeWindow( currentWindow ) );
		}
	}

	// If we're opening a dialog, close all inspectors first
	if ( windowType === 'dialog' ) {
		inspectorWindowManager = this.getWindowManager( 'inspector' );
		currentInspector = inspectorWindowManager.getCurrentWindow();
		if ( currentInspector ) {
			autoClosePromises.push( inspectorWindowManager.closeWindow( currentInspector ) );
		}
	}

	$.when.apply( $, autoClosePromises ).always( function () {
		windowManager.getWindow( name ).then( function ( win ) {
			var opening = windowManager.openWindow( win, data );

			surface.getView().emit( 'position' );

			if ( !win.constructor.static.activeSurface ) {
				surface.getView().deactivate();
			}

			opening.then( function ( closing ) {
				closing.then( function ( closed ) {
					if ( !win.constructor.static.activeSurface ) {
						surface.getView().activate();
					}
					closed.then( function () {
						surface.getView().emit( 'position' );
					} );
				} );
			} ).always( function () {
				if ( action ) {
					win.executeAction( action );
				}
			} );
		} );
	} );

	return true;
};

/**
 * Close a window
 *
 * @method
 * @param {string} name Symbolic name of window to open
 * @param {Object} [data] Window closing data
 * @return {boolean} Action was executed
 */
ve.ui.WindowAction.prototype.close = function ( name, data ) {
	var windowType = this.getWindowType( name ),
		windowManager = windowType && this.getWindowManager( windowType );

	if ( !windowManager ) {
		return false;
	}

	windowManager.closeWindow( name, data );
	return true;
};

/**
 * Toggle a window between open and close
 *
 * @method
 * @param {string} name Symbolic name of window to open or close
 * @param {Object} [data] Window opening or closing data
 * @return {boolean} Action was executed
 */
ve.ui.WindowAction.prototype.toggle = function ( name, data ) {
	var win,
		windowType = this.getWindowType( name ),
		windowManager = windowType && this.getWindowManager( windowType );

	if ( !windowManager ) {
		return false;
	}

	win = windowManager.getCurrentWindow();
	if ( !win || win.constructor.static.name !== name ) {
		this.open( name, data );
	} else {
		this.close( name, data );
	}
	return true;
};

/**
 * Get the specified window type
 *
 * @param {string} name Window name
 * @return {string|null} Window type: 'inspector', 'toolbar' or 'dialog'
 */
ve.ui.WindowAction.prototype.getWindowType = function ( name ) {
	var windowClass = ve.ui.windowFactory.lookup( name );
	if ( windowClass.prototype instanceof ve.ui.FragmentInspector ) {
		return 'inspector';
	} else if ( windowClass.prototype instanceof ve.ui.ToolbarDialog ) {
		return 'toolbar';
	} else if ( windowClass.prototype instanceof OO.ui.Dialog ) {
		return 'dialog';
	}
	return null;
};

/**
 * Get the window manager for a specified window type
 *
 * @param {Function} windowType Window type: 'inspector', 'toolbar', or 'dialog'
 * @return {ve.ui.WindowManager|null} Window manager
 */
ve.ui.WindowAction.prototype.getWindowManager = function ( windowType ) {
	switch ( windowType ) {
		case 'inspector':
			return this.surface.getContext().getInspectors();
		case 'toolbar':
			return this.surface.getToolbarDialogs();
		case 'dialog':
			return this.surface.getDialogs();
	}
	return null;
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.WindowAction );
