/*!
 * VisualEditor user interface MWTemplatePage class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki transclusion dialog template page.
 *
 * @class
 * @extends OO.ui.PageLayout
 *
 * @constructor
 * @param {ve.dm.MWTemplateModel} parameter Template
 * @param {string} name Unique symbolic name of page
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTemplatePage = function VeUiMWTemplatePage( template, name, config ) {
	// Configuration initialization
	config = ve.extendObject( {
		'scrollable': false
	}, config );

	// Parent constructor
	OO.ui.PageLayout.call( this, name, config );

	// Properties
	this.template = template;
	this.spec = template.getSpec();
	this.$more = this.$( '<div>' );
	this.removeButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'remove',
			'title': ve.msg( 'visualeditor-dialog-transclusion-remove-template' ),
			'flags': ['destructive'],
			'classes': [ 've-ui-mwTransclusionDialog-removeButton' ]
		} )
		.connect( this, { 'click': 'onRemoveButtonClick' } );
	this.infoFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': this.spec.getLabel(),
		'icon': 'template'
	} );
	this.addButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'parameter',
			'label': ve.msg( 'visualeditor-dialog-transclusion-add-param' ),
			'tabIndex': -1
		} )
		.connect( this, { 'click': 'onAddButtonClick' } );

	// Initialization
	this.$more
		.addClass( 've-ui-mwTemplatePage-more' )
		.append( this.addButton.$element );
	this.$element
		.addClass( 've-ui-mwTemplatePage' )
		.append( this.infoFieldset.$element, this.removeButton.$element, this.$more );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWTemplatePage, OO.ui.PageLayout );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWTemplatePage.prototype.setOutlineItem = function ( outlineItem ) {
	// Parent method
	OO.ui.PageLayout.prototype.setOutlineItem.call( this, outlineItem );

	if ( this.outlineItem ) {
		this.outlineItem
			.setIcon( 'template' )
			.setMovable( true )
			.setRemovable( true )
			.setLabel( this.spec.getLabel() );
	}
};

ve.ui.MWTemplatePage.prototype.onRemoveButtonClick = function () {
	this.template.remove();
};

ve.ui.MWTemplatePage.prototype.onAddButtonClick = function () {
	this.template.addParameter( new ve.dm.MWParameterModel( this.template ) );
};
