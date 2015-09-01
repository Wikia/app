/*!
 * VisualEditor UserInterface MWTargetWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWTargetWidget object.
 *
 * @class
 * @abstract
 * @extends ve.ui.TargetWidget
 *
 * @constructor
 * @param {ve.dm.Document} doc Document model
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTargetWidget = function VeUiMWTargetWidget( doc, config ) {
	// Parent constructor
	ve.ui.MWTargetWidget.super.call( this, doc, config );

	// Initialization
	this.$element.addClass( 've-ui-mwTargetWidget' );
	this.surface.getView().$element.addClass( 'mw-body-content' );
	this.surface.$placeholder.addClass( 'mw-body-content' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWTargetWidget, ve.ui.TargetWidget );
