/*!
 * VisualEditor Standalone Initialization Desktop Target class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Initialization standalone desktop target.
 *
 * @class
 * @extends ve.init.sa.Target
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {Object} [toolbarConfig] Configuration options for the toolbar
 */
ve.init.sa.DesktopTarget = function VeInitSaDesktopTarget( config ) {
	// Parent constructor
	ve.init.sa.DesktopTarget.super.call( this, config );

	this.$element.addClass( 've-init-sa-desktopTarget' );
};

/* Inheritance */

OO.inheritClass( ve.init.sa.DesktopTarget, ve.init.sa.Target );

/* Methods */

/**
 * @inheritdoc
 */
ve.init.sa.DesktopTarget.prototype.setupToolbar = function ( surface ) {
	if ( !this.actions ) {
		this.actions = new ve.ui.TargetToolbar( this );
		this.getToolbar().$actions.append( this.actions.$element );
	}

	this.actions.setup( this.constructor.static.actionGroups, surface );

	// Parent method
	ve.init.sa.DesktopTarget.super.prototype.setupToolbar.call( this, surface );
};
