/*!
 * VisualEditor DataModel TableSelectionNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel table section node.
 *
 * @class
 * @extends ve.dm.BranchNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.TableSectionNode = function VeDmTableSectionNode() {
	// Parent constructor
	ve.dm.TableSectionNode.super.apply( this, arguments );

	// Events
	this.connect( this, { splice: 'onSplice' } );
};

/* Inheritance */

OO.inheritClass( ve.dm.TableSectionNode, ve.dm.BranchNode );

/* Static Properties */

ve.dm.TableSectionNode.static.name = 'tableSection';

ve.dm.TableSectionNode.static.childNodeTypes = [ 'tableRow' ];

ve.dm.TableSectionNode.static.parentNodeTypes = [ 'table' ];

ve.dm.TableSectionNode.static.defaultAttributes = { style: 'body' };

ve.dm.TableSectionNode.static.matchTagNames = [ 'thead', 'tbody', 'tfoot' ];

/* Static Methods */

ve.dm.TableSectionNode.static.toDataElement = function ( domElements ) {
	var styles = {
			thead: 'header',
			tbody: 'body',
			tfoot: 'footer'
		},
		style = styles[domElements[0].nodeName.toLowerCase()] || 'body';
	return { type: this.name, attributes: { style: style } };
};

ve.dm.TableSectionNode.static.toDomElements = function ( dataElement, doc ) {
	var tags = {
			header: 'thead',
			body: 'tbody',
			footer: 'tfoot'
		},
		tag = tags[dataElement.attributes && dataElement.attributes.style || 'body'];
	return [ doc.createElement( tag ) ];
};

/* Methods */

/**
 * Handle splicing of child nodes
 */
ve.dm.TableSectionNode.prototype.onSplice = function () {
	if ( this.getRoot() ) {
		this.getParent().getMatrix().invalidate();
	}
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.TableSectionNode );
