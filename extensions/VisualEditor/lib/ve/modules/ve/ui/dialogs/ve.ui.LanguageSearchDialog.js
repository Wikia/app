/*!
 * VisualEditor UserInterface LanguageSearchDialog class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Language search dialog
 *
 * @class
 * @extends ve.ui.Dialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.LanguageSearchDialog = function VeUiLanguageSearchDialog( config ) {
	// Configuration initialization
	config = ve.extendObject( { 'footless': true, 'size': 'medium' }, config );

	// Parent constructor
	ve.ui.Dialog.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.LanguageSearchDialog, ve.ui.Dialog );

/* Static Properties */

ve.ui.LanguageSearchDialog.static.name = 'languageSearch';

ve.ui.LanguageSearchDialog.static.title =
	OO.ui.deferMsg( 'visualeditor-dialog-language-search-title' );

ve.ui.LanguageSearchDialog.static.icon = 'language';

/**
 * Language search widget class to use.
 *
 * @static
 * @property {Function}
 * @inheritable
 */
ve.ui.LanguageSearchDialog.static.languageSearchWidget = ve.ui.LanguageSearchWidget;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.LanguageSearchDialog.prototype.initialize = function () {
	ve.ui.LanguageSearchDialog.super.prototype.initialize.apply( this, arguments );

	this.searchWidget = new this.constructor.static.languageSearchWidget( {
		'$': this.$
	} ).on( 'select', ve.bind( this.onSearchWidgetSelect, this ) );
	this.$body.append( this.searchWidget.$element );
};

/**
 * Handle the search widget being selected
 *
 * @param {Object} data Data from the selected option widget
 */
ve.ui.LanguageSearchDialog.prototype.onSearchWidgetSelect = function ( data ) {
	this.close( {
		'action': 'apply',
		'lang': data.code,
		'dir': ve.init.platform.getLanguageDirection( data.code )
	} );
};

/**
 * @inheritdoc
 */
ve.ui.LanguageSearchDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.LanguageSearchDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.searchWidget.addResults();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.LanguageSearchDialog.prototype.getReadyProcess = function ( data ) {
	return ve.ui.LanguageSearchDialog.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			this.searchWidget.getQuery().focus();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.LanguageSearchDialog.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.LanguageSearchDialog.super.prototype.getTeardownProcess.call( this, data )
		.next( function () {
			this.searchWidget.getQuery().setValue( '' );
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.LanguageSearchDialog );
