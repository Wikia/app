/*!
 * VisualEditor DataModel MWAlienExtensionNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki alien extension node.
 *
 * @class
 * @abstract
 *
 * @constructor
 */
ve.dm.MWAlienExtensionNode = function VeDmMWAlienExtensionNode() {};

/* Inheritance */

OO.initClass( ve.dm.MWAlienExtensionNode );

/* Static members */

ve.dm.MWAlienExtensionNode.static.getMatchRdfaTypes = function () {
	return [
		/^mw:Extension/
	];
};

ve.dm.MWAlienExtensionNode.static.toDataElement = function ( domElements, converter ) {
	// 'Parent' method
	var element = ve.dm.MWExtensionNode.static.toDataElement( domElements, converter ),
		isInline = this.isHybridInline( domElements, converter );

	element.type = isInline ? 'mwAlienInlineExtension' : 'mwAlienBlockExtension';
	return element;
};

/**
 * @inheritdoc ve.dm.MWExtensionNode
 */
ve.dm.MWAlienExtensionNode.static.getExtensionName = function ( dataElement ) {
	return dataElement.attributes.mw.name;
};

/**
 * DataModel MediaWiki alien inline extension node.
 *
 * @class
 * @abstract
 * @extends ve.dm.MWInlineExtensionNode
 * @mixins ve.dm.MWAlienExtensionNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 */
ve.dm.MWAlienInlineExtensionNode = function VeDmMWAlienInlineExtensionNode() {
	// Parent constructor
	ve.dm.MWAlienInlineExtensionNode.super.apply( this, arguments );

	// Mixin constructors
	ve.dm.MWAlienExtensionNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWAlienInlineExtensionNode, ve.dm.MWInlineExtensionNode );

OO.mixinClass( ve.dm.MWAlienInlineExtensionNode, ve.dm.MWAlienExtensionNode );

/* Static members */

ve.dm.MWAlienInlineExtensionNode.static.name = 'mwAlienInlineExtension';

ve.dm.MWAlienInlineExtensionNode.static.isContent = true;

ve.dm.MWAlienInlineExtensionNode.static.tagName = 'span';

/**
 * DataModel MediaWiki alien block extension node.
 *
 * @class
 * @abstract
 * @extends ve.dm.MWBlockExtensionNode
 * @mixins ve.dm.MWAlienExtensionNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.MWAlienBlockExtensionNode = function VeDmMWAlienBlockExtensionNode() {
	// Parent constructor
	ve.dm.MWAlienBlockExtensionNode.super.apply( this, arguments );

	// Mixin constructors
	ve.dm.MWAlienExtensionNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWAlienBlockExtensionNode, ve.dm.MWBlockExtensionNode );

OO.mixinClass( ve.dm.MWAlienBlockExtensionNode, ve.dm.MWAlienExtensionNode );

/* Static members */

ve.dm.MWAlienBlockExtensionNode.static.name = 'mwAlienBlockExtension';

ve.dm.MWAlienBlockExtensionNode.static.tagName = 'div';

/* Registration */

ve.dm.modelRegistry.register( ve.dm.MWAlienInlineExtensionNode );
ve.dm.modelRegistry.register( ve.dm.MWAlienBlockExtensionNode );
