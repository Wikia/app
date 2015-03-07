/*!
 * VisualEditor user interface WikiaSourceModeDialog class.
 */

/*global alert, veTrack */

/**
 * Dialog for editing wikitext in source mode.
 *
 * @class
 * @extends OO.ui.ProcessDialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSourceModeDialog = function VeUiWikiaSourceModeDialog( config ) {
	// Parent constructor
	ve.ui.WikiaSourceModeDialog.super.call( this, config );

	// Properties
	this.surface = null;
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaSourceModeDialog, ve.ui.FragmentDialog );

/* Static Properties */

ve.ui.WikiaSourceModeDialog.static.name = 'wikiaSourceMode';

ve.ui.WikiaSourceModeDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-wikiasourcemode-title' );

// as in OO.ui.WindowManager.static.sizes
ve.ui.WikiaSourceModeDialog.static.size = 'large';

ve.ui.WikiaSourceModeDialog.static.icon = 'source';

ve.ui.WikiaSourceModeDialog.static.actions = [
	{
		action: 'apply',
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-apply' ),
		flags: [ 'progressive', 'primary' ]
	},
	{
		label: OO.ui.deferMsg( 'visualeditor-dialog-action-cancel' ),
		flags: 'safe'
	}
];

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaSourceModeDialog.prototype.getBodyHeight = function () {
	return 600;
};

/**
 * @inheritdoc
 */
ve.ui.WikiaSourceModeDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaSourceModeDialog.super.prototype.initialize.call( this );

	// Properties
	this.openCount = 0; // tracking
	this.timings = {}; // tracking
	this.sourceModeTextarea = new OO.ui.TextInputWidget({
		$: this.$,
		multiline: true
	});

	this.initLinkSuggest();
	this.$body.append( this.sourceModeTextarea.$element );
	this.$content.addClass( 've-ui-wikiaSourceModeDialog-content' );
};

/**
 * Initialize link suggest (if available)
 *
 * @method
 */
ve.ui.WikiaSourceModeDialog.prototype.initLinkSuggest = function () {
	if ( !!mw.loader.getState( 'ext.wikia.LinkSuggest' ) ) {
		// jquery.ui.autocomplete.js
		this.sourceModeTextarea.$input.css( {
			'z-index': 9999999,
			position: 'relative'
		} );
		mw.loader.using(
			'ext.wikia.LinkSuggest',
			function () {
				this.sourceModeTextarea.$input.linksuggest();
			}.bind( this )
		);
	}
};

/**
 * @inheritdoc
 */
ve.ui.WikiaSourceModeDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaSourceModeDialog.super.prototype.getSetupProcess.call( this, data )
		.first( function () {
			this.surface = data.surface;
			this.openCount++;
			this.timings.serializeStart = ve.now();
		}, this )
		.next( function () {
			this.$content.startThrobbing();
			this.surface.getTarget().serialize(
				ve.dm.converter.getDomFromModel( this.getFragment().getDocument(), false ),
				this.onSerialize.bind( this )
			);
		}, this );
};

/**
 * @method
 * @param {string} wikitext Wikitext returned from Parsoid.
 */
ve.ui.WikiaSourceModeDialog.prototype.onSerialize = function ( wikitext ) {
	this.sourceModeTextarea.setValue( wikitext );
	this.sourceModeTextarea.$input.focus();
	this.$content.stopThrobbing();

	ve.track( 'wikia', {
		action: ve.track.actions.SUCCESS,
		label: 'dialog-source-serialize',
		value: ve.now() - this.timings.serializeStart
	} );
};

ve.ui.WikiaSourceModeDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'apply' ) {
		return new OO.ui.Process( function () {
			this.timings.parseStart = ve.now();
			this.$content.startThrobbing();
			this.parse()
				.done( this.onParseDone.bind( this) )
				.fail( this.onParseFail.bind( this) );
		}, this );
	}
	return ve.ui.WikiaSourceModeDialog.super.prototype.getActionProcess.call( this, action );
};

ve.ui.WikiaSourceModeDialog.prototype.parse = function () {
	return $.ajax( {
		url: mw.util.wikiScript( 'api' ),
		data: {
			action: 'visualeditor',
			paction: 'parsefragment',
			page: mw.config.get( 'wgRelevantPageName' ),
			wikitext: this.sourceModeTextarea.getValue(),
			token: mw.user.tokens.get( 'editToken' ),
			format: 'json'
		},
		dataType: 'json',
		type: 'POST',
		// Wait up to 100 seconds before giving up
		timeout: 100000,
		cache: 'false'
	} );
};

ve.ui.WikiaSourceModeDialog.prototype.onParseDone = function ( response ) {
	if ( !response ||
		response.error ||
		!response.visualeditor ||
		response.visualeditor.result !== 'success' ||
		response.visualeditor.content === false ) {
		return this.onParseFail.call( this );
	}
	this.close().done( function () {
		var target = this.surface.getTarget();
		target.deactivating = true;
		target.toolbarSaveButton.disconnect( target );
		target.toolbarSaveButton.$element.detach();
		target.getToolbar().$actions.empty();
		target.tearDownSurface( true ).done( function () {
			target.deactivating = false;
			target.wikitext = this.sourceModeTextarea.getValue();
			target.activating = true;
			target.edited = true;
			target.doc = ve.createDocumentFromHtml( response.visualeditor.content );
			target.docToSave = null;
			target.clearPreparedCacheKey();
			target.setupSurface( target.doc, function () {
				target.startSanityCheck();
				target.emit( 'surfaceReady' );
			} );
		}.bind( this ) );
	}.bind( this ) );
};

ve.ui.WikiaSourceModeDialog.prototype.onParseFail = function ( ) {
	ve.track( 'wikia', {
		action: ve.track.actions.ERROR,
		label: 'dialog-source-parse',
		value: ve.now() - this.timings.parseStart
	} );
	if ( window.veTrack ) {
		veTrack( {
			action: 'parsoid-parsewt-error'
		} );
	}
	alert( ve.msg( 'wikia-visualeditor-save-error-generic' ) );
	this.$content.stopThrobbing();
};

ve.ui.windowFactory.register( ve.ui.WikiaSourceModeDialog );
