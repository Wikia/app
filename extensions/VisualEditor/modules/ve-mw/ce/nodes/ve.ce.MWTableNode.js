/*!
 * VisualEditor ContentEditable MWTableNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MW table node.
 *
 * @class
 * @extends ve.ce.TableNode
 *
 * @constructor
 * @param {ve.dm.MWTableNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWTableNode = function VeCeMWTableNode() {
	// Parent constructor
	ve.ce.MWTableNode.super.apply( this, arguments );

	this.model.connect( this, { attributeChange: 'onAttributeChange' } );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWTableNode, ve.ce.TableNode );

/* Static Properties */

ve.ce.MWTableNode.static.name = 'mwTable';

/* Methods */

ve.ce.MWTableNode.prototype.onAttributeChange = function ( key, from, to ) {
	switch ( key ) {
		case 'article-table':
			this.$element.toggleClass( 'article-table', !!to );
			break;
		case 'sortable':
			this.$element.toggleClass( 'sortable', !!to );
			break;
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWTableNode );
