/*!
 * VisualEditor DataModel MWImageNode class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
/*global mw */

/**
 * DataModel generated content node.
 *
 * @class
 * @abstract
 * @extends ve.dm.GeneratedContentNode
 * @mixins ve.dm.ResizableNode
 *
 * @constructor
 */
ve.dm.MWImageNode = function VeDmMWImageNode() {
	// Parent constructor
	ve.dm.GeneratedContentNode.call( this );
	// Mixin constructor
	ve.dm.ResizableNode.call( this );

	this.scalablePromise = null;

	// Use 'bitmap' as default media type until we can
	// fetch the actual media type from the API
	this.mediaType = 'BITMAP';
	// Get wiki defaults
	this.svgMaxSize = mw.config.get( 'wgVisualEditor' ).svgMaxSize;
	this.defaultThumbSize = mw.config.get( 'wgVisualEditorConfig' ).defaultUserOptions.defaultthumbsize;

	// Initialize
	this.syncScalableToType( this.getAttribute( 'type' ) );

	// Events
	this.connect( this, { 'attributeChange': 'onAttributeChange' } );
};

/* Inheritance */

OO.inheritClass( ve.dm.MWImageNode, ve.dm.GeneratedContentNode );

OO.mixinClass( ve.dm.MWImageNode, ve.dm.ResizableNode );

/* Methods */

/**
 * Update image scalable properties according to the image type.
 *
 * @param {string} type The new image type
 */
ve.dm.MWImageNode.prototype.syncScalableToType = function ( type ) {
	var originalDimensions, dimensions,
		scalable = this.getScalable(),
		width = this.getAttribute( 'width' ),
		height = this.getAttribute( 'height' );

	// If no type is given, assume we are updating per current type
	type = type || this.getAttribute( 'type' );

	originalDimensions = scalable.getOriginalDimensions();

	// Deal with the different default sizes
	if ( type === 'thumb' || type === 'frameless' ) {
		// Set the default size to that in the wiki configuration if
		// 1. The image width is not smaller than the default
		// 2. If the image is an SVG drawing
		if ( width >= this.defaultThumbSize || this.getMediaType() === 'DRAWING' ) {
			dimensions = this.scalable.getDimensionsFromValue( {
				'width': this.defaultThumbSize
			} );
		} else {
			dimensions = this.scalable.getDimensionsFromValue( {
				'width': width
			} );
		}
		scalable.setDefaultDimensions( dimensions );
	} else {
		if ( originalDimensions ) {
			scalable.setDefaultDimensions( originalDimensions );
		}
	}

	// Deal with maximum dimensions for images and drawings
	if ( this.getMediaType() !== 'DRAWING' ) {
		if ( originalDimensions ) {
			scalable.setMaxDimensions( originalDimensions );
			scalable.setEnforcedMax( true );
		} else {
			scalable.setEnforcedMax( false );
		}
	} else {
		// Set max to svgMaxSize on the shortest side
		if ( width < height ) {
			dimensions = scalable.getDimensionsFromValue( {
				'width': this.svgMaxSize
			} );
		} else {
			dimensions = scalable.getDimensionsFromValue( {
				'height': this.svgMaxSize
			} );
		}
		scalable.setMaxDimensions( dimensions );
		scalable.setEnforcedMax( true );
	}
};
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
		this.syncScalableToType( to );
	}
};

/**
 * Get the normalised filename of the image
 *
 * @returns {string} Filename
 */
ve.dm.MWImageNode.prototype.getFilename = function () {
	return ve.dm.MWImageNode.static.getFilenameFromResource( this.getAttribute( 'resource' ) );
};

/**
 * Get the store hash for the original dimensions of the image
 *
 * @returns {string} Store hash
 */
ve.dm.MWImageNode.prototype.getSizeHash = function () {
	return 'MWImageOriginalSize:' + this.getFilename();
};

/* Static methods */

ve.dm.MWImageNode.static.getHashObject = function ( dataElement ) {
	return {
		'type': dataElement.type,
		'resource': dataElement.attributes.resource,
		'width': dataElement.attributes.width,
		'height': dataElement.attributes.height
	};
};

ve.dm.MWImageNode.static.getFilenameFromResource = function ( resource ) {
	// Strip ./ stuff and decode URI encoding
	var filename = resource.replace( /^(.+\/)*/, '' );
	// Protect against decodeURIComponent() throwing exceptions
	try {
		filename = decodeURIComponent( filename );
	} catch ( e ) {
		ve.log( 'URI decoding exception', e );
	}
	return filename;
};

/**
 * @inheritdoc
 */
ve.dm.MWImageNode.prototype.getScalable = function () {
	this.getScalablePromise();
	// Parent method
	return ve.dm.ResizableNode.prototype.getScalable.call( this );
};

/**
 * Get the scalable promise which fetches original dimensions from the API
 *
 * @returns {jQuery.Promise} Promise which resolves setOriginalDimensions has been called (if required)
 */
ve.dm.MWImageNode.prototype.getScalablePromise = function () {
	// On the first call set off an async call to update the scalable's
	// original dimensions from the API.
	if ( !this.scalablePromise ) {
		this.scalablePromise = ve.init.target.constructor.static.apiRequest(
			{
				'action': 'query',
				'prop': 'imageinfo',
				'indexpageids': '1',
				'iiprop': 'size|mediatype',
				'titles': this.getFilename()
			},
			{ 'type': 'POST' }
		).then( ve.bind( function ( response ) {
			var page = response.query && response.query.pages[response.query.pageids[0]],
				info = page && page.imageinfo && page.imageinfo[0];

			if ( info ) {
				this.getScalable().setOriginalDimensions( {
					'width': info.width,
					'height': info.height
				} );
				// Update media type
				this.mediaType = info.mediatype;
				// Update according to type
				this.syncScalableToType();
			}
		}, this ) ).promise();
	}
	return this.scalablePromise;
};

/**
 * @inheritdoc
 */
ve.dm.MWImageNode.prototype.createScalable = function () {
	return new ve.dm.Scalable( {
		'currentDimensions': {
			'width': this.getAttribute( 'width' ),
			'height': this.getAttribute( 'height' )
		},
		'minDimensions': {
			'width': 1,
			'height': 1
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
