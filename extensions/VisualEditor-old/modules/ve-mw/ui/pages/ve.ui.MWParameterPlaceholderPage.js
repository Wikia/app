/*!
 * VisualEditor user interface MWParameterPlaceholderPage class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki transclusion dialog parameter placeholder page.
 *
 * @class
 * @extends OO.ui.PageLayout
 *
 * @constructor
 * @param {ve.dm.MWTemplateModel} parameter Template
 * @param {string} name Unique symbolic name of page
 * @param {Object} [config] Configuration options
 */
ve.ui.MWParameterPlaceholderPage = function VeUiMWParameterPlaceholderPage( parameter, name, config ) {
	// Configuration initialization
	config = ve.extendObject( {
		'scrollable': false
	}, config );

	// Parent constructor
	OO.ui.PageLayout.call( this, name, config );

	// Properties
	this.parameter = parameter;
	this.template = this.parameter.getTemplate();
	this.addParameterSearch = new ve.ui.MWParameterSearchWidget( this.template, { '$': this.$ } )
		.connect( this, { 'select': 'onParameterSelect' } );
	this.removeButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'remove',
			'title': ve.msg( 'visualeditor-dialog-transclusion-remove-param' ),
			'classes': [ 've-ui-mwTransclusionDialog-removeButton' ]
		} )
		.connect( this, { 'click': 'onRemoveButtonClick' } );
	this.addParameterFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-transclusion-add-param' ),
		'icon': 'parameter',
		'classes': [ 've-ui-mwTransclusionDialog-addParameterFieldset' ],
		'$content': this.addParameterSearch.$element
	} );

	// Initialization
	this.$element
		.addClass( 've-ui-mwParameterPlaceholderPage' )
		.append( this.addParameterFieldset.$element, this.removeButton.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWParameterPlaceholderPage, OO.ui.PageLayout );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWParameterPlaceholderPage.prototype.setOutlineItem = function ( outlineItem ) {
	// Parent method
	OO.ui.PageLayout.prototype.setOutlineItem.call( this, outlineItem );

	if ( this.outlineItem ) {
		this.outlineItem
			.setIcon( 'parameter' )
			.setMovable( false )
			.setRemovable( true )
			.setLevel( 1 )
			.setFlags( [ 'placeholder' ] )
			.setLabel( ve.msg( 'visualeditor-dialog-transclusion-add-param' ) );
	}
};

ve.ui.MWParameterPlaceholderPage.prototype.onParameterSelect = function ( name ) {
	var param;

	if ( name ) {
		param = new ve.dm.MWParameterModel( this.template, name );
		this.addParameterSearch.query.setValue( '' );
		this.parameter.remove();
		this.template.addParameter( param );
	}
};

ve.ui.MWParameterPlaceholderPage.prototype.onRemoveButtonClick = function () {
	this.parameter.remove();
};
