/*!
 * VisualEditor UserInterface LanguageResultWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.LanguageResultWidget object.
 *
 * @class
 * @extends OO.ui.OptionWidget
 *
 * @constructor
 * @param {Mixed} data Item data
 * @param {Object} [config] Configuration options
 */
ve.ui.LanguageResultWidget = function VeUiLanguageResultWidget( data, config ) {
	// Parent constructor
	OO.ui.OptionWidget.call( this, data, config );

	// Initialization
	this.$element.addClass( 've-ui-languageResultWidget' );
	this.$name = this.$( '<div>' ).addClass( 've-ui-languageResultWidget-name' );
	this.$otherMatch = this.$( '<div>' ).addClass( 've-ui-languageResultWidget-otherMatch' );
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
		$highlighted = this.highlightQuery( data[matchedProperty], query );
		if ( matchedProperty === 'name' ) {
			this.$name.empty().append( $highlighted );
		} else {
			this.$otherMatch.empty().append( $highlighted );
		}
	}

	return this;
};

/**
 * Highlight text where a substring query matches
 *
 * @param {string} text Text
 * @param {string} query Query to find
 * @returns {jQuery} Text with query substring wrapped in highlighted span
 */
ve.ui.LanguageResultWidget.prototype.highlightQuery = function ( text, query ) {
	var $result = this.$( '<span>' ),
		offset = text.toLowerCase().indexOf( query.toLowerCase() );

	if ( !query.length || offset === -1 ) {
		return $result.text( text );
	}
	$result.append(
		document.createTextNode( text.substr( 0, offset ) ),
		this.$( '<span>' )
			.addClass( 've-ui-languageResultWidget-highlight' )
			.text( text.substr( offset, query.length ) ),
		document.createTextNode( text.substr( offset + query.length ) )

	);
	return $result.contents();
};
