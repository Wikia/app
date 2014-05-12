/*!
 * VisualEditor user interface MWParameterPage class.
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
 * @param {ve.dm.MWParameterModel} parameter Template parameter
 * @param {string} name Unique symbolic name of page
 * @param {Object} [config] Configuration options
 */
ve.ui.MWParameterPage = function VeUiMWParameterPage( parameter, name, config ) {
	var paramName = parameter.getName();

	// Parent constructor
	OO.ui.PageLayout.call( this, name, config );

	// Properties
	this.parameter = parameter;
	this.spec = parameter.getTemplate().getSpec();
	this.defaultValue = this.spec.getParameterDefaultValue( paramName );
	this.$label = this.$( '<div>' );
	this.$field = this.$( '<div>' );
	this.$actions = this.$( '<div>' );
	this.$indicators = this.$( '<div>' );
	this.$info = this.$( '<div>' );
	this.$description = this.$( '<div>' );
	this.$more = this.$( '<div>' );
	this.valueInput = new OO.ui.TextInputWidget( {
			'$': this.$,
			'multiline': true,
			'autosize': true,
			'placeholder': this.defaultValue
		} )
		.setValue( this.parameter.getValue() )
		.connect( this, { 'change': 'onValueInputChange' } );
	this.removeButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'remove',
			'title': ve.msg( 'visualeditor-dialog-transclusion-remove-param' ),
			'tabIndex': -1
		} )
		.connect( this, { 'click': 'onRemoveButtonClick' } );
	this.addButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'parameter',
			'label': ve.msg( 'visualeditor-dialog-transclusion-add-param' ),
			'tabIndex': -1
		} )
		.connect( this, { 'click': 'onAddButtonClick' } );
	this.requiredIndicator = new OO.ui.IndicatorWidget( { '$': this.$ } );

	// TODO: Use spec.deprecation
	// TODO: Use spec.type

	// Events
	this.$label.on( 'click', ve.bind( this.onLabelClick, this ) );
	this.$description.on( 'click', ve.bind( this.onDescriptionClick, this ) );

	// Initialization
	this.$label
		.addClass( 've-ui-mwParameterPage-label' )
		.text( this.spec.getParameterLabel( paramName ) );
	this.$actions
		.addClass( 've-ui-mwParameterPage-actions' )
		.append( this.removeButton.$element );
	this.$indicators
		.addClass( 've-ui-mwParameterPage-indicators' )
		.append( this.requiredIndicator.$element );
	this.$description
		.addClass( 've-ui-mwParameterPage-description' )
		.text( this.spec.getParameterDescription( paramName ) || '' );
	this.$info
		.addClass( 've-ui-mwParameterPage-info' )
		.append( this.$description );
	this.$field
		.addClass( 've-ui-mwParameterPage-field' )
		.append( this.valueInput.$element, this.$indicators, this.$actions, this.$info );
	this.$more
		.addClass( 've-ui-mwParameterPage-more' )
		.append( this.addButton.$element );
	this.$element
		.addClass( 've-ui-mwParameterPage' )
		.append( this.$label, this.$field, this.$more );

	if ( this.parameter.isRequired() ) {
		this.requiredIndicator
			.setIndicator( 'required' )
			.setIndicatorTitle(
				ve.msg( 'visualeditor-dialog-transclusion-required-parameter' )
			);
	}
};

/* Inheritance */

OO.inheritClass( ve.ui.MWParameterPage, OO.ui.PageLayout );

/* Methods */

ve.ui.MWParameterPage.prototype.isEmpty = function () {
	return this.valueInput.getValue() === '' && this.defaultValue === '';
};

ve.ui.MWParameterPage.prototype.onValueInputChange = function () {
	var value = this.valueInput.getValue();

	this.parameter.setValue( value );

	if ( this.outlineItem ) {
		this.outlineItem.setFlags( { 'empty': this.isEmpty() } );
	}
};

ve.ui.MWParameterPage.prototype.onRemoveButtonClick = function () {
	this.parameter.remove();
};

ve.ui.MWParameterPage.prototype.onAddButtonClick = function () {
	var template = this.parameter.getTemplate();
	template.addParameter( new ve.dm.MWParameterModel( template ) );
};

ve.ui.MWParameterPage.prototype.onLabelClick = function () {
	this.valueInput.simulateLabelClick();
};

ve.ui.MWParameterPage.prototype.onDescriptionClick = function () {
	this.valueInput.simulateLabelClick();
	this.$description.toggleClass( 've-ui-mwParameterPage-description-all' );
};

/**
 * @inheritdoc
 */
ve.ui.MWParameterPage.prototype.setOutlineItem = function ( outlineItem ) {
	// Parent method
	OO.ui.PageLayout.prototype.setOutlineItem.call( this, outlineItem );

	if ( this.outlineItem ) {
		this.outlineItem
			.setIcon( 'parameter' )
			.setMovable( false )
			.setRemovable( true )
			.setLevel( 1 )
			.setFlags( { 'empty': this.isEmpty() } )
			.setLabel( this.spec.getParameterLabel( this.parameter.getName() ) );

		if ( this.parameter.isRequired() ) {
			this.outlineItem
				.setIndicator( 'required' )
				.setIndicatorTitle(
					ve.msg( 'visualeditor-dialog-transclusion-required-parameter' )
				);
		}
	}
};
