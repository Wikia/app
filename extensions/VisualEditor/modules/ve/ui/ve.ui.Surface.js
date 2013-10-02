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
 * @extends ve.Element
 *
 * @constructor
 * @param {HTMLDocument|Array|ve.dm.LinearData|ve.dm.Document} dataOrDoc Document data to edit
 * @param {Object} [config] Configuration options
 */
ve.ui.Surface = function VeUiSurface( dataOrDoc, config ) {
	// Parent constructor
	ve.Element.call( this, config );

	// Mixin constructor
	ve.EventEmitter.call( this, config );

	// Properties
	this.$globalOverlay = $( '<div>' );
	this.$localOverlay = this.$$( '<div>' );
	this.$localOverlayBlockers = this.$$( '<div>' );
	this.$localOverlayControls = this.$$( '<div>' );
	this.$localOverlayMenus = this.$$( '<div>' );
	this.model = new ve.dm.Surface(
		dataOrDoc instanceof ve.dm.Document ? dataOrDoc : new ve.dm.Document( dataOrDoc )
	);
	this.view = new ve.ce.Surface( this.model, this, { '$$': this.$$ } );
	this.context = new ve.ui.Context( this, { '$$': this.$$ } );
	this.dialogs = new ve.ui.WindowSet( this, ve.ui.dialogFactory );
	this.commands = {};
	this.enabled = true;

	// Initialization
	this.$
		.addClass( 've-ui-surface' )
		.append( this.view.$ );
	this.$localOverlay
		.addClass( 've-ui-surface-overlay ve-ui-surface-overlay-local' )
		.append( this.$localOverlayBlockers )
		.append( this.$localOverlayControls )
		.append( this.$localOverlayMenus );
	this.$localOverlayMenus
		.append( this.context.$ );
	this.$globalOverlay
		.addClass( 've-ui-surface-overlay ve-ui-surface-overlay-global' )
		.append( this.dialogs.$ );

	// Make instance globally accessible for debugging
	ve.instances.push( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.Surface, ve.Element );

ve.mixinClass( ve.ui.Surface, ve.EventEmitter );

/* Events */

/**
 * When the surface changes its position (only if it happens
 * after initialize has already been called).
 *
 * @event position
 */

/* Methods */

/** */
ve.ui.Surface.prototype.initialize = function () {
	this.view.$.after( this.$localOverlay );
	$( 'body' ).append( this.$globalOverlay );

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
 * @returns {ve.ui.WindowSet} Dialogs window set
 */
ve.ui.Surface.prototype.getDialogs = function () {
	return this.dialogs;
};

/**
 * Get the context menu.
 *
 * @method
 * @returns {ve.ui.Context} Context user interface
 */
ve.ui.Surface.prototype.getCommands = function () {
	return this.commands;
};

/**
 * Destroy the surface, releasing all memory and removing all DOM elements.
 *
 * @method
 * @returns {ve.ui.Context} Context user interface
 */
ve.ui.Surface.prototype.destroy = function () {
	ve.instances.splice( ve.instances.indexOf( this ), 1 );
	this.$.remove();
	this.$globalOverlay.remove();
	this.$localOverlay.remove();
	this.view.destroy();
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
		trigger = action.toString();
		if ( trigger in this.commands ) {
			return this.execute.apply( this, this.commands[trigger] );
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
 * @method
 * @param {string[]|Object[]} commands List of symbolic names of commands in the command registry
 */
ve.ui.Surface.prototype.addCommands = function ( commands ) {
	var i, len, command;

	for ( i = 0, len = commands.length; i < len; i++ ) {
		command = ve.ui.commandRegistry.lookup( commands[i] );
		if ( !command ) {
			throw new Error( 'No command registered by that name: ' + commands[i] );
		}
		this.addTriggers( [ve.ui.triggerRegistry.lookup( commands[i] )], command );
	}
};

/**
 * Add triggers to surface.
 *
 * @method
 * @param {ve.ui.Trigger[]} triggers Triggers to associate with command
 * @param {Object} command Command to trigger
 */
ve.ui.Surface.prototype.addTriggers = function ( triggers, command ) {
	var i, len, trigger;

	for ( i = 0, len = triggers.length; i < len; i++ ) {
		// Normalize
		trigger = triggers[i].toString();
		// Validate
		if ( trigger.length === 0 ) {
			throw new Error( 'Incomplete trigger: ' + triggers[i] );
		}
		this.commands[trigger] = command.action;
	}
};

/**
 * Surface 'dir' property (GUI/User-Level Direction)
 * @returns {string} 'ltr' or 'rtl'
 */
ve.ui.Surface.prototype.getDir = function () {
	return this.$.css( 'direction' );
};
