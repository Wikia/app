/*!
 * VisualEditor ContentEditable MWExtensionNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki extension node.
 *
 * Configuration options for .update():
 * - extsrc: override the contents of the tag (string)
 * - attrs: override the attributes of the tag (object)
 *
 * @class
 * @abstract
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.GeneratedContentNode
 *
 * @constructor
 */
ve.ce.MWExtensionNode = function VeCeMWExtensionNode() {
	// Parent constructor
	ve.ce.MWExtensionNode.super.apply( this, arguments );

	// Mixin constructors
	ve.ce.FocusableNode.call( this, this.getFocusableElement() );
	ve.ce.GeneratedContentNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWExtensionNode, ve.ce.LeafNode );
OO.mixinClass( ve.ce.MWExtensionNode, ve.ce.FocusableNode );
OO.mixinClass( ve.ce.MWExtensionNode, ve.ce.GeneratedContentNode );

/* Static properties */

/**
 * Extension renders visible content when empty
 *
 * @static
 * @property {boolean}
 * @inheritable
 */
ve.ce.MWExtensionNode.static.rendersEmpty = false;

/* Methods */

/** */
ve.ce.MWExtensionNode.prototype.generateContents = function ( config ) {
	var xhr, attr, wikitext,
		deferred = $.Deferred(),
		mwData = this.getModel().getAttribute( 'mw' ),
		extsrc = config && config.extsrc !== undefined ? config.extsrc : mwData.body.extsrc,
		attrs = config && config.attrs || mwData.attrs,
		tagName = this.getModel().getExtensionName();

	// undefined means omit the attribute, not convert it to string 'undefined'
	for ( attr in mwData.attrs ) {
		if ( mwData.attrs[ attr ] === undefined ) {
			delete mwData.attrs[ attr ];
		}
	}

	// XML-like tags in wikitext are not actually XML and don't expect their contents to be escaped.
	wikitext = mw.html.element( tagName, attrs, new mw.html.Raw( extsrc ) );

	if ( !this.constructor.static.rendersEmpty && extsrc.trim() !== '' ) {
		xhr = new mw.Api().post( {
			action: 'visualeditor',
			paction: 'parsefragment',
			page: mw.config.get( 'wgRelevantPageName' ),
			wikitext: wikitext
		} )
			.done( this.onParseSuccess.bind( this, deferred ) )
			.fail( this.onParseError.bind( this, deferred ) );
		return deferred.promise( { abort: xhr.abort } );
	} else {
		deferred.resolve( $( '<span>&nbsp;</span>' ).get() );
		return deferred.promise();
	}
};

/**
 * Handle a successful response from the parser for the wikitext fragment.
 *
 * @param {jQuery.Deferred} deferred The Deferred object created by generateContents
 * @param {Object} response Response data
 */
ve.ce.MWExtensionNode.prototype.onParseSuccess = function ( deferred, response ) {
	var data = response.visualeditor,
		contentNodes = $( data.content ).get();
	deferred.resolve( contentNodes );
};

/** */
ve.ce.MWExtensionNode.prototype.afterRender = function () {
	var node = this,
		$images = this.$element.find( 'img:not([width]),img:not([height])' );

	// Images missing a dimension change size after load
	// TODO: Ignore images which have dimensions defined in CSS, if performant
	if ( $images.length ) {
		$images.on( 'load', function () {
			// Mixin method
			ve.ce.GeneratedContentNode.prototype.afterRender.call( node );
		} );
	} else {
		// Mixin method
		ve.ce.GeneratedContentNode.prototype.afterRender.call( this );
	}
};

/**
 * Handle an unsuccessful response from the parser for the wikitext fragment.
 *
 * @param {jQuery.Deferred} deferred The promise object created by generateContents
 * @param {Object} response Response data
 */
ve.ce.MWExtensionNode.prototype.onParseError = function ( deferred ) {
	deferred.reject();
};

/**
 * ContentEditable MediaWiki inline extension node.
 *
 * @class
 * @abstract
 * @extends ve.ce.MWExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWInlineExtensionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWInlineExtensionNode = function VeCeMWInlineExtensionNode() {
	// Parent constructor
	ve.ce.MWInlineExtensionNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWInlineExtensionNode, ve.ce.MWExtensionNode );

/* Methods */

/**
 * @inheritdoc
 */
ve.ce.MWInlineExtensionNode.prototype.onParseSuccess = function ( deferred, response ) {
	var data = response.visualeditor,
		contentNodes = $( data.content ).get();

	// Inline nodes will come back in wrapper paragraphs, so unwrap them.
	if ( contentNodes[ 0 ] && contentNodes[ 0 ].childNodes ) {
		contentNodes = Array.prototype.slice.apply( contentNodes[ 0 ].childNodes );
	}
	deferred.resolve( contentNodes );
};

/**
 * ContentEditable MediaWiki block extension node.
 *
 * @class
 * @abstract
 * @extends ve.ce.MWExtensionNode
 *
 * @constructor
 * @param {ve.dm.MWBlockExtensionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWBlockExtensionNode = function VeCeMWBlockExtensionNode() {
	// Parent constructor
	ve.ce.MWBlockExtensionNode.super.apply( this, arguments );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWBlockExtensionNode, ve.ce.MWExtensionNode );
