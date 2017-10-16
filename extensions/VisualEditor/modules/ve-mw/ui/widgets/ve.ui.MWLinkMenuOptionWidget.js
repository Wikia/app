/*!
 * VisualEditor UserInterface MWLinkMenuOptionWidget class
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Creates a ve.ui.MWLinkMenuOptionWidget object.
 *
 * @class
 * @extends OO.ui.MenuOptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string} [href] href to point to pages from link suggestions
 */
ve.ui.MWLinkMenuOptionWidget = function VeUiMWLinkMenuOptionWidget( config ) {
	// Config initialization
	config = config || {};

	// Parent constructor
	ve.ui.MWLinkMenuOptionWidget.super.call( this, config );

	// initialization
	this.$label.wrap( '<a>' );
	this.$link = this.$label.parent();
	this.$link.attr( 'href', config.href );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLinkMenuOptionWidget, OO.ui.MenuOptionWidget );
