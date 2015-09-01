/*!
 * VisualEditor ContentEditable MWTransclusionNode class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki transclusion node.
 *
 * @class
 * @abstract
 * @extends ve.ce.LeafNode
 * @mixins OO.ui.mixin.IconElement
 * @mixins ve.ce.GeneratedContentNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.TableCellableNode
 *
 * @constructor
 * @param {ve.dm.MWTransclusionNode} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.MWTransclusionNode = function VeCeMWTransclusionNode( model, config ) {
	// Parent constructor
	ve.ce.MWTransclusionNode.super.call( this, model, config );

	// Mixin constructors
	OO.ui.mixin.IconElement.call( this, config );
	ve.ce.GeneratedContentNode.call( this );
	ve.ce.FocusableNode.call( this );
	ve.ce.TableCellableNode.call( this );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWTransclusionNode, ve.ce.LeafNode );

OO.mixinClass( ve.ce.MWTransclusionNode, OO.ui.mixin.IconElement );
OO.mixinClass( ve.ce.MWTransclusionNode, ve.ce.GeneratedContentNode );
OO.mixinClass( ve.ce.MWTransclusionNode, ve.ce.FocusableNode );
OO.mixinClass( ve.ce.MWTransclusionNode, ve.ce.TableCellableNode );

/* Static Properties */

ve.ce.MWTransclusionNode.static.name = 'mwTransclusion';

ve.ce.MWTransclusionNode.static.renderHtmlAttributes = false;

ve.ce.MWTransclusionNode.static.primaryCommandName = 'transclusion';

/* Static Methods */

/**
 * Get a list of descriptions of template parts in a transclusion node
 *
 * @static
 * @param {ve.dm.Node} model Node model
 * @return {string[]} List of template part descriptions
 */
ve.ce.MWTransclusionNode.static.getTemplatePartDescriptions = function ( model ) {
	var i, len, part,
		parts = model.getPartsList(),
		words = [];

	for ( i = 0, len = parts.length; i < len; i++ ) {
		part = parts[ i ];
		if ( part.template ) {
			words.push( part.template );
		}
	}

	return words;
};

/**
 * @inheritdoc
 */
ve.ce.MWTransclusionNode.static.getDescription = function ( model ) {
	return this.getTemplatePartDescriptions( model )
		.map( function ( template ) {
			var title = mw.Title.newFromText( template, mw.config.get( 'wgNamespaceIds' ).template );
			if ( title ) {
				return title.getRelativeText( mw.config.get( 'wgNamespaceIds' ).template );
			} else {
				return template;
			}
		} )
		.join( ve.msg( 'comma-separator' ) );
};

/* Methods */

/**
 * @inheritdoc
 */
ve.ce.MWTransclusionNode.prototype.onSetup = function () {
	// Parent method
	ve.ce.MWTransclusionNode.super.prototype.onSetup.call( this );

	if ( !this.isVisible() ) {
		// We have to reset the icon when it is reappended, because
		// setIcon also affects the classes attached to this.$element
		this.setIcon( 'template' );
		// Reattach icon
		this.$element.first().prepend( this.$icon );
	} else {
		// We have to clear the icon because if the icon's symbolic name
		// has not changed since the last time we rendered, this.setIcon()
		// above will internally short circuit.
		this.setIcon( null );
	}
};

/**
 * @inheritdoc
 */
ve.ce.MWTransclusionNode.prototype.generateContents = function ( config ) {
	var xhr, deferred = $.Deferred();
	xhr = new mw.Api().post( {
		action: 'visualeditor',
		paction: 'parsefragment',
		page: mw.config.get( 'wgRelevantPageName' ),
		wikitext: ( config && config.wikitext ) || this.model.getWikitext(),
		pst: 1
	} )
		.done( this.onParseSuccess.bind( this, deferred ) )
		.fail( this.onParseError.bind( this, deferred ) );

	return deferred.promise( { abort: xhr.abort } );
};

/**
 * Handle a successful response from the parser for the wikitext fragment.
 *
 * @param {jQuery.Deferred} deferred The Deferred object created by #generateContents
 * @param {Object} response Response data
 */
