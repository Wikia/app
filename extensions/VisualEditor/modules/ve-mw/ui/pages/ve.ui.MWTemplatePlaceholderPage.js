/*!
 * VisualEditor user interface MWTemplatePlaceholderPage class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki transclusion dialog placeholder page.
 *
 * @class
 * @extends OO.ui.PageLayout
 *
 * @constructor
 * @param {ve.dm.MWTemplatePlaceholderModel} placeholder Template placeholder
 * @param {string} name Unique symbolic name of page
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTemplatePlaceholderPage = function VeUiMWTemplatePlaceholderPage( placeholder, name, config ) {
	// Parent constructor
	OO.ui.PageLayout.call( this, name, config );

	// Properties
	this.placeholder = placeholder;
	this.addTemplateInput = new ve.ui.MWTitleInputWidget( {
			'$': this.$, '$overlay': this.$overlay, 'namespace': 10
		} )
		.connect( this, {
			'change': 'onTemplateInputChange',
			'enter': 'onAddTemplate'
		} );
	this.addTemplateButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'label': ve.msg( 'visualeditor-dialog-transclusion-add-template' ),
			'flags': ['constructive'],
			'disabled': true
		} )
		.connect( this, { 'click': 'onAddTemplate' } );
	this.removeButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'remove',
			'title': ve.msg( 'visualeditor-dialog-transclusion-remove-template' ),
			'flags': ['destructive'],
			'classes': [ 've-ui-mwTransclusionDialog-removeButton' ]
		} )
		.connect( this, { 'click': 'onRemoveButtonClick' } );
	this.addTemplateFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-placeholder' ),
		'icon': 'template',
		'classes': [ 've-ui-mwTransclusionDialog-addTemplateFieldset' ],
		'$content': this.addTemplateInput.$element.add( this.addTemplateButton.$element )
	} );

	// Initialization
	this.$element
		.addClass( 've-ui-mwTemplatePlaceholderPage' )
		.append( this.addTemplateFieldset.$element, this.removeButton.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWTemplatePlaceholderPage, OO.ui.PageLayout );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWTemplatePlaceholderPage.prototype.setOutlineItem = function ( outlineItem ) {
	// Parent method
	OO.ui.PageLayout.prototype.setOutlineItem.call( this, outlineItem );

	if ( this.outlineItem ) {
		this.outlineItem
			.setIcon( 'template' )
			.setMovable( true )
			.setRemovable( true )
			.setFlags( [ 'placeholder' ] )
			.setLabel( ve.msg( 'visualeditor-dialog-transclusion-placeholder' ) );
	}
};

ve.ui.MWTemplatePlaceholderPage.prototype.onAddTemplate = function () {
	var transclusion = this.placeholder.getTransclusion(),
		part = ve.dm.MWTemplateModel.newFromName( transclusion, this.addTemplateInput.getValue() );

	transclusion.replacePart( this.placeholder, part );
	this.addTemplateInput.pushPending();
	this.addTemplateButton.setDisabled( true );
	this.removeButton.setDisabled( true );
};

ve.ui.MWTemplatePlaceholderPage.prototype.onTemplateInputChange = function ( value ) {
	this.addTemplateButton.setDisabled( value === '' );
};

ve.ui.MWTemplatePlaceholderPage.prototype.onRemoveButtonClick = function () {
	this.placeholder.remove();
};
