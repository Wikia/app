/*!
 * VisualEditor user interface WikiaSourceModeDialog class.
 */

/*global mw*/

/**
 * Dialog for editing wikitext in source mode.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSourceModeDialog = function VeUiMWSourceModeDialog( surface, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaSourceModeDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.WikiaSourceModeDialog.static.name = 'wikiaSourceMode';

ve.ui.WikiaSourceModeDialog.static.titleMessage = 'visualeditor-dialog-source-mode-title';

ve.ui.WikiaSourceModeDialog.static.icon = 'source';

/* Methods */

ve.ui.WikiaSourceModeDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

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
	ve.ui.MWDialog.prototype.onOpen.call( this );

	var doc = this.surface.getModel().getDocument();
	// TODO: display loading graphic

	// Request wikitext
	this.surface.target.serialize(
		ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList() ),
		ve.bind( this.onSerialize, this )
	);

};

ve.ui.WikiaSourceModeDialog.prototype.onSerialize = function ( wikitext ) {
	this.sourceModeTextarea.$input.val( wikitext );
	// TODO: remove loading graphic
};

ve.ui.WikiaSourceModeDialog.prototype.onApply = function ( action, wikitext ) {
	if( action === 'parse' ) {
		this.parse( )
	}
};

ve.ui.WikiaSourceModeDialog.prototype.getWikitext = function() {
	return this.sourceModeTextarea.$input.val();
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
			'paction': 'parsefragment',
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
		'error': ve.bind( this.onParseError, this, deferred )
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
	// TODO: update surface with response.visualeditor.content (html)
};

ve.ui.WikiaSourceModeDialog.prototype.onParseError = function ( deferred ) {
	// TODO: error handling?
	deferred.reject();
};

ve.ui.dialogFactory.register( ve.ui.WikiaSourceModeDialog );
