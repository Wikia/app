/*!
 * VisualEditor UserInterface MWCategoryInputWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Creates an ve.ui.MWCategoryInputWidget object.
 *
 * @class
 * @extends ve.ui.TextInputWidget
 * @mixins ve.ui.LookupInputWidget
 *
 * @constructor
 * @param {ve.ui.MWCategoryWidget} categoryWidget
 * @param {Object} [config] Configuration options
 */
ve.ui.MWCategoryInputWidget = function VeUiMWCategoryInputWidget( categoryWidget, config ) {
	// Config intialization
	config = ve.extendObject( {
		'placeholder': ve.msg( 'visualeditor-dialog-meta-categories-input-placeholder' )
	}, config );

	// Parent constructor
	ve.ui.TextInputWidget.call( this, config );

	// Mixin constructors
	ve.ui.LookupInputWidget.call( this, this, config );

	// Properties
	this.categoryWidget = categoryWidget;
	this.forceCapitalization = mw.config.get( 'wgCaseSensitiveNamespaces' ).indexOf( 14 ) === -1;
	this.categoryPrefix = mw.config.get( 'wgFormattedNamespaces' )['14'] + ':';

	// Initialization
	this.$.addClass( 've-ui-mwCategoryInputWidget' );
	this.lookupMenu.$.addClass( 've-ui-mwCategoryInputWidget-menu' );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWCategoryInputWidget, ve.ui.TextInputWidget );

ve.mixinClass( ve.ui.MWCategoryInputWidget, ve.ui.LookupInputWidget );

/* Methods */

/**
 * Gets a new request object of the current lookup query value.
 *
 * @method
 * @returns {jqXHR} AJAX object without success or fail handlers attached
 */
ve.ui.MWCategoryInputWidget.prototype.getLookupRequest = function () {
	return $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'format': 'json',
			'action': 'opensearch',
			'search': this.categoryPrefix + this.value,
			'suggest': ''
		},
		'dataType': 'json'
	} );
};

/**
 * Get lookup cache item from server response data.
 *
 * @method
 * @param {Mixed} data Response from server
 */
ve.ui.MWCategoryInputWidget.prototype.getLookupCacheItemFromData = function ( data ) {
	var i, len, title, result = [];
	if ( ve.isArray( data ) && data.length ) {
		for ( i = 0, len = data[1].length; i < len; i++ ) {
			try {
				title = new mw.Title( data[1][i] );
				result.push( title.getMainText() );
			} catch ( e ) { }
			// If the received title isn't valid, just ignore it
		}
	}
	return result;
};

/**
 * Get list of menu items from a server response.
 *
 * @param {Object} data Query result
 * @returns {ve.ui.MenuItemWidget[]} Menu items
 */
ve.ui.MWCategoryInputWidget.prototype.getLookupMenuItemsFromData = function ( data ) {
	var i, len, item,
		exactMatch = false,
		newCategoryItems = [],
		existingCategoryItems = [],
		matchingCategoryItems = [],
		items = [],
		menu$$ = this.lookupMenu.$$,
		category = this.getCategoryItemFromValue( this.value ),
		existingCategories = this.categoryWidget.getCategories(),
		matchingCategories = data || [];

	// Existing categories
	for ( i = 0, len = existingCategories.length - 1; i < len; i++ ) {
		item = existingCategories[i];
		// Verify that item starts with category.value
		if ( item.lastIndexOf( category.value, 0 ) === 0 ) {
			if ( item === category.value ) {
				exactMatch = true;
			}
			existingCategoryItems.push( item );
		}
	}
	// Matching categories
	for ( i = 0, len = matchingCategories.length; i < len; i++ ) {
		item = matchingCategories[i];
		if (
			ve.indexOf( item, existingCategories ) === -1 &&
			item.lastIndexOf( category.value, 0 ) === 0
		) {
			if ( item === category.value ) {
				exactMatch = true;
			}
			matchingCategoryItems.push( item );
		}
	}
	// New category
	if ( !exactMatch ) {
		newCategoryItems.push( category.value );
	}

	// Add sections for non-empty groups
	if ( newCategoryItems.length ) {
		items.push( new ve.ui.MenuSectionItemWidget(
			'newCategory', { '$$': menu$$, 'label': ve.msg( 'visualeditor-dialog-meta-categories-input-newcategorylabel' ) }
		) );
		for ( i = 0, len = newCategoryItems.length; i < len; i++ ) {
			item = newCategoryItems[i];
			items.push( new ve.ui.MenuItemWidget( item, { '$$': menu$$, 'label': item } ) );
		}
	}
	if ( existingCategoryItems.length ) {
		items.push( new ve.ui.MenuSectionItemWidget(
			'inArticle', { '$$': menu$$, 'label': ve.msg( 'visualeditor-dialog-meta-categories-input-movecategorylabel' ) }
		) );
		for ( i = 0, len = existingCategoryItems.length; i < len; i++ ) {
			item = existingCategoryItems[i];
			items.push( new ve.ui.MenuItemWidget( item, { '$$': menu$$, 'label': item } ) );
		}
	}
	if ( matchingCategoryItems.length ) {
		items.push( new ve.ui.MenuSectionItemWidget(
			'matchingCategories', { '$$': menu$$, 'label': ve.msg( 'visualeditor-dialog-meta-categories-input-matchingcategorieslabel' ) }
		) );
		for ( i = 0, len = matchingCategoryItems.length; i < len; i++ ) {
			item = matchingCategoryItems[i];
			items.push( new ve.ui.MenuItemWidget( item, { '$$': menu$$, 'label': item } ) );
		}
	}

	return items;
};

/**
 * Get a category item.
 *
 * @method
 * @param {string} value Category name
 * @returns {Object} Category item with name, value and metaItem properties
 */
ve.ui.MWCategoryInputWidget.prototype.getCategoryItemFromValue = function ( value ) {
	var title;

	// Normalize
	try {
		title = new mw.Title( this.categoryPrefix + value );
		return {
			'name': title.getPrefixedText(),
			'value': title.getMainText(),
			'metaItem': {}
		};
	} catch ( e ) { }

	if ( this.forceCapitalization ) {
		value = value.substr( 0, 1 ).toUpperCase() + value.substr( 1 );
	}

	return { 'name': this.categoryPrefix + value, 'value': value, 'metaItem': {} };
};
