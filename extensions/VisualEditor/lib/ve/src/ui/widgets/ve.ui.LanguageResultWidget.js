/*!
 * VisualEditor UserInterface LanguageResultWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Creates an ve.ui.LanguageResultWidget object.
 *
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.LanguageResultWidget = function VeUiLanguageResultWidget( config ) {
	// Parent constructor
	OO.ui.OptionWidget.call( this, config );

	// Initialization
	this.$element.addClass( 've-ui-languageResultWidget' );
	this.$name = $( '<div>' ).addClass( 've-ui-languageResultWidget-name' );
	this.$otherMatch = $( '<div>' ).addClass( 've-ui-languageResultWidget-otherMatch' );
	this.setLabel( this.$otherMatch.add( this.$name ) );
};

/* Inheritance */

OO.inheritClass( ve.ui.LanguageResultWidget, OO.ui.OptionWidget );

/* Methods */

/**
 * Update labels based on query
 *
 * @param {string} [query] Query text which matched this result
 * @param {string} [matchedProperty] Data property which matched the query text
 * @chainable
 */
ve.ui.LanguageResultWidget.prototype.updateLabel = function ( query, matchedProperty ) {
	var $highlighted, data = this.getData();

	// Reset text
	this.$name.text( data.name );
	this.$otherMatch.text( data.code );

	// Highlight where applicable
	if ( matchedProperty ) {
		$highlighted = ve.highlightQuery( data[ matchedProperty ], query );
		if ( matchedProperty === 'name' ) {
			this.$name.empty().append( $highlighted );
		} else {
			this.$otherMatch.empty().append( $highlighted );
		}
	}

	return this;
};
