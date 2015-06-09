/*!
 * VisualEditor user interface MWTransclusionContentPage class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki transclusion dialog content page.
 *
 * @class
 * @extends OO.ui.PageLayout
 *
 * @constructor
 * @param {ve.dm.MWTransclusionContentModel} content Transclusion content
 * @param {string} name Unique symbolic name of page
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTransclusionContentPage = function VeUiMWTransclusionContentPage( content, name, config ) {
	// Configuration initialization
	config = ve.extendObject( {
		'scrollable': false
	}, config );

	// Parent constructor
	OO.ui.PageLayout.call( this, name, config );

	// Properties
	this.content = content;
	this.textInput = new OO.ui.TextInputWidget( {
			'$': this.$,
			'multiline': true,
			'autosize': true,
			'classes': [ 've-ui-mwTransclusionDialog-input' ]
		} )
		.setValue( this.content.getValue() )
		.connect( this, { 'change': 'onTextInputChange' } );
	this.removeButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'remove',
			'title': ve.msg( 'visualeditor-dialog-transclusion-remove-content' ),
			'flags': [ 'destructive' ],
			'classes': [ 've-ui-mwTransclusionDialog-removeButton' ]
		} )
		.connect( this, { 'click': 'onRemoveButtonClick' } );
	this.valueFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-content' ),
		'icon': 'source',
		'$content': this.textInput.$element
	} );

	// Initialization
	this.$element
		.addClass( 've-ui-mwTransclusionContentPage' )
		.append( this.valueFieldset.$element, this.removeButton.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWTransclusionContentPage, OO.ui.PageLayout );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWTransclusionContentPage.prototype.setOutlineItem = function ( outlineItem ) {
	// Parent method
	OO.ui.PageLayout.prototype.setOutlineItem.call( this, outlineItem );

	if ( this.outlineItem ) {
		this.outlineItem
			.setIcon( 'source' )
			.setMovable( true )
			.setRemovable( true )
			.setLabel( ve.msg( 'visualeditor-dialog-transclusion-content' ) );
	}
};

ve.ui.MWTransclusionContentPage.prototype.onTextInputChange = function () {
	this.content.setValue( this.textInput.getValue() );
};

ve.ui.MWTransclusionContentPage.prototype.onRemoveButtonClick = function () {
	this.content.remove();
};
