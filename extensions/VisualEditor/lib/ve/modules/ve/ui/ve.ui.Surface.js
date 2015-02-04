/*!
 * VisualEditor UserInterface Surface class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * A surface is a top-level object which contains both a surface model and a surface view.
 *
 * @class
 * @abstract
 * @extends OO.ui.Element
 *
 * @constructor
 * @param {HTMLDocument|Array|ve.dm.LinearData|ve.dm.Document} dataOrDoc Document data to edit
 * @param {Object} [config] Configuration options
 * @param {ve.init.mw.Target} [target] Target instance (optional)
 */
ve.ui.Surface = function VeUiSurface( dataOrDoc, config, target ) {
	var documentModel;

	// Parent constructor
	OO.ui.Element.call( this, config );

	// Mixin constructor
	OO.EventEmitter.call( this, config );

	// Properties
	this.$globalOverlay = this.$( '<div>' );
	this.$localOverlay = this.$( '<div>' );
	this.$localOverlayBlockers = this.$( '<div>' );
	this.$localOverlayControls = this.$( '<div>' );
	if ( dataOrDoc instanceof ve.dm.Document ) {
		// ve.dm.Document
		documentModel = dataOrDoc;
	} else if ( dataOrDoc instanceof ve.dm.LinearData || ve.isArray( dataOrDoc ) ) {
		// LinearData or raw linear data
		documentModel = new ve.dm.Document( dataOrDoc );
	} else {
		// HTMLDocument
		documentModel = ve.dm.converter.getModelFromDom( dataOrDoc );
	}
	this.model = new ve.dm.Surface( documentModel );
	this.view = new ve.ce.Surface( this.model, this, { '$': this.$ } );
	this.dialogs = new ve.ui.WindowSet( ve.ui.windowFactory, { '$': this.$ } );
	this.commands = {};
	this.triggers = {};
	this.pasteRules = {};
	this.enabled = true;
	this.target = target || null;
	if ( config && config.focusMode ) {
		this.focusWidget = new ve.ui.WikiaFocusWidget( this );
	}

	// Events
	this.dialogs.connect( this, { 'teardown': 'onDialogTeardown' } );

	// Initialization
	this.setupContext();
	this.$element
		.addClass( 've-ui-surface' )
		.append( this.view.$element );
	this.$localOverlay
		.addClass( 've-ui-surface-overlay ve-ui-surface-overlay-local' )
		.append( this.$localOverlayBlockers )
		.append( this.$localOverlayControls );
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
 * When a command is added to the surface.
 *
 * @event addCommand
 * @param {string} name Symbolic name of command and trigger
 * @param {ve.ui.Command} command Command that's been registered
 * @param {ve.ui.Trigger[]} triggers Triggers to associate with command
 */

/**
 * When a surface is destroyed.
 *
 * @event destroy
 */

/* Methods */

/**
 * Destroy the surface, releasing all memory and removing all DOM elements.
 *
 * @method
 * @fires destroy
 */
ve.ui.Surface.prototype.destroy = function () {
	// Remove instance from global array
	ve.instances.splice( ve.instances.indexOf( this ), 1 );

	// Stop periodic history tracking in model
	this.model.stopHistoryTracking();

	// Destroy the ce.Surface and the ui.Context
	this.view.destroy();
	this.context.destroy();

	// Disconnect events
	this.dialogs.disconnect( this );

	// Remove DOM elements
	this.$element.remove();
	this.$globalOverlay.remove();
	this.$localOverlay.remove();

	// Let others know we have been destroyed
	this.emit( 'destroy' );
};

/**
 * Handle dialog teardown events
 */
ve.ui.Surface.prototype.onDialogTeardown = function () {
	this.getView().focus();
};

/**
 * Initialize surface.
 *
 * This must be called after the surface has been attached to the DOM.
 */
ve.ui.Surface.prototype.initialize = function () {
	var $body = $( 'body' );

	this.getView().$element.after( this.$localOverlay );
	if ( this.focusWidget ) {
		this.focusWidget.$element
			.hide()
			.appendTo( $body );
	}
	// Attach globalOverlay to the global <body>, not the local frame's <body>
	$body.append( this.$globalOverlay );

	this.getView().initialize();
	this.getModel().startHistoryTracking();
};

/**
 * Set up a context.
 *
 * @method
 * @abstract
 * @throws {Error} If this method is not overridden in a concrete subclass
 */
ve.ui.Surface.prototype.setupContext = function () {
	throw new Error( 've.ui.Surface.setupContext must be overridden in subclass' );
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
 * Get command associated with trigger string.
 *
 * @method
 * @param {string} trigger Trigger string
 * @returns {ve.ui.Command|undefined} Command
 */
ve.ui.Surface.prototype.getCommand = function ( trigger ) {
	return this.commands[trigger];
};

/**
 * Get triggers for a specified name.
 *
 * @method
 * @param {string} name Trigger name
 * @returns {ve.ui.Trigger[]} Triggers
 */
ve.ui.Surface.prototype.getTriggers = function ( name ) {
	return this.triggers[name];
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
 * @fires addCommand
 */
ve.ui.Surface.prototype.addCommands = function ( names ) {
	var i, j, len, key, command, triggers, trigger;

	for ( i = 0, len = names.length; i < len; i++ ) {
		command = ve.ui.commandRegistry.lookup( names[i] );
		if ( !command ) {
			throw new Error( 'No command registered by that name: ' + names[i] );
		}
		// Normalize trigger key
		triggers = ve.ui.triggerRegistry.lookup( names[i] );
		if ( !triggers ) {
			throw new Error( 'No triggers registered by that name: ' + names[i] );
		}
		for ( j = triggers.length - 1; j >= 0; j-- ) {
			trigger = triggers[j];
			key = trigger.toString();
			// Validate trigger
			if ( key.length === 0 ) {
				throw new Error( 'Incomplete trigger: ' + trigger );
			}
			this.commands[key] = command;
		}
		this.triggers[names[i]] = triggers;
		this.emit( 'addCommand', names[i], command, triggers );
	}
};

/**
 * Get sanitization rules for rich paste
 *
 * @returns {Object} Paste rules
 */
ve.ui.Surface.prototype.getPasteRules = function () {
	return this.pasteRules;
};

/**
 * Set sanitization rules for rich paste
 *
 * @see ve.dm.ElementLinearData#sanitize
 * @param {Object} pasteRules Paste rules
 */
ve.ui.Surface.prototype.setPasteRules = function ( pasteRules ) {
	this.pasteRules = pasteRules;
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

/**
 * @method
 * @returns {ve.ui.WikiaFocusWidget}
 */
ve.ui.Surface.prototype.getFocusWidget = function () {
	return this.focusWidget;
};

/**
 * @method
 * @returns {jQuery} this.$globalOverlay
 */
ve.ui.Surface.prototype.getGlobalOverlay = function () {
	return this.$globalOverlay;
};
