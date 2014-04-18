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
	ve.ui.MWReferenceDialog.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaReferenceDialog, ve.ui.MWReferenceDialog );

/* Static Properties */

ve.ui.WikiaReferenceDialog.static.toolbarGroups = [
	{ 'include': [ 'undo', 'redo' ] },
	{ 'include': [ 'bold', 'italic', 'link', 'clear' ] },
	{ 'include': [ 'number', 'bullet', 'outdent', 'indent' ] },
	{
		'include': '*',
		'exclude': [
			'code',
			{ 'group': 'format' },
			'mediaInsert',
			'reference',
			'referenceList',
			'wikiaMediaInsert'
		]
	}
];

/* Registration */

ve.ui.dialogFactory.register( ve.ui.WikiaReferenceDialog );