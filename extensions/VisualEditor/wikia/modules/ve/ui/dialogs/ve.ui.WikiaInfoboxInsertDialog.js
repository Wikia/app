/*
 * VisualEditor user interface WikiaInfoboxInsertDialog class.
 */

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

ve.ui.WikiaInfoboxInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-infobox-insert-title' );

ve.ui.WikiaInfoboxInsertDialog.static.size = 'small';

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
 * Handle selecting infobox template.
 *
 * @method
 * @param {Object|null} itemData Data of selected item, or null
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.onInfoboxTemplateSelect = function ( itemData ) {
	var template;

	if ( itemData ) {
		this.$frame.startThrobbing();
		this.transclusionModel = new ve.dm.WikiaTransclusionModel();
		this.transclusionModel.setIsInfobox( true );
		template = ve.dm.MWTemplateModel.newFromName(
			this.transclusionModel, itemData.data
		);
		this.transclusionModel.addPart( template )
			.done( this.insertInfoboxTemplate.bind( this ) );

		ve.track( 'wikia', {
			action: ve.track.actions.ADD,
			label: 'infobox-template-insert-from-plain-list'
		} );
	}
};

/**
 * Prepare infobox template names
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.loadInfoboxTemplates = function () {
	this.getInfoboxTemplates().done(
		this.showResults.bind( this )
	);
};

/**
 * Fetch infobox template names from API
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getInfoboxTemplates = function () {
	var deferred;
	if ( !this.gettingTemplateNames ) {
		deferred = $.Deferred();
		ve.init.target.constructor.static.apiRequest( {
			action: 'query',
			list: 'allinfoboxes'
		} )
			.done( function ( data ) {
				deferred.resolve( data );
			} )
			.fail( function () {
				// TODO: Add better error handling.
				ve.track( 'wikia', {
					action: ve.track.actions.ERROR,
					label: 'infobox-templates-api'
				} );
				deferred.resolve( {} );
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
			// TODO: Add better error handling.
			ve.track( 'wikia', {
				action: ve.track.actions.ERROR,
				label: 'dialog-infobox-template-insert'
			} );
		}.bind( this ) );
};

/**
 * Add the infobox template names to the dialog's SelectWidget
 *
 * @param {Object} data Response data from API
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.showResults = function ( data ) {
	var i,
		items = [],
		infoboxes = data.query ? data.query.allinfoboxes : [];

	if ( infoboxes.length > 0 ) {
		this.sortTemplateTitles.apply( this, [infoboxes] );
		for ( i = 0; i < infoboxes.length; i++ ) {
			items.push(
				new OO.ui.DecoratedOptionWidget({
					data: infoboxes[i].title,
					label:  infoboxes[i].label
				})
			);
		}
		this.select.addItems( items );
	}
};

/**
 * Sort template titles alphabetically. We don't need to use toLowerCase() or toUpperCase()
 * to unify titles for sorting because title in response from API always will be UpperCased
 *
 * @param array of infoboxes
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.sortTemplateTitles = function ( infoboxes ) {
	var title1, title2;

	return infoboxes.sort( function ( template1, template2 ) {
		title1 = template1.title;
		title2 = template2.title;

		if ( title1 < title2 ) {
			return -1;
		} else if ( title1 > title2 ) {
			return 1;
		}
		return 0;
	});
};

/**
 * Insert prepared linear model to surface.
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.onParseSuccess = function () {
	var type = ve.dm.WikiaInfoboxTransclusionBlockNode.static.name,
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

	//setTimeout used for calling command for the node after current stack is cleared.
	//getFocusedNode can be not known here yet
	setTimeout( function () {
		ve.ui.commandRegistry.getCommandForNode( this.surface.getView().getFocusedNode() ).execute( this.surface );
	}.bind( this ), 0 );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.WikiaInfoboxInsertDialog.super.prototype.getTeardownProcess.call( this, data )
		.next( function () {
			this.select.selectItem();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxInsertDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.WikiaInfoboxInsertDialog.super.prototype.getReadyProcess.call( this, data );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaInfoboxInsertDialog );
