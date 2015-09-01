/*!
 * VisualEditor DataModel MWImageNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * DataModel MediaWiki image node.
 *
 * @class
 * @abstract
 * @extends ve.dm.GeneratedContentNode
 * @mixins ve.dm.FocusableNode
 * @mixins ve.dm.ResizableNode
 *
 * @constructor
 */
ve.dm.MWImageNode = function VeDmMWImageNode() {
	// Parent constructor
	ve.dm.GeneratedContentNode.call( this );

	// Mixin constructors
	ve.dm.ResizableNode.call( this );
	ve.dm.FocusableNode.call( this );

	this.scalablePromise = null;

	// Use 'bitmap' as default media type until we can
	// fetch the actual media type from the API
	this.mediaType = 'BITMAP';
	// Get wiki defaults
	this.svgMaxSize = mw.config.get( 'wgVisualEditorConfig' ).svgMaxSize;

	// Initialize
	this.constructor.static.syncScalableToType(
		this.getAttribute( 'type' ),
		this.mediaType,
		this.getScalable()
	);

	// Events
	this.connect( this, { attributeChange: 'onAttributeChange' } );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWImageNode, ve.dm.GeneratedContentNode );

OO.mixinClass( ve.dm.MWImageNode, ve.dm.FocusableNode );

OO.mixinClass( ve.dm.MWImageNode, ve.dm.ResizableNode );

/* Static methods */

ve.dm.MWImageNode.static.getHashObject = function ( dataElement ) {
	return {
		type: dataElement.type,
		resource: dataElement.attributes.resource,
		width: dataElement.attributes.width,
		height: dataElement.attributes.height
	};
};

/**
 * Take the given dimensions and scale them to thumbnail size.
 *
 * @param {Object} dimensions Width and height of the image
 * @param {string} [mediaType] Media type 'DRAWING' or 'BITMAP'
 * @return {Object} The new width and height of the scaled image
 */
ve.dm.MWImageNode.static.scaleToThumbnailSize = function ( dimensions, mediaType ) {
	var defaultThumbSize = mw.config.get( 'wgVisualEditorConfig' ).defaultUserOptions.defaultthumbsize;

	mediaType = mediaType || 'BITMAP';

	if ( dimensions.width && dimensions.height ) {
		// Use dimensions
		// Resize to default thumbnail size, but only if the image itself
		// isn't smaller than the default size
		// For svg/drawings, the default wiki size is always applied
		if ( dimensions.width > defaultThumbSize || mediaType === 'DRAWING' ) {
			return ve.dm.Scalable.static.getDimensionsFromValue( {
				width: defaultThumbSize
			}, dimensions.width / dimensions.height );
		}
	}
	return dimensions;
};

/**
 * Translate the image dimensions into new ones according to the bounding box.
 *
 * @param {Object} imageDimensions Width and height of the image
 * @param {Object} boundingBox The limit of the bounding box
 * @return {Object} The new width and height of the scaled image.
 */
ve.dm.MWImageNode.static.resizeToBoundingBox = function ( imageDimensions, boundingBox ) {
	var newDimensions = ve.copy( imageDimensions ),
		scale = Math.min(
			boundingBox.height / imageDimensions.height,
			boundingBox.width / imageDimensions.width
		);

	if ( scale < 1 ) {
		// Scale down
		newDimensions = {
			width: Math.floor( newDimensions.width * scale ),
			height: Math.floor( newDimensions.height * scale )
		};
	}
	return newDimensions;
};

/**
 * Update image scalable properties according to the image type.
 *
 * @param {string} type The new image type
 * @param {string} mediaType Image media type 'DRAWING' or 'BITMAP'
 * @param {ve.dm.Scalable} scalable The scalable object to update
 */
