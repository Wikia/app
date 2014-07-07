/*!
 * VisualEditor ContentEditable MWBlockImageNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki image node.
 *
 * @class
 * @extends ve.ce.BranchNode
 * @mixins ve.ce.MWImageNode
 *
 * @constructor
 * @param {ve.dm.MWBlockImageNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWBlockImageNode = function VeCeMWBlockImageNode( model, config ) {
	var type, align;

	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	type = this.model.getAttribute( 'type' );
	align = this.model.getAttribute( 'align' );

	// Properties
	this.captionVisible = false;
	this.typeToRdfa = this.getTypeToRdfa();

	// DOM Hierarchy for BlockImageNode:
	// <div> this.$element
	//   <figure> this.$figure (ve-ce-mwBlockImageNode-{type})
	//     <a> this.$a
	//       <img> this.$image
	//     <figcaption> this.caption.view.$element

	// Build DOM:
	this.$a = this.$( '<a>' )
		.addClass( 'image' )
		.attr( 'href', this.getResolvedAttribute( 'href' ) );

	this.$image = this.$( '<img>' )
		.attr( 'src', this.getResolvedAttribute( 'src' ) )
		.appendTo( this.$a );

	this.$figure = this.$( '<figure>' )
		.appendTo( this.$element )
		.append( this.$a )
		.addClass( 've-ce-mwBlockImageNode ve-ce-mwBlockImageNode-type-' + type )
		// 'typeof' should appear with the proper Parsoid-generated
		// type. The model deals with converting it
		.attr( 'typeof', this.typeToRdfa[ type ] );

	this.updateCaption();

	this.updateSize();

	// Mixin constructors
	ve.ce.MWImageNode.call( this, this.$figure, this.$image );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWBlockImageNode, ve.ce.BranchNode );

// Need to mixin base class as well
OO.mixinClass( ve.ce.MWBlockImageNode, ve.ce.GeneratedContentNode );

OO.mixinClass( ve.ce.MWBlockImageNode, ve.ce.MWImageNode );

/* Static Properties */

ve.ce.MWBlockImageNode.static.name = 'mwBlockImage';

ve.ce.MWBlockImageNode.static.tagName = 'div';

ve.ce.MWBlockImageNode.static.renderHtmlAttributes = false;

ve.ce.MWBlockImageNode.static.transition = false;

ve.ce.MWBlockImageNode.static.cssClasses = {
	'default': {
		'left': 'mw-halign-left',
		'right': 'mw-halign-right',
		'center': 'mw-halign-center',
		'none': 'mw-halign-none'
	},
	'none': {
		'left': 'mw-halign-left',
		'right': 'mw-halign-right',
		'center': 'mw-halign-center',
		'none': 'mw-halign-none'
	}
};

/* Methods */

/**
 * Set up an object that converts from the type to rdfa, based
 *  on the rdfaToType object in the model.
 * @returns {Object.<string,string>} A type to Rdfa conversion object
 */
ve.ce.MWBlockImageNode.prototype.getTypeToRdfa = function () {
	var rdfa, obj = {};

	for ( rdfa in this.model.constructor.static.rdfaToType ) {
		obj[ this.model.constructor.static.rdfaToType[rdfa] ] = rdfa;
	}
	return obj;
};

/**
 * Update the caption based on the current model state
 */
ve.ce.MWBlockImageNode.prototype.updateCaption = function () {
	var model, view,
		type = this.model.getAttribute( 'type' );

	this.captionVisible = type !== 'none' &&
		type !== 'frameless' &&
		type !== 'border' &&
		this.model.children.length === 1;

	if ( this.captionVisible ) {
		// Only create a caption if we need it
		if ( !this.$caption ) {
			model = this.model.children[0];
			view = ve.ce.nodeFactory.create( model.getType(), model );
			model.connect( this, { 'update': 'onModelUpdate' } );
			this.children.push( view );
			view.attach( this );
			if ( this.live !== view.isLive() ) {
				view.setLive( this.live );
			}
			this.$caption = view.$element;
			this.$figure.append( this.$caption );
		}
	}
	if ( this.$caption ) {
		// Don't use show() as it sets display to block, overriding the stylesheet.
		this.$caption.css( 'display', this.captionVisible ? '' : 'none' );
	}
};

/**
 * Update CSS classes based on alignment and type
 *
 * @param {string} [oldAlign] The old alignment, for removing classes
 */
