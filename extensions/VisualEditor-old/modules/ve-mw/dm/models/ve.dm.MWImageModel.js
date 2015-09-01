/*!
 * VisualEditor DataModel MWImageModel class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki image model.
 *
 * @class
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {string} [resourceName] The resource name of the given media file
 * @cfg {Object} [currentDimensions] Current dimensions, width & height
 * @cfg {Object} [minDimensions] Minimum dimensions, width & height
 * @cfg {boolean} [isDefaultSize] Object is using its default size dimensions
 */
ve.dm.MWImageModel = function VeDmMWImageModel( config ) {
	var scalable, currentDimensions, minDimensions;

	config = config || {};

	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.attributesCache = null;

	// Image properties
	this.captionDoc = null;
	this.caption = null;
	this.mediaType = null;
	this.altText = '';
	this.type = null;
	this.alignment = null;
	this.scalable = null;
	this.sizeType = null;
	this.border = false;
	this.borderable = false;
	this.dir = null;
	this.lang = null;
	this.defaultDimensions = null;

	this.imageSrc = '';
	this.imageResourceName = '';
	this.imageHref = '';

	this.boundingBox = null;
	this.initialHash = {};

	// Get wiki default thumbnail size
	this.defaultThumbSize = mw.config.get( 'wgVisualEditorConfig' )
		.defaultUserOptions.defaultthumbsize;

	if ( config.resourceName ) {
		this.setImageResourceName( config.resourceName );
	}

	// Create scalable
	currentDimensions = config.currentDimensions || {};
	minDimensions = config.minDimensions || {};

	scalable = new ve.dm.Scalable( {
		currentDimensions: {
			width: currentDimensions.width,
			height: currentDimensions.height
		},
		minDimensions: {
			width: minDimensions.width || 1,
			height: minDimensions.height || 1
		},
		defaultSize: !!config.isDefaultSize
	} );
	// Set the initial scalable, connect it to events
	// and request an update from the API
	this.attachScalable( scalable );
};

/* Inheritance */

OO.mixinClass( ve.dm.MWImageModel, OO.EventEmitter );

/* Events */

/**
 * Change of image alignment or of having alignment at all
 *
 * @event alignmentChange
 * @param {string} Alignment 'left', 'right', 'center' or 'none'
 */

/**
 * Change in size type between default and custom
 *
 * @event sizeDefaultChange
 * @param {boolean} Image is default size
 */

/**
 * Change in the image type
 *
 * @event typeChange
 * @param {string} Image type 'thumb', 'frame', 'frameless' or 'none'
 */

/* Static Properties */

ve.dm.MWImageModel.static.infoCache = {};

/* Static Methods */

/**
 * Create a new image node based on given parameters.
 * @param {Object} attributes Image attributes
 * @param {string} [imageType] Image node type 'mwInlineImage' or 'mwBlockImage'.
 *  Defaults to 'mwBlockImage'
 * @returns {ve.dm.MWImageNode} An image node
 */
ve.dm.MWImageModel.static.createImageNode = function ( attributes, imageType ) {
	var attrs, newNode, newDimensions,
		defaultThumbSize = mw.config.get( 'wgVisualEditorConfig' ).defaultUserOptions.defaultthumbsize;

	attrs = ve.extendObject( {
		type: 'thumb',
		align: 'default',
		width: defaultThumbSize,
		mediaType: 'BITMAP',
		defaultSize: true
	}, attributes );

	if ( attrs.defaultSize ) {
		newDimensions = ve.dm.MWImageNode.static.scaleToThumbnailSize( attrs, attrs.mediaType );
		if ( newDimensions ) {
			attrs.width = newDimensions.width;
			attrs.height = newDimensions.height;
		}
	}

	imageType = imageType || 'mwBlockImage';

	newNode = ve.dm.nodeFactory.create( imageType, {
		type: imageType,
		attributes: attrs
	} );

	ve.dm.MWImageNode.static.syncScalableToType( attrs.type, attrs.mediaType, newNode.getScalable() );

	return newNode;
};

/**
 * Load from image data with scalable information.
 *
 * @param {Object} attrs Image node attributes
 * @param {string} [dir] Document direction
 * @param {string} [lang] Document language
 * @return {ve.dm.MWImageModel} Image model
 */
ve.dm.MWImageModel.static.newFromImageAttributes = function ( attrs, dir, lang, isVideo ) {
	var imgModel = new ve.dm.MWImageModel( {
			resourceName: attrs.resource,
			currentDimensions: {
				width: attrs.width,
				height: attrs.height
			},
			defaultSize: !!attrs.defaultSize
		} );

	// Cache the attributes so we can create a new image without
	// losing any existing information
	imgModel.cacheOriginalImageAttributes( attrs );

	imgModel.setImageSource( attrs.src );
	imgModel.setImageHref( attrs.href );

	// Collect all the information
	imgModel.toggleBorder( !!attrs.borderImage );
	imgModel.setAltText( attrs.alt || '' );

	imgModel.setDir( dir );
	imgModel.setLang( lang );

	imgModel.setType( attrs.type );

	// Fix cases where alignment is undefined
	// Inline images have no 'align' (they have 'valign' instead)
	// But we do want an alignment case for these in case they
	// are transformed to block images
	imgModel.setAlignment( attrs.align || 'default' );

	// Default size
	imgModel.toggleDefaultSize( !!attrs.defaultSize );

	// TODO: When scale/upright is available, set the size
	// type accordingly
	imgModel.setSizeType(
		imgModel.isDefaultSize() ?
		'default' :
		'custom'
	);

	if ( isVideo ) {
		imgModel.setMediaType( 'VIDEO' );
	}

	return imgModel;
};

/* Methods */

/**
 * Get the hash object of the current image model state.
 * @returns {Object} Hash object
 */
ve.dm.MWImageModel.prototype.getHashObject = function () {
	var hash = {
		normalizedSource: this.getNormalizedImageSource(),
		altText: this.getAltText(),
		type: this.getType(),
		alignment: this.getAlignment(),
		sizeType: this.getSizeType(),
		border: this.hasBorder(),
		borderable: this.isBorderable()
	};

	if ( this.getScalable() ) {
		hash.scalable = {
			currentDimensions: ve.copy( this.getScalable().getCurrentDimensions() ),
			isDefault: this.getScalable().isDefault()
		};
	}
	return hash;
};

/**
 * Normalize the source url by stripping the protocol off.
 * This is done so when an image is replaced with the same image,
 * the imageModel can recognize that nothing has actually changed.
 *
 * Example:
 * 'http://upload.wikimedia.org/wikipedia/commons/0/Foo.png'
 * to '//upload.wikimedia.org/wikipedia/commons/0/Foo.png'
 *
 * @return {string} Normalized image source
 */
ve.dm.MWImageModel.prototype.getNormalizedImageSource = function () {
	// Strip the url prefix 'http' / 'https' etc
	return this.getImageSource().replace( /^https?:\/\//, '//' );
};

/**
 * Adjust the model parameters based on a new image
 * @param {Object} attrs New image source attributes
 * @param {Object} [dimensions] New dimensions of the image
 */
ve.dm.MWImageModel.prototype.changeImageSource = function ( attrs, dimensions ) {
	var newDimensions, remoteFilename,
		imageModel = this;

	if ( attrs.mediaType ) {
		this.setMediaType( attrs.mediaType );
	}
	if ( attrs.href ) {
		this.setImageHref( attrs.href );
	}
	if ( attrs.resource ) {
		this.setImageResourceName( attrs.resource );
		remoteFilename = attrs.resource.replace( /^(\.+\/)*/, '' );
	}

	if ( attrs.src ) {
		this.setImageSource( attrs.src );
	}

	// Remove the scalable default and original dimensions
	this.scalable.clearOriginalDimensions();
	this.scalable.clearDefaultDimensions();
	this.scalable.clearMaxDimensions();
	this.scalable.clearMinDimensions();

	// Call for updated scalable
	if ( remoteFilename ) {
		ve.dm.MWImageNode.static.getScalablePromise( remoteFilename ).done( function ( info ) {
			imageModel.scalable.setOriginalDimensions( {
				width: info.width,
				height: info.height
			} );
			// Update media type
			imageModel.setMediaType( info.mediatype );
			// Update defaults
			ve.dm.MWImageNode.static.syncScalableToType(
				imageModel.getType(),
				info.mediatype,
				imageModel.scalable
			);
		} );
	}

	// Resize the new image's current dimensions to default or based on the bounding box
	if ( this.isDefaultSize() ) {
		// Scale to default
		newDimensions = ve.dm.MWImageNode.static.scaleToThumbnailSize( dimensions );
	} else {
		if ( this.getBoundingBox() ) {
			// Scale the new image by its width
			newDimensions = ve.dm.MWImageNode.static.resizeToBoundingBox(
				dimensions,
				this.boundingBox,
				true
			);
		} else {
			newDimensions = dimensions;
		}
	}

	if ( newDimensions ) {
		this.getScalable().setCurrentDimensions( newDimensions );
	}
};

/**
 * Get the current image node type according to the attributes.
 * If either of the parameters are given, the node type is tested
 * against them, otherwise, it is tested against the current image
 * parameters.
 *
 * @param {string} [imageType] Optional. Image type.
 * @param {string} [align] Optional. Image alignment.
 * @return {string} Node type 'mwInlineImage' or 'mwBlockImage'
 */
ve.dm.MWImageModel.prototype.getImageNodeType = function ( imageType, align ) {
	imageType = imageType || this.getType();

	if (
		( this.getType() === 'frameless' || this.getType() === 'none' ) &&
		( !this.isAligned( align ) || this.isDefaultAligned( imageType, align ) )
	) {
		return this.getMediaType() === 'VIDEO' ? 'wikiaInlineVideo' : 'mwInlineImage';
	} else {
		return this.getMediaType() === 'VIDEO' ? 'wikiaBlockVideo' : 'wikiaBlockImage';
	}
};

/**
 * Get the original bounding box
 * @returns {Object} Bounding box with width and height
 */
ve.dm.MWImageModel.prototype.getBoundingBox = function () {
	return this.boundingBox;
};

/**
 * Update an existing image node by changing its attributes
 *
 * @param {ve.dm.MWImageNode} node Image node to update
 * @param {ve.dm.Surface} surfaceModel Surface model of main document
 */
ve.dm.MWImageModel.prototype.updateImageNode = function ( node, surfaceModel ) {
	var captionRange, captionNode,
		doc = surfaceModel.getDocument(),
		captionType;

	// Update the caption
	if ( node.getType() === 'wikiaBlockImage' || node.getType() === 'wikiaBlockVideo' ) {
		captionNode = node.getCaptionNode();
		if ( !captionNode ) {
			if ( node.getType() === 'wikiaBlockImage' ) {
				captionType = 'wikiaImageCaption';
			} else {
				captionType = 'wikiaVideoCaption';
			}
			// There was no caption before, so insert one now
			surfaceModel.getFragment()
				.adjustLinearSelection( 1 )
				.collapseToStart()
				.insertContent( [ { type: captionType }, { type: '/' + captionType } ] );
			// Update the caption node
			captionNode = node.getCaptionNode();
		}

		captionRange = captionNode.getRange();

		// Remove contents of old caption
		surfaceModel.change(
			ve.dm.Transaction.newFromRemoval(
				doc,
				captionRange,
				true
			)
		);

		// Add contents of new caption
		surfaceModel.change(
			ve.dm.Transaction.newFromDocumentInsertion(
				doc,
				captionRange.start,
				this.getCaptionDocument()
			)
		);
	}

	// Update attributes
	surfaceModel.change(
		ve.dm.Transaction.newFromAttributeChanges(
			doc,
			node.getOffset(),
			this.getUpdatedAttributes()
		)
	);
};

/**
 * Insert image into a surface.
 *
 * Image is inserted at the current fragment position.
 *
 * @param {ve.dm.SurfaceFragment} fragment Fragment covering range to insert at
 * @return {ve.dm.SurfaceFragment} Fragment covering inserted image
 * @throws {Error} Unknown image node type
 */
ve.dm.MWImageModel.prototype.insertImageNode = function ( fragment ) {
	var editAttributes, captionDoc,
		offset,
		contentToInsert = [],
		nodeType = this.getImageNodeType(),
		originalAttrs = ve.copy( this.getOriginalImageAttributes() ),
		surfaceModel = fragment.getSurface();

	if ( !( fragment.getSelection() instanceof ve.dm.LinearSelection ) ) {
		return fragment;
	}

	editAttributes = $.extend( originalAttrs, this.getUpdatedAttributes() );

	// Remove old classes
	delete editAttributes.originalClasses;
	delete editAttributes.unrecognizedClasses;

	contentToInsert = [
		{
			type: nodeType,
			attributes: editAttributes
		},
		{ type: '/' + nodeType }
	];

	switch ( nodeType ) {
		case 'mwInlineImage':
		case 'wikiaInlineVideo':
			// Try to put the image inside the nearest content node
			offset = fragment.getDocument().data.getNearestContentOffset( fragment.getSelection().getRange().start );
			if ( offset > -1 ) {
				fragment = fragment.clone( new ve.dm.LinearSelection( fragment.getDocument(), new ve.Range( offset ) ) );
			}
			fragment.insertContent( contentToInsert );
			return fragment;

		case 'wikiaBlockImage':
		case 'wikiaBlockVideo':
			if ( nodeType === 'wikiaBlockImage' ) {
				contentToInsert.splice( 1, 0, { type: 'wikiaImageCaption' }, { type: '/wikiaImageCaption' } );
			} else {
				contentToInsert.splice( 1, 0, { type: 'wikiaVideoCaption' }, { type: '/wikiaVideoCaption' } );
			}
			// Try to put the image in front of the structural node
			offset = fragment.getDocument().data.getNearestStructuralOffset( fragment.getSelection().getRange().start, -1 );
			if ( offset > -1 ) {
				fragment = fragment.clone( new ve.dm.LinearSelection( fragment.getDocument(), new ve.Range( offset ) ) );
			}
			fragment.insertContent( contentToInsert );
			// Check if there is caption document and insert it
			captionDoc = this.getCaptionDocument();
			if ( captionDoc.data.countNonInternalElements() > 2 ) {
				// Add contents of new caption
				surfaceModel.change(
					ve.dm.Transaction.newFromDocumentInsertion(
						surfaceModel.getDocument(),
						fragment.getSelection().getRange().start + 2,
						this.getCaptionDocument()
					)
				);
			}
			return fragment;

		default:
			throw new Error( 'Unknown image node type ' + nodeType );
	}
};

/**
 * Return all updated attributes that belong to the node.
 * @return {Object} Updated attributes
 */
ve.dm.MWImageModel.prototype.getUpdatedAttributes = function () {
	var attrs, currentDimensions,
		origAttrs = this.getOriginalImageAttributes();

	// Adjust default dimensions if size is set to default
	if ( this.scalable.isDefault() && this.scalable.getDefaultDimensions() ) {
		currentDimensions = this.scalable.getDefaultDimensions();
	} else {
		currentDimensions = this.getCurrentDimensions();
	}

	attrs = {
		type: this.getType(),
		width: currentDimensions.width,
		height: currentDimensions.height,
		defaultSize: this.isDefaultSize(),
		borderImage: this.hasBorder()
	};

	if ( origAttrs.alt !== undefined || this.getAltText() !== '' ) {
		attrs.alt = this.getAltText();
	}

	if ( this.isDefaultAligned() ) {
		attrs.align = 'default';
	} else if ( !this.isAligned() ) {
		attrs.align = 'none';
	} else {
		attrs.align = this.getAlignment();
	}

	attrs.src = this.getImageSource();
	attrs.href = this.getImageHref();
	attrs.resource = this.getImageResourceName();

	// If converting from block to inline, set isLinked=true to avoid |link=
	if ( origAttrs.isLinked === undefined && this.getImageNodeType() === 'mwInlineImage' ) {
		attrs.isLinked = true;
	}

	return attrs;
};

/**
 * Deal with default change on the scalable object
 *
 * @param {boolean} isDefault
 */
ve.dm.MWImageModel.prototype.onScalableDefaultSizeChange = function ( isDefault ) {
	this.toggleDefaultSize( isDefault );
};

/**
 * Set the image file source
 * @param {string} src The source of the given media file
 */
ve.dm.MWImageModel.prototype.setImageSource = function ( src ) {
	this.imageSrc = src;
};

/**
 * Set the image file resource name
 * @param {string} resourceName The resource name of the given image file
 */
ve.dm.MWImageModel.prototype.setImageResourceName = function ( resourceName ) {
	this.imageResourceName = resourceName;
};

/**
 * Set the image href value
 * @param {string} href The destination href of the given media file
 */
ve.dm.MWImageModel.prototype.setImageHref = function ( href ) {
	this.imageHref = href;
};

/**
 * Set the original bounding box
 * @param {Object} box Bounding box with width and height
 */
ve.dm.MWImageModel.prototype.setBoundingBox = function ( box ) {
	this.boundingBox = box;
};

/**
 * Set the initial hash object of the image to be compared to when
 * checking if the model is modified.
 *
 * @param {Object} hash The initial hash object
 */
ve.dm.MWImageModel.prototype.storeInitialHash = function ( hash ) {
	this.initialHash = hash;
};

/**
 * Set symbolic name of media type.
 *
 * Example values: "BITMAP" for JPEG or PNG images; "DRAWING" for SVG graphics
 *
 * @param {string|undefined} Symbolic media type name, or undefined if empty
 */
ve.dm.MWImageModel.prototype.setMediaType = function ( type ) {
	this.mediaType = type;
};

/**
 * Check whether the image is set to default size
 * @return {boolean} Default size flag on or off
 */
ve.dm.MWImageModel.prototype.isDefaultSize = function () {
	return this.scalable.isDefault();
};

/**
 * Check whether the image has the border flag set
 * @return {boolean} Border flag on or off
 */
ve.dm.MWImageModel.prototype.hasBorder = function () {
	return this.border;
};

/**
 * Check whether the image has floating alignment set
 * @param {string} [align] Optional. Alignment value to test against.
 * @return {boolean} hasAlignment flag on or off
 */
ve.dm.MWImageModel.prototype.isAligned = function ( align ) {
	align = align || this.alignment;
	// The image is aligned if it has alignment (not undefined and not null)
	// and if its alignment is not 'none'.
	// Inline images initially have null alignment value (and are not aligned)
	return align && align !== 'none';
};

/**
 * Check whether the image is set to default alignment
 * We explicitly repeat tests so to avoid recursively calling
 * the other methods.
 * @param {string} [align] Optional alignment value to test against.
 * Supplying this parameter would test whether this align parameter
 * would mean the image is aligned to its default position.
 * @return {boolean} defaultAlignment flag on or off
 */
ve.dm.MWImageModel.prototype.isDefaultAligned = function ( imageType, align ) {
	var alignment = align || this.getAlignment(),
		defaultAlignment = ( this.getDir() === 'rtl' ) ? 'left' : 'right';

	imageType = imageType || this.getType();
	// No alignment specified means defeault alignment always
	// Inline images have no align attribute; during the initialization
	// stage of the model we have to account for that option. Later the
	// model creates a faux alignment for inline images ('none' for default)
	// but if initially the alignment is null or undefined, it means the image
	// is inline without explicit alignment (which makes it default aligned)
	if ( !alignment ) {
		return true;
	}

	if (
		(
			( imageType === 'frameless' || imageType === 'none' ) &&
			alignment === 'none'
		) ||
		(
			( imageType === 'thumb' || imageType === 'frame' ) &&
			alignment === defaultAlignment
		)
	) {
		return true;
	}

	return false;
};

/**
 * Check whether the image can have a border set on it
 * @return {boolean} Border possible or not
 */
ve.dm.MWImageModel.prototype.isBorderable = function () {
	return this.borderable;
};

/**
 * Get the image file resource name
 * @returns {string} resourceName The resource name of the given media file
 */
ve.dm.MWImageModel.prototype.getResourceName = function () {
	return this.imageResourceName;
};

/**
 * Get the image alternate text
 * @return {string} Alternate text
 */
ve.dm.MWImageModel.prototype.getAltText = function () {
	return this.altText || '';
};

/**
 * Get image wikitext type; 'thumb', 'frame', 'frameless' or 'none/inline'
 * @return {string} Image type
 */
ve.dm.MWImageModel.prototype.getType = function () {
	return this.type;
};

/**
 * Get the image size type of the image
 */
ve.dm.MWImageModel.prototype.getSizeType = function () {
	return this.sizeType;
};

/**
 * Get symbolic name of media type.
 *
 * Example values: "BITMAP" for JPEG or PNG images; "DRAWING" for SVG graphics
 *
 * @return {string|undefined} Symbolic media type name, or undefined if empty
 */
ve.dm.MWImageModel.prototype.getMediaType = function () {
	return this.mediaType;
};

/**
 * Get image alignment 'left', 'right', 'center', 'none' or 'default'
 * @return {string|null} Image alignment. Inline images have initial alignment
 * value of null.
 */
ve.dm.MWImageModel.prototype.getAlignment = function () {
	return this.alignment;
};

/**
 * Get image vertical alignment
 * 'middle', 'baseline', 'sub', 'super', 'top', 'text-top', 'bottom', 'text-bottom' or 'default'
 * @return {string} Image alignment
 */
ve.dm.MWImageModel.prototype.getVerticalAlignment = function () {
	return this.verticalAlignment;
};

/**
 * Get the scalable object responsible for size manipulations
 * for the given image
 * @return {ve.dm.Scalable} Scalable object
 */
ve.dm.MWImageModel.prototype.getScalable = function () {
	return this.scalable;
};

/**
 * Get the image current dimensions
 * @return {Object} Current dimensions width/height
 * @return {number} dimensions.width The width of the image
 * @return {number} dimensions.height The height of the image
 */
ve.dm.MWImageModel.prototype.getCurrentDimensions = function () {
	return this.scalable.getCurrentDimensions();
};

/**
 * Get image caption document.
 *
 * Auto-generates a blank document if no document exists.
 *
 * @return {ve.dm.Document} Caption document
 */
ve.dm.MWImageModel.prototype.getCaptionDocument = function () {
	if ( !this.captionDoc ) {
		this.captionDoc = new ve.dm.Document( [
			{ type: 'paragraph', internal: { generated: 'wrapper' } },
			{ type: '/paragraph' },
			{ type: 'internalList' },
			{ type: '/internalList' }
		],
		/* htmlDocument */ null,
		/* parentDocument */ null,
		/* internalList */ null,
		/* innerWhitespace */ null,
		/* lang */ this.getLang(),
		/* dir */ this.getDir() );
	}
	return this.captionDoc;
};

/**
 * Toggle the option of whether this image can or cannot have
 * a border set on it.
 *
 * @param {boolean} [borderable] Set or unset borderable. If not
 *  specified, the current state is toggled.
 */
ve.dm.MWImageModel.prototype.toggleBorderable = function ( borderable ) {
	borderable = borderable !== undefined ? !!borderable : !this.isBorderable();

	this.borderable = borderable;
};

/**
 * Toggle the border flag of the image
 *
 * @param {boolean} [hasBorder] Border flag. Omit to toggle current value.
 */
ve.dm.MWImageModel.prototype.toggleBorder = function ( hasBorder ) {
	hasBorder = hasBorder !== undefined ? !!hasBorder : !this.hasBorder();

	this.border = !!hasBorder;
};

/**
 * Toggle the default size flag of the image
 * @param {boolean} [isDefault] Default size flag. Omit to toggle current value.
 * @fires sizeDefaultChange
 */
ve.dm.MWImageModel.prototype.toggleDefaultSize = function ( isDefault ) {
	isDefault = isDefault !== undefined ? !!isDefault : !this.isDefaultSize();

	if ( this.isDefaultSize() !== isDefault ) {
		this.scalable.toggleDefault( !!isDefault );
		this.resetDefaultDimensions();
		this.emit( 'sizeDefaultChange', !!isDefault );
	}
};

/**
 * Cache all image attributes
 * @param {Object} attrs Image attributes
 */
ve.dm.MWImageModel.prototype.cacheOriginalImageAttributes = function ( attrs ) {
	this.attributesCache = attrs;
};

/**
 * Get the cache of all image attributes
 * @return {Object} attrs Image attributes
 */
ve.dm.MWImageModel.prototype.getOriginalImageAttributes = function () {
	return this.attributesCache;
};

/**
 * Set the current dimensions of the image.
 * Normalize in case only one dimension is available.
 * @param {Object} dimensions Dimensions width and height
 * @param {number} dimensions.width The width of the image
 * @param {number} dimensions.height The height of the image
 */
ve.dm.MWImageModel.prototype.setCurrentDimensions = function ( dimensions ) {
	var normalizedDimensions = ve.dm.Scalable.static.getDimensionsFromValue( dimensions, this.scalable.getRatio() );
	this.scalable.setCurrentDimensions( normalizedDimensions );
};

/**
 * Set alternate text
 * @param {string} text Alternate text
 */
ve.dm.MWImageModel.prototype.setAltText = function ( text ) {
	this.altText = text;
};

/**
 * Set image type
 * @see #getType
 *
 * @param {string} type Image type
 * @fires typeChange
 */
ve.dm.MWImageModel.prototype.setType = function ( type ) {
	var isDefaultAligned = this.isDefaultAligned( this.imageCurrentType );

	this.type = type;

	// If we're switching between inline and block or vise versa,
	// check if the old type image was default aligned
	if ( isDefaultAligned && this.imageCurrentType !== this.type ) {
		if ( this.type === 'none' || this.type === 'frameless' ) {
			// Reset default alignment for switching to inline images
			this.setAlignment( 'none' );
		} else {
			// Reset default alignment for all other images
			this.setAlignment( 'default' );
		}
	}

	// Cache the current type for next check
	this.imageCurrentType = type;

	if ( type === 'frame' || type === 'thumb' ) {
		// Disable border option
		this.toggleBorderable( false );
	} else {
		// Enable border option
		this.toggleBorderable( true );
	}

	// If type is frame, set to 'default' size
	if ( type === 'frame' ) {
		this.toggleDefaultSize( true );
	}

	// Let the image node update scalable considerations
	// for default and max dimensions as per the new type.
	ve.dm.MWImageNode.static.syncScalableToType( type, this.getMediaType(), this.getScalable() );

	this.emit( 'typeChange', type );
};

/**
 * Reset the default dimensions of the image based on its type
 * and on whether we have the originalDimensions object from
 * the API
 */
ve.dm.MWImageModel.prototype.resetDefaultDimensions = function () {
	var originalDimensions = this.scalable.getOriginalDimensions();

	if ( !$.isEmptyObject( originalDimensions ) ) {
		if ( this.getType() === 'thumb' || this.getType() === 'frameless' ) {
			// Default is thumb size
			if ( originalDimensions.width <= this.defaultThumbSize ) {
				this.scalable.setDefaultDimensions( originalDimensions );
			} else {
				this.scalable.setDefaultDimensions(
					ve.dm.Scalable.static.getDimensionsFromValue( {
						width: this.defaultThumbSize
					}, this.scalable.getRatio() )
				);
			}
		} else {
			// Default is original size
			this.scalable.setDefaultDimensions( originalDimensions );
		}
	} else {
		this.scalable.setDefaultDimensions( {} );
	}
};

/**
 * Retrieve the currently set default dimensions from the scalable
 * object attached to the image.
 *
 * @return {Object} Image default dimensions
 */
ve.dm.MWImageModel.prototype.getDefaultDimensions = function () {
	return this.scalable.getDefaultDimensions();
};

/**
 * Change size type of the image
 *
 * @param {string} type Size type 'default', 'custom' or 'scale'
 */
ve.dm.MWImageModel.prototype.setSizeType = function ( type ) {
	if ( this.sizeType !== type ) {
		this.sizeType = type;
		this.toggleDefaultSize( type === 'default' );
	}
};

/**
 * Set image alignment
 *
 * @see #getAlignment
 *
 * @param {string} align Alignment
 */
ve.dm.MWImageModel.prototype.setAlignment = function ( align ) {
	if ( align === 'default' ) {
		// If default, set the alignment to language dir default
		align = this.getDefaultDir();
	}

	this.alignment = align;
	this.emit( 'alignmentChange', align );
};

/**
 * Set image vertical alignment
 *
 * @see #getVerticalAlignment
 *
 * @param {string} valign Alignment
 */
ve.dm.MWImageModel.prototype.setVerticalAlignment = function ( valign ) {
	this.verticalAlignment = valign;
	this.emit( 'alignmentChange', valign );
};

/**
 * Get the default alignment according to the document direction
 *
 * @param {string} [imageNodeType] Optional. The image node type that we would
 * like to get the default direction for. Supplying this parameter allows us
 * to check what the default alignment of a specific type of node would be.
 * If the parameter is not supplied, the default alignment will be calculated
 * based on the current node type.
 * @return {string} Node alignment based on document direction
 */
ve.dm.MWImageModel.prototype.getDefaultDir = function ( imageNodeType ) {
	imageNodeType = imageNodeType || this.getImageNodeType();

	if ( this.getDir() === 'rtl' ) {
		// Assume position is 'left'
		return ( imageNodeType === 'wikiaBlockImage' || imageNodeType === 'wikiaBlockVideo' ) ? 'left' : 'none';
	} else {
		// Assume position is 'right'
		return ( imageNodeType === 'wikiaBlockImage' || imageNodeType === 'wikiaBlockVideo' ) ? 'right' : 'none';
	}
};

/**
 * Get the directionality of the image, especially important for
 * default alignment.
 *
 * @return {string} Current document direction 'rtl' or 'ltr'
 */
ve.dm.MWImageModel.prototype.getDir = function () {
	return this.dir;
};

/**
 * Set the directionality of the image, especially important for
 * default alignment.
 * @param {string} dir 'rtl' or 'ltr'
 */
ve.dm.MWImageModel.prototype.setDir = function ( dir ) {
	this.dir = dir;
};

/**
 * Get the language of the image document. Specifically relevant
 * for the caption document.
 * @return {string} Document language
 */
ve.dm.MWImageModel.prototype.getLang = function () {
	return this.lang;
};

/**
 * Set the language of the image document. Specifically relevant
 * for the caption document.
 * @param {string} lang Document language
 */
ve.dm.MWImageModel.prototype.setLang = function ( lang ) {
	this.lang = lang;
};

/**
 * Get the image file source
 * The image file source that points to the location of the
 * file on the web.
 * For instance, '//upload.wikimedia.org/wikipedia/commons/0/0f/Foo.jpg'
 * @returns {string} The source of the given media file
 */
ve.dm.MWImageModel.prototype.getImageSource = function () {
	return this.imageSrc;
};

/**
 * Get the image file resource name.
 * The resource name represents the filename without the full
 * source url.
 * For example, './File:Foo.jpg'
 * @returns {string} The resource name of the given media file
 */
ve.dm.MWImageModel.prototype.getImageResourceName = function () {
	return this.imageResourceName;
};

/**
 * Get the image href value.
 * This is the link that the image leads to. It usually contains
 * the link to the source of the image in commons or locally, but
 * may hold an alternative link if link= is supplied in the wikitext.
 * For example, './File:Foo.jpg' or 'http://www.wikipedia.org'
 * @returns {string} The destination href of the given media file
 */
ve.dm.MWImageModel.prototype.getImageHref = function () {
	return this.imageHref;
};

/**
 * Attach a new scalable object to the model and request the
 * information from the API.
 *
 * @param {ve.dm.Scalable} Scalable object
 */
ve.dm.MWImageModel.prototype.attachScalable = function ( scalable ) {
	var imageName = this.getResourceName().replace( /^(\.+\/)*/, '' ),
		imageModel = this;

	if ( this.scalable instanceof ve.dm.Scalable ) {
		this.scalable.disconnect( this );
	}
	this.scalable = scalable;

	// Events
	this.scalable.connect( this, { defaultSizeChange: 'onScalableDefaultSizeChange' } );

	// Call for updated scalable
	if ( imageName ) {
		ve.dm.MWImageNode.static.getScalablePromise( imageName ).done( function ( info ) {
			imageModel.scalable.setOriginalDimensions( {
				width: info.width,
				height: info.height
			} );
			// Update media type
			imageModel.setMediaType( info.mediatype );
			// Update according to type
			ve.dm.MWImageNode.static.syncScalableToType(
				imageModel.getType(),
				imageModel.getMediaType(),
				imageModel.getScalable()
			);

			// We have to adjust the details in the initial hash if the original
			// image was 'default' since we didn't have default until now and the
			// default dimensions that were 'recorded' were wrong
			if ( !$.isEmptyObject( imageModel.initialHash ) && imageModel.initialHash.scalable.isDefault ) {
				imageModel.initialHash.scalable.currentDimensions = imageModel.scalable.getDefaultDimensions();
			}

		} );
	}
};

/**
 * Set image caption document.
 *
 * @param {ve.dm.Document} Image caption document
 */
ve.dm.MWImageModel.prototype.setCaptionDocument = function ( doc ) {
	this.captionDoc = doc;
};

/**
 * Check if the model attributes and parameters have been modified by
 * comparing the current hash to the new hash object.
 * @return {boolean} Model has been modified
 */
ve.dm.MWImageModel.prototype.hasBeenModified = function () {
	if ( this.initialHash ) {
		return !ve.compare( this.initialHash, this.getHashObject() );
	}
	return true;
};
