/*!
 * VisualEditor ContentEditable WikiaBlockVideoNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * VisualEditor ContentEditable Wikia video node.
 *
 * @class
 * @extends ve.ce.WikiaBlockMediaNode
 * @mixins ve.ce.WikiaVideoNode
 *
 * @constructor
 * @param {ve.dm.WikiaBlockVideoNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.WikiaBlockVideoNode = function VeCeWikiaBlockVideoNode( model, config ) {
	// Parent constructor
	ve.ce.WikiaBlockMediaNode.call( this, model, config );

	// Mixin constructors
	ve.ce.WikiaVideoNode.call( this );
};

/* Inheritance */

ve.inheritClass( ve.ce.WikiaBlockVideoNode, ve.ce.WikiaBlockMediaNode );

ve.mixinClass( ve.ce.WikiaBlockVideoNode, ve.ce.WikiaVideoNode );

/* Static Properties */

ve.ce.WikiaBlockVideoNode.static.name = 'wikiaBlockVideo';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.WikiaBlockVideoNode );
