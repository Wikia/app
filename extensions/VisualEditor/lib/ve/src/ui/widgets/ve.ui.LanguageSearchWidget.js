/*!
 * VisualEditor UserInterface LanguageSearchWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Creates an ve.ui.LanguageSearchWidget object.
 *
 * @class
 * @extends OO.ui.SearchWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.LanguageSearchWidget = function VeUiLanguageSearchWidget( config ) {
	// Configuration initialization
	config = ve.extendObject( {
		placeholder: ve.msg( 'visualeditor-language-search-input-placeholder' )
	}, config );

	// Parent constructor
	OO.ui.SearchWidget.call( this, config );

	// Properties
	this.languageResultWidgets = [];
	this.filteredLanguageResultWidgets = [];

	var i, l, languageCode,
		languageCodes = ve.init.platform.getLanguageCodes().sort();

	for ( i = 0, l = languageCodes.length; i < l; i++ ) {
		languageCode = languageCodes[i];
		this.languageResultWidgets.push(
			new ve.ui.LanguageResultWidget( {
				$: this.$,
				data: {
					code: languageCode,
					name: ve.init.platform.getLanguageName( languageCode ),
					autonym: ve.init.platform.getLanguageAutonym( languageCode )
				}
			} )
		);
	}
	this.setAvailableLanguages();

	// Initialization
	this.$element.addClass( 've-ui-languageSearchWidget' );
};

/* Inheritance */

OO.inheritClass( ve.ui.LanguageSearchWidget, OO.ui.SearchWidget );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.LanguageSearchWidget.prototype.onQueryChange = function () {
	// Parent method
	OO.ui.SearchWidget.prototype.onQueryChange.call( this );

	// Populate
	this.addResults();
};

/**
 * Set available languages to show
 *
 * @param {string[]} Available language codes to show, all if undefined
 */
ve.ui.LanguageSearchWidget.prototype.setAvailableLanguages = function ( availableLanguages ) {
	if ( !availableLanguages ) {
		this.filteredLanguageResultWidgets = this.languageResultWidgets.slice();
		return;
	}
	var i, iLen, languageResult, data;

	this.filteredLanguageResultWidgets = [];

	for ( i = 0, iLen = this.languageResultWidgets.length; i < iLen; i++ ) {
		languageResult = this.languageResultWidgets[i];
		data = languageResult.getData();
		if ( ve.indexOf( data.code, availableLanguages ) !== -1 ) {
			this.filteredLanguageResultWidgets.push( languageResult );
		}
	}
};

/**
 * Update search results from current query
 */
ve.ui.LanguageSearchWidget.prototype.addResults = function () {
	var i, iLen, j, jLen, languageResult, data, matchedProperty,
		matchProperties = ['name', 'autonym', 'code'],
		query = this.query.getValue().trim(),
		matcher = new RegExp( '^' + this.constructor.static.escapeRegex( query ), 'i' ),
		hasQuery = !!query.length,
		items = [];

	this.results.clearItems();

	for ( i = 0, iLen = this.filteredLanguageResultWidgets.length; i < iLen; i++ ) {
		languageResult = this.filteredLanguageResultWidgets[i];
		data = languageResult.getData();
		matchedProperty = null;

		for ( j = 0, jLen = matchProperties.length; j < jLen; j++ ) {
			if ( matcher.test( data[matchProperties[j]] ) ) {
				matchedProperty = matchProperties[j];
				break;
			}
		}

		if ( query === '' || matchedProperty ) {
			items.push(
				languageResult
					.updateLabel( query, matchedProperty )
					.setSelected( false )
					.setHighlighted( false )
			);
		}
	}

	this.results.addItems( items );
	if ( hasQuery ) {
		this.results.highlightItem( this.results.getFirstSelectableItem() );
	}
};

/**
 * Escape regex.
 *
 * Ported from Languagefilter#escapeRegex in jquery.uls.
 *
 * @param {string} value Text
 * @returns {string} Text escaped for use in regex
 */
ve.ui.LanguageSearchWidget.static.escapeRegex = function ( value ) {
	return value.replace( /[\-\[\]{}()*+?.,\\\^$\|#\s]/g, '\\$&' );
};
