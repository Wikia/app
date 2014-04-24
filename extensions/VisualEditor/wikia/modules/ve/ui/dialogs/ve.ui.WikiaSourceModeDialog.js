
/*!
 * VisualEditor user interface WikiaSourceModeDialog class.
 */

/*global mw*/

/**
 * Dialog for editing wikitext in source mode.
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSourceModeDialog = function VeUiWikiaSourceModeDialog( config ) {
	// Parent constructor
	ve.ui.Dialog.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaSourceModeDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.WikiaSourceModeDialog.static.name = 'wikiaSourceMode';

ve.ui.WikiaSourceModeDialog.static.titleMessage = 'wikia-visualeditor-dialog-wikiasourcemode-title';

ve.ui.WikiaSourceModeDialog.static.icon = 'source';

/* Methods */

ve.ui.WikiaSourceModeDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.Dialog.prototype.initialize.call( this );

	// Properties
	this.openCount = 0;
	this.timings = {};
	this.sourceModeTextarea = new OO.ui.TextInputWidget({
		'$': this.$,
		'multiline': true
	});
	this.applyButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'wikia-visualeditor-dialog-wikiasourcemode-apply-button' ),
		'flags': ['primary']
	} );
	this.$helpLink = this.$('<a>')
		.addClass( 've-ui-wikiaSourceModeDialog-helplink' )
		.attr( {
			'href': new mw.Title( ve.msg( 'wikia-visualeditor-dialog-wikiasourcemode-help-link' ) ).getUrl(),
			'target': '_blank'
		} )
		.text( ve.msg( 'wikia-visualeditor-dialog-wikiasourcemode-help-text' ) );

	// Events
	this.applyButton.connect( this, { 'click': [ 'onApply' ] } );

	// Initialization
	this.$body.append( this.sourceModeTextarea.$element );
	this.$foot.append( this.$helpLink, this.applyButton.$element );
	this.frame.$content.addClass( 've-ui-wikiaSourceModeDialog-content' );
};

/**
 * Handle opening the dialog.
 *
 * @method
 */
ve.ui.WikiaSourceModeDialog.prototype.setup = function () {
	var doc = this.surface.getModel().getDocument();

	this.openCount++;
	this.timings.serializeStart = ve.now();

	// Parent method
	ve.ui.Dialog.prototype.setup.call( this );

	this.$frame.startThrobbing();
	this.surface.getTarget().serialize(
		ve.dm.converter.getDomFromData( doc.getFullData(), doc.getStore(), doc.getInternalList() ),
		ve.bind( this.onSerialize, this )
	);
};

/**
 * @method
 * @param {string} wikitext Wikitext returned from Parsoid.
 */
ve.ui.WikiaSourceModeDialog.prototype.onSerialize = function ( wikitext ) {
	this.sourceModeTextarea.setValue( wikitext );
	this.sourceModeTextarea.$input.focus();
	this.$frame.stopThrobbing();

	ve.track( 'wikia', {
		'action': ve.track.actions.SUCCESS,
		'label': 'dialog-source-serialize',
		'value': ve.now() - this.timings.serializeStart
	} );
};

/**
 * @method
 */
ve.ui.WikiaSourceModeDialog.prototype.onApply = function () {
	ve.track( 'wikia', { 'action': ve.track.actions.CLICK, 'label': 'dialog-source-button-save' } );
	this.timings.parseStart = ve.now();
	this.$frame.startThrobbing();
	this.parse();
};

/**
 * @method
 */
ve.ui.WikiaSourceModeDialog.prototype.getWikitext = function() {
	return this.sourceModeTextarea.getValue();
};

/**
 * @method
 */
ve.ui.WikiaSourceModeDialog.prototype.parse = function( ) {
	$.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'action': 'visualeditor',
			'paction': 'parsewt',
			'page': mw.config.get( 'wgRelevantPageName' ),
			'wikitext': this.sourceModeTextarea.getValue(),
			'token': mw.user.tokens.get( 'editToken' ),
			'format': 'json'
		},
		'dataType': 'json',
		'type': 'POST',
		// Wait up to 100 seconds before giving up
		'timeout': 100000,
		'cache': 'false',
		'success': ve.bind( this.onParseSuccess, this ),
		'error': ve.bind( this.onParseError, this ),
		'complete': ve.bind( function() {
			this.$frame.stopThrobbing();
		} , this )
	} );
};

/**
 * @method
 */
ve.ui.WikiaSourceModeDialog.prototype.onParseSuccess = function( response ) {
	var target;
	if ( !response || response.error || !response.visualeditor || response.visualeditor.result !== 'success' ) {
		return this.onParseError.call( this );
	}

	// TODO: Close is called in this way in order to be synchronous (compare with OO.ui.Dialog.close)
	// otherwise it was causing problems with stealing the focus from newly created surface.
	OO.ui.Window.prototype.close.call( this );
	$( window ).off( 'mousewheel', this.onWindowMouseWheelHandler );
	$( document ).off( 'keydown', this.onDocumentKeyDownHandler );

	// TODO: This whole approach is based on ve.init.mw.ViewPageTarget.js and contains a lot of code
	// duplication, it should be discussed with WMF guys and refactored.
	target = this.surface.getTarget();

	target.deactivating = true;
	target.tearDownToolbarButtons();
	target.detachToolbarButtons();
	target.saveDialog.reset();
	target.saveDialog.close();

	target.tearDownSurface( false );

	target.wikitext = this.sourceModeTextarea.getValue();

	target.activating = true;
	target.edited = true;
	target.doc = ve.createDocumentFromHtml( response.visualeditor.content );
	target.setUpSurface( target.doc, ve.bind( function() {
		this.editNotices = {};
		this.setupToolbarButtons();
		this.setupSaveDialog();
		this.attachToolbarButtons();
		this.$document[0].focus();
		this.activating = false;

		ve.track( 'wikia', {
			'action': ve.track.actions.SUCCESS,
			'label': 'dialog-source-parse',
			'value': ve.now() - this.timings.parseStart
		} );
	}, target ), false );
};

/**
 * @method
 */
ve.ui.WikiaSourceModeDialog.prototype.onParseError = function ( ) {
	ve.track( 'wikia', {
		'action': ve.track.actions.ERROR,
		'label': 'dialog-source-parse',
		'value': ve.now() - this.timings.parseStart
	} );
	// TODO: error handling?
};

ve.ui.dialogFactory.register( ve.ui.WikiaSourceModeDialog );
