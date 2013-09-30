/*!
 * VisualEditor UserInterface GridLayout class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Grid layout.
 *
 * @class
 * @extends ve.ui.Layout
 *
 * @constructor
 * @param {ve.ui.PanelLayout[]} panels Panels in the grid
 * @param {Object} [config] Configuration options
 * @cfg {number[]} [widths] Widths of columns as ratios
 * @cfg {number[]} [heights] Heights of columns as ratios
 */
ve.ui.GridLayout = function VeUiGridLayout( panels, config ) {
	var i, len, widths;

	// Config initialization
	config = config || {};

	// Parent constructor
	ve.ui.Layout.call( this, config );

	// Properties
	this.panels = [];
	this.widths = [];
	this.heights = [];

	// Initialization
	this.$.addClass( 've-ui-gridLayout' );
	for ( i = 0, len = panels.length; i < len; i++ ) {
		this.panels.push( panels[i] );
		this.$.append( panels[i].$ );
	}
	if ( config.widths || config.heights ) {
		this.layout( config.widths || [1], config.heights || [1] );
	} else {
		// Arrange in columns by default
		widths = [];
		for ( i = 0, len = this.panels.length; i < len; i++ ) {
			widths[i] = 1;
		}
		this.layout( widths, [1] );
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.GridLayout, ve.ui.Layout );

/* Events */

/**
 * @event layout
 */

/**
 * @event update
 */

/* Static Properties */

ve.ui.GridLayout.static.tagName = 'div';

/* Methods */

/**
 * Set grid dimensions.
 *
 * @method
 * @param {number[]} widths Widths of columns as ratios
 * @param {number[]} heights Heights of rows as ratios
 * @emits layout
 * @throws {Error} If grid is not large enough to fit all panels
 */
ve.ui.GridLayout.prototype.layout = function ( widths, heights ) {
	var x, y,
		xd = 0,
		yd = 0,
		cols = widths.length,
		rows = heights.length;

	// Verify grid is big enough to fit panels
	if ( cols * rows < this.panels.length ) {
		throw new Error( 'Grid is not large enough to fit ' + this.panels.length + 'panels' );
	}

	// Sum up denominators
	for ( x = 0; x < cols; x++ ) {
		xd += widths[x];
	}
	for ( y = 0; y < rows; y++ ) {
		yd += heights[y];
	}
	// Store factors
	this.widths = [];
	this.heights = [];
	for ( x = 0; x < cols; x++ ) {
		this.widths[x] = widths[x] / xd;
	}
	for ( y = 0; y < rows; y++ ) {
		this.heights[y] = heights[y] / yd;
	}
	// Synchronize view
	this.update();
	this.emit( 'layout' );
};

/**
 * Update panel positions and sizes.
 *
 * @method
 * @emits update
 */
ve.ui.GridLayout.prototype.update = function () {
	var x, y, panel,
		i = 0,
		left = 0,
		top = 0,
		dimensions,
		width = 0,
		height = 0,
		cols = this.widths.length,
		rows = this.heights.length;

	for ( y = 0; y < rows; y++ ) {
		for ( x = 0; x < cols; x++ ) {
			panel = this.panels[i];
			width = this.widths[x];
			height = this.heights[y];
			dimensions = {
				'width': Math.round( width * 100 ) + '%',
				'height': Math.round( height * 100 ) + '%',
				'top': Math.round( top * 100 ) + '%'
			};
			// If RTL, reverse:
			if ( this.$$.frame.dir === 'rtl' ) {
				dimensions.right = Math.round( left * 100 ) + '%';
			} else {
				dimensions.left = Math.round( left * 100 ) + '%';
			}
			panel.$.css( dimensions );
			i++;
			left += width;
		}
		top += height;
		left = 0;
	}

	this.emit( 'update' );
};

/**
 * Get a panel at a given position.
 *
 * The x and y position is affected by the current grid layout.
 *
 * @method
 * @param {number} x Horizontal position
 * @param {number} y Vertical position
 * @returns {ve.ui.PanelLayout} The panel at the given postion
 */
ve.ui.GridLayout.prototype.getPanel = function ( x, y ) {
	return this.panels[( x * this.widths.length ) + y];
};
