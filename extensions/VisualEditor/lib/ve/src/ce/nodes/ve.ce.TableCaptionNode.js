/*!
 * VisualEditor ContentEditable TableCaptionNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable table caption node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @constructor
 * @param {ve.dm.TableCaptionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.TableCaptionNode = function VeCeTableCaptionNode() {
	// Parent constructor
	ve.ce.TableCaptionNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ce.TableCaptionNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.TableCaptionNode.static.name = 'tableCaption';

ve.ce.TableCaptionNode.static.tagName = 'caption';

/* Methods */

/**
 * @inheritdoc
 */
ve.ce.TableCaptionNode.prototype.onSetup = function () {
	// Parent method
	ve.ce.TableCaptionNode.super.prototype.onSetup.call( this );

	// DOM changes
	this.$element
		.addClass( 've-ce-tableCaptionNode' )
		.prop( 'contentEditable', 'true' );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.TableCaptionNode );
