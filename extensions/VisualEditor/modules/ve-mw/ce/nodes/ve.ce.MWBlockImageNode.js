/*!
 * VisualEditor ContentEditable MWBlockImageNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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
	var captionModel, captionView, type;

	// Parent constructor
	ve.ce.BranchNode.call( this, model, config );

	type = this.model.getAttribute( 'type' );

	if ( this.model.getAttribute( 'align' ) === 'center' ) {
		this.$element.addClass( 'center' );
		this.$thumb = this.$( '<div>' ).appendTo( this.$element );
	} else {
		this.$thumb = this.$element;
	}

	this.$thumbInner = this.$( '<div>' )
		.addClass( 'thumbinner' )
		.css( 'width', parseInt( this.model.getAttribute( 'width' ), 10 ) + 2 );

	this.$a = this.$( '<a>' )
		.addClass( 'image' )
		.attr( 'href', this.getResolvedAttribute( 'href' ) );

	this.$image = this.$( '<img>' )
		.attr( 'src', this.getResolvedAttribute( 'src' ) )
		.attr( 'width', this.model.getAttribute( 'width' ) )
		.attr( 'height', this.model.getAttribute( 'height' ) )
		.appendTo( this.$a );

	this.$inner = this.$( '<div>' ).addClass( 've-ce-mwBlockImageNode-inner' );

	if ( type === 'none' || type === 'frameless' ) {
		this.$thumb.addClass(
			this.getCssClass( 'none', this.model.getAttribute( 'align' ) )
		);
		this.$a.appendTo( this.$thumb );

		// For centered images, this.$thumb is full width, so wrap
		// this.$image in another div and use that for selection
		this.$inner
			.append( this.$image )
			.appendTo( this.$a );
	} else {
		// Type "frame", "thumb" and the default
		this.$image.addClass( 'thumbimage' );
		this.$thumb
			.addClass( 'thumb' );
		this.$a.appendTo( this.$thumbInner );
		this.$thumbInner.appendTo( this.$thumb );

		// For centered images, this.$thumb is full width, so wrap
		// this.$thumbInner in another div and use that for selection
		this.$inner
			.append( this.$thumbInner )
			.appendTo( this.$thumb );
	}

	// Mixin constructors
	ve.ce.MWImageNode.call( this, this.$inner, this.$image );

	// I smell a caption!
	if ( type !== 'none' && type !== 'frameless' && this.model.children.length === 1 ) {
		captionModel = this.model.children[0];
		captionView = ve.ce.nodeFactory.create( captionModel.getType(), captionModel );
		captionModel.connect( this, { 'update': 'onModelUpdate' } );
		this.children.push( captionView );
		captionView.attach( this );
		captionView.$element.appendTo( this.$thumbInner );
		if ( this.live !== captionView.isLive() ) {
			captionView.setLive( this.live );
		}
	}

	// Events
	this.model.connect( this, { 'attributeChange': 'onAttributeChange' } );
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
		'left': 'tleft',
		'right': 'tright',
		'center' : 'tnone',
		'none' : 'tnone'
	},
	'none': {
		'left': 'floatleft',
		'right': 'floatright',
		'center' : 'floatnone',
		'none' : 'floatnone'
	}
};

/* Methods */

/**
 * Get the right CSS class to use for alignment
 * @param {string} type 'none' or 'default'
 * @param {string} alignment 'left', 'right', 'center', 'none' or 'default'
 */
ve.ce.MWBlockImageNode.prototype.getCssClass = function ( type, alignment ) {
	// TODO use this.model.getAttribute( 'type' ) etc., see bug 52065
	// Default is different between RTL and LTR wikis:
	if ( type === 'default' && alignment === 'default' ) {
		if ( this.$element.css( 'direction' ) === 'rtl' ) {
			return 'tleft';
		} else {
			return 'tright';
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
	var type = this.model.getAttribute( 'type' );

	ve.ce.BranchNode.prototype.onSetup.call( this );

	if ( type !== 'none' && type !=='frameless' ) {
		this.$thumb.addClass( this.getCssClass( 'default', this.model.getAttribute( 'align' ) ) );
	}

};

/**
 * Update the rendering of the 'align', src', 'width' and 'height' attributes when they change
 * in the model.
 *
 * @method
 * @param {string} key Attribute key
 * @param {string} from Old value
 * @param {string} to New value
 * @fires setup
 */
ve.ce.MWBlockImageNode.prototype.onAttributeChange = function ( key, from, to ) {
	var $wrapper, type;

	if ( key === 'height' || key === 'width' ) {
		to = parseInt( to, 10 );
	}

	if ( from !== to ) {
		switch ( key ) {
			case 'align':
				if ( to === 'center' || from === 'center' ) {
					this.emit( 'teardown' );
					if ( to === 'center' ) {
						$wrapper = this.$( '<div>' ).addClass( 'center' );
						this.$thumb = this.$element;
						this.$element.replaceWith( $wrapper );
						this.$element = $wrapper;
						this.$element.append( this.$thumb );
					} else {
						this.$element.replaceWith( this.$thumb );
						this.$element = this.$thumb;
					}
					this.emit( 'setup' );
				}
				type = this.model.getAttribute( 'type' );
				if ( type === 'none' || type === 'frameless' ) {
					this.$thumb.removeClass( this.getCssClass( 'none', from ) );
					this.$thumb.addClass( this.getCssClass( 'none', to ) );
				} else {
					this.$thumb.removeClass( this.getCssClass( 'default', from ) );
					this.$thumb.addClass( this.getCssClass( 'default', to ) );
				}
				break;
			case 'src':
				this.$image.attr( 'src', this.getResolvedAttribute( 'src' ) );
				break;
			case 'width':
				this.$thumbInner.css( 'width', to + 2 );
				this.$image.css( 'width', to );
				break;
			case 'height':
				this.$image.css( 'height', to );
				break;
		}
	}
};

/** */
ve.ce.MWBlockImageNode.prototype.onResizableResizing = function ( dimensions ) {
	if ( !this.outline ) {
		ve.ce.ResizableNode.prototype.onResizableResizing.call( this, dimensions );
		this.$thumbInner.css( 'width', dimensions.width + 2 );
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
