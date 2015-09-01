/*!
 * VisualEditor ContentEditable MWAlienExtensionNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki alien extension node.
 *
 * @class
 * @abstract
 * @mixins OO.ui.mixin.IconElement
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ce.MWAlienExtensionNode = function VeCeMWAlienExtensionNode( config ) {
	// Mixin constructors
	OO.ui.mixin.IconElement.call( this, config );

	// Events
	this.connect( this, { setup: 'onAlienSetup' } );
};

/* Inheritance */

OO.initClass( ve.ce.MWAlienExtensionNode );

OO.mixinClass( ve.ce.MWAlienExtensionNode, OO.ui.mixin.IconElement );

/* Static members */

ve.ce.MWAlienExtensionNode.static.primaryCommandName = 'alienExtension';

/* Methods */

/**
 * Handle setup events
 */
ve.ce.MWAlienExtensionNode.prototype.onAlienSetup = function () {
	if ( !this.isVisible() ) {
		this.setIcon( 'alienextension' );
		this.$element.first().prepend( this.$icon );
	} else {
		this.setIcon( null );
	}
};

/**
 * @inheritdoc ve.ce.MWExtensionNode
 */
ve.ce.MWAlienExtensionNode.prototype.render = function ( generatedContents ) {
	// Since render is trigerred before onSetup, we need to make sure that the
	// icon is detached only when it is defined and is not null
	if ( this.$icon ) {
		this.$icon.detach();
	}
	// Call parent mixin
	ve.ce.GeneratedContentNode.prototype.render.call( this, generatedContents );

	// Since render replaces this.$element with a new node, we need to make sure
	// our iconElement is defined again to be this.$element
	this.$element.addClass( 've-ce-mwAlienExtensionNode' );
};

/* Static methods */

/**
 * @inheritdoc ve.ce.MWExtensionNode
 */
ve.ce.MWAlienExtensionNode.static.getDescription = function ( model ) {
	return model.getExtensionName();
};

/**
 * ContentEditable MediaWiki alien inline extension node.
 *
 * @class
 * @abstract
 * @extends ve.ce.MWInlineExtensionNode
 * @mixins ve.ce.MWAlienExtensionNode
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ce.MWAlienInlineExtensionNode = function VeCeMWAlienInlineExtensionNode( config ) {
	// Parent constructor
	ve.ce.MWAlienInlineExtensionNode.super.apply( this, arguments );

	// Mixin constructors
	ve.ce.MWAlienExtensionNode.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWAlienInlineExtensionNode, ve.ce.MWInlineExtensionNode );

OO.mixinClass( ve.ce.MWAlienInlineExtensionNode, ve.ce.MWAlienExtensionNode );

/* Static members */

ve.ce.MWAlienInlineExtensionNode.static.name = 'mwAlienInlineExtension';

/**
 * ContentEditable MediaWiki alien block extension node.
 *
 * @class
 * @abstract
 * @extends ve.ce.MWBlockExtensionNode
 * @mixins ve.ce.MWAlienExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWAlienBlockExtensionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWAlienBlockExtensionNode = function VeCeMWAlienBlockExtensionNode() {
	// Parent constructor
	ve.ce.MWAlienBlockExtensionNode.super.apply( this, arguments );

	// Mixin constructors
	ve.ce.MWAlienExtensionNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWAlienBlockExtensionNode, ve.ce.MWBlockExtensionNode );

OO.mixinClass( ve.ce.MWAlienBlockExtensionNode, ve.ce.MWAlienExtensionNode );

/* Static members */

ve.ce.MWAlienBlockExtensionNode.static.name = 'mwAlienBlockExtension';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWAlienInlineExtensionNode );
ve.ce.nodeFactory.register( ve.ce.MWAlienBlockExtensionNode );
