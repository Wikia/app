/*!
 * VisualEditor user interface MWParameterPage class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
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
	var placeholder = null,
		paramName = parameter.getName();

	// Configuration initialization
	config = ve.extendObject( {
		scrollable: false
	}, config );

	// Parent constructor
	OO.ui.PageLayout.call( this, name, config );

	// Properties
	this.parameter = parameter;
	this.spec = parameter.getTemplate().getSpec();
	this.defaultValue = parameter.getDefaultValue();
	this.exampleValue = parameter.getExampleValue();

	this.$info = $( '<div>' );
	this.$actions = $( '<div>' );
	this.$labelElement = $( '<div>' );
	this.$field = $( '<div>' );
	this.$more = $( '<div>' );
	this.$description = $( '<div>' );
	if ( this.defaultValue ) {
		placeholder = ve.msg( 'visualeditor-dialog-transclusion-param-default', this.defaultValue );
	} else if ( this.exampleValue ) {
		placeholder = ve.msg( 'visualeditor-dialog-transclusion-param-example', this.exampleValue );
	}
	this.valueInput = new OO.ui.TextInputWidget( {
		multiline: true,
		autosize: true,
		required: this.parameter.isRequired(),
		validate: this.parameter.isRequired() ? 'non-empty' : null,
		placeholder: placeholder
	} )
		.setValue( this.parameter.getValue() )
		.connect( this, { change: 'onValueInputChange' } );

	this.removeButton = new OO.ui.ButtonWidget( {
		framed: false,
		icon: 'remove',
		title: ve.msg( 'visualeditor-dialog-transclusion-remove-param' ),
		flags: [ 'destructive' ],
		classes: [ 've-ui-mwParameterPage-removeButton' ]
	} )
		.connect( this, { click: 'onRemoveButtonClick' } )
		.toggle( !this.parameter.isRequired() );

	this.infoButton = new OO.ui.PopupButtonWidget( {
		framed: false,
		icon: 'info',
		title: ve.msg( 'visualeditor-dialog-transclusion-param-info' ),
		classes: [ 've-ui-mwParameterPage-infoButton' ]
	} );

	this.addButton = new OO.ui.ButtonWidget( {
		framed: false,
		icon: 'parameter',
		label: ve.msg( 'visualeditor-dialog-transclusion-add-param' ),
		tabIndex: -1
	} )
		.connect( this, { click: 'onAddButtonFocus' } );

	this.statusIndicator = new OO.ui.IndicatorWidget( {
		classes: [ 've-ui-mwParameterPage-statusIndicator' ]
	} );

	// TODO: Use spec.type

	// Events
	this.$labelElement.on( 'click', this.onLabelClick.bind( this ) );

	// Initialization
	this.$info
		.addClass( 've-ui-mwParameterPage-info' )
		.append( this.$labelElement, this.statusIndicator.$element );
	this.$actions
		.addClass( 've-ui-mwParameterPage-actions' )
		.append( this.infoButton.$element, this.removeButton.$element );
	this.$labelElement
		.addClass( 've-ui-mwParameterPage-label' )
		.text( this.spec.getParameterLabel( paramName ) );
	this.$field
		.addClass( 've-ui-mwParameterPage-field' )
		.append(
			this.valueInput.$element
		);
	this.$more
		.addClass( 've-ui-mwParameterPage-more' )
		.append( this.addButton.$element )
		.focus( this.onAddButtonFocus.bind( this ) );
	this.$element
		.addClass( 've-ui-mwParameterPage' )
		.append( this.$info, this.$actions, this.$field, this.$more );
	this.$description
		.addClass( 've-ui-mwParameterPage-description' )
		.append( $( '<p>' ).text( this.spec.getParameterDescription( paramName ) || '' ) );

	if ( this.parameter.isRequired() ) {
		this.statusIndicator
			.setIndicator( 'required' )
			.setIndicatorTitle(
				ve.msg( 'visualeditor-dialog-transclusion-required-parameter' )
			);
		this.$description.append(
			$( '<p>' )
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
			$( '<p>' )
				.addClass( 've-ui-mwParameterPage-description-deprecated' )
				.text(
					ve.msg(
						'visualeditor-dialog-transclusion-deprecated-parameter-description',
						this.spec.getParameterDeprecationDescription( paramName )
					)
				)
		);
	}

	if ( this.defaultValue ) {
		this.$description.append(
			$( '<p>' )
				.addClass( 've-ui-mwParameterPage-description-default' )
				.text(
					ve.msg( 'visualeditor-dialog-transclusion-param-default', this.defaultValue )
				)
		);
	}

	if ( this.exampleValue ) {
		this.$description.append(
			$( '<p>' )
				.addClass( 've-ui-mwParameterPage-description-example' )
				.text(
					ve.msg( 'visualeditor-dialog-transclusion-param-example', this.exampleValue )
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
		this.outlineItem.setFlags( { empty: this.isEmpty() } );
	}
};

ve.ui.MWParameterPage.prototype.onRemoveButtonClick = function () {
	this.parameter.remove();
};

ve.ui.MWParameterPage.prototype.onAddButtonFocus = function () {
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
			.setFlags( { empty: this.isEmpty() } )
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
