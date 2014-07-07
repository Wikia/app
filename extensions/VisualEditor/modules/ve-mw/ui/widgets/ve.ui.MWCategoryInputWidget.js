/*!
 * VisualEditor UserInterface MWCategoryInputWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Creates an ve.ui.MWCategoryInputWidget object.
 *
 * @class
 * @extends OO.ui.TextInputWidget
 * @mixins OO.ui.LookupInputWidget
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
	OO.ui.TextInputWidget.call( this, config );

	// Mixin constructors
	OO.ui.LookupInputWidget.call( this, this, config );

	// Properties
	this.categoryWidget = categoryWidget;
	this.forceCapitalization = mw.config.get( 'wgCaseSensitiveNamespaces' ).indexOf( 14 ) === -1;
	this.categoryPrefix = mw.config.get( 'wgFormattedNamespaces' )['14'] + ':';

	// Initialization
	this.$element.addClass( 've-ui-mwCategoryInputWidget' );
	this.lookupMenu.$element.addClass( 've-ui-mwCategoryInputWidget-menu' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCategoryInputWidget, OO.ui.TextInputWidget );

OO.mixinClass( ve.ui.MWCategoryInputWidget, OO.ui.LookupInputWidget );

/* Methods */

/**
 * Gets a new request object of the current lookup query value.
 *
 * @method
 * @returns {jqXHR} AJAX object without success or fail handlers attached
 */
ve.ui.MWCategoryInputWidget.prototype.getLookupRequest = function () {
	var propsJqXhr,
		searchJqXhr = ve.init.mw.Target.static.apiRequest( {
			'action': 'opensearch',
			'search': this.categoryPrefix + this.value,
			'suggest': ''
		} );

	return searchJqXhr.then( function ( data ) {
		propsJqXhr = ve.init.mw.Target.static.apiRequest( {
			'action': 'query',
			'prop': 'pageprops',
			'titles': ( data[1] || [] ).join( '|' ),
			'ppprop': 'hiddencat'
		} );
		return propsJqXhr;
	} ).promise( { abort: function () {
		searchJqXhr.abort();

		if ( propsJqXhr ) {
			propsJqXhr.abort();
		}
	} } );
};

/**
 * Get lookup cache item from server response data.
 *
 * @method
 * @param {Mixed} data Response from server
 */
ve.ui.MWCategoryInputWidget.prototype.getLookupCacheItemFromData = function ( data ) {
	var categoryWidget = this.categoryWidget, result = {};
	if ( data.query && data.query.pages ) {
		$.each( data.query.pages, function ( pageId, pageInfo ) {
			var title = mw.Title.newFromText( pageInfo.title );
			if ( title ) {
				result[title.getMainText()] = !!( pageInfo.pageprops && pageInfo.pageprops.hiddencat !== undefined );
				categoryWidget.categoryHiddenStatus[pageInfo.title] = result[title.getMainText()];
			} else {
				mw.log.warning( '"' + pageInfo.title + '" is an invalid title!' );
			}
		} );
	}
	return result;
};

/**
 * Get list of menu items from a server response.
 *
 * @param {Object} data Query result
 * @returns {OO.ui.MenuItemWidget[]} Menu items
 */
ve.ui.MWCategoryInputWidget.prototype.getLookupMenuItemsFromData = function ( data ) {
	var i, len, item,
		exactMatch = false,
		newCategoryItems = [],
		existingCategoryItems = [],
		matchingCategoryItems = [],
		hiddenCategoryItems = [],
		items = [],
		menu$ = this.lookupMenu.$,
		category = this.getCategoryItemFromValue( this.value ),
		existingCategories = this.categoryWidget.getCategories(),
		matchingCategories = [],
		hiddenCategories = [];

	$.each( data, function ( title, hiddenStatus ) {
		if ( hiddenStatus ) {
			hiddenCategories.push( title );
		} else {
			matchingCategories.push( title );
		}
	} );

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
	// Hidden categories
	for ( i = 0, len = hiddenCategories.length; i < len; i++ ) {
		item = hiddenCategories[i];
		if (
			ve.indexOf( item, existingCategories ) === -1 &&
			item.lastIndexOf( category.value, 0 ) === 0
		) {
			if ( item === category.value ) {
				exactMatch = true;
			}
			hiddenCategoryItems.push( item );
		}
	}
	// New category
	if ( !exactMatch ) {
		newCategoryItems.push( category.value );
	}

	// Add sections for non-empty groups
	if ( newCategoryItems.length ) {
		items.push( new OO.ui.MenuSectionItemWidget(
			'newCategory', { '$': menu$, 'label': ve.msg( 'visualeditor-dialog-meta-categories-input-newcategorylabel' ) }
		) );
		for ( i = 0, len = newCategoryItems.length; i < len; i++ ) {
			item = newCategoryItems[i];
			items.push( new OO.ui.MenuItemWidget( item, { '$': menu$, 'label': item } ) );
		}
	}
	if ( existingCategoryItems.length ) {
		items.push( new OO.ui.MenuSectionItemWidget(
			'inArticle', { '$': menu$, 'label': ve.msg( 'visualeditor-dialog-meta-categories-input-movecategorylabel' ) }
		) );
		for ( i = 0, len = existingCategoryItems.length; i < len; i++ ) {
			item = existingCategoryItems[i];
			items.push( new OO.ui.MenuItemWidget( item, { '$': menu$, 'label': item } ) );
		}
	}
	if ( matchingCategoryItems.length ) {
		items.push( new OO.ui.MenuSectionItemWidget(
			'matchingCategories', { '$': menu$, 'label': ve.msg( 'visualeditor-dialog-meta-categories-input-matchingcategorieslabel' ) }
		) );
		for ( i = 0, len = matchingCategoryItems.length; i < len; i++ ) {
			item = matchingCategoryItems[i];
			items.push( new OO.ui.MenuItemWidget( item, { '$': menu$, 'label': item } ) );
		}
	}
	if ( hiddenCategoryItems.length ) {
		items.push( new OO.ui.MenuSectionItemWidget(
			'hiddenCategories', { '$': menu$, 'label': ve.msg( 'visualeditor-dialog-meta-categories-input-hiddencategorieslabel' ) }
		) );
		for ( i = 0, len = hiddenCategoryItems.length; i < len; i++ ) {
			item = hiddenCategoryItems[i];
			items.push( new OO.ui.MenuItemWidget( item, { '$': menu$, 'label': item } ) );
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
	title = mw.Title.newFromText( this.categoryPrefix + value );
	if ( title ) {
		return {
			'name': title.getPrefixedText(),
			'value': title.getMainText(),
			'metaItem': {}
		};
	}

	if ( this.forceCapitalization ) {
		value = value.substr( 0, 1 ).toUpperCase() + value.substr( 1 );
	}

	return {
		'name': this.categoryPrefix + value,
		'value': value,
		'metaItem': {}
	};
};
