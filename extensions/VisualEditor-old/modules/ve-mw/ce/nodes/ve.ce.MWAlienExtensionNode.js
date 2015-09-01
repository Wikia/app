/*!
 * VisualEditor ContentEditable MWAlienExtensionNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki alien extension node.
 *
 * @class
 * @extends ve.ce.MWBlockExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWAlienExtensionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWAlienExtensionNode = function VeCeMWAlienExtensionNode() {
	// Parent constructor
	ve.ce.MWAlienExtensionNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWAlienExtensionNode, ve.ce.MWBlockExtensionNode );

/* Static Properties */

ve.ce.MWAlienExtensionNode.static.name = 'mwAlienExtension';

ve.ce.MWAlienExtensionNode.static.primaryCommandName = 'alienExtension';

/* Static Methods */

/**
 * @inheritdoc
 */
ve.ce.MWAlienExtensionNode.static.getDescription = function ( model ) {
	return model.getExtensionName();
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ce.MWAlienExtensionNode.prototype.onSetup = function () {
	ve.ce.MWAlienExtensionNode.super.prototype.onSetup.call( this );
	// DOM changes
	this.$element.addClass( 've-ce-mwAlienExtensionNode' );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWAlienExtensionNode );
