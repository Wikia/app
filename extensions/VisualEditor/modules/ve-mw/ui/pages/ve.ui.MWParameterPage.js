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

	// Configuration initialization
	config = ve.extendObject( {
		'scrollable': false
	}, config );

	// Parent constructor
	OO.ui.PageLayout.call( this, name, config );

	// Properties
	this.parameter = parameter;
	this.spec = parameter.getTemplate().getSpec();
	this.defaultValue = this.spec.getParameterDefaultValue( paramName );
	this.$info = this.$( '<div>' );
	this.$actions = this.$( '<div>' );
	this.$label = this.$( '<div>' );
	this.$field = this.$( '<div>' );
	this.$more = this.$( '<div>' );
	this.$description = this.$( '<div>' );
	this.valueInput = new OO.ui.TextInputWidget( {
			'$': this.$,
			'multiline': true,
			'autosize': true,
			'placeholder': this.defaultValue
		} )
		.setValue( this.parameter.getValue() )
		.connect( this, { 'change': 'onValueInputChange' } );
	if ( this.parameter.isRequired() ) {
		this.valueInput.$input.prop( 'required', true );
	}

	this.removeButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'remove',
			'title': ve.msg( 'visualeditor-dialog-transclusion-remove-param' ),
			'classes': [ 've-ui-mwParameterPage-removeButton' ]
		} )
		.connect( this, { 'click': 'onRemoveButtonClick' } );
	this.infoButton = new OO.ui.PopupButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'info',
			'title': ve.msg( 'visualeditor-dialog-transclusion-param-info' ),
			'classes': [ 've-ui-mwParameterPage-infoButton' ]
		} );
	this.addButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'parameter',
			'label': ve.msg( 'visualeditor-dialog-transclusion-add-param' ),
			'tabIndex': -1
		} )
		.connect( this, { 'click': 'onAddButtonClick' } );
	this.statusIndicator = new OO.ui.IndicatorWidget( {
		'$': this.$,
		'classes': [ 've-ui-mwParameterPage-statusIndicator' ]
	} );

	// TODO: Use spec.type

	// Events
	this.$label.on( 'click', ve.bind( this.onLabelClick, this ) );
	this.$description.on( 'click', ve.bind( this.onDescriptionClick, this ) );

	// Initialization
	this.$info
		.addClass( 've-ui-mwParameterPage-info' )
		.append( this.$label, this.statusIndicator.$element );
	this.$actions
		.addClass( 've-ui-mwParameterPage-actions' )
		.append( this.infoButton.$element, this.removeButton.$element );
	this.$label
		.addClass( 've-ui-mwParameterPage-label' )
		.text( this.spec.getParameterLabel( paramName ) );
	this.$field
		.addClass( 've-ui-mwParameterPage-field' )
		.append(
			this.valueInput.$element
		);
	this.$more
		.addClass( 've-ui-mwParameterPage-more' )
		.append( this.addButton.$element );
	this.$element
		.addClass( 've-ui-mwParameterPage' )
		.append( this.$info, this.$actions, this.$field, this.$more );
	this.$description
		.addClass( 've-ui-mwParameterPage-description' )
		.append( this.$( '<p>' ).text( this.spec.getParameterDescription( paramName ) || '' ) );

	if ( this.parameter.isRequired() ) {
		this.statusIndicator
			.setIndicator( 'required' )
			.setIndicatorTitle(
				ve.msg( 'visualeditor-dialog-transclusion-required-parameter' )
			);
		this.$description.append(
			this.$( '<p>' )
				.addClass( 've-ui-mwParameterPage-description-required' )
				.text(
					ve.msg( 'visualeditor-dialog-transclusion-required-parameter-description' )
				)
		);
	} else if ( this.parameter.isDeprecated() ) {
		this.statusIndicator
			.setIndicator( 'alert' )
			.setIndicatorTitle(
				ve.msg( 'visualeditor-dialog-transclusion-deprecated-parameter' )
			);
		this.$description.append(
			this.$( '<p>' )
				.addClass( 've-ui-mwParameterPage-description-deprecated' )
				.text(
					ve.msg(
						'visualeditor-dialog-transclusion-deprecated-parameter-description',
						this.spec.getParameterDeprecationDescription( paramName )
					)
				)
		);
	}
	if ( this.$description.text().trim() === '' ) {
		this.infoButton
			.setDisabled( true )
			.setTitle(
				ve.msg( 'visualeditor-dialog-transclusion-param-info-missing' )
			);
	} else {
		this.infoButton.getPopup().$body.append( this.$description );
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
		if ( this.parameter.isDeprecated() ) {
			this.outlineItem
				.setIndicator( 'alert' )
				.setIndicatorTitle(
					ve.msg( 'visualeditor-dialog-transclusion-deprecated-parameter' )
				);
		}
	}
};
