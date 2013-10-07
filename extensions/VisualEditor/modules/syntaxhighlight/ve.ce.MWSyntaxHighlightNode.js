/*!
 * VisualEditor ContentEditable MWSyntaxHighlightNode class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * ContentEditable MediaWiki syntaxhighlight node.
 *
 * @class
 * @extends ve.ce.LeafNode
 * @mixins ve.ce.FocusableNode
 * @mixins ve.ce.ProtectedNode
 * @mixins ve.ce.GeneratedContentNode
 *
 * @constructor
 * @param {ve.dm.MWSyntaxHighlightNode} model Model to observe
 * @param {Object} [config] Config options
 */
ve.ce.MWSyntaxHighlightNode = function VeCeMWSyntaxHighlightNode( model, config ) {
	// Parent constructor
	ve.ce.LeafNode.call( this, model, config );

	// Mixin constructors
	ve.ce.FocusableNode.call( this );
	ve.ce.ProtectedNode.call( this );
	ve.ce.GeneratedContentNode.call( this );

	// DOM Changes
	this.$.addClass( 've-ce-MWSyntaxHighlightNode mwSyntaxHighlight' );

	// Helpers
	this.highlighter = null;
	this.tokenizer = null;

	// Events
	this.model.connect( this, { 'update': 'update' } );

	// Initialization
	this.update();
};

/* Inheritance */

ve.inheritClass( ve.ce.MWSyntaxHighlightNode, ve.ce.LeafNode );

ve.mixinClass( ve.ce.MWSyntaxHighlightNode, ve.ce.FocusableNode );
ve.mixinClass( ve.ce.MWSyntaxHighlightNode, ve.ce.ProtectedNode );
ve.mixinClass( ve.ce.MWSyntaxHighlightNode, ve.ce.GeneratedContentNode );

/* Static Properties */

ve.ce.MWSyntaxHighlightNode.static.name = 'mwSyntaxHighlight';

ve.ce.MWSyntaxHighlightNode.static.tagName = 'div';

ve.ce.MWSyntaxHighlightNode.static.renderHtmlAttributes = true;

/* Methods */

/**
 * Called when the node starts generating new content.
 * @method
 */
ve.ce.MWSyntaxHighlightNode.prototype.startGenerating = function () {
	var lang = this.model.getAttribute( 'lang' );

	// Properties
	this.$wrapper = this.$$( '<div>' );
	this.$code = this.$$( '<pre>' );

	// Initialization
	this.$wrapper
		.addClass( lang + ' source-' + lang )
		.append( this.$code );
	// TODO perhaps replace with a prettier loading bar
	this.$code.text( '[ Generating code preview... ]' );
	this.highlighter = new ve.ce.MWSyntaxHighlightHighlighter( lang );
	this.tokenizer = new ve.dm.MWSyntaxHighlightTokenizer();
};

/**
 * Start a deferred process to generate the contents of the node.
 * @returns {jQuery.Promise} Promise object
 */
ve.ce.MWSyntaxHighlightNode.prototype.generateContents = function () {
	var data = this.model.getAttribute( 'body' ),
		tokens = this.tokenizer.tokenize(data);
	if ( this.highlighter.isSupportedLanguage() ){
		if ( this.highlighter.isEnabledLanguage() ){
			this.highlighter.initialize();
			tokens = this.highlighter.mark(tokens, data, false);
			this.$code.html(this.highlighter.displaySimple(tokens));
		} else {
			this.$code.html(this.highlighter.displaySimple(tokens));
			this.$code.append( '>>>Support for this language is not enabled. Preview in plaintext.' );
		}
	} else {
		this.$code.html(this.highlighter.displaySimple(tokens));
		this.$code.append( '>>>This language is not supported. Preview in plaintext.' );
	}
	return this.$wrapper.promise();
};

/**
 * Called when the has failed to generate new content.
 * @method
 */
ve.ce.MWSyntaxHighlightNode.prototype.failGenerating = function () {
	// TODO perhaps replace with a prettier sad face
	this.$code.text( '[ Unable to generate code preview for this piece. ]' );
	this.generatingPromise = null;
};

/**
 * Called when the node successfully finishes generating new content.
 *
 * @method
 * @param {jQuery} domElements jQuery object Generated content
 */
ve.ce.MWSyntaxHighlightNode.prototype.doneGenerating = function ( domElements ) {
	var store = this.model.doc.getStore(),
		hash = ve.getHash( this.model );
	store.index( domElements.toArray() , hash );
	this.render( domElements.toArray() );
	this.generatingPromise = null;
};

/* Registration */

ve.ce.nodeFactory.register( ve.ce.MWSyntaxHighlightNode );