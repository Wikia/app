/*!
 * VisualEditor ContentEditable MWInlineImageNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki image node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.MWImageNode
 *
 * @constructor
 * @param {ve.dm.MWInlineImageNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWInlineImageNode = function VeCeMWInlineImageNode( model, config ) {
	var valign;

	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	if ( this.model.getAttribute( 'isLinked' ) ) {
		this.$element = this.$( '<a>' ).addClass( 'image' );
		this.$image = this.$( '<img>' ).appendTo( this.$element );
	} else {
		// For inline images that are not linked (empty linkto=) we intentionally don't match output
		// of MW Parser, instead we wrap those images in span so selection and hover (based on
		// shields) can work well. It might change in the future when we improve our selection.
		this.$element = this.$( '<span>' );
		this.$image = this.$( '<img>' ).appendTo( this.$element );
	}

	// Mixin constructors
	ve.ce.MWImageNode.call( this, this.$element, this.$image );

	this.$image
		.attr( 'src', this.getResolvedAttribute( 'src' ) )
		.attr( 'width', this.model.getAttribute( 'width' ) )
		.attr( 'height', this.model.getAttribute( 'height' ) );

	if ( this.model.getAttribute( 'border' ) ) {
		this.$image.addClass( 'thumbborder' );
	}

	valign = this.model.getAttribute( 'valign' );
	if ( valign !== 'default' ) {
		this.$image.css( 'vertical-align', valign );
	}

	// DOM changes
	this.$element.addClass( 've-ce-mwInlineImageNode' );

	// Events
	this.model.connect( this, { 'attributeChange': 'onAttributeChange' } );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWInlineImageNode, ve.ce.LeafNode );

// Need to mixin base class as well
OO.mixinClass( ve.ce.MWInlineImageNode, ve.ce.GeneratedContentNode );

OO.mixinClass( ve.ce.MWInlineImageNode, ve.ce.MWImageNode );

/* Static Properties */

ve.ce.MWInlineImageNode.static.name = 'mwInlineImage';

/* Methods */

/**
 * Update the rendering of the 'src', 'width' and 'height' attributes when they change in the model.
 *
 * @method
 * @param {string} key Attribute key
 * @param {string} from Old value
 * @param {string} to New value
 */
ve.ce.MWInlineImageNode.prototype.onAttributeChange = function ( key, from, to ) {
	if ( key === 'height' || key === 'width' ) {
		to = parseInt( to, 10 );
	}

	if ( from !== to ) {
		switch ( key ) {
			// TODO: 'align', 'src', 'valign', 'border'
			case 'width':
				this.$image.css( 'width', to );
				break;
			case 'height':
				this.$image.css( 'height', to );
				break;
		}
	}
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWInlineImageNode );
