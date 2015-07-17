/*!
 * VisualEditor DataModel MWImageModel class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
/*global mw */

/**
 * MediaWiki image model.
 *
 * @class
 * @mixins OO.EventEmitter
 *
 * @constructor
 */
ve.dm.MWImageModel = function VeDmMWImageModel() {
	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.mediaNode = null;
	this.attributesCache = null;

	// Image properties
	this.captionDoc = null;
	this.caption = null;
	this.altText = null;
	this.type = null;
	this.alignment = null;
	this.scalable = null;
	this.sizeType = null;
	this.border = false;
	this.borderable = false;
	this.dir = 'ltr';
	this.defaultDimensions = null;

	// Get wiki default thumbnail size
	this.defaultThumbSize = mw.config.get( 'wgVisualEditorConfig' )
		.defaultUserOptions.defaultthumbsize;
};

/* Inheritance */

OO.mixinClass( ve.dm.MWImageModel, OO.EventEmitter );

/* Events */

/**
 * Change of image alignment or of having alignment at all
 * @event alignmentChange
 * @param {string} Alignment 'left', 'right', 'center' or 'none'
 */

/**
 * Change in size type between default and custom
 * @event sizeDefaultChange
 * @param {boolean} Image is default size
 */

/**
 * Change in the image type
 * @event typeChange
 * @param {string} Image type 'thumb', 'frame', 'frameless' or 'none'
 */
/* Static Properties */

ve.dm.MWImageModel.static.infoCache = {};

/* Static Methods */

/**
 * Load from image data with scalable information.
 *
 * @param {ve.dm.MWImageNode} node Image node
 * @return {ve.dm.MWImageModel} Image model
 */
ve.dm.MWImageModel.static.newFromImageNode = function ( node ) {
	var doc = node.getDocument(),
		captionNode,
		attrs = node.getAttributes(),
		imgModel = new ve.dm.MWImageModel();

	imgModel.setMediaNode( node );
	// Set scalable
	imgModel.setScalable( node.getScalable() );

	// Cache the attributes so we can create a new image without
	// losing any existing information
	imgModel.cacheOriginalImageAttributes( attrs );

	// Collect all the information
	imgModel.toggleBorder( !!attrs.borderImage );
	imgModel.setAltText( attrs.alt );

	imgModel.setDir( doc.getDir() );

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

	// Make sure the node type and scalable are synchronized
	node.syncScalableToType();

	// If this is a block image, get the caption
	if ( node instanceof ve.dm.MWBlockImageNode ) {
		captionNode = node.getCaptionNode();
		if ( captionNode && captionNode.getLength() > 0 ) {
			imgModel.setCaptionDocument( doc.cloneFromRange( captionNode.getRange() ) );
		}
	}
	return imgModel;
};

/* Methods */

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
		return this.mediaNode.mediaType === 'VIDEO' ? 'wikiaInlineVideo' : 'wikiaInlineImage';
	} else {
		return this.mediaNode.mediaType === 'VIDEO' ? 'wikiaBlockVideo' : 'wikiaBlockImage';
	}
};

/**
 * Update an existing image node by changing its attributes
 *
 * @param {ve.dm.Surface} surfaceModel Surface model of main document
 */
ve.dm.MWImageModel.prototype.updateImageNode = function ( surfaceModel ) {
	var captionRange, captionNode,
		doc = surfaceModel.getDocument(),
		node = this.getMediaNode(),
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
				.adjustRange( 1 )
				.collapseRangeToStart()
				.insertContent( [ { 'type': captionType }, { 'type': '/' + captionType } ] );

			// Update the caption node
			captionNode = this.getMediaNode().getCaptionNode();
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

	editAttributes = $.extend( originalAttrs, this.getUpdatedAttributes() );

	// Remove old classes
	delete editAttributes.originalClasses;
	delete editAttributes.unrecognizedClasses;

	contentToInsert = [
		{
			'type': nodeType,
			'attributes': editAttributes
		},
		{ 'type': '/' + nodeType }
	];

	switch ( nodeType ) {
		case 'wikiaInlineImage':
		case 'wikiaInlineVideo':
			// Try to put the image inside the nearest content node
			offset = fragment.getDocument().data.getNearestContentOffset( fragment.getRange().start );
			if ( offset > -1 ) {
				fragment = fragment.clone( new ve.Range( offset ) );
			}
			fragment.insertContent( contentToInsert );
			return fragment;

		case 'wikiaBlockImage':
		case 'wikiaBlockVideo':
			if ( nodeType === 'wikiaBlockImage' ) {
				contentToInsert.splice( 1, 0, { 'type': 'wikiaImageCaption' }, { 'type': '/wikiaImageCaption' } );
			} else {
				contentToInsert.splice( 1, 0, { 'type': 'wikiaVideoCaption' }, { 'type': '/wikiaVideoCaption' } );
			}
			// Try to put the image in front of the structural node
			offset = fragment.getDocument().data.getNearestStructuralOffset( fragment.getRange().start, -1 );
			if ( offset > -1 ) {
				fragment = fragment.clone( new ve.Range( offset ) );
			}
			fragment.insertContent( contentToInsert );
			// Check if there is caption document and insert it
			captionDoc = this.getCaptionDocument();
			if ( captionDoc.data.getLength() > 4 ) {
				// Add contents of new caption
				surfaceModel.change(
					ve.dm.Transaction.newFromDocumentInsertion(
						surfaceModel.getDocument(),
						fragment.getRange().start + 2,
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
		'type': this.getType(),
		'width': currentDimensions.width,
		'height': currentDimensions.height,
		'defaultSize': this.isDefaultSize(),
		'borderImage': this.hasBorder()
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

	// If converting from block to inline, set isLinked=true to avoid |link=
	if ( origAttrs.isLinked === undefined && this.getImageNodeType() === 'wikiaInlineImage' ) {
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
 * Set the media node
 * @param {ve.dm.MWImageNode} node Node model
 */
ve.dm.MWImageModel.prototype.setMediaNode = function ( node ) {
	this.mediaNode = node;
};

/**
 * Retrieve the media node
 * @return {ve.dm.MWImageNode} node Node model
 */
ve.dm.MWImageModel.prototype.getMediaNode = function () {
	return this.mediaNode;
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
 * Get the image alternate text
 * @return {string} Alternate text
 */
ve.dm.MWImageModel.prototype.getAltText = function () {
	return this.altText;
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
	return this.getMediaNode().getMediaType();
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
			{ 'type': 'paragraph', 'internal': { 'generated': 'wrapper' } },
			{ 'type': '/paragraph' },
			{ 'type': 'internalList' },
			{ 'type': '/internalList' }
		] );
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
	var normalizedDimensions = this.scalable.getDimensionsFromValue( dimensions );
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
	this.getMediaNode().syncScalableToType( type );

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
					this.scalable.getDimensionsFromValue( {
						'width': this.defaultThumbSize
				} ) );
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
 * Set the scalable object relevant to the image node
 *
 * @param {ve.dm.Scalable} Scalable object
 */
ve.dm.MWImageModel.prototype.setScalable = function ( scalable ) {
	if ( this.scalable instanceof ve.dm.Scalable ) {
		this.scalable.disconnect( this );
	}
	this.scalable = scalable;
	// Events
	this.scalable.connect( this, { 'defaultSizeChange': 'onScalableDefaultSizeChange' } );
};

/**
 * Set image caption document.
 *
 * @param {ve.dm.Document} Image caption document
 */
ve.dm.MWImageModel.prototype.setCaptionDocument = function ( doc ) {
	this.captionDoc = doc;
};
