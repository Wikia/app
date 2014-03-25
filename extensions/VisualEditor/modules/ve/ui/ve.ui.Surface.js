/*!
 * VisualEditor UserInterface Surface class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * A surface is a top-level object which contains both a surface model and a surface view.
 *
 * @class
 * @extends OO.ui.Element
 *
 * @constructor
 * @param {HTMLDocument|Array|ve.dm.LinearData|ve.dm.Document} dataOrDoc Document data to edit
 * @param {Object} [config] Configuration options
 * @param {ve.init.mw.Target} [target] Target instance (optional)
 */
ve.ui.Surface = function VeUiSurface( dataOrDoc, config, target ) {
	// Parent constructor
	OO.ui.Element.call( this, config );

	// Mixin constructor
	OO.EventEmitter.call( this, config );

	// Properties
	this.$globalOverlay = this.$( '<div>' );
	this.$localOverlay = this.$( '<div>' );
	this.$localOverlayBlockers = this.$( '<div>' );
	this.$localOverlayControls = this.$( '<div>' );
	this.$localOverlayMenus = this.$( '<div>' );
	this.model = new ve.dm.Surface(
		dataOrDoc instanceof ve.dm.Document ? dataOrDoc : new ve.dm.Document( dataOrDoc )
	);
	this.view = new ve.ce.Surface( this.model, this, { '$': this.$ } );
	this.context = new ve.ui.Context( this, { '$': this.$ } );
	this.dialogs = new ve.ui.WindowSet( this, ve.ui.dialogFactory, { '$': this.$ } );
	this.commands = {};
	this.triggers = {};
	this.enabled = true;
	this.target = target || null;
	if ( this.target ) {
		this.focus = new ve.ui.WikiaFocusWidget( this );
	}

	// Initialization
	this.$element
		.addClass( 've-ui-surface' )
		.append( this.view.$element );
	this.$localOverlay
		.addClass( 've-ui-surface-overlay ve-ui-surface-overlay-local' )
		.append( this.$localOverlayBlockers )
		.append( this.$localOverlayControls )
		.append( this.$localOverlayMenus );
	this.$localOverlayMenus
		.append( this.context.$element );
	this.$globalOverlay
		.addClass( 've-ui-surface-overlay ve-ui-surface-overlay-global' )
		.append( this.dialogs.$element );

	// Make instance globally accessible for debugging
	ve.instances.push( this );
};

/* Inheritance */

OO.inheritClass( ve.ui.Surface, OO.ui.Element );

OO.mixinClass( ve.ui.Surface, OO.EventEmitter );

/* Events */

/**
 * When the surface changes its position (only if it happens
 * after initialize has already been called).
 *
 * @event position
 */

/**
 * When a command is added to the surface.
 *
 * @event addCommand
 * @param {string} name Symbolic name of command and trigger
 * @param {ve.ui.Command} command Command that's been registered
 * @param {ve.ui.Trigger} trigger Trigger to associate with command
 */

/* Methods */

/**
 * Initialize surface.
 *
 * This must be called after the surface has been attached to the DOM.
 */
ve.ui.Surface.prototype.initialize = function () {
	var $body = this.$( 'body' );

	this.view.$element.after( this.$localOverlay );
	if ( this.focus ) {
		$body.append( this.focus.$element );
	}
	$body.append( this.$globalOverlay );

	this.view.initialize();
	// By re-asserting the current selection and forcing a poll we force selection to be something
	// reasonable - otherwise in Firefox, the initial selection is (0,0), causing bug 42277
	this.model.getFragment().select();
	this.view.surfaceObserver.pollOnce();
	this.model.startHistoryTracking();
};

/**
 * Check if editing is enabled.
 *
 * @method
 * @returns {boolean} Editing is enabled
 */
ve.ui.Surface.prototype.isEnabled = function () {
	return this.enabled;
};

/**
 * Get the surface model.
 *
 * @method
 * @returns {ve.dm.Surface} Surface model
 */
ve.ui.Surface.prototype.getModel = function () {
	return this.model;
};

/**
 * Get the surface view.
 *
 * @method
 * @returns {ve.ce.Surface} Surface view
 */
ve.ui.Surface.prototype.getView = function () {
	return this.view;
};

/**
 * Get the context menu.
 *
 * @method
 * @returns {ve.ui.Context} Context user interface
 */
