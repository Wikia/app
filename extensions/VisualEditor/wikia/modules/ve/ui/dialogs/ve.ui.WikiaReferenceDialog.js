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
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaReferenceDialog = function VeUiWikiaReferenceDialog( windowSet, config ) {
	// Parent constructor
	ve.ui.MWReferenceDialog.call( this, windowSet, config );
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