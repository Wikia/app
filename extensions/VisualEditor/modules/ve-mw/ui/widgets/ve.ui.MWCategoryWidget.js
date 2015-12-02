/*!
 * VisualEditor UserInterface MWCategoryWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWCategoryWidget object.
 *
 * @class
 * @abstract
 * @extends OO.ui.Widget
 * @mixins OO.ui.GroupElement
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {jQuery} [$overlay] Overlay to render dropdowns in
 */
ve.ui.MWCategoryWidget = function VeUiMWCategoryWidget( config ) {
	// Config initialization
	config = config || {};

	// Parent constructor
	OO.ui.Widget.call( this, config );

	// Mixin constructors
	OO.ui.GroupElement.call( this, config );

	// Properties
	this.categories = {};
	this.categoryRedirects = {}; // Source -> target
	this.popupState = false;
	this.savedPopupState = false;
	this.popup = new ve.ui.MWCategoryPopupWidget( {
		$: this.$
	} );
	this.input = new ve.ui.MWCategoryInputWidget( this, {
		$: this.$, $overlay: config.$overlay
	} );

	// Events
	this.input.lookupMenu.connect( this, { choose: 'onLookupMenuItemChoose' } );
	this.popup.connect( this, {
		removeCategory: 'onRemoveCategory',
		updateSortkey: 'onUpdateSortkey',
		hide: 'onPopupHide'
	} );

	// Initialization
	this.$element.addClass( 've-ui-mwCategoryWidget' )
		.append(
			this.$group.addClass( 've-ui-mwCategoryWidget-items' ),
			this.input.$element,
			this.popup.$element,
			this.$( '<div>' ).css( 'clear', 'both' )
		);
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCategoryWidget, OO.ui.Widget );

OO.mixinClass( ve.ui.MWCategoryWidget, OO.ui.GroupElement );

/* Events */

/**
 * @event newCategory
 * @param {Object} item Category item
 * @param {string} item.name Fully prefixed category name
 * @param {string} item.value Category value (name without prefix)
 * @param {Object} item.metaItem Category meta item
 */

/**
 * @event updateSortkey
 * @param {Object} item Category item
 * @param {string} item.name Fully prefixed category name
 * @param {string} item.value Category value (name without prefix)
 * @param {Object} item.metaItem Category meta item
 */

/* Methods */

/**
 * Handle menu item select event.
 *
 * @method
 * @param {OO.ui.MenuOptionWidget} item Selected item
 */
ve.ui.MWCategoryWidget.prototype.onLookupMenuItemChoose = function ( item ) {
	var categoryItem,
		value = item && item.getData(),
		categoryWidget = this;

	if ( value && value !== '' ) {
		// Add new item
		categoryItem = this.input.getCategoryItemFromValue( value );
		this.queryCategoryStatus( [categoryItem.name] ).done( function ( normalisedTitles ) {
			// Remove existing items by name
			var toRemove = mw.Title.newFromText( categoryItem.name ).getMainText();
			if ( Object.prototype.hasOwnProperty.call( categoryWidget.categories, toRemove ) ) {
				categoryWidget.categories[toRemove].metaItem.remove();
			}
			categoryItem.name = normalisedTitles[categoryItem.name] || categoryItem.name;
			categoryWidget.emit( 'newCategory', categoryItem );
		} );

		// Reset input
		this.input.setValue( '' );
	}
};

/**
 * Removes category from model.
 *
 * @method
 * @param {string} name category name
 */
ve.ui.MWCategoryWidget.prototype.onRemoveCategory = function ( name ) {
	this.categories[name].metaItem.remove();
};

/**
 * Update sortkey value, emit updateSortkey event
 *
 * @method
 * @param {string} name
 * @param {string} value
 */
ve.ui.MWCategoryWidget.prototype.onUpdateSortkey = function ( name, value ) {
	this.categories[name].sortKey = value;
	this.emit( 'updateSortkey', this.categories[name] );
};

/**
 * Sets popup state when popup is hidden
 */
ve.ui.MWCategoryWidget.prototype.onPopupHide = function () {
	this.popupState = false;
};

/**
 * Saves current popup state
 */
ve.ui.MWCategoryWidget.prototype.onSavePopupState = function () {
	this.savedPopupState = this.popupState;
};

/**
 * Toggles popup menu per category item
 * @param {Object} item
 */
ve.ui.MWCategoryWidget.prototype.onTogglePopupMenu = function ( item ) {
	// Close open popup.
	if ( this.savedPopupState === false || item.value !== this.popup.category ) {
		this.popup.openPopup( item );
	} else {
		// Handle toggle
		this.popup.closePopup();
	}
};

/** */
ve.ui.MWCategoryWidget.prototype.setDefaultSortKey = function ( value ) {
	this.popup.setDefaultSortKey( value );
};

/**
 * Get list of category names.
 *
 * @method
 * @param {string[]} List of category names
 */
ve.ui.MWCategoryWidget.prototype.getCategories = function () {
	return ve.getObjectKeys( this.categories );
};

/**
 * Starts a request to update the link cache's hidden and missing status for
 *  the given titles, following normalisation responses as necessary.
 * The returned promise will be resolved with an object with input titles as keys
 * and their normalised versions as values, where different.
 *
 * @param {string[]} categoryNames
 * @return {jQuery.Promise}
 */