ve.ui.Surface.prototype.getContext = function () {
	return this.context;
};

/**
 * Get dialogs window set.
 *
 * @method
 * @returns {OO.ui.WindowSet} Dialogs window set
 */
ve.ui.Surface.prototype.getDialogs = function () {
	return this.dialogs;
};

/**
 * Get list of commands keyed by trigger string.
 *
 * @method
 * @returns {Object.<string,ve.ui.Command>} Commands
 */
ve.ui.Surface.prototype.getCommands = function () {
	return this.commands;
};

/**
 * Get list of triggers keyed by symbolic name.
 *
 * @method
 * @returns {Object.<string,ve.ui.Trigger>} Triggers
 */
ve.ui.Surface.prototype.getTriggers = function () {
	return this.triggers;
};

/**
 * Destroy the surface, releasing all memory and removing all DOM elements.
 *
 * @method
 * @returns {ve.ui.Context} Context user interface
 */
ve.ui.Surface.prototype.destroy = function () {
	ve.instances.splice( ve.instances.indexOf( this ), 1 );
	this.view.destroy();
	this.$element.remove();
	this.$globalOverlay.remove();
	this.$localOverlay.remove();
};

/**
 * Disable editing.
 *
 * @method
 */
ve.ui.Surface.prototype.disable = function () {
	this.view.disable();
	this.model.disable();
	this.enabled = false;
};

/**
 * Enable editing.
 *
 * @method
 */
ve.ui.Surface.prototype.enable = function () {
	this.enabled = true;
	this.view.enable();
	this.model.enable();
};

/**
 * Execute an action or command.
 *
 * @method
 * @param {ve.ui.Trigger|string} action Trigger or symbolic name of action
 * @param {string} [method] Action method name
 * @param {Mixed...} [args] Additional arguments for action
 * @returns {boolean} Action or command was executed
 */
ve.ui.Surface.prototype.execute = function ( action, method ) {
	var trigger, obj, ret;

	if ( !this.enabled ) {
		return;
	}

	if ( action instanceof ve.ui.Trigger ) {
		// Lookup command by trigger
		trigger = action.toString();
		if ( trigger in this.commands ) {
			// Have command call execute with action arguments
			return this.commands[trigger].execute( this );
		}
	} else if ( typeof action === 'string' && typeof method === 'string' ) {
		// Validate method
		if ( ve.ui.actionFactory.doesActionSupportMethod( action, method ) ) {
			// Create an action object and execute the method on it
			obj = ve.ui.actionFactory.create( action, this );
			ret = obj[method].apply( obj, Array.prototype.slice.call( arguments, 2 ) );
			return ret === undefined || !!ret;
		}
	}
	return false;
};

/**
 * Add all commands from initialization options.
 *
 * Commands and triggers must be registered under the same name prior to adding them to the surface.
 *
 * @method
 * @param {string[]} names List of symbolic names of commands in the command registry
 * @throws {Error} If command has not been registered
 * @throws {Error} If trigger has not been registered
 * @throws {Error} If trigger is not complete
 */
ve.ui.Surface.prototype.addCommands = function ( names ) {
	var i, len, key, command, trigger;

	for ( i = 0, len = names.length; i < len; i++ ) {
		command = ve.ui.commandRegistry.lookup( names[i] );
		if ( !command ) {
			throw new Error( 'No command registered by that name: ' + names[i] );
		}
		// Normalize trigger key
		trigger = ve.ui.triggerRegistry.lookup( names[i] );
		if ( !trigger ) {
			throw new Error( 'No trigger registered by that name: ' + names[i] );
		}
		key = trigger.toString();
		// Validate trigger
		if ( key.length === 0 ) {
			throw new Error( 'Incomplete trigger: ' + trigger );
		}
		this.commands[key] = command;
		this.triggers[names[i]] = trigger;
		this.emit( 'addCommand', names[i], command, trigger );
	}
};

/**
 * Surface 'dir' property (GUI/User-Level Direction)
 * @returns {string} 'ltr' or 'rtl'
 */
ve.ui.Surface.prototype.getDir = function () {
	return this.$element.css( 'direction' );
};

/**
 * @method
 * @returns {ve.init.mw.Target}
 */
ve.ui.Surface.prototype.getTarget = function () {
	return this.target;
};