ve.ce.MWTransclusionNode.prototype.onParseSuccess = function ( deferred, response ) {
	var contentNodes;

	if ( ve.getProp( response, 'visualeditor', 'result' ) !== 'success' ) {
		return this.onParseError.call( this, deferred );
	}

	// Work around https://github.com/jquery/jquery/issues/1997
	contentNodes = $.parseHTML( response.visualeditor.content, this.getModelHtmlDocument() ) || [];
	// HACK: if $content consists of a single paragraph, unwrap it.
	// We have to do this because the PHP parser wraps everything in <p>s, and inline templates
	// will render strangely when wrapped in <p>s.
	if ( contentNodes.length === 1 && contentNodes[ 0 ].nodeName.toLowerCase() === 'p' ) {
		contentNodes = Array.prototype.slice.apply( contentNodes[ 0 ].childNodes );
	}

	deferred.resolve( contentNodes );
};

/**
 * Extend the ve.ce.GeneratedContentNode render method to check for hidden templates.
 *
 * Check if the final result of the imported template is empty.
 * If it is empty, set the icon to be the template icon so that it can
 * be accessible to users (either to remove or edit)
 *
 * @see ve.ce.GeneratedContentNode#render
 */
ve.ce.MWTransclusionNode.prototype.render = function ( generatedContents ) {
	// Detach the icon
	this.$icon.detach();
	// Call parent mixin
	ve.ce.GeneratedContentNode.prototype.render.call( this, generatedContents );

	// Since render replaces this.$element with a new node, we need to make sure
	// our iconElement is defined again to be this.$element
	this.$element.addClass( 've-ce-mwTransclusionNode' );
};

/**
 * @inheritdoc
 */
ve.ce.MWTransclusionNode.prototype.getRenderedDomElements = function ( domElements ) {
	var $elements = $( ve.ce.GeneratedContentNode.prototype.getRenderedDomElements.call( this, domElements ) ),
		transclusionNode = this;
	if ( this.getModelHtmlDocument() ) {
		$elements
			.find( 'a[href][rel="mw:WikiLink"]' ).addBack( 'a[href][rel="mw:WikiLink"]' )
			.each( function () {
				var targetData = ve.dm.MWInternalLinkAnnotation.static.getTargetDataFromHref(
						this.href, transclusionNode.getModelHtmlDocument()
					),
					normalisedHref = ve.safeDecodeURIComponent( targetData.title );
				if ( mw.Title.newFromText( normalisedHref ) ) {
					normalisedHref = mw.Title.newFromText( normalisedHref ).getPrefixedText();
				}
				ve.init.platform.linkCache.styleElement( normalisedHref, $( this ) );
			} );
	}
	return $elements.toArray();
};

/**
 * Handle an unsuccessful response from the parser for the wikitext fragment.
 *
 * @param {jQuery.Deferred} deferred The promise object created by #generateContents
 * @param {Object} response Response data
 */
ve.ce.MWTransclusionNode.prototype.onParseError = function ( deferred ) {
	deferred.reject();
};

/* Concrete subclasses */

/**
 * ContentEditable MediaWiki transclusion block node.
 *
 * @class
 * @extends ve.ce.MWTransclusionNode
 * @constructor
 * @param {ve.dm.MWTransclusionBlockNode} model Model to observe
 */
ve.ce.MWTransclusionBlockNode = function VeCeMWTransclusionBlockNode( model ) {
	// Parent constructor
	ve.ce.MWTransclusionBlockNode.super.call( this, model );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWTransclusionBlockNode, ve.ce.MWTransclusionNode );

/* Static Properties */

ve.ce.MWTransclusionBlockNode.static.name = 'mwTransclusionBlock';

ve.ce.MWTransclusionBlockNode.static.tagName = 'div';

/**
 * ContentEditable MediaWiki transclusion inline node.
 *
 * @class
 * @extends ve.ce.MWTransclusionNode
 * @constructor
 * @param {ve.dm.MWTransclusionInlineNode} model Model to observe
 */
ve.ce.MWTransclusionInlineNode = function VeCeMWTransclusionInlineNode( model ) {
	// Parent constructor
	ve.ce.MWTransclusionInlineNode.super.call( this, model );
};

/* Inheritance */

OO.inheritClass( ve.ce.MWTransclusionInlineNode, ve.ce.MWTransclusionNode );

/* Static Properties */

ve.ce.MWTransclusionInlineNode.static.name = 'mwTransclusionInline';

ve.ce.MWTransclusionInlineNode.static.tagName = 'span';

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWTransclusionNode );
ve.ce.nodeFactory.register( ve.ce.MWTransclusionBlockNode );
ve.ce.nodeFactory.register( ve.ce.MWTransclusionInlineNode );
