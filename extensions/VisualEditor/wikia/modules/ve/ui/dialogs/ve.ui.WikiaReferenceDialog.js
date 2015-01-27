/*!
 * VisualEditor UserInterface WikiaReferenceDialog class.
 */

/**
 * Dialog for editing MediaWiki references.
 *
 * @class
 * @extends ve.ui.MWReferenceDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaReferenceDialog = function VeUiWikiaReferenceDialog( config ) {
	// Parent constructor
	ve.ui.WikiaReferenceDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaReferenceDialog, ve.ui.MWReferenceDialog );

/* Static Properties */

ve.ui.WikiaReferenceDialog.static.toolbarGroups = [
	// History
	{ 'include': [ 'undo' ] },
	// Style
	{ 'include': [ 'bold', 'italic', 'link' ] },
	{
		'type': 'list',
		'icon': 'text-style',
		'indicator': 'down',
		'title': OO.ui.deferMsg( 'visualeditor-toolbar-style-tooltip' ),
		'include': [ 'subscript', 'superscript', 'strikethrough', 'underline', 'clear' ]
	}
];

/* Methods */

ve.ui.WikiaReferenceDialog.prototype.setup = function ( data ) {
	ve.ui.WikiaReferenceDialog.super.prototype.setup.call( this, data );
	this.referenceSurface.$element.addClass( 'WikiaArticle' );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaReferenceDialog );
