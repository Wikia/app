/*!
 * VisualEditor ContentEditable AlienNode, AlienBlockNode and AlienInlineNode classes.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * ContentEditable alien node.
 *
 * @class
 * @abstract
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.TableCellableNode
 *
 * @constructor
 * @param {ve.dm.AlienNode} model
 * @param {Object} [config]
 */
ve.ce.AlienNode = function VeCeAlienNode() {
	// Parent constructor
	ve.ce.AlienNode.super.apply( this, arguments );

	// DOM changes
	this.$element = $( ve.copyDomElements( this.model.getOriginalDomElements(), document ) );

	// Mixin constructors
	ve.ce.FocusableNode.call( this, this.$element, {
		classes: [ 've-ce-alienNode-highlights' ]
	} );
	ve.ce.TableCellableNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ce.AlienNode, ve.ce.LeafNode );

OO.mixinClass( ve.ce.AlienNode, ve.ce.FocusableNode );

OO.mixinClass( ve.ce.AlienNode, ve.ce.TableCellableNode );

/* Static Properties */

ve.ce.AlienNode.static.name = 'alien';

/* Methods */

/**
 * @inheritdoc
 */
ve.ce.AlienNode.static.getDescription = function () {
	return ve.msg( 'visualeditor-aliennode-tooltip' );
};

/* Concrete subclasses */

/**
 * ContentEditable alien block node.
 *
 * @class
 * @extends ve.ce.AlienNode
 *
 * @constructor
 * @param {ve.dm.AlienBlockNode} model
 * @param {Object} [config]
 */
ve.ce.AlienBlockNode = function VeCeAlienBlockNode() {
	// Parent constructor
	ve.ce.AlienBlockNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ce.AlienBlockNode, ve.ce.AlienNode );

/* Static Properties */

ve.ce.AlienBlockNode.static.name = 'alienBlock';

/**
 * ContentEditable alien inline node.
 *
 * @class
 * @extends ve.ce.AlienNode
 *
 * @constructor
 * @param {ve.dm.AlienInlineNode} model
 * @param {Object} [config]
 */
ve.ce.AlienInlineNode = function VeCeAlienInlineNode() {
	// Parent constructor
	ve.ce.AlienInlineNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ce.AlienInlineNode, ve.ce.AlienNode );

/* Static Properties */

ve.ce.AlienInlineNode.static.name = 'alienInline';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.AlienBlockNode );
ve.ce.nodeFactory.register( ve.ce.AlienInlineNode );
