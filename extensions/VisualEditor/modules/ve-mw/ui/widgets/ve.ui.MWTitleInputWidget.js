/*!
 * VisualEditor UserInterface MWTitleInputWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw*/

/**
 * Creates an ve.ui.MWTitleInputWidget object.
 *
 * @class
 * @extends ve.ui.TextInputWidget
 * @mixins ve.ui.LookupInputWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @param {number} [namespace] Namespace to prepend to queries not prefixed with ':'
 */
ve.ui.MWTitleInputWidget = function VeUiMWTitleInputWidget( config ) {
	// Config intialization
	config = config || {};

	// Parent constructor
	ve.ui.TextInputWidget.call( this, config );

	// Mixin constructors
	ve.ui.LookupInputWidget.call( this, this, config );

	// Properties
	this.namespace = config.namespace || null;

	// Events
	this.lookupMenu.connect( this, { 'select': 'onLookupMenuItemSelect' } );

	// Initialization
	this.$.addClass( 've-ui-mwTitleInputWidget' );
	this.lookupMenu.$.addClass( 've-ui-mwTitleInputWidget-menu' );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWTitleInputWidget, ve.ui.TextInputWidget );

ve.mixinClass( ve.ui.MWTitleInputWidget, ve.ui.LookupInputWidget );

/* Methods */

/**
 * Handle menu item select event.
 *
 * @method
 * @param {ve.ui.MenuItemWidget} item Selected item
 */
ve.ui.MWTitleInputWidget.prototype.onLookupMenuItemSelect = function ( item ) {
	if ( item ) {
		this.setValue( item.getData() );
	}
};

/**
 * Gets a new request object of the current lookup query value.
 *
 * @method
 * @returns {jQuery.Deferred} Deferred object with success and fail handlers already attached
 */
ve.ui.MWTitleInputWidget.prototype.getLookupRequest = function () {
	var value = this.value;

	// Prefix with default namespace name
	if ( this.namespace !== null && value.charAt( 0 ) !== ':' ) {
		value = mw.config.get( 'wgFormattedNamespaces' )[this.namespace] + ':' + value;
	}

	// Dont send leading ':' to open search
	if ( value.charAt( 0 ) === ':' ) {
		value = value.substr( 1 );
	}

	return $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'format': 'json',
			'action': 'opensearch',
			'search': value,
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
ve.ui.MWTitleInputWidget.prototype.getLookupCacheItemFromData = function ( data ) {
	return ve.isArray( data ) && data.length ? data[1] : [];
};

/**
 * Get list of menu items from a server response.
 *
 * @param {Object} data Query result
 * @returns {ve.ui.MenuItemWidget[]} Menu items
 */
ve.ui.MWTitleInputWidget.prototype.getLookupMenuItemsFromData = function ( data ) {
	var i, len, title, value,
		menu$$ = this.lookupMenu.$$,
		items = [],
		matchingPages = data;

	// Matching pages
	if ( matchingPages && matchingPages.length ) {
		for ( i = 0, len = matchingPages.length; i < len; i++ ) {
			title = new mw.Title( matchingPages[i] );
			if ( this.namespace !== null ) {
				value = title.getNamespaceId() === this.namespace ?
					title.getNameText() : ':' + title.getPrefixedText();
			} else {
				value = title.getPrefixedText();
			}
			items.push( new ve.ui.MenuItemWidget(
				value, { '$$': menu$$, 'label': value }
			) );
		}
	}

	return items;
};
