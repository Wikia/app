/*!
 * VisualEditor UserInterface LanguageInputWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Creates an ve.ui.LanguageInputWidget object.
 *
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {boolean} [requireDir] Require directionality to be set (no 'auto' value)
 * @cfg {boolean} [hideCodeInput] Prevent user from entering a language code as free text
 * @cfg {ve.ui.WindowManager} [dialogManager] Window manager to launch the language search dialog in
 * @cfg {string[]} [availableLanguages] Available language codes to show in search dialog
 */
ve.ui.LanguageInputWidget = function VeUiLanguageInputWidget( config ) {
	var dirItems;

	// Configuration initialization
	config = config || {};

	// Parent constructor
	OO.ui.Widget.call( this, config );

	// Properties
	this.lang = null;
	this.dir = null;

	this.overlay = new ve.ui.Overlay( { classes: [ 've-ui-overlay-global' ] } );
	this.dialogs = config.dialogManager || new ve.ui.WindowManager( { factory: ve.ui.windowFactory, isolate: true } );
	this.availableLanguages = config.availableLanguages;

	this.findLanguageButton = new OO.ui.ButtonWidget( {
		classes: [ 've-ui-languageInputWidget-findLanguageButton' ],
		label: ve.msg( 'visualeditor-languageinspector-widget-changelang' ),
		indicator: 'next'
	} );
	this.languageCodeTextInput = new OO.ui.TextInputWidget( {
		classes: [ 've-ui-languageInputWidget-languageCodeTextInput' ]
	} );
	this.directionSelect = new OO.ui.ButtonSelectWidget( {
		classes: [ 've-ui-languageInputWidget-directionSelect' ]
	} );
	this.languageLabel = {
		align: 'left',
		label: ve.msg( 'visualeditor-languageinspector-widget-label-language' )
	};

	if ( config.hideCodeInput ) {
		this.languageLayout = new OO.ui.FieldLayout(
			this.findLanguageButton,
			this.languageLabel
		);
	} else {
		this.languageLayout = new OO.ui.ActionFieldLayout(
			this.languageCodeTextInput,
			this.findLanguageButton,
			this.languageLabel
		);
	}

	this.directionField = new OO.ui.FieldLayout( this.directionSelect, {
		align: 'left',
		label: ve.msg( 'visualeditor-languageinspector-widget-label-direction' )
	} );

	// Events
	this.findLanguageButton.connect( this, { click: 'onFindLanguageButtonClick' } );
	this.languageCodeTextInput.connect( this, { change: 'onChange' } );
	this.directionSelect.connect( this, { select: 'onChange' } );

	// Initialization
	dirItems = [
		new OO.ui.ButtonOptionWidget( {
			data: 'rtl',
			icon: 'textDirRTL'
		} ),
		new OO.ui.ButtonOptionWidget( {
			data: 'ltr',
			icon: 'textDirLTR'
		} )
	];
	if ( !config.requireDir ) {
		dirItems.splice(
			1, 0, new OO.ui.ButtonOptionWidget( {
				data: null,
				label: ve.msg( 'visualeditor-dialog-language-auto-direction' )
			} )
		);
	}
	this.directionSelect.addItems( dirItems );
	this.overlay.$element.append( this.dialogs.$element );
	$( 'body' ).append( this.overlay.$element );

	this.$element
		.addClass( 've-ui-languageInputWidget' )
		.append(
			this.languageLayout.$element,
			this.directionField.$element
		);
};

/* Inheritance */

OO.inheritClass( ve.ui.LanguageInputWidget, OO.ui.Widget );

/* Events */

/**
 * @event change
 * @param {string} lang Language code
 * @param {string} dir Directionality
 */

/* Methods */

/**
 * Handle find language button click events.
 */
ve.ui.LanguageInputWidget.prototype.onFindLanguageButtonClick = function () {
	var widget = this;
	this.dialogs.openWindow( 'languageSearch', { availableLanguages: this.availableLanguages } )
		.then( function ( opened ) {
			opened.then( function ( closing ) {
				closing.then( function ( data ) {
					data = data || {};
					if ( data.action === 'apply' ) {
						widget.setLangAndDir( data.lang, data.dir );
					}
				} );
			} );
		} );
};

/**
 * Handle input widget change events.
 */
ve.ui.LanguageInputWidget.prototype.onChange = function () {
	var selectedItem;

	if ( this.updating ) {
		return;
	}

	selectedItem = this.directionSelect.getSelectedItem();
	this.setLangAndDir(
		this.languageCodeTextInput.getValue(),
		selectedItem ? selectedItem.getData() : null
	);
};

/**
 * Set language and directionality
 *
 * The inputs value will automatically be updated.
 *
 * @param {string} lang Language code
 * @param {string} dir Directionality
 * @fires change
 */
ve.ui.LanguageInputWidget.prototype.setLangAndDir = function ( lang, dir ) {
	if ( lang === this.lang && dir === this.dir ) {
		// No change
		return;
	}

	// Set state flag while programmatically changing input widget values
	this.updating = true;
	if ( lang || dir ) {
		lang = lang || '';
		this.languageCodeTextInput.setValue( lang );
		this.findLanguageButton.setLabel(
			ve.init.platform.getLanguageName( lang.toLowerCase() ) ||
			ve.msg( 'visualeditor-languageinspector-widget-changelang' )
		);
		this.directionSelect.selectItemByData( dir );
	} else {
		this.languageCodeTextInput.setValue( '' );
		this.findLanguageButton.setLabel(
			ve.msg( 'visualeditor-languageinspector-widget-changelang' )
		);
		this.directionSelect.selectItem( null );
	}
	this.updating = false;

	this.emit( 'change', lang, dir );
	this.lang = lang;
	this.dir = dir;
};

/**
 * Get the language
 *
 * @return {string} Language code
 */
ve.ui.LanguageInputWidget.prototype.getLang = function () {
	return this.lang;
};

/**
 * Get the directionality
 *
 * @return {string} Directionality (ltr/rtl)
 */
ve.ui.LanguageInputWidget.prototype.getDir = function () {
	return this.dir;
};
