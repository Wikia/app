/*!
 * VisualEditor UserInterface MWCategoryWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWCategoryWidget object.
 *
 * @class
 * @abstract
 * @extends OO.ui.Widget
 * @mixins OO.ui.mixin.GroupElement
 * @mixins OO.ui.mixin.DraggableGroupElement
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
	OO.ui.mixin.GroupElement.call( this, config );
	OO.ui.mixin.DraggableGroupElement.call( this, $.extend( {}, config, { orientation: 'horizontal' } ) );

	// Properties
	this.categories = {};
	this.categoryRedirects = {}; // Source -> target
	this.popupState = false;
	this.savedPopupState = false;
	this.popup = new ve.ui.MWCategoryPopupWidget();
	this.input = new ve.ui.MWCategoryInputWidget( this, { $overlay: config.$overlay } );
	this.forceCapitalization = mw.config.get( 'wgCaseSensitiveNamespaces' ).indexOf( 14 ) === -1;
	this.categoryPrefix = mw.config.get( 'wgFormattedNamespaces' )[ '14' ] + ':';

	// Events
	this.input.connect( this, { choose: 'onInputChoose' } );
	this.popup.connect( this, {
		removeCategory: 'onRemoveCategory',
		updateSortkey: 'onUpdateSortkey',
		hide: 'onPopupHide'
	} );
	this.connect( this, { reorder: 'onReorder' } );

	// Initialization
	this.$element.addClass( 've-ui-mwCategoryWidget' )
		.append(
			this.$group.addClass( 've-ui-mwCategoryWidget-items' ),
			this.input.$element,
			this.popup.$element,
			$( '<div>' ).css( 'clear', 'both' )
		);
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCategoryWidget, OO.ui.Widget );

OO.mixinClass( ve.ui.MWCategoryWidget, OO.ui.mixin.GroupElement );
OO.mixinClass( ve.ui.MWCategoryWidget, OO.ui.mixin.DraggableGroupElement );

/* Events */

/**
 * @event newCategory
 * @param {Object} item Category item
 * @param {string} item.name Fully prefixed category name
 * @param {string} item.value Category value (name without prefix)
 * @param {Object} item.metaItem Category meta item
 * @param {ve.dm.MetaItem} [afterCategory] Insert after this category; if unset, insert at the end
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
 * Handle input 'choose' event.
 *
 * @param {OO.ui.MenuOptionWidget} item Selected item
 */
ve.ui.MWCategoryWidget.prototype.onInputChoose = function ( item ) {
	var categoryItem,
		value = item.getData(),
		widget = this;

	if ( value && value !== '' ) {
		// Add new item
		categoryItem = this.getCategoryItemFromValue( value );
		this.queryCategoryStatus( [ categoryItem.name ] ).done( function ( normalisedTitles ) {
			// Remove existing items by name
			var toRemove = mw.Title.newFromText( categoryItem.name ).getMainText();
			if ( Object.prototype.hasOwnProperty.call( widget.categories, toRemove ) ) {
				widget.categories[ toRemove ].metaItem.remove();
			}
			categoryItem.name = normalisedTitles[ categoryItem.name ] || categoryItem.name;
			widget.emit( 'newCategory', categoryItem );
		} );
	}
};

/**
 * Get a category item.
 *
 * @param {string} value Category name
 * @return {Object} Category item with name, value and metaItem properties
 */
