/*!
 * VisualEditor UserInterface MWParameterResultWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWParameterResultWidget object.
 *
 * @class
 * @extends ve.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} data Item data
 * @param {Object} [config] Configuration options
 */
ve.ui.MWParameterResultWidget = function VeUiMWParameterResultWidget( data, config ) {
	// Configuration initialization
	config = ve.extendObject( { 'icon': 'parameter' }, config );

	// Parent constructor
	ve.ui.OptionWidget.call( this, data, config );

	// Initialization
	this.$.addClass( 've-ui-mwParameterResultWidget' );
	this.setLabel( this.buildLabel() );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWParameterResultWidget, ve.ui.OptionWidget );

/* Methods */

/** */
ve.ui.MWParameterResultWidget.prototype.buildLabel = function () {
	var i, len,
		$label = this.$$( '<div>' )
			.addClass( 've-ui-mwParameterResultWidget-label' )
			.text( this.data.label ),
		$names = this.$$( '<div>' )
			.addClass( 've-ui-mwParameterResultWidget-names' ),
		$description = this.$$( '<div>' )
			.addClass( 've-ui-mwParameterResultWidget-description' )
			.text( this.data.description || '' );

	if ( this.data.name ) {
		$names.append(
			this.$$( '<span>' )
				.addClass( 've-ui-mwParameterResultWidget-name' )
				.text( this.data.name )
		);
	}
	for ( i = 0, len = this.data.aliases.length; i < len; i++ ) {
		$names.append(
			this.$$( '<span>' )
				.addClass( 've-ui-mwParameterResultWidget-name' )
				.text( this.data.aliases[i] )
		);
	}

	return $label.add( $names ).add( $description );
};
