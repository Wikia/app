/*!
 * VisualEditor ContentEditable ImageNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable image node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.ResizableNode
 *
 * @constructor
 * @param {ve.dm.ImageNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.ImageNode = function VeCeImageNode( model, config ) {
	config = ve.extendObject( {
		'minDimensions': { 'width': 1, 'height': 1 }
	}, config );

	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// Properties
	this.$image = this.$( '<img>' ).appendTo( this.$element );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );
	ve.ce.ResizableNode.call( this, this.$image, config );

	// Events
	this.$element.on( 'click', ve.bind( this.onClick, this ) );
	this.$image.on( 'load', ve.bind( this.onLoad, this ) );
	this.model.connect( this, { 'attributeChange': 'onAttributeChange' } );

	// Initialization
	this.$element.addClass( 've-ce-imageNode' );
	this.$image
		.attr( {
			'alt': this.model.getAttribute( 'alt' ),
			'src': this.getResolvedAttribute( 'src' )
		} )
		.css( {
			'width': this.model.getAttribute( 'width' ),
			'height': this.model.getAttribute( 'height' )
		} );
};

/* Inheritance */

OO.inheritClass( ve.ce.ImageNode, ve.ce.LeafNode );

OO.mixinClass( ve.ce.ImageNode, ve.ce.FocusableNode );
OO.mixinClass( ve.ce.ImageNode, ve.ce.ResizableNode );

/* Static Properties */

ve.ce.ImageNode.static.name = 'image';

ve.ce.ImageNode.static.tagName = 'span';

/* Methods */

/**
 * Update the rendering of the 'src', 'width' and 'height' attributes when they change in the model.
 *
 * @method
 * @param {string} key Attribute key
 * @param {string} from Old value
 * @param {string} to New value
 */
ve.ce.ImageNode.prototype.onAttributeChange = function ( key, from, to ) {
	if ( key === 'src' ) {
		this.$image.attr( 'src', this.getResolvedAttribute( 'src' ) );
	}
	if ( key === 'width' || key === 'height' ) {
		this.$image.css( key, to );
	}
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

/**
 * Handle the image load
 *
 * @method
 * @param {jQuery.Event} e Load event
 */
ve.ce.ImageNode.prototype.onLoad = function () {
	this.setOriginalDimensions( {
		'width': this.$image.prop( 'naturalWidth' ),
		'height': this.$image.prop( 'naturalHeight' )
	} );
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.ImageNode );
