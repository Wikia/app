/*!
 * VisualEditor UserInterface MWLinkTargetInputWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw*/

/**
 * Creates an ve.ui.MWLinkTargetInputWidget object.
 *
 * @class
 * @extends ve.ui.LinkTargetInputWidget
 * @mixins ve.ui.LookupInputWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWLinkTargetInputWidget = function VeUiMWLinkTargetInputWidget( config ) {
	// Config intialization
	config = config || {};

	// Parent constructor
	ve.ui.LinkTargetInputWidget.call( this, config );

	// Mixin constructors
	ve.ui.LookupInputWidget.call( this, this, config );

	// Events
	this.lookupMenu.connect( this, { 'select': 'onLookupMenuItemSelect' } );

	// Initialization
	this.$.addClass( 've-ui-mwLinkTargetInputWidget' );
	this.lookupMenu.$.addClass( 've-ui-mwLinkTargetInputWidget-menu' );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWLinkTargetInputWidget, ve.ui.LinkTargetInputWidget );

ve.mixinClass( ve.ui.MWLinkTargetInputWidget, ve.ui.LookupInputWidget );

/* Methods */

/**
 * Handle menu item select event.
 *
 * If no item is selected then the input must be invalid, so clear the annotation.
 * We shouldn't just leave the previous annotation as the user has no way of knowing
 * what that might be. For example if "Foo{}Bar" is typed, this.annotation will be
 * a link to "Foo".
 *
 * @method
 * @param {ve.ui.MenuItemWidget|null} item Selected item
 */
ve.ui.MWLinkTargetInputWidget.prototype.onLookupMenuItemSelect = function ( item ) {
	if ( item ) {
		this.setAnnotation( item.getData() );
	} else if ( this.annotation ) {
		this.annotation = null;
	}
};

/**
 * Gets a new request object of the current lookup query value.
 *
 * @method
 * @returns {jqXHR} AJAX object without success or fail handlers attached
 */
