/*
 * VisualEditor user interface WikiaTemplateInsertDialog class.
 */

/*global mw*/

/**
 * Dialog for inserting templates.
 *
 * @class
 * @extends ve.ui.FragmentDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaInfoboxInsertDialog = function VeUiWikiaInfoboxInsertDialog( config ) {
	// Parent constructor
	ve.ui.WikiaInfoboxInsertDialog.super.call( this, config );

	// Properties
	this.surface = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaInfoboxInsertDialog, ve.ui.FragmentDialog );

/* Static Properties */

ve.ui.WikiaInfoboxInsertDialog.static.name = 'wikiaInfoboxInsert';

//TODO: introduce new translation
ve.ui.WikiaInfoboxInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-infobox-insert-title' );
ve.ui.WikiaInfoboxInsertDialog.static.title = 'Insert infobox :)';

ve.ui.WikiaInfoboxInsertDialog.static.size = '800px';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaInfoboxInsertDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.surface = data.surface;
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getBodyHeight = function () {
	return 600;
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaInfoboxInsertDialog.super.prototype.initialize.call( this );

	// Initialization
	this.$content.addClass( 've-ui-wikiaInfoboxInsertDialog' );
	// Properties
	this.loadInfoboxTemplates();
	this.select = new OO.ui.SelectWidget();

	// Events
	this.select.connect( this, {
		select: 'onInfoboxTemplateSelect'
	} );

	this.$body.append( this.select.$element );
};

/**
 * Handle selecting results.
 *
 * @method
 * @param {Object|null} itemData Data of selected item, or null
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.onInfoboxTemplateSelect = function ( itemData ) {
	var template;

	if ( itemData ) {
		this.$frame.startThrobbing();
		this.transclusionModel = new ve.dm.WikiaTransclusionModel();
		template = ve.dm.MWTemplateModel.newFromName(
			this.transclusionModel, itemData.data
		);
		this.transclusionModel.addPart( template )
			.done( this.insertTemplate.bind( this ) );

		// Track
		ve.track( 'wikia', {
			action: ve.track.actions.ADD,
			label: 'infobox-insert-from-plain-list'
		} );
	}
};

ve.ui.WikiaInfoboxInsertDialog.prototype.loadInfoboxTemplates = function () {
	this.getInfoboxTemplates().done(
		this.showResults.bind( this )
	);
};

ve.ui.WikiaInfoboxInsertDialog.prototype.getInfoboxTemplates = function () {
	var deferred;
	if ( !this.gettingTemplateNames ) {
		deferred = $.Deferred();
		$.ajax( {
			dataType: 'json',
			url: 'http://public.diana.wikia-dev.com/infobox_templates.php'
		} )
			.done( function ( data ) {
				deferred.resolve( data.items );
			} )
			.fail( function () {
				// TODO: Add better error handling.
				deferred.resolve( [] );
			} );
		this.gettingTemplateNames = deferred.promise();
	}
	return this.gettingTemplateNames;
};

/**
 * Insert template
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.insertTemplate = function () {
	ve.init.target.constructor.static.apiRequest( {
		action: 'visualeditor',
		paction: 'parsefragment',
		page: mw.config.get( 'wgRelevantPageName' ),
		wikitext: this.transclusionModel.getWikitext()
	}, { type: 'POST' } )
		.done( this.onParseSuccess.bind( this ) )
		.fail( function () {
			// TODO: Implement some proper handling, at least tracking
		}.bind( this ) );
};

ve.ui.WikiaInfoboxInsertDialog.prototype.showResults = function ( data ) {
	var items = [], i;

	if ( data.length > 0 ) {
		for ( i = 0; i < data.length; i++ ) {
			items.push(
				new ve.ui.WikiaInfoboxOptionWidget({
					data: data[i].title,
					label:  data[i].label
				})
			);
		}
		this.select.addItems( items );
	}
};

/**
 * Handle a successful response from the parser for the wikitext fragment.
 *
 * @param {Object} response Response data
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.onParseSuccess = function ( response ) {
	// Deferred is used here only to allow for reusing MWTransclusionNode.onParseSuccess
	// method instead of having to do a code duplication. It's not a prefect approach
	// and it is a subject to change - based on the future discussion.
	var deferred = $.Deferred();
	ve.ce.MWTransclusionNode.prototype.onParseSuccess.call( this, deferred, response );
	deferred.done( function ( contents ) {
		var isInline = this.constructor.static.isHybridInline( contents ),
			type = isInline ? 'mwTransclusionInline' : 'mwTransclusionBlock',
			linmod = [
				{
					type: type,
					attributes: {
						mw: this.transclusionModel.getPlainObject()
					}
				},
				{ type: '/' + type }
			];

		this.surface.getModel().getDocument().once( 'transact', this.onTransact.bind( this ) );

		// Fill out the cache so MWTransclusionNode does not have to send exact same
		// parsefragment request.
		this.fragment.getDocument().getStore().index(
			contents,
			OO.getHash( [ ve.dm.MWTransclusionNode.static.getHashObject( linmod[0] ), null ] )
		);

		this.fragment = this.getFragment()
			.collapseToEnd()
			.setAutoSelect( true )
			.insertContent( linmod );
	}.bind( this ) );
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
ve.ui.WikiaInfoboxInsertDialog.static.isHybridInline = function ( domElements ) {
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
ve.ui.WikiaInfoboxInsertDialog.prototype.onTransact = function () {
	ve.track( 'wikia', {
		action: ve.track.actions.ADD,
		label: 'dialog-infobox-insert'
	} );
	this.$frame.stopThrobbing();
	this.close();
	setTimeout( function () {
		ve.ui.commandRegistry.getCommandForNode( this.surface.getView().getFocusedNode() ).execute( this.surface );
	}.bind( this ), 0 );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaInfoboxInsertDialog );
