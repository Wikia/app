/*!
 * VisualEditor DataModel WikiaBlockVideoNode class.
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel Wikia video node.
 *
 * @class
 * @extends ve.dm.WikiaBlockMediaNode
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.WikiaBlockVideoNode = function VeDmWikiaBlockVideoNode() {
	ve.dm.WikiaBlockVideoNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.dm.WikiaBlockVideoNode, ve.dm.WikiaBlockMediaNode );

/* Static Properties */

ve.dm.WikiaBlockVideoNode.static.name = 'wikiaBlockVideo';

ve.dm.WikiaBlockMediaNode.static.childNodeTypes = [ 'wikiaVideoCaption' ];

ve.dm.WikiaBlockMediaNode.static.captionNodeType = 'wikiaVideoCaption';

ve.dm.WikiaBlockVideoNode.static.rdfaToType = {
	'mw:Video/Thumb': 'thumb',
	'mw:Video/Frame': 'frame',
	'mw:Video/Frameless': 'frameless',
	'mw:Video': 'none'
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.WikiaBlockVideoNode );
