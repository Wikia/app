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
	this.categoryRedirects = [];
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
	return ve.init.target.constructor.static.apiRequest( {
		'action': 'query',
		'list': 'allcategories',
		'acprefix': this.value,
		'acprop': 'hidden',
		'redirects': ''
	} );
};

/**
 * Get lookup cache item from server response data.
 *
 * @method
 * @param {Mixed} data Response from server
 */
ve.ui.MWCategoryInputWidget.prototype.getLookupCacheItemFromData = function ( data ) {
	var categoryInputWidget = this, result = {};
	if ( data.query && data.query.allcategories ) {
		$.each( data.query.allcategories, function () {
			var title = mw.Title.newFromText( this['*'] );
			if ( title ) {
				result[title.getMainText()] = this.hasOwnProperty( 'hidden' );
				categoryInputWidget.categoryWidget.categoryHiddenStatus[this['*']] = result[title.getMainText()];
			} else {
				mw.log.warning( '"' + this['*'] + '" is an invalid title!' );
			}
		} );
	}
	if ( data.query && data.query.redirects ) {
		$.each( data.query.redirects, function ( index, redirectInfo ) {
			var foundIdentical = false;
			$.each( categoryInputWidget.categoryRedirects, function ( index, existingRedirectInfo ) {
				if ( existingRedirectInfo.from === redirectInfo.from && existingRedirectInfo.to === redirectInfo.to ) {
					foundIdentical = true;
				}
			} );
			if ( !foundIdentical ) {
				categoryInputWidget.categoryRedirects.push( redirectInfo );
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
		hiddenCategories = [],
		redirectStorage = {},
		itemTitle,
		searchForQueryWithinRedirectInfo = function ( element ) {
			return element.lastIndexOf( new mw.Title( 'Category:' + category.value ).getPrefixedText(), 0 ) === 0;
		};

	$.each( this.categoryRedirects, function () {
		if ( redirectStorage.hasOwnProperty( this.to ) && redirectStorage[this.to].indexOf( this.from ) === -1 ) {
			redirectStorage[this.to].push( this.from );
		} else {
			redirectStorage[this.to] = [this.from];
		}
	} );

	$.each( data, function ( title, hiddenStatus ) {
		if ( hiddenStatus ) {
			hiddenCategories.push( title );
		} else {
			matchingCategories.push( title );
		}
	} );

	// Existing categories
	// This is deliberately not checking the last existingCategories entry so we don't show it under
	// "Move this category here" etc. That is done below.
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
	// Now check the last one. Don't add to existingCategoryItems but do make it a match
	if ( existingCategories[existingCategories.length - 1] === category.value ) {
		exactMatch = true;
	}

	// Matching categories
	for ( i = 0, len = matchingCategories.length; i < len; i++ ) {
		item = matchingCategories[i];
		itemTitle = new mw.Title( 'Category:' + item ).getPrefixedText();
		if (
			ve.indexOf( item, existingCategories ) === -1 &&
			item.lastIndexOf( category.value, 0 ) === 0 || (
				redirectStorage[itemTitle] !== undefined &&
				$.grep( redirectStorage[itemTitle], searchForQueryWithinRedirectInfo ).length
			)
		) {
			if ( ( item === category.value ) || (
				redirectStorage[itemTitle] !== undefined &&
				redirectStorage[itemTitle].indexOf( new mw.Title( 'Category:' + category.value ).getPrefixedText() ) !== -1
			) ) {
				exactMatch = true;
			}
			matchingCategoryItems.push( item );
		}
	}
	// Hidden categories
	for ( i = 0, len = hiddenCategories.length; i < len; i++ ) {
		item = hiddenCategories[i];
		itemTitle = new mw.Title( 'Category:' + item ).getPrefixedText();
		if (
			ve.indexOf( item, existingCategories ) === -1 &&
			item.lastIndexOf( category.value, 0 ) === 0 || (
				redirectStorage[itemTitle] !== undefined &&
				$.grep( redirectStorage[itemTitle], searchForQueryWithinRedirectInfo ).length
			)
		) {
			if ( ( item === category.value ) || (
				redirectStorage[itemTitle] !== undefined &&
				redirectStorage[itemTitle].indexOf( new mw.Title( 'Category:' + category.value ).getPrefixedText() ) !== -1
			) ) {
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
			items.push( this.getMenuItemWidgetFromCategoryName( item, menu$ ) );
		}
	}
	if ( hiddenCategoryItems.length ) {
		items.push( new OO.ui.MenuSectionItemWidget(
			'hiddenCategories', { '$': menu$, 'label': ve.msg( 'visualeditor-dialog-meta-categories-input-hiddencategorieslabel' ) }
		) );
		for ( i = 0, len = hiddenCategoryItems.length; i < len; i++ ) {
			item = hiddenCategoryItems[i];
			items.push( this.getMenuItemWidgetFromCategoryName( item, menu$ ) );
		}
	}

	return items;
};

/**
 * Get a OO.ui.MenuSectionItemWidget object for a given category name.
 * Deals with redirects.
 *
 * @method
 * @param {string} item Category name
 * @param {jQuery} menu$ Lookup menu jQuery
 * @returns {OO.ui.MenuSectionItemWidget} Menu item
 */
ve.ui.MWCategoryInputWidget.prototype.getMenuItemWidgetFromCategoryName = function ( item, menu$ ) {
	var itemTitle = new mw.Title( 'Category:' + item ).getPrefixedText(),
		redirectInfo = $.grep( this.categoryRedirects, function ( redirectInfo ) {
			return redirectInfo.to === itemTitle;
		} );
	if ( redirectInfo.length ) {
		return new OO.ui.MenuItemWidget( item, {
			'$': menu$,
			'autoFitLabel': false,
			'label': this.$( '<span>' )
				.text( new mw.Title( redirectInfo[0].from ).getMainText() )
				.append( '<br>↳ ' )
				.append( $( '<span>' ).text( new mw.Title( item ).getMainText() ) )
		} );
	} else {
		return new OO.ui.MenuItemWidget( item, { '$': menu$, 'label': item } );
	}
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
