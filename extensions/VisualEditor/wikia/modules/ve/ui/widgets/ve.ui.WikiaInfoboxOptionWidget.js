/*!
 * VisualEditor UserInterface WikiaInfoboxOptionWidget class.
 */

/**
 * @class
 * @extends OO.ui.DecoratedOptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {number} [size] Media thumbnail size
 */
ve.ui.WikiaInfoboxOptionWidget = function VeUiWikiaInfoboxOptionWidget( config ) {
	// Parent constructor
	ve.ui.WikiaInfoboxOptionWidget.super.call( this, config );

	//here we can add the wikia infobox specific classes
};

/* Inheritance */
OO.inheritClass( ve.ui.WikiaInfoboxOptionWidget, OO.ui.DecoratedOptionWidget );
