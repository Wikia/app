/*!
 * VisualEditor user interface WikiaVideoInsertDialog class.
 */

/**
 * Dialog for inserting videos.
 *
 * @class
 * @extends ve.ui.WikiaMediaInsertDialog
 *
 * @constructor
 * @param {Object} [config] Config options
 */
ve.ui.WikiaVideoInsertDialog = function VeUiMWMediaInsertDialog( config ) {
	// Parent constructor
	ve.ui.WikiaVideoInsertDialog.super.call( this, config );

	this.searchInputPlaceholder = ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-video-search-input-placeholder' );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaVideoInsertDialog, ve.ui.WikiaMediaInsertDialog );

/* Static Properties */

ve.ui.WikiaVideoInsertDialog.static.name = 'wikiaVideoInsert';

ve.ui.WikiaVideoInsertDialog.static.title = OO.ui.deferMsg( 'wikia-visualeditor-dialog-video-insert-title' );

ve.ui.WikiaVideoInsertDialog.static.trackingLabel = 'dialog-video-insert';

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaVideoInsertDialog.prototype.initialize = function () {
	var uploadWidget;

	// Parent method
	ve.ui.WikiaVideoInsertDialog.super.prototype.initialize.call( this );

	this.pages.removePages( [ this.mainPage ] );
	this.addVideoMainPage();

	uploadWidget = this.query.getUpload();
	uploadWidget.getUploadButton().toggle();
};

ve.ui.WikiaVideoInsertDialog.prototype.addVideoMainPage = function () {
	this.$videoMainPage = this.$( '<div>' );

	if ( mw.user.anonymous() ) {
		var loginButtonConfig = {
				$: this.$,
				label: ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-log-in-button' ),
				flags: ['primary']
			},
			registerButtonConfig = {
				$: this.$,
				classes: [ 've-ui-wikiaRegisterButton' ],
				label: ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-register-button' ),
				flags: ['primary']
			},
			logInButton = new OO.ui.ButtonWidget( loginButtonConfig ),
			registerButton = new OO.ui.ButtonWidget( registerButtonConfig );

		this.$logInLabel = this.$( '<span>' )
			.text( ve.msg( 'wikia-visualeditor-dialog-wikiamediainsert-video-log-in-notice' ) );

		logInButton.on( 'click', function () {
			this.onLogInButtonClicked();
		}.bind( this ) );

		registerButton.on( 'click', function () {
			this.onRegisterButtonClicked();
		}.bind( this ) );

		this.$videoIcon = this.$( '<span>' )
			.addClass( 'oo-ui-icon-video' );

		this.$videoMainPage
			.append( this.$videoIcon, this.$logInLabel, logInButton.$element, registerButton.$element )
			.addClass( 've-ui-wikiaVideoInsertDialogLogIn' );
	}

	this.videoMainPage = new OO.ui.PageLayout( 'videoMain', { $content: this.$videoMainPage } );
	this.pages.addPages( [ this.videoMainPage ] );
};

ve.ui.WikiaVideoInsertDialog.prototype.getDefaultPage = function () {
	return this.queryInput.getValue().trim().length === 0 ? 'videoMain' : 'search';
};

ve.ui.WikiaVideoInsertDialog.prototype.onLogInSuccess = function () {
	ve.init.target.onLogInSuccess();
	this.query.onLogInSuccess();
	this.$videoMainPage.remove();
};

ve.ui.windowFactory.register( ve.ui.WikiaVideoInsertDialog );
