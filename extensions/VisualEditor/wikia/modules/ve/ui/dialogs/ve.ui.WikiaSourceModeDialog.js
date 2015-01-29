/*!
 * VisualEditor user interface WikiaSourceModeDialog class.
 */

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
	return 400;
};

/**
 * @inheritdoc
 */
ve.ui.WikiaSourceModeDialog.prototype.initialize = function () {
	// Parent method
	ve.ui.WikiaSourceModeDialog.super.prototype.initialize.call( this );

	// Properties
	this.openCount = 0;
	this.timings = {};
	this.sourceModeTextarea = new OO.ui.TextInputWidget({
		'$': this.$,
		'multiline': true
	});

	this.$body.append( this.sourceModeTextarea.$element );
	this.$content.addClass( 've-ui-wikiaSourceModeDialog-content' );
};


/**
 * @inheritdoc
 */
ve.ui.WikiaSourceModeDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaSourceModeDialog.super.prototype.getSetupProcess.call( this, data )
		.first( function () {
			this.surface = data.surface;
		}, this )
		.next( function () {
			var doc = this.getFragment().getDocument();
			this.$body.startThrobbing();
			this.actions.setAbilities( { apply: false } );
			this.surface.getTarget().serialize(
				ve.dm.converter.getDomFromModel( doc, false ),
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
	this.$body.stopThrobbing();
	this.actions.setAbilities( { apply: true } );
};



ve.ui.WikiaSourceModeDialog.prototype.getActionProcess = function ( action ) {
	if ( action === 'apply' ) {
		return new OO.ui.Process( function () {
			this.$body.startThrobbing();			

			$.ajax( {
				'url': mw.util.wikiScript( 'api' ),
				'data': {
					'action': 'visualeditor',
					'paction': 'parsefragment',
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
				'success': this.DONE.bind(this)
			} );

			var deferred = $.Deferred();
			deferred.resolve();
			return deferred;
		}, this );
	}
	return ve.ui.WikiaSourceModeDialog.super.prototype.getActionProcess.call( this, action );
};

ve.ui.WikiaSourceModeDialog.prototype.DONE = function ( response ) {
	var _this = this;
	this.close( { action: 'apply' } ).done(function() {
		//console.log('data', data);
		//$( document ).off( 'keydown', this.onDocumentKeyDownHandler );?

		var target = _this.surface.getTarget();
		target.deactivating = true;
		target.toolbarSaveButton.disconnect( target );
		target.toolbarSaveButton.$element.detach();
		target.getToolbar().$actions.empty();
		target.tearDownSurface( true ).done(function() {
			target.deactivating = false;
			target.wikitext = _this.sourceModeTextarea.getValue();
			target.activating = true;
			target.edited = true;
			target.doc = ve.createDocumentFromHtml( response.visualeditor.content );
			target.docToSave = null;
			target.clearPreparedCacheKey();
			console.log('target.setupSurface');
			target.setupSurface( target.doc, function () {
				target.startSanityCheck();
				target.emit( 'surfaceReady' );
			} );

		});
	});
};

ve.ui.windowFactory.register( ve.ui.WikiaSourceModeDialog );