ve.ui.MWLinkTargetInputWidget.prototype.getLookupRequest = function () {
	return $.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'format': 'json',
			'action': 'opensearch',
			'search': this.value,
			'namespace': 0,
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
ve.ui.MWLinkTargetInputWidget.prototype.getLookupCacheItemFromData = function ( data ) {
	return ve.isArray( data ) && data.length ? data[1] : [];
};

/**
 * Get list of menu items from a server response.
 *
 * @param {Object} data Query result
 * @returns {ve.ui.MenuItemWidget[]} Menu items
 */
ve.ui.MWLinkTargetInputWidget.prototype.getLookupMenuItemsFromData = function ( data ) {
	var i, len, item,
		menu$$ = this.lookupMenu.$$,
		items = [],
		matchingPages = data,
		// If not found, run value through mw.Title to avoid treating a match as a
		// mismatch where normalisation would make them matching (bug 48476)
		pageExistsExact = ve.indexOf( this.value, matchingPages ) !== -1,
		pageExists =
			pageExistsExact ||
			ve.indexOf( new mw.Title( this.value ).getPrefixedText(), matchingPages ) !== -1;

	// External link
	if ( ve.init.platform.getExternalLinkUrlProtocolsRegExp().test( this.value ) ) {
		items.push( new ve.ui.MenuSectionItemWidget(
			'externalLink',
			{ '$$': menu$$, 'label': ve.msg( 'visualeditor-linkinspector-suggest-external-link' ) }
		) );
		items.push( new ve.ui.MenuItemWidget(
			this.getExternalLinkAnnotationFromUrl( this.value ),
			{ '$$': menu$$, 'rel': 'externalLink', 'label': this.value }
		) );
	}

	// Internal link
	if ( !pageExists ) {
		if ( ve.ui.MWLinkInspector.static.legalTitle.test( this.value ) ) {
			items.push( new ve.ui.MenuSectionItemWidget(
				'newPage',
				{ '$$': menu$$, 'label': ve.msg( 'visualeditor-linkinspector-suggest-new-page' ) }
			) );
			items.push( new ve.ui.MenuItemWidget(
				this.getInternalLinkAnnotationFromTitle( this.value ),
				{ '$$': menu$$, 'rel': 'newPage', 'label': this.value }
			) );
		} else {
			item = new ve.ui.MenuSectionItemWidget(
				'illegalTitle',
				{ '$$': menu$$, 'label': ve.msg( 'visualeditor-linkinspector-illegal-title' ) }
			);
			item.$.addClass( 've-ui-mwLinkTargetInputWidget-warning' );
			items.push( item );
		}
	}

	// Matching pages
	if ( matchingPages && matchingPages.length ) {
		items.push( new ve.ui.MenuSectionItemWidget(
			'matchingPages',
			{ '$$': menu$$, 'label': ve.msg( 'visualeditor-linkinspector-suggest-matching-page' ) }
		) );
		// Offer the exact text as a suggestion if the page exists
		if ( pageExists && !pageExistsExact ) {
			matchingPages.unshift( this.value );
		}
		for ( i = 0, len = matchingPages.length; i < len; i++ ) {
			items.push( new ve.ui.MenuItemWidget(
				this.getInternalLinkAnnotationFromTitle( matchingPages[i] ),
				{ '$$': menu$$, 'rel': 'matchingPage', 'label': matchingPages[i] }
			) );
		}
	}

	return items;
};

/**
 * @inheritdoc
 */
ve.ui.MWLinkTargetInputWidget.prototype.initializeLookupMenuSelection = function () {
	var item;

	// Parent method
	ve.ui.LookupInputWidget.prototype.initializeLookupMenuSelection.call( this );

	// Update annotation to match selected item
	item = this.lookupMenu.getSelectedItem();
	if ( item ) {
		// Set annotation directly, bypassing re-setting the value of the input
		this.annotation = item.getData();
	}
};

/**
 * Set the value of the input.
 *
 * Overrides setValue to keep annotations in sync.
 *
 * @method
 * @param {string} value New value
 */
ve.ui.MWLinkTargetInputWidget.prototype.setValue = function ( value ) {
	// Keep annotation in sync with value by skipping parent and calling grandparent method
	ve.ui.TextInputWidget.prototype.setValue.call( this, value );
};

/**
 * Gets an internal link annotation.
 *
 * File: or Category: links will be prepended with a colon so they are interpreted as a links rather
 * than image inclusions or categorizations.
 *
 * @method
 * @param {string} target Page title
 * @returns {ve.dm.MWInternalLinkAnnotation}
 */
ve.ui.MWLinkTargetInputWidget.prototype.getInternalLinkAnnotationFromTitle = function ( target ) {
	var title;
	try {
		title = new mw.Title( target );
		if ( title.getNamespaceId() === 6 || title.getNamespaceId() === 14 ) {
			target = ':' + target;
		}
	} catch ( e ) { }
	return new ve.dm.MWInternalLinkAnnotation( {
		'type': 'link/mwInternal',
		'attributes': {
			'title': target,
			'normalizedTitle': ve.dm.MWInternalLinkAnnotation.static.normalizeTitle( target )
		}
	} );
};

/**
 * Gets an external link annotation.
 *
 * @method
 * @param {string} target Web address
 * @returns {ve.dm.MWExternalLinkAnnotation}
 */
ve.ui.MWLinkTargetInputWidget.prototype.getExternalLinkAnnotationFromUrl = function ( target ) {
	return new ve.dm.MWExternalLinkAnnotation( {
		'type': 'link/mwExternal',
		'attributes': {
			'href': target
		}
	} );
};

/**
 * Gets a target from an annotation.
 *
 * @method
 * @param {ve.dm.MWExternalLinkAnnotation|ve.dm.MWInternalLinkAnnotation} annotation Annotation
 * @returns {string} Target
 */
ve.ui.MWLinkTargetInputWidget.prototype.getTargetFromAnnotation = function ( annotation ) {
	if ( annotation instanceof ve.dm.MWExternalLinkAnnotation ) {
		return annotation.getAttribute( 'href' );
	} else if ( annotation instanceof ve.dm.MWInternalLinkAnnotation ) {
		return annotation.getAttribute( 'title' );
	}
	return '';
};
