/*!
 * VisualEditor UserInterface MWTocItemWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an item an item for the MWTocWidget
 *
 * @class
 * @extends OO.ui.Widget
 * @mixins OO.ui.mixin.GroupElement
 *
 * @constructor
 * @param {Object} config TOC Item configuration
 * @cfg {ve.ce.Node} node ContentEditable node
 * @cfg {ve.ui.MWTocItemWidget} parent Parent toc item
 * @cfg {string} sectionPrefix TOC item section number
 * @cfg {number} tocLevel Depth level of the TOC item
 * @cfg {number} tocIndex Running count of TOC items
 *
 */
ve.ui.MWTocItemWidget = function VeUiMWTocItemWidget( config ) {
	// Parent constructor
	OO.ui.Widget.call( this, config );

	// Mixin Constructor
	OO.ui.mixin.GroupElement.call( this, $.extend( {}, config, { $group: $( '<ul>' ) } ) );

	config = config || {};

	// Properties
	this.node = config.node || null;
	this.parent = config.parent;
	this.sectionPrefix = config.sectionPrefix;
	this.tocLevel = config.tocLevel;
	this.tocIndex = config.tocIndex;

	// Allows toc items to be optionally associated to a node.
	// For the case of the zero level parent item.
	if ( this.node ) {
		this.$tocNumber = $( '<span>' ).addClass( 'tocnumber' )
			.text( this.sectionPrefix );
		this.$tocText = $( '<span>' ).addClass( 'toctext' )
			.text( this.node.$element.text() );
		this.$element
			.addClass( 'toclevel-' + this.tocLevel )
			.addClass( 'tocsection-' + this.tocIndex )
			.append( $( '<a>' ).append( this.$tocNumber, this.$tocText ) );

		// Monitor node events
		this.node.model.connect( this, { update: 'onUpdate' } );
	}
	this.$element.append( this.$group );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWTocItemWidget, OO.ui.Widget );

OO.mixinClass( ve.ui.MWTocItemWidget, OO.ui.mixin.GroupElement );

/* Static Properties */

ve.ui.MWTocItemWidget.static.tagName = 'li';

/* Methods */

/**
 * Updates the text of the toc item
 *
 */
ve.ui.MWTocItemWidget.prototype.onUpdate = function () {
	var widget = this;
	// Timeout needed to let the dom element actually update
	setTimeout( function () {
		widget.$tocText.text( widget.node.$element.text() );
	} );
};

/**
 * Removes this toc item from its parent
 *
 */
ve.ui.MWTocItemWidget.prototype.remove = function () {
	this.node.model.disconnect( this );
	this.parent.removeItems( [ this ] );
};