ve.ui.MWCategoryWidget.prototype.queryCategoryStatus = function ( categoryNames ) {
	var categoryWidget = this, categoryNamesToQuery = [];
	// Get rid of any we already know the hidden status of.
	categoryNamesToQuery = $.grep( categoryNames, function ( categoryTitle ) {
		var cacheEntry = ve.init.platform.linkCache.getCached( categoryTitle );
		return !( cacheEntry && cacheEntry.hidden );
	} );

	if ( !categoryNamesToQuery.length ) {
		return $.Deferred().resolve( {} ).promise();
	}

	return new mw.Api().get( {
		action: 'query',
		prop: 'pageprops',
		titles: categoryNamesToQuery.join( '|' ),
		ppprop: 'hiddencat',
		redirects: ''
	} ).then( function ( result ) {
		var linkCacheUpdate = {}, normalisedTitles = {};
		if ( result && result.query && result.query.pages ) {
			$.each( result.query.pages, function ( index, pageInfo ) {
				linkCacheUpdate[pageInfo.title] = {
					missing: Object.prototype.hasOwnProperty.call( pageInfo, 'missing' ),
					hidden: pageInfo.pageprops &&
						Object.prototype.hasOwnProperty.call( pageInfo.pageprops, 'hiddencat' )
				};
			} );
		}
		if ( result && result.query && result.query.redirects ) {
			$.each( result.query.redirects, function ( index, redirectInfo ) {
				categoryWidget.categoryRedirects[redirectInfo.from] = redirectInfo.to;
			} );
		}
		ve.init.platform.linkCache.set( linkCacheUpdate );

		if ( result.query && result.query.normalized ) {
			$.each( result.query.normalized, function ( index, normalisation ) {
				normalisedTitles[normalisation.from] = normalisation.to;
			} );
		}

		return normalisedTitles;
	} );
};

/**
 * Adds category items.
 *
 * @method
 * @param {Object[]} items Items to add
 * @param {number} [index] Index to insert items after
 * @return {jQuery.Promise}
 */
ve.ui.MWCategoryWidget.prototype.addItems = function ( items, index ) {
	var i, len, item, categoryItem,
		categoryItems = [],
		existingCategoryItem = null,
		categoryNames = $.map( items, function ( item ) {
			return item.name;
		} ),
		categoryWidget = this;

	return this.queryCategoryStatus( categoryNames ).then( function ( normalisedTitles ) {
		var itemTitle, config, cachedData;

		for ( i = 0, len = items.length; i < len; i++ ) {
			item = items[i];
			item.name = normalisedTitles[item.name] || item.name;

			itemTitle = new mw.Title( item.name, mw.config.get( 'wgNamespaceIds' ).category );
			// Create a widget using the item data
			config = {
				$: categoryWidget.$,
				item: item
			};
			if ( Object.prototype.hasOwnProperty.call( categoryWidget.categoryRedirects, itemTitle.getPrefixedText() ) ) {
				config.redirectTo = new mw.Title(
					categoryWidget.categoryRedirects[itemTitle.getPrefixedText()],
					mw.config.get( 'wgNamespaceIds' ).category
				).getMainText();
				cachedData = ve.init.platform.linkCache.getCached( categoryWidget.categoryRedirects[itemTitle.getPrefixedText()] );
			} else {
				cachedData = ve.init.platform.linkCache.getCached( item.name );
			}
			config.hidden = cachedData.hidden;
			config.missing = cachedData.missing;

			categoryItem = new ve.ui.MWCategoryItemWidget( config );
			categoryItem.connect( categoryWidget, {
				savePopupState: 'onSavePopupState',
				togglePopupMenu: 'onTogglePopupMenu'
			} );

			// Index item
			categoryWidget.categories[itemTitle.getMainText()] = categoryItem;
			// Copy sortKey from old item when "moving"
			if ( existingCategoryItem ) {
				categoryItem.sortKey = existingCategoryItem.sortKey;
			}

			categoryItems.push( categoryItem );
		}

		OO.ui.GroupElement.prototype.addItems.call( categoryWidget, categoryItems, index );

		categoryWidget.fitInput();
	} );
};

/**
 * Remove category items.
 *
 * @method
 * @param {string[]} names Names of categories to remove
 */
ve.ui.MWCategoryWidget.prototype.removeItems = function ( names ) {
	var i, len, categoryItem,
		items = [];

	for ( i = 0, len = names.length; i < len; i++ ) {
		categoryItem = this.categories[names[i]];
		if ( categoryItem ) {
			categoryItem.disconnect( this );
			items.push( categoryItem );
			delete this.categories[names[i]];
		}
	}

	OO.ui.GroupElement.prototype.removeItems.call( this, items );

	this.fitInput();
};

/**
 * Auto-fit the input.
 *
 * @method
 */
ve.ui.MWCategoryWidget.prototype.fitInput = function () {
	var gap, min, $lastItem,
		$input = this.input.$element;

	if ( !$input.is( ':visible') ) {
		return;
	}

	$input.css( { width: 'inherit' } );
	min = $input.outerWidth();

	$input.css( { width: '100%' } );
	$lastItem = this.$element.find( '.ve-ui-mwCategoryItemWidget:last' );
	if ( $lastItem.length ) {
		// Try to fit to the right of the last item
		gap = ( $input.offset().left + $input.outerWidth() ) -
				( $lastItem.offset().left + $lastItem.outerWidth() );
		if ( gap >= min ) {
			$input.css( { width: gap } );
		}
	}
};
