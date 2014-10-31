/*
 * VisualEditor user interface WikiaTemplateInsertDialog class.
 */

/*global mw*/

/**
 * Dialog for inserting templates.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaTemplateInsertDialog = function VeUiWikiaTemplateInsertDialog( config ) {
	// Parent constructor
	ve.ui.WikiaTemplateInsertDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTemplateInsertDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaTemplateInsertDialog.static.name = 'wikiaTemplateInsert';

ve.ui.WikiaTemplateInsertDialog.static.icon = 'template';

ve.ui.WikiaTemplateInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-template-insert-title' );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaTemplateInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaTemplateInsertDialog.super.prototype.initialize.call( this );

	// Properties
	this.search = new ve.ui.WikiaTemplateSearchWidget( {
		'placeholder': ve.msg( 'wikia-visualeditor-dialog-wikiatemplateinsert-search' ),
		'clearable': true
	} );

	// Events
	this.search.connect( this, {
		'select': 'onTemplateSelect'
	} );

	// Initialization
	this.frame.$content.addClass( 've-ui-wikiaTemplateInsertDialog' );
	this.$body.append( this.search.$element );
};

/**
 * Handle selecting results.
 *
 * @method
 * @param {Object|null} itemData Data of selected item, or null
 */
ve.ui.WikiaTemplateInsertDialog.prototype.onTemplateSelect = function ( itemData ) {
	var template;

	if ( itemData ) {
		this.$frame.startThrobbing();
		this.transclusionModel = new ve.dm.WikiaTransclusionModel();
		template = ve.dm.MWTemplateModel.newFromName(
			this.transclusionModel, itemData.title
		);
		this.transclusionModel.addPart( template )
			.done( ve.bind( this.insertTemplate, this ) );

		// Track
		ve.track( 'wikia', {
			'action': ve.track.actions.ADD,
			// Only suggestions data have "uses" information - so use it to determine where
			// insertion is coming from
			'label': 'template-insert-from-' + ( 'uses' in itemData ? 'suggestions' : 'search' )
		} );
	}
};

/**
 * Insert template
 */
ve.ui.WikiaTemplateInsertDialog.prototype.insertTemplate = function () {
	ve.init.target.constructor.static.apiRequest( {
		'action': 'visualeditor',
		'paction': 'parsefragment',
		'page': mw.config.get( 'wgRelevantPageName' ),
		'wikitext': this.transclusionModel.getWikitext()
	}, { 'type': 'POST' } )
		.done( ve.bind( this.onParseSuccess, this ) )
		.fail( ve.bind( function () {
			// TODO: Implement some proper handling, at least tracking
		}, this ) );
};

/**
 * Handle a successful response from the parser for the wikitext fragment.
 *
 * @param {Object} response Response data
 */
ve.ui.WikiaTemplateInsertDialog.prototype.onParseSuccess = function ( response ) {
	// Deferred is used here only to allow for reusing MWTransclusionNode.onParseSuccess
	// method instead of having to do a code duplication. It's not a prefect approach
	// and it is a subject to change - based on the future discussion.
	var deferred = $.Deferred();
	ve.ce.MWTransclusionNode.prototype.onParseSuccess( deferred, response );
	deferred.done( ve.bind( function ( contents ) {
		var isInline = this.constructor.static.isHybridInline( contents ),
			type = isInline ? 'mwTransclusionInline' : 'mwTransclusionBlock',
			linmod = [
				{
					'type': type,
					'attributes': {
						'mw': this.transclusionModel.getPlainObject()
					}
				},
				{ 'type': '/' + type }
			];

		this.surface.getModel().getDocument().once( 'transact', ve.bind( this.onTransact, this ) );

		// Fill out the cache so MWTransclusionNode does not have to send exact same
		// parsefragment request.
		this.fragment.getDocument().getStore().index(
			contents,
			OO.getHash( [ ve.dm.MWTransclusionNode.static.getHashObject( linmod[0] ), null ] )
		);

		this.fragment = this.getFragment()
			.collapseRangeToEnd()
			.setAutoSelect( true )
			.insertContent( linmod );
	}, this ) );
};

/**
 * Determine if a hybrid element is inline and allowed to be inline in this context
 *
 * We generate block elements for block tags and inline elements for inline
 * tags.
 *
 * @param {HTMLElement[]} domElements DOM elements being converted
 * @returns {boolean} The element is inline
 */
ve.ui.WikiaTemplateInsertDialog.static.isHybridInline = function ( domElements ) {
	var i, length, allTagsInline = true;
	for ( i = 0, length = domElements.length; i < length; i++ ) {
		if ( ve.isBlockElement( domElements[i] ) ) {
			allTagsInline = false;
			break;
		}
	}
	return allTagsInline;
};

/**
 * Handle document model transaction
 *
 * Once the transclusionModel has inserted the transclusion, the new node in the surface will be selected.
 * We can ask the commandRegistry for the command for the node and execute it.
 */
ve.ui.WikiaTemplateInsertDialog.prototype.onTransact = function () {
	this.$frame.stopThrobbing();
	setTimeout( ve.bind( function () {
		ve.ui.commandRegistry.getCommandForNode(
			this.surface.getView().getFocusedNode()
		).execute( this.surface );

		ve.track( 'wikia', {
			'action': ve.track.actions.ADD,
			'label': 'dialog-template-insert'
		} );

	}, this ), 0 );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTemplateInsertDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.WikiaTemplateInsertDialog.super.prototype.getTeardownProcess.call( this, data )
		.next( function () {
			// Reset the search widget
			this.search.reset();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaTemplateInsertDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.WikiaTemplateInsertDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			// Focus cursor in search input
			this.search.focusQuery();
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaTemplateInsertDialog );
