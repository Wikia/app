/*!
 * VisualEditor UserInterface MWSurfaceWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWSurfaceWidget object.
 *
 * @class
 * @abstract
 * @extends ve.ui.SurfaceWidget
 *
 * @constructor
 * @param {ve.dm.Document} doc Document model
 * @param {Object} [config] Configuration options
 */
ve.ui.MWSurfaceWidget = function VeUiMWSurfaceWidget( doc, config ) {
	// Parent constructor
	ve.ui.MWSurfaceWidget.super.call( this, doc, config );

	// Initialization
	this.$element.addClass( 've-ui-mwSurfaceWidget' );
	this.surface.getView().$element.addClass( 'mw-body-content' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWSurfaceWidget, ve.ui.SurfaceWidget );
