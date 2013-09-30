/*!
 * VisualEditor ContentEditable ImageNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable image node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.RelocatableNode
 * @mixins ve.ce.ResizableNode
 *
 * @constructor
 * @param {ve.dm.ImageNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.ImageNode = function VeCeImageNode( model, config ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );
	ve.ce.RelocatableNode.call( this );
	ve.ce.ResizableNode.call( this );

	// Properties
	this.$image = this.$;

	// Events
	this.model.connect( this, { 'update': 'onUpdate' } );
	this.$.on( 'click', ve.bind( this.onClick, this ) );

	// Initialization
	this.$image
		.addClass( 've-ce-imageNode' )
		.attr( 'alt', this.model.getAttribute( 'alt' ) )
		.attr( 'src', this.model.getAttribute( 'src' ) )
		.css( {
			'width': this.model.getAttribute( 'width' ),
			'height': this.model.getAttribute( 'height' )
		} );
};

/* Inheritance */

ve.inheritClass( ve.ce.ImageNode, ve.ce.LeafNode );

ve.mixinClass( ve.ce.ImageNode, ve.ce.FocusableNode );
ve.mixinClass( ve.ce.ImageNode, ve.ce.RelocatableNode );
ve.mixinClass( ve.ce.ImageNode, ve.ce.ResizableNode );

/* Static Properties */

ve.ce.ImageNode.static.name = 'image';

ve.ce.ImageNode.static.tagName = 'img';

/* Methods */

/**
 * Handle attribute change events.
 *
 * Whitelisted attributes will be added or removed in sync with the DOM. They are initially set in
 * the constructor.
 *
 * @method
 * @param {string} key Attribute key
 * @param {string} from Old value
 * @param {string} to New value
 */
ve.ce.ImageNode.prototype.onAttributeChange = function ( key, from, to ) {
	if ( from !== to ) {
		if ( key === 'src' ) {
			this.$image.attr( 'src', to );
		}
		if ( key === 'width' || key === 'height' ) {
			this.$image.css( key, to );
		}
	}
};

/**
 * Update method
 *
 * @method
 */
ve.ce.ImageNode.prototype.onUpdate = function () {
};

/**
 * Handle the mouse click.
 *
 * @method
 * @param {jQuery.Event} e Click event
 */
ve.ce.ImageNode.prototype.onClick = function ( e ) {
	var surfaceModel = this.getRoot().getSurface().getModel(),
		selectionRange = surfaceModel.getSelection(),
		nodeRange = this.model.getOuterRange();

	surfaceModel.getFragment(
		e.shiftKey ?
			ve.Range.newCoveringRange(
				[ selectionRange, nodeRange ], selectionRange.from > nodeRange.from
			) :
			nodeRange
	).select();
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.ImageNode );
