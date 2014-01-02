/*!
 * VisualEditor UserInterface TriggerRegistry class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Trigger registry.
 *
 * @class
 * @extends ve.Registry
 * @constructor
 */
ve.ui.TriggerRegistry = function VeUiTriggerRegistry() {
	// Parent constructor
	ve.Registry.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.TriggerRegistry, ve.Registry );

/* Methods */

/**
 * Register a constructor with the factory.
 *
 * The only supported platforms are 'mac' and 'pc'. All platforms not identified as 'mac' will be
 * considered to be 'pc', including 'win', 'linux', 'solaris', etc.
 *
 * @method
 * @param {string|string[]} name Symbolic name or list of symbolic names
 * @param {ve.ui.Trigger|Object} trigger Trigger object, or map of trigger objects keyed by
 * platform name e.g. 'mac' or 'pc'
 */
ve.ui.TriggerRegistry.prototype.register = function ( name, trigger ) {
	var platform = ve.init.platform.getSystemPlatform(),
		platformKey = platform === 'mac' ? 'mac' : 'pc';

	// Validate arguments
	if ( typeof name !== 'string' && !ve.isArray( name ) ) {
		throw new Error( 'name must be a string or array, cannot be a ' + typeof name );
	}
	if ( !( trigger instanceof ve.ui.Trigger ) && !ve.isPlainObject( trigger ) ) {
		throw new Error(
			'trigger must be an instance of ve.ui.Trigger or an object containing instances of ' +
				've.ui.Trigger, cannot be a ' + typeof trigger
		);
	}

	// Check for platform-specific trigger
	if ( ve.isPlainObject( trigger ) ) {
		// Only register if the current platform is supported
		if ( platformKey in trigger ) {
			ve.Registry.prototype.register.call( this, name, trigger[platformKey] );
		}
	} else {
		ve.Registry.prototype.register.call( this, name, trigger );
	}
};

/* Initialization */

ve.ui.triggerRegistry = new ve.ui.TriggerRegistry();

ve.ui.triggerRegistry.register(
	'bold', { 'mac': new ve.ui.Trigger( 'cmd+b' ), 'pc': new ve.ui.Trigger( 'ctrl+b' ) }
);
ve.ui.triggerRegistry.register(
	'italic', { 'mac': new ve.ui.Trigger( 'cmd+i' ), 'pc': new ve.ui.Trigger( 'ctrl+i' ) }
);
ve.ui.triggerRegistry.register(
	'clear', { 'mac': new ve.ui.Trigger( 'cmd+\\' ), 'pc': new ve.ui.Trigger( 'ctrl+\\' ) }
);
ve.ui.triggerRegistry.register( 'indent', new ve.ui.Trigger( 'tab' ) );
ve.ui.triggerRegistry.register( 'outdent', new ve.ui.Trigger( 'shift+tab' ) );
ve.ui.triggerRegistry.register(
	'link', { 'mac': new ve.ui.Trigger( 'cmd+k' ), 'pc': new ve.ui.Trigger( 'ctrl+k' ) }
);
ve.ui.triggerRegistry.register(
	'redo', { 'mac': new ve.ui.Trigger( 'cmd+shift+z' ), 'pc': new ve.ui.Trigger( 'ctrl+shift+z' ) }
);
ve.ui.triggerRegistry.register(
	'undo', { 'mac': new ve.ui.Trigger( 'cmd+z' ), 'pc': new ve.ui.Trigger( 'ctrl+z' ) }
);
// Ctrl+0-7 below are not mapped to Cmd+0-7 on Mac because Chrome reserves those for switching tabs
ve.ui.triggerRegistry.register(
	'paragraph', { 'mac': new ve.ui.Trigger( 'ctrl+0' ), 'pc': new ve.ui.Trigger ( 'ctrl+0' ) }
);
ve.ui.triggerRegistry.register(
	'heading1', { 'mac': new ve.ui.Trigger( 'ctrl+1' ), 'pc': new ve.ui.Trigger ( 'ctrl+1' ) }
);
ve.ui.triggerRegistry.register(
	'heading2', { 'mac': new ve.ui.Trigger( 'ctrl+2' ), 'pc': new ve.ui.Trigger ( 'ctrl+2' ) }
);
ve.ui.triggerRegistry.register(
	'heading3', { 'mac': new ve.ui.Trigger( 'ctrl+3' ), 'pc': new ve.ui.Trigger ( 'ctrl+3' ) }
);
ve.ui.triggerRegistry.register(
	'heading4', { 'mac': new ve.ui.Trigger( 'ctrl+4' ), 'pc': new ve.ui.Trigger ( 'ctrl+4' ) }
);
ve.ui.triggerRegistry.register(
	'heading5', { 'mac': new ve.ui.Trigger( 'ctrl+5' ), 'pc': new ve.ui.Trigger ( 'ctrl+5' ) }
);
ve.ui.triggerRegistry.register(
	'heading6', { 'mac': new ve.ui.Trigger( 'ctrl+6' ), 'pc': new ve.ui.Trigger ( 'ctrl+6' ) }
);
ve.ui.triggerRegistry.register(
	'preformatted', { 'mac': new ve.ui.Trigger( 'ctrl+7' ), 'pc': new ve.ui.Trigger ( 'ctrl+7' ) }
);