ve.ui.MWCategoryWidget.prototype.getCategoryItemFromValue = function ( value ) {
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

/**
 * @param {Object} item Item that was moved
 * @param {number} newIndex The new index of the item
 */
ve.ui.MWCategoryWidget.prototype.onReorder = function ( item, newIndex ) {
	// Compute afterCategory before removing, otherwise newIndex
	// could be off by one
	var afterCategory = this.items[ newIndex ] && this.items[ newIndex ].metaItem;
	if ( Object.prototype.hasOwnProperty.call( this.categories, item.value ) ) {
		this.categories[ item.value ].metaItem.remove();
	}

	this.emit( 'newCategory', item, afterCategory );
};

/**
 * Removes category from model.
 *
 * @method
 * @param {string} name category name
 */
ve.ui.MWCategoryWidget.prototype.onRemoveCategory = function ( name ) {
	this.categories[ name ].metaItem.remove();
	delete this.categories[ name ];
};

/**
 * Update sortkey value, emit updateSortkey event
 *
 * @method
 * @param {string} name
 * @param {string} value
 */
ve.ui.MWCategoryWidget.prototype.onUpdateSortkey = function ( name, value ) {
	this.categories[ name ].sortKey = value;
	this.emit( 'updateSortkey', this.categories[ name ] );
};

/**
 * @inheritdoc
 */
ve.ui.MWCategoryWidget.prototype.clearItems = function () {
	OO.ui.mixin.GroupElement.prototype.clearItems.call( this );
	this.categories = {};
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
 *
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
	return Object.keys( this.categories );
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
	var categoryWidget = this,
		categoryNamesToQuery = [];
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
		var linkCacheUpdate = {},
			normalisedTitles = {};
		if ( result && result.query && result.query.pages ) {
			$.each( result.query.pages, function ( index, pageInfo ) {
				linkCacheUpdate[ pageInfo.title ] = {
					missing: Object.prototype.hasOwnProperty.call( pageInfo, 'missing' ),
					hidden: pageInfo.pageprops &&
						Object.prototype.hasOwnProperty.call( pageInfo.pageprops, 'hiddencat' )
				};
			} );
		}
		if ( result && result.query && result.query.redirects ) {
			$.each( result.query.redirects, function ( index, redirectInfo ) {
				categoryWidget.categoryRedirects[ redirectInfo.from ] = redirectInfo.to;
			} );
		}
		ve.init.platform.linkCache.set( linkCacheUpdate );

		if ( result.query && result.query.normalized ) {
			$.each( result.query.normalized, function ( index, normalisation ) {
				normalisedTitles[ normalisation.from ] = normalisation.to;
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
		existingCategoryItems = [],
		categoryNames = $.map( items, function ( item ) {
			return item.name;
		} ),
		categoryWidget = this;

	return this.queryCategoryStatus( categoryNames ).then( function ( normalisedTitles ) {
		var itemTitle, config, cachedData,
			checkValueMatches = function ( existingCategoryItem ) {
				return config.item.value === existingCategoryItem.value;
			};

		for ( i = 0, len = items.length; i < len; i++ ) {
			item = items[ i ];
			item.name = normalisedTitles[ item.name ] || item.name;

			itemTitle = new mw.Title( item.name, mw.config.get( 'wgNamespaceIds' ).category );
			// Create a widget using the item data
			config = {
				item: item
			};
			if ( Object.prototype.hasOwnProperty.call( categoryWidget.categoryRedirects, itemTitle.getPrefixedText() ) ) {
				config.redirectTo = new mw.Title(
					categoryWidget.categoryRedirects[ itemTitle.getPrefixedText() ],
					mw.config.get( 'wgNamespaceIds' ).category
				).getMainText();
				cachedData = ve.init.platform.linkCache.getCached( categoryWidget.categoryRedirects[ itemTitle.getPrefixedText() ] );
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
			categoryWidget.categories[ itemTitle.getMainText() ] = categoryItem;
			// Copy sortKey from old item when "moving"
			existingCategoryItems = $.grep( categoryWidget.items, checkValueMatches );
			if ( existingCategoryItems.length ) {
				// There should only be one element in existingCategoryItems
				categoryItem.sortKey = existingCategoryItems[ 0 ].sortKey;
				categoryWidget.removeItems( [ existingCategoryItems[ 0 ] ] );
			}

			categoryItems.push( categoryItem );
		}

		OO.ui.mixin.DraggableGroupElement.prototype.addItems.call( categoryWidget, categoryItems, index );

		categoryWidget.fitInput();
	} );
};

/**
 * @inheritdoc
 */
ve.ui.MWCategoryWidget.prototype.removeItems = function ( items ) {
	var i, len, categoryItem;

	for ( i = 0, len = items.length; i < len; i++ ) {
		categoryItem = items[ i ];
		if ( categoryItem ) {
			categoryItem.disconnect( this );
			items.push( categoryItem );
			delete this.categories[ categoryItem.value ];
		}
	}

	OO.ui.mixin.DraggableGroupElement.prototype.removeItems.call( this, items );

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

	if ( !$input.is( ':visible' ) ) {
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
