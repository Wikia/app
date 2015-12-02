/*!
 * VisualEditor UserInterface MWCategoryInputWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

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
	// Config initialization
	config = ve.extendObject( {
		placeholder: ve.msg( 'visualeditor-dialog-meta-categories-input-placeholder' )
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
 * @inheritdoc
 */
ve.ui.MWCategoryInputWidget.prototype.getLookupRequest = function () {
	return ve.init.target.constructor.static.apiRequest( {
		action: 'query',
		generator: 'allcategories',
		gacmin: 1,
		gacprefix: this.value,
		prop: 'categoryinfo',
		redirects: ''
	} );
};

/**
 * @inheritdoc
 */
ve.ui.MWCategoryInputWidget.prototype.getLookupCacheItemFromData = function ( data ) {
	var result = [], linkCacheUpdate = {}, query = data.query || {};

	$.each( query.pages || [], function ( pageId, categoryPage ) {
		result.push( mw.Title.newFromText( categoryPage.title ).getMainText() );
		linkCacheUpdate[categoryPage.title] = {
			missing: categoryPage.hasOwnProperty( 'missing' ),
			hidden: categoryPage.categoryinfo && categoryPage.categoryinfo.hasOwnProperty( 'hidden' )
		};
	} );

	$.each( query.redirects || [], function ( index, redirect ) {
		if ( !linkCacheUpdate.hasOwnProperty( redirect.to ) ) {
			linkCacheUpdate[redirect.to] = ve.init.platform.linkCache.getCached( redirect.to ) ||
				{ missing: false, redirectFrom: [redirect.from] };
		}
		if (
			linkCacheUpdate[redirect.to].redirectFrom &&
			linkCacheUpdate[redirect.to].redirectFrom.indexOf( redirect.from ) === -1
		) {
			linkCacheUpdate[redirect.to].redirectFrom.push( redirect.from );
		} else {
			linkCacheUpdate[redirect.to].redirectFrom = [redirect.from];
		}
	} );

	ve.init.platform.linkCache.set( linkCacheUpdate );

	return result;
};

/**
 * @inheritdoc
 */
ve.ui.MWCategoryInputWidget.prototype.getLookupMenuItemsFromData = function ( data ) {
	var exactMatch = false,
		itemWidgets = [],
		existingCategoryItems = [], matchingCategoryItems = [],
		hiddenCategoryItems = [], newCategoryItems = [],
		existingCategories = this.categoryWidget.getCategories(),
		linkCacheUpdate = {},
		canonicalQueryValue = mw.Title.newFromText( this.value ),
		prefixedCanonicalQueryValue = mw.Title.newFromText(
			this.value,
			mw.config.get( 'wgNamespaceIds' ).category
		);

	prefixedCanonicalQueryValue = prefixedCanonicalQueryValue && prefixedCanonicalQueryValue.getPrefixedText();

	// Invalid titles end up with canonicalQueryValue being null.
	if ( canonicalQueryValue ) {
		canonicalQueryValue = canonicalQueryValue.getMainText();
	}

	$.each( data, function ( index, suggestedCategory ) {
		var suggestedCategoryTitle = mw.Title.newFromText(
				suggestedCategory,
				mw.config.get( 'wgNamespaceIds' ).category
			).getPrefixedText(),
			suggestedCacheEntry = ve.init.platform.linkCache.getCached( suggestedCategoryTitle );
		if ( canonicalQueryValue === suggestedCategory ) {
			exactMatch = true;
		}
		if ( !suggestedCacheEntry ) {
			linkCacheUpdate[suggestedCategoryTitle] = { missing: false };
		}
		if (
			ve.indexOf( suggestedCategory, existingCategories ) === -1
		) {
			if ( suggestedCacheEntry && suggestedCacheEntry.hidden ) {
				hiddenCategoryItems.push( suggestedCategory );
			} else {
				matchingCategoryItems.push( suggestedCategory );
			}
		}
	}.bind( this ) );

	// Existing categories
	$.each( existingCategories, function ( index, existingCategory ) {
		if ( existingCategory === canonicalQueryValue ) {
			exactMatch = true;
		}
		if ( index < existingCategories.length - 1 && existingCategory.lastIndexOf( canonicalQueryValue, 0 ) === 0 ) {
			// Verify that item starts with category.value
			existingCategoryItems.push( existingCategory );
		}
	} );

	// New category
	if ( !exactMatch && canonicalQueryValue ) {
		newCategoryItems.push( canonicalQueryValue );
		linkCacheUpdate[prefixedCanonicalQueryValue] = { missing: true };
	}

	ve.init.platform.linkCache.set( linkCacheUpdate );

	// Add sections for non-empty groups. Each section consists of an id, a label and items
	$.each( [
		{
			id: 'newCategory',
			label: ve.msg( 'visualeditor-dialog-meta-categories-input-newcategorylabel' ),
			items: newCategoryItems
		},
		{
			id: 'inArticle',
			label: ve.msg( 'visualeditor-dialog-meta-categories-input-movecategorylabel' ),
			items: existingCategoryItems
		},
		{
			id: 'matchingCategories',
			label: ve.msg( 'visualeditor-dialog-meta-categories-input-matchingcategorieslabel' ),
			items: matchingCategoryItems
		},
		{
			id: 'hiddenCategories',
			label: ve.msg( 'visualeditor-dialog-meta-categories-input-hiddencategorieslabel' ),
			items: hiddenCategoryItems
		}
	], function ( index, sectionData ) {
		if ( sectionData.items.length ) {
			itemWidgets.push( new OO.ui.MenuSectionOptionWidget( {
				$: this.lookupMenu.$,
				data: sectionData.id,
				label: sectionData.label
			} ) );
			$.each( sectionData.items, function ( index, categoryItem ) {
				itemWidgets.push( this.getCategoryWidgetFromName( categoryItem ) );
			}.bind( this ) );
		}
	}.bind( this ) );

	return itemWidgets;
};

/**
 * Take a category name and turn it into a menu item widget, following redirects.
 *
 * @method
 * @param {string} name Category name
 * @returns {OO.ui.MenuOptionWidget} Menu item widget to be shown
 */
ve.ui.MWCategoryInputWidget.prototype.getCategoryWidgetFromName = function ( name ) {
	var cachedData = ve.init.platform.linkCache.getCached(
		mw.Title.newFromText( name, mw.config.get( 'wgNamespaceIds' ).category ).getPrefixedText()
	);
	if ( cachedData && cachedData.redirectFrom ) {
		return new OO.ui.MenuOptionWidget( {
			$: this.lookupMenu.$,
			data: name,
			autoFitLabel: false,
			label: this.$( '<span>' )
				.text( mw.Title.newFromText( cachedData.redirectFrom[0] ).getMainText() )
				.append( '<br>↳ ' )
				.append( this.$( '<span>' ).text( mw.Title.newFromText( name ).getMainText() ) )
		} );
	} else {
		return new OO.ui.MenuOptionWidget( {
			$: this.lookupMenu.$,
			data: name,
			label: name
		} );
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
			name: title.getPrefixedText(),
			value: title.getMainText(),
			metaItem: {}
		};
	}

	if ( this.forceCapitalization ) {
		value = value.slice( 0, 1 ).toUpperCase() + value.slice( 1 );
	}

	return {
		name: this.categoryPrefix + value,
		value: value,
		metaItem: {}
	};
};
