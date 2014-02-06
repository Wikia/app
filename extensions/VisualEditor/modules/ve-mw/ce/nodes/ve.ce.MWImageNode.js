/*!
 * VisualEditor ContentEditable MWImageNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * ContentEditable MediaWiki image node.
 *
 * @class
 * @abstract
 * @extends ve.ce.GeneratedContentNode
 * @mixins ve.ce.ProtectedNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.RelocatableNode
 * @mixins ve.ce.MWResizableNode
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ce.MWImageNode = function VeCeMWImageNode( $inner, $image, config ) {
	// Parent constructor
	ve.ce.GeneratedContentNode.call( this );

	this.$inner = $inner;
	this.$image = $image;

	// Mixin constructors
	ve.ce.ProtectedNode.call( this, this.$inner, config );
	ve.ce.FocusableNode.call( this, this.$inner, config );
	ve.ce.RelocatableNode.call( this, this.$inner, config );
	ve.ce.MWResizableNode.call( this, this.$image, config );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWImageNode, ve.ce.GeneratedContentNode );

OO.mixinClass( ve.ce.MWImageNode, ve.ce.ProtectedNode );

OO.mixinClass( ve.ce.MWImageNode, ve.ce.FocusableNode );

OO.mixinClass( ve.ce.MWImageNode, ve.ce.RelocatableNode );

// Need to mixin base class as well
OO.mixinClass( ve.ce.MWImageNode, ve.ce.ResizableNode );

OO.mixinClass( ve.ce.MWImageNode, ve.ce.MWResizableNode );

/* Methods */

/** */
ve.ce.MWImageNode.prototype.generateContents = function () {
	var xhr, deferred = $.Deferred();

	xhr = $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'action': 'query',
			'prop': 'imageinfo',
			'iiprop': 'url',
			'iiurlwidth': this.model.getAttribute( 'width' ),
			'iiurlheight': this.model.getAttribute( 'height' ),
			'titles': this.model.getAttribute( 'resource' ).replace( /^(.+\/)*/, '' ),
			'format': 'json'
		},
		'cache': 'false'
	} )
		.done( ve.bind( this.onParseSuccess, this, deferred ) )
		.fail( ve.bind( this.onParseError, this, deferred ) );

	return deferred.promise( { abort: xhr.abort } );
};

/**
 * Handle a successful response from the parser for the image src.
 *
 * @param {jQuery.Deferred} deferred The Deferred object created by generateContents
 * @param {Object} response Response data
 */
ve.ce.MWImageNode.prototype.onParseSuccess = function ( deferred, response ) {
	var id, src, pages = ve.getProp( response, 'query', 'pages' );
	for ( id in pages ) {
		if ( pages[id].imageinfo ) {
			src = pages[id].imageinfo[0].thumburl;
		}
	}
	if ( src ) {
		deferred.resolve( src );
	} else {
		deferred.reject();
	}
};

/** */
ve.ce.MWImageNode.prototype.render = function ( generateContents ) {
	this.$image.attr( 'src', ve.resolveUrl( generateContents, this.getModelHtmlDocument() ) );
	if ( this.live ) {
		this.afterRender();
	}
};

/**
 * Handle an unsuccessful response from the parser for the image src.
 *
 * @param {jQuery.Deferred} deferred The promise object created by generateContents
 * @param {Object} response Response data
 */
ve.ce.MWImageNode.prototype.onParseError = function ( deferred ) {
	deferred.reject();
};
