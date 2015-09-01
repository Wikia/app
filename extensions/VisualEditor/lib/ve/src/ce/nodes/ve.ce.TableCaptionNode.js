/*!
 * VisualEditor ContentEditable TableCaptionNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
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

	// DOM changes
	this.$element
		.addClass( 've-ce-tableCaptionNode' )
		.prop( 'contentEditable', 'true' );
};

/* Inheritance */

OO.inheritClass( ve.ce.TableCaptionNode, ve.ce.BranchNode );

/* Static Properties */

ve.ce.TableCaptionNode.static.name = 'tableCaption';

ve.ce.TableCaptionNode.static.tagName = 'caption';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.TableCaptionNode );
