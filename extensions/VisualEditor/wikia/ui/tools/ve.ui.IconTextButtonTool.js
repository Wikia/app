/*!
 * VisualEditor UserInterface IconTextButton class.
 */

/**
 * UserInterface icon text button tool.
 *
 * @class
 * @extends ve.ui.DialogButtonTool
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.IconTextButtonTool = function VeUiIconTextButtonTool( toolbar, config ) {
	var label = ve.msg( this.constructor.static.labelMessage );

	// Parent constructor
	ve.ui.DialogTool.call( this, toolbar, config );

	// Properties
	this.$label = this.$$( '<span>' ).addClass( 've-ui-iconTextButtonTool-label' ).text( label );

	// Initialization
	this.$
		.addClass( 've-ui-iconTextButtonTool' )
		.append( this.$label );
	this.$icon
		.addClass( 've-ui-iconTextButtonTool-icon' );
};

/* Inheritance */

ve.inheritClass( ve.ui.IconTextButtonTool, ve.ui.DialogTool );

