/*!
 * VisualEditor UserInterface PanelLayout class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Panel layout.
 *
 * @class
 * @extends ve.ui.Layout
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {boolean} [scrollable] Allow vertical scrolling
 * @cfg {boolean} [padded] Pad the content from the edges
 */
ve.ui.PanelLayout = function VeUiPanelLayout( config ) {
	// Config initialization
	config = config || {};

	// Parent constructor
	ve.ui.Layout.call( this, config );

	// Initialization
	this.$.addClass( 've-ui-panelLayout' );
	if ( config.scrollable ) {
		this.$.addClass( 've-ui-panelLayout-scrollable' );
	}

	if ( config.padded ) {
		this.$.addClass( 've-ui-panelLayout-padded' );
	}

	// Add directionality class:
	this.$.addClass( 've-' + this.$$.frame.dir );
};

/* Inheritance */

ve.inheritClass( ve.ui.PanelLayout, ve.ui.Layout );
