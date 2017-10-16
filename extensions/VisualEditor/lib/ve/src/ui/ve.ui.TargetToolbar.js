/*!
 * VisualEditor UserInterface TargetToolbar class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface target toolbar.
 *
 * @class
 * @extends ve.ui.Toolbar
 *
 * @constructor
 * @param {ve.init.Target} target Target to control
 * @param {Object} [config] Configuration options
 */
ve.ui.TargetToolbar = function VeUiTargetToolbar( target, config ) {
	// Parent constructor
	ve.ui.TargetToolbar.super.call( this, config );

	// Properties
	this.target = target;
};

/* Inheritance */

OO.inheritClass( ve.ui.TargetToolbar, ve.ui.Toolbar );

/* Methods */

/**
 * Gets the target which the toolbar controls.
 *
 * @returns {ve.init.Target} Target being controlled
 */
ve.ui.TargetToolbar.prototype.getTarget = function () {
	return this.target;
};

/**
 * @inheritdoc
 */
ve.ui.TargetToolbar.prototype.getTriggers = function ( name ) {
	var triggers = ve.ui.TargetToolbar.super.prototype.getTriggers.apply( this, arguments );
	return triggers ||
		this.getTarget().targetTriggerListener.getTriggers( name ) ||
		this.getTarget().documentTriggerListener.getTriggers( name );
};

/**
 * @inheritdoc
 */
ve.ui.TargetToolbar.prototype.getCommands = function () {
	return ve.ui.TargetToolbar.super.prototype.getCommands.apply( this, arguments ).concat(
		this.getTarget().targetTriggerListener.getCommands(),
		this.getTarget().documentTriggerListener.getCommands()
	);
};
