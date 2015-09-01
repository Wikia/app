/*!
 * VisualEditor DataModel BlockImageNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * DataModel block image node.
 *
 * @class
 * @extends ve.dm.BranchNode
 * @mixins ve.dm.ImageNode
 * @mixins ve.dm.AlignableNode
 *
 * @constructor
 * @param {Object} [element] Reference to element in linear model
 * @param {ve.dm.Node[]} [children]
 */
ve.dm.BlockImageNode = function VeDmBlockImageNode() {
	// Parent constructor
	ve.dm.BlockImageNode.super.apply( this, arguments );

	// Mixin constructors
	ve.dm.ImageNode.call( this );
	ve.dm.AlignableNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.dm.BlockImageNode, ve.dm.BranchNode );

OO.mixinClass( ve.dm.BlockImageNode, ve.dm.ImageNode );

// Mixin Alignable's parent class
OO.mixinClass( ve.dm.BlockImageNode, ve.dm.ClassAttributeNode );

OO.mixinClass( ve.dm.BlockImageNode, ve.dm.AlignableNode );

/* Static Properties */

ve.dm.BlockImageNode.static.name = 'blockImage';

ve.dm.BlockImageNode.static.preserveHtmlAttributes = function ( attribute ) {
	var attributes = [ 'src', 'width', 'height', 'href' ];
	return attributes.indexOf( attribute ) === -1;
};

ve.dm.BlockImageNode.static.handlesOwnChildren = true;

ve.dm.BlockImageNode.static.ignoreChildren = true;

ve.dm.BlockImageNode.static.childNodeTypes = [ 'imageCaption' ];

ve.dm.BlockImageNode.static.matchTagNames = [ 'figure' ];

// FIXME: This commented code has been here since the file was created. Explain or remove.
// ve.dm.BlockImageNode.static.blacklistedAnnotationTypes = [ 'link' ];

ve.dm.BlockImageNode.static.toDataElement = function ( domElements, converter ) {
	var dataElement, figure, classAttr, img, caption, attributes, width, height, altText;

	// Workaround for jQuery's .children() being expensive due to
	// https://github.com/jquery/sizzle/issues/311
	function findChildren( parent, nodeNames ) {
		return Array.prototype.filter.call( parent.childNodes, function ( element ) {
			return nodeNames.indexOf( element.nodeName.toLowerCase() ) !== -1;
		} );
	}

	figure = domElements[ 0 ];
	classAttr = figure.getAttribute( 'class' );
	img = findChildren( figure, 'img' )[ 0 ] || null;
	caption = findChildren( figure, 'figcaption' )[ 0 ] || null;
	attributes = {
		src: img && img.getAttribute( 'src' )
	};
	width = img && img.getAttribute( 'width' );
	height = img && img.getAttribute( 'height' );
	altText = img && img.getAttribute( 'alt' );

	if ( altText !== undefined ) {
		attributes.alt = altText;
	}

	this.setClassAttributes( attributes, classAttr );

	attributes.width = width !== undefined && width !== '' ? Number( width ) : null;
	attributes.height = height !== undefined && height !== '' ? Number( height ) : null;

	dataElement = {
		type: this.name,
		attributes: attributes
	};

	if ( !caption ) {
		return [
			dataElement,
			{ type: 'imageCaption' },
			{ type: 'imageCaption' },
			{ type: '/' + this.name }
		];
	} else {
		return [ dataElement ]
			.concat( converter.getDataFromDomClean( caption, { type: 'imageCaption' } ) )
			.concat( [ { type: '/' + this.name } ] );
	}
};

// TODO: Consider using jQuery instead of pure JS.
// TODO: At this moment node is not resizable but when it will be then adding defaultSize class
// should be more conditional.
ve.dm.BlockImageNode.static.toDomElements = function ( data, doc, converter ) {
	var dataElement = data[ 0 ],
		width = dataElement.attributes.width,
		height = dataElement.attributes.height,
		classAttr = this.getClassAttrFromAttributes( dataElement.attributes ),
		figure = doc.createElement( 'figure' ),
		img = doc.createElement( 'img' ),
		wrapper = doc.createElement( 'div' ),
		captionData = data.slice( 1, -1 );

	img.setAttribute( 'src', dataElement.attributes.src );
	img.setAttribute( 'width', width );
	img.setAttribute( 'height', height );
	if ( dataElement.attributes.alt !== undefined ) {
		img.setAttribute( 'alt', dataElement.attributes.alt );
	}
	figure.appendChild( img );

	if ( classAttr ) {
		figure.className = classAttr;
	}

	// If length of captionData is smaller or equal to 2 it means that there is no caption or that
	// it is empty - in both cases we are going to skip appending <figcaption>.
	if ( captionData.length > 2 ) {
		converter.getDomSubtreeFromData( data.slice( 1, -1 ), wrapper );
		while ( wrapper.firstChild ) {
			figure.appendChild( wrapper.firstChild );
		}
	}

	return [ figure ];
};

/* Methods */

/**
 * Get the caption node of the image.
 *
 * @method
 * @return {ve.dm.BlockImageCaptionNode|null} Caption node, if present
 */
ve.dm.BlockImageNode.prototype.getCaptionNode = function () {
	var node = this.children[ 0 ];
	return node instanceof ve.dm.BlockImageCaptionNode ? node : null;
};

/* Registration */

ve.dm.modelRegistry.register( ve.dm.BlockImageNode );