ve.dm.MWImageNode.static.syncScalableToType = function ( type, mediaType, scalable ) {
	var originalDimensions, dimensions,
		defaultThumbSize = mw.config.get( 'wgVisualEditorConfig' ).defaultUserOptions.defaultthumbsize;

	originalDimensions = scalable.getOriginalDimensions();

	// We can only set default dimensions if we have the original ones
	if ( originalDimensions ) {
		if ( type === 'thumb' || type === 'frameless' ) {
			// Set the default size to that in the wiki configuration if
			// 1. The original image width is not smaller than the default
			// 2. If the image is an SVG drawing
			if ( originalDimensions.width >= defaultThumbSize || mediaType === 'DRAWING' ) {
				dimensions = ve.dm.Scalable.static.getDimensionsFromValue( {
					width: defaultThumbSize
				}, scalable.getRatio() );
			} else {
				dimensions = ve.dm.Scalable.static.getDimensionsFromValue(
					originalDimensions,
					scalable.getRatio()
				);
			}
			scalable.setDefaultDimensions( dimensions );
		} else {
			scalable.setDefaultDimensions( originalDimensions );
		}
	}

	// Deal with maximum dimensions for images and drawings
	if ( mediaType !== 'DRAWING' ) {
		if ( originalDimensions ) {
			scalable.setMaxDimensions( originalDimensions );
			scalable.setEnforcedMax( true );
		} else {
			scalable.setEnforcedMax( false );
		}
	}
	// TODO: Some day, when svgMaxSize works properly in MediaWiki
	// we can add it back as max dimension consideration.
};

/**
 * Get the scalable promise which fetches original dimensions from the API
 *
 * @param {string} filename The image filename whose details the scalable will represent
 * @return {jQuery.Promise} Promise which resolves after the image size details are fetched from the API
 */
ve.dm.MWImageNode.static.getScalablePromise = function ( filename ) {
	// On the first call set off an async call to update the scalable's
	// original dimensions from the API.
	if ( ve.init.platform.imageInfoCache ) {
		return ve.init.platform.imageInfoCache.get( filename ).then( function ( info ) {
			if ( !info ) {
				return $.Deferred().reject().promise();
			}
			return info;
		} );
	} else {
		return $.Deferred().reject().promise();
	}
};

/* Methods */

/**
 * Respond to attribute change.
 * Update the rendering of the 'align', src', 'width' and 'height' attributes
 * when they change in the model.
 *
 * @method
 * @param {string} key Attribute key
 * @param {string} from Old value
 * @param {string} to New value
 */
ve.dm.MWImageNode.prototype.onAttributeChange = function ( key, from, to ) {
	if ( key === 'type' ) {
		this.constructor.static.syncScalableToType( to, this.mediaType, this.getScalable() );
	}
};

/**
 * Get the normalised filename of the image
 *
 * @return {string} Filename
 */
ve.dm.MWImageNode.prototype.getFilename = function () {
	// Strip ./ stuff and decode URI encoding
	var resource = this.getAttribute( 'resource' ) || '',
		filename = resource.replace( /^(\.+\/)*/, '' );

	return ve.safeDecodeURIComponent( filename );
};

/**
 * Get the store hash for the original dimensions of the image
 *
 * @return {string} Store hash
 */
ve.dm.MWImageNode.prototype.getSizeHash = function () {
	return 'MWImageOriginalSize:' + this.getFilename();
};

/**
 * @inheritdoc
 */
ve.dm.MWImageNode.prototype.getScalable = function () {
	var imageNode = this;
	if ( !this.scalablePromise ) {
		this.scalablePromise = ve.dm.MWImageNode.static.getScalablePromise( this.getFilename() );
		// If the promise was already resolved before getScalablePromise returned, then jQuery will execute the done straight away.
		// So don't just do getScalablePromise( ... ).done because we need to make sure that this.scalablePromise gets set first.
		this.scalablePromise.done( function ( info ) {
			if ( info ) {
				imageNode.getScalable().setOriginalDimensions( {
					width: info.width,
					height: info.height
				} );
				// Update media type
				imageNode.mediaType = info.mediatype;
				// Update according to type
				imageNode.constructor.static.syncScalableToType(
					imageNode.getAttribute( 'type' ),
					imageNode.mediaType,
					imageNode.getScalable()
				);
			}
		} );
	}
	// Parent method
	return ve.dm.ResizableNode.prototype.getScalable.call( this );
};

/**
 * @inheritdoc
 */
ve.dm.MWImageNode.prototype.createScalable = function () {
	return new ve.dm.Scalable( {
		currentDimensions: {
			width: this.getAttribute( 'width' ),
			height: this.getAttribute( 'height' )
		},
		minDimensions: {
			width: 1,
			height: 1
		}
	} );
};

/**
 * Get symbolic name of media type.
 *
 * Example values: "BITMAP" for JPEG or PNG images; "DRAWING" for SVG graphics
 *
 * @return {string|undefined} Symbolic media type name, or undefined if empty
 */
ve.dm.MWImageNode.prototype.getMediaType = function () {
	return this.mediaType;
};
