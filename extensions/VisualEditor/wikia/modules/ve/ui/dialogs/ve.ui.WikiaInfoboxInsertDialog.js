/*
 * VisualEditor user interface WikiaInfoboxInsertDialog class.
 */

/*global mw*/

/**
 * Dialog for inserting portable infobox templates.
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
ve.ui.WikiaInfoboxInsertDialog.static.size = 'medium';

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

	// Load select widget
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
			.done( this.insertInfoboxTemplate.bind( this ) );

		// TODO: Track
		ve.track( 'wikia', {
			action: ve.track.actions.ADD,
			label: 'infobox-template-insert-from-plain-list'
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
			//TODO: change to non-mocky url
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
ve.ui.WikiaInfoboxInsertDialog.prototype.insertInfoboxTemplate = function () {
	ve.init.target.constructor.static.apiRequest({
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
ve.ui.WikiaInfoboxInsertDialog.prototype.onParseSuccess = function () {
	var type = 'mwTransclusionBlock',
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
	this.fragment = this.getFragment()
		.collapseToEnd()
		.setAutoSelect( true )
		.insertContent( linmod );
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

	//setTimeout used for calling command for the node after current stack us cleared.
	//getFocusedNode can be not known here yet
	setTimeout( function () {
		ve.ui.commandRegistry.getCommandForNode( this.surface.getView().getFocusedNode() ).execute( this.surface );
	}.bind( this ), 0 );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaInfoboxInsertDialog );
