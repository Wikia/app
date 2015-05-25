/*!
 * VisualEditor UserInterface MWParameterResultWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWParameterResultWidget object.
 *
 * @class
 * @extends OO.ui.DecoratedOptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWParameterResultWidget = function VeUiMWParameterResultWidget( config ) {
	// Configuration initialization
	config = ve.extendObject( { icon: 'parameter' }, config );

	// Parent constructor
	OO.ui.DecoratedOptionWidget.call( this, config );

	// Initialization
	this.$element.addClass( 've-ui-mwParameterResultWidget' );
	this.setLabel( this.buildLabel() );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWParameterResultWidget, OO.ui.DecoratedOptionWidget );

/* Methods */

/** */
ve.ui.MWParameterResultWidget.prototype.buildLabel = function () {
	var i, len,
		$label = this.$( '<div>' )
			.addClass( 've-ui-mwParameterResultWidget-label' )
			.text( this.data.label ),
		$names = this.$( '<div>' )
			.addClass( 've-ui-mwParameterResultWidget-names' ),
		$description = this.$( '<div>' )
			.addClass( 've-ui-mwParameterResultWidget-description' )
			.text( this.data.description || '' );

	if ( this.data.name ) {
		$names.append(
			this.$( '<span>' )
				.addClass( 've-ui-mwParameterResultWidget-name' )
				.text( this.data.name )
		);
	}
	for ( i = 0, len = this.data.aliases.length; i < len; i++ ) {
		$names.append(
			this.$( '<span>' )
				.addClass( 've-ui-mwParameterResultWidget-name' )
				.text( this.data.aliases[i] )
		);
	}

	return $label.add( $names ).add( $description );
};