ve.ce.MWBlockImageNode.prototype.updateClasses = function ( oldAlign ) {
	var alignClass,
		align = this.model.getAttribute( 'align' ),
		type = this.model.getAttribute( 'type' );

	if ( oldAlign && oldAlign !== align ) {
		// Remove previous alignment
		this.$figure
			.removeClass( this.getCssClass( 'none', oldAlign ) )
			.removeClass( this.getCssClass( 'default', oldAlign ) );
	}

	if ( type !== 'none' && type !== 'frameless' ) {
		alignClass = this.getCssClass( 'default', align );
		this.$image.addClass( 've-ce-mwBlockImageNode-thumbimage' );
		this.$figure.addClass( 've-ce-mwBlockImageNode-borderwrap' );
	} else {
		alignClass = this.getCssClass( 'none', align );
		this.$image.removeClass( 've-ce-mwBlockImageNode-thumbimage' );
		this.$figure.removeClass( 've-ce-mwBlockImageNode-borderwrap' );
	}
	this.$figure.addClass( alignClass );

	// Border
	this.$figure.toggleClass( 'mw-image-border', !!this.model.getAttribute( 'borderImage' ) );

	switch ( alignClass ) {
		case 'mw-halign-right':
			this.showHandles( ['sw'] );
			break;
		case 'mw-halign-left':
			this.showHandles( ['se'] );
			break;
		case 'mw-halign-center':
			this.showHandles( ['sw', 'se'] );
			break;
		default:
			this.showHandles();
			break;
	}
};

/**
 * Redraw the image and its wrappers at the specified dimensions
 *
 * The current dimensions from the model are used if none are specified.
 *
 * @param {Object} [dimensions] Dimension object containing width & height
 */
ve.ce.MWBlockImageNode.prototype.updateSize = function ( dimensions ) {
	if ( !dimensions ) {
		dimensions = {
			'width': this.model.getAttribute( 'width' ),
			'height': this.model.getAttribute( 'height' )
		};
	}

	this.$image.css( dimensions );

	// Make sure $figure is sharing the dimensions, otherwise 'middle' and 'none'
	// positions don't work properly
	this.$figure.css( {
		'width': dimensions.width + ( this.captionVisible ? 2 : 0 ),
		'height': this.captionVisible ? 'auto' : dimensions.height
	} );
	this.$figure.toggleClass( 'mw-default-size', !!this.model.getAttribute( 'defaultSize' ) );
};

/**
 * Get the right CSS class to use for alignment
 *
 * @param {string} type 'none' or 'default'
 * @param {string} alignment 'left', 'right', 'center', 'none' or 'default'
 */
ve.ce.MWBlockImageNode.prototype.getCssClass = function ( type, alignment ) {
	// TODO use this.model.getAttribute( 'type' ) etc., see bug 52065
	// Default is different between RTL and LTR wikis:
	if ( type === 'default' && alignment === 'default' ) {
		if ( this.$element.css( 'direction' ) === 'rtl' ) {
			return 'mw-halign-left';
		} else {
			return 'mw-halign-right';
		}
	} else {
		return this.constructor.static.cssClasses[type][alignment];
	}
};

/**
 * Override the default onSetup to add direction-dependent
 * classes to the image thumbnail.
 *
 * @method
 */
ve.ce.MWBlockImageNode.prototype.onSetup = function () {
	// Parent method
	ve.ce.BranchNode.prototype.onSetup.call( this );

	this.updateClasses();
};

/**
 * @inheritdoc
 */
ve.ce.MWBlockImageNode.prototype.onAttributeChange = function ( key, from, to ) {
	if ( key === 'height' || key === 'width' ) {
		to = parseInt( to, 10 );
	}

	if ( from !== to ) {
		switch ( key ) {
			case 'align':
				this.updateClasses( from );
				break;
			case 'src':
				this.$image.attr( 'src', this.getResolvedAttribute( 'src' ) );
				break;
			case 'width':
				this.updateSize( {
					'width': to,
					'height': this.model.getAttribute( 'height' )
				} );
				break;
			case 'height':
				this.updateSize( {
					'width': this.model.getAttribute( 'width' ),
					'height': to
				} );
				break;
			case 'type':
				this.$figure
					.removeClass( 've-ce-mwBlockImageNode-type-' + from )
					.addClass( 've-ce-mwBlockImageNode-type-' + to )
					.attr( 'typeof', this.typeToRdfa[ to ] );

				this.updateClasses();
				this.updateCaption();
				break;
			// Other image attributes if they exist
			case 'alt':
				if ( !to ) {
					this.$image.removeAttr( key );
				} else {
					this.$image.attr( key, to );
				}
				break;
			case 'defaultSize':
				this.$figure.toggleClass( 'mw-default-size', to );
				break;
		}
	}
};

/** */
ve.ce.MWBlockImageNode.prototype.onResizableResizing = function ( dimensions ) {
	if ( !this.outline ) {
		ve.ce.ResizableNode.prototype.onResizableResizing.call( this, dimensions );

		this.updateSize( dimensions );
	}
};

/** */
ve.ce.MWBlockImageNode.prototype.setupSlugs = function () {
	// Intentionally empty
};

/** */
ve.ce.MWBlockImageNode.prototype.onSplice = function () {
	// Intentionally empty
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWBlockImageNode );
