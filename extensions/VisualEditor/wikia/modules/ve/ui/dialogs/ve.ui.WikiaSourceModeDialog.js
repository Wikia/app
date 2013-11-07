/*!
 * VisualEditor user interface WikiaSourceModeDialog class.
 */

/*global mw*/

/**
 * Dialog for editing wikitext in source mode.
 *
 * @class
 * @extends ve.ui.WikiaDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSourceModeDialog = function VeUiWikiaSourceModeDialog( surface, config ) {
	// Parent constructor
	ve.ui.WikiaDialog.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaSourceModeDialog, ve.ui.WikiaDialog );

/* Static Properties */

ve.ui.WikiaSourceModeDialog.static.name = 'wikiaSourceMode';

ve.ui.WikiaSourceModeDialog.static.titleMessage = 'visualeditor-dialog-source-mode-title';

ve.ui.WikiaSourceModeDialog.static.icon = 'source';

/* Methods */

ve.ui.WikiaSourceModeDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaDialog.prototype.initialize.call( this );

	this.sourceModeTextarea = new ve.ui.TextInputWidget({
		'$$': this.frame.$$,
		'multiline': true
	});
	this.$body.append( this.sourceModeTextarea.$ );

	this.applytButton = new ve.ui.ButtonWidget( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-wikiasourcemode-button-apply' ),
		'flags': ['primary']
	} );
	this.$foot.append( this.applytButton.$ );
	this.applytButton.connect( this, { 'click': [ 'onApply', 'parse' ] } );

	this.frame.$content.addClass( 've-ui-wikiaSourceModeDialog-content' );

};

ve.ui.WikiaSourceModeDialog.prototype.onOpen = function () {
	ve.ui.WikiaDialog.prototype.onOpen.call( this );

	var doc = this.surface.getModel().getDocument();

	// Display loading graphic
	this.startLoading();

	// Request wikitext
	this.surface.getTarget().serialize(
		ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList() ),
		ve.bind( this.onSerialize, this )
	);

};

ve.ui.WikiaSourceModeDialog.prototype.onSerialize = function ( wikitext ) {
	this.sourceModeTextarea.setValue( wikitext );
	this.stopLoading();
};

ve.ui.WikiaSourceModeDialog.prototype.onApply = function ( action, wikitext ) {
	if( action === 'parse' ) {
		this.startLoading();
		this.parse();
	}
};

ve.ui.WikiaSourceModeDialog.prototype.getWikitext = function() {
	return this.sourceModeTextarea.getValue();
};

ve.ui.WikiaSourceModeDialog.prototype.parse = function( ) {
	// TODO: I basically just copied and pasted this function from ve.ce.MWTransclusionNode.js
	// maybe we should create a common helper function for this sort of thing.
	var xhr, promise, wikitext, deferred;

	deferred = $.Deferred();
	wikitext = this.getWikitext();

	xhr = $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'action': 'visualeditor',
			// NOTE: neither of these (parse / parsefragment) is the API we want, that will be written next
			'paction': 'wikiaparse',
			//'paction': 'parsefragment',
			'page': mw.config.get( 'wgRelevantPageName' ),
			'wikitext': wikitext,
			'token': mw.user.tokens.get( 'editToken' ),
			'format': 'json'
		},
		'dataType': 'json',
		'type': 'POST',
		// Wait up to 100 seconds before giving up
		'timeout': 100000,
		'cache': 'false',
		'success': ve.bind( this.onParseSuccess, this, deferred ),
		'error': ve.bind( this.onParseError, this, deferred ),
		'complete': ve.bind( this.stopLoading, this )
	} );
	promise = deferred.promise();
	promise.abort = function () {
		xhr.abort();
	};
	return promise;

};

ve.ui.WikiaSourceModeDialog.prototype.onParseSuccess = function( deferred, response ) {
	if ( !response || response.error || !response.visualeditor || response.visualeditor.result !== 'success' ) {
		return this.onParseError.call( this, deferred );
	}

	this.surface.getTarget().setWikitext( this.getWikitext() );
 
 	var surfaceModel = this.surface.getModel(),
		doc = surfaceModel.getDocument();

	surfaceModel.change(
		ve.dm.Transaction.newFromRemoval( doc, doc.getDocumentNode().getRange() )
	);

	if ( doc.metadata.data[0].length ) {
		surfaceModel.change(
			ve.dm.Transaction.newFromMetadataRemoval( doc, 0, new ve.Range( 0, doc.metadata.data[0].length ) )
		);
	}


	var store = new ve.dm.IndexValueStore();
	var internalList = new ve.dm.InternalList();
	var fullData = ve.dm.converter.getDataFromDom( ve.createDocumentFromHtml( response.visualeditor.content ), store, internalList );
	var newDoc = new ve.dm.Document( fullData, null, internalList );
	//var newDoc = new ve.dm.Document ( ve.createDocumentFromHtml( response.visualeditor.content ) );


	var tx = ve.dm.Transaction.newFromDocumentReplace( doc, new ve.Range(0,0), newDoc );
	surfaceModel.change(
		tx,
		new ve.Range(0,0)
	);
	this.close();

	/*
		new ve.Range( 0, this.surface.model.documentModel.metadata.data[0].length )






	var surface = this.surface
	t2 = ve.dm.Transaction.newFromRemoval(ve.instances[0].model.documentModel, ve.instances[0].model.documentModel.documentNode.getRange(), true)
	t2 = ve.dm.Transaction.newFromMetadataRemoval(ve.instances[0].model.documentModel, 0, new ve.Range(0,3))








	var newDoc, doc, surfaceModel, tx;

	surfaceModel = this.surface.getModel();
	doc = surfaceModel.getDocument();

	newDoc = new ve.dm.Document ( ve.createDocumentFromHtml( response.visualeditor.content ) );

	// Create a new transaction to change surfaceModel.
	// Note: there is a bug where the last metadata item needs to be processed with tx.pushReplaceMetadata.
	// Ask Roan, I'm really not sure what that's about - Liz
	tx = new ve.dm.Transaction();

	tx.pushReplace( doc, 0, doc.data.data.length, newDoc.data.data,
		( newDoc.metadata.data.length ? newDoc.metadata.data : [] )
		//( newDoc.metadata.data.length ? newDoc.metadata.data.slice( 0, -1 ) : [] )
	);

	/*tx.pushReplaceMetadata(
		// only send the last items
		( doc.metadata.data.length ? doc.metadata.data[doc.metadata.data.length - 1] : [] ),
		( newDoc.metadata.data.length ? newDoc.metadata.data[doc.metadata.data.length - 1] : [] )
	);*/

	surfaceModel.change( tx, new ve.Range( 0 ) );

	this.close();
	*/
};

ve.ui.WikiaSourceModeDialog.prototype.onParseError = function ( deferred ) {
	// TODO: error handling?
	deferred.reject();
};

ve.ui.WikiaSourceModeDialog.prototype.onClose = function () {
	this.sourceModeTextarea.setValue( '' );
};

ve.ui.dialogFactory.register( ve.ui.WikiaSourceModeDialog );
