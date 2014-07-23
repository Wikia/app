/*!
 * VisualEditor UserInterface WikiaMediaEditDialog class.
 */

/**
 * Dialog for editing MediaWiki media objects.
 *
 * @class
 * @extends ve.ui.MWMediaEditDialog
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaMediaEditDialog = function VeUiWikiaMediaEditDialog( config ) {
	// Parent constructor
	ve.ui.WikiaMediaEditDialog.super.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaMediaEditDialog, ve.ui.MWMediaEditDialog );

/* Static Properties */

ve.ui.WikiaMediaEditDialog.static.toolbarGroups = [
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
	},
	// Insert
	{
		'type': 'list',
		'label': OO.ui.deferMsg( 'visualeditor-toolbar-insert' ),
		'indicator': 'down',
		'include': [ 'transclusion', 'reference' ]
	}
];

/* Methods */

ve.ui.WikiaMediaEditDialog.prototype.getSetupProcess = function ( data ) {
	return ve.ui.WikiaMediaEditDialog.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			this.captionSurface.$element.addClass( 'WikiaArticle' );
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.WikiaMediaEditDialog );
