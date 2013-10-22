/*!
 * VisualEditor user interface MWMetaDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw*/

/**
 * Dialog for editing MediaWiki page meta information.
 *
 * @class
 * @extends ve.ui.MWDialog
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMetaDialog = function VeUiMWMetaDialog( surface, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, surface, config );

	// Properties
	this.metaList = surface.getModel().metaList;
	this.defaultSortKeyChanged = false;
	this.fallbackDefaultSortKey = mw.config.get( 'wgTitle' );

	// Events
	this.metaList.connect( this, {
		'insert': 'onMetaListInsert',
		'remove': 'onMetaListRemove'
	} );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWMetaDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWMetaDialog.static.name = 'meta';

ve.ui.MWMetaDialog.static.titleMessage = 'visualeditor-dialog-meta-title';

ve.ui.MWMetaDialog.static.icon = 'settings';

/* Methods */

/** */
ve.ui.MWMetaDialog.prototype.initialize = function () {
	var languagePromise;

	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.pagedOutlineLayout = new ve.ui.PagedOutlineLayout( { '$$': this.frame.$$ } );
	this.categoriesFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-meta-categories-data-label' ),
		'icon': 'tag'
	} );
	this.categoryOptionsFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-meta-categories-options' ),
		'icon': 'settings'
	} );
	this.categoryWidget = new ve.ui.MWCategoryWidget( {
		'$$': this.frame.$$, '$overlay': this.$overlay
	} );
	this.defaultSortInput = new ve.ui.TextInputWidget( {
		'$$': this.frame.$$, 'placeholder': this.fallbackDefaultSortKey
	} );
	this.defaultSortLabel = new ve.ui.InputLabelWidget( {
		'$$': this.frame.$$,
		'input': this.defaultSortInput,
		'label': ve.msg( 'visualeditor-dialog-meta-categories-defaultsort-label' )
	} );
	this.languagesFieldset = new ve.ui.FieldsetLayout( {
		'$$': this.frame.$$,
		'label': ve.msg( 'visualeditor-dialog-meta-languages-label' ),
		'icon': 'language'
	} );
	this.applyButton = new ve.ui.ButtonWidget( {
		'$$': this.$$, 'label': ve.msg( 'visualeditor-dialog-action-apply' ), 'flags': ['primary']
	} );

	// Events
	this.categoryWidget.connect( this, {
		'newCategory': 'onNewCategory',
		'updateSortkey': 'onUpdateSortKey'
	} );
	this.defaultSortInput.connect( this, {
		'change': 'onDefaultSortChange'
	} );
	this.applyButton.connect( this, { 'click': [ 'close', 'apply' ] } );

	// Initialization
	this.categoryWidget.addItems( this.getCategoryItems() );

	this.$body.append( this.pagedOutlineLayout.$ );
	this.$foot.append( this.applyButton.$ );

	this.pagedOutlineLayout.addPage( 'categories', {
		'$content': [ this.categoriesFieldset.$, this.categoryOptionsFieldset.$ ],
		'label': ve.msg( 'visualeditor-dialog-meta-categories-section' ),
		'icon': 'tag'
	} ).addPage( 'languages', {
		'$content': this.languagesFieldset.$,
		'label': ve.msg( 'visualeditor-dialog-meta-languages-section' ),
		'icon': 'language'
	} );

	this.categoriesFieldset.$.append( this.categoryWidget.$ );
	this.categoryOptionsFieldset.$.append( this.defaultSortLabel.$, this.defaultSortInput.$ );
	this.languagesFieldset.$.append(
		this.frame.$$( '<span>' )
			.text( ve.msg( 'visualeditor-dialog-meta-languages-readonlynote' ) )
	);

	languagePromise = this.getAllLanguageItems();
	languagePromise.done( ve.bind( function ( languages ) {
		var i, $languagesTable = this.frame.$$( '<table>' ), languageslength = languages.length;

		$languagesTable
			.addClass( 've-ui-mwMetaDialog-languages-table' )
			.append( this.frame.$$( '<tr>' )
				.append(
					this.frame.$$( '<th>' )
						.append( ve.msg( 'visualeditor-dialog-meta-languages-code-label' ) )
				)
				.append(
					this.frame.$$( '<th>' )
						.append( ve.msg( 'visualeditor-dialog-meta-languages-link-label' ) )
				)
			);

		for ( i = 0; i < languageslength; i++ ) {
			languages[i].safelang = languages[i].lang;
			languages[i].dir = 'auto';
			if ( $.uls ) {
				// site codes don't always represent official language codes
				// using real language code instead of a dummy ('redirect' in ULS' terminology)
				languages[i].safelang = $.uls.data.isRedirect( languages[i].lang ) || languages[i].lang;
				languages[i].dir = $.uls.data.getDir( languages[i].safelang );
			}
			$languagesTable
				.append( this.frame.$$( '<tr>' )
					.append( this.frame.$$( '<td>' ).append( languages[i].lang ) )
					.append( this.frame.$$( '<td>' ).append( languages[i].title )
						.attr( 'lang', languages[i].safelang )
						.attr( 'dir', languages[i].dir ) )
				);
		}

		this.languagesFieldset.$.append( $languagesTable );
	}, this ) );
};

/** */
ve.ui.MWMetaDialog.prototype.onOpen = function () {
	var surfaceModel = this.surface.getModel(),
		categoryWidget = this.categoryWidget,
		defaultSortKeyItem = this.getDefaultSortKeyItem();

	// Parent method
	ve.ui.MWDialog.prototype.onOpen.call( this );

	this.defaultSortInput.setValue(
		defaultSortKeyItem ? defaultSortKeyItem.getAttribute( 'content' ) : ''
	);
	this.defaultSortKeyChanged = false;

	// Force all previous transactions to be separate from this history state
	surfaceModel.breakpoint();
	surfaceModel.stopHistoryTracking();

	// Update input position once visible
	setTimeout( function () {
		categoryWidget.fitInput();
	} );
};

/** */
ve.ui.MWMetaDialog.prototype.onClose = function ( action ) {
	var hasTransactions, newDefaultSortKeyItem, newDefaultSortKeyItemData,
		surfaceModel = this.surface.getModel(),
		currentDefaultSortKeyItem = this.getDefaultSortKeyItem();

	// Parent method
	ve.ui.MWDialog.prototype.onClose.call( this );

	// Place transactions made while dialog was open in a common history state
	hasTransactions = surfaceModel.breakpoint();

	// Undo everything done in the dialog and prevent redoing those changes
	if ( action === 'cancel' && hasTransactions ) {
		surfaceModel.undo();
		surfaceModel.truncateUndoStack();
	}

	if ( this.defaultSortKeyChanged ) {
		if ( this.defaultSortInput.getValue() !== '' ) {
			newDefaultSortKeyItemData = {
				'type': 'mwDefaultSort',
				'attributes': { 'content': this.defaultSortInput.getValue() }
			};
			if ( currentDefaultSortKeyItem ) {
				newDefaultSortKeyItem = new ve.dm.MWDefaultSortMetaItem(
					ve.extendObject( {}, currentDefaultSortKeyItem.getElement(), newDefaultSortKeyItemData )
				);
				currentDefaultSortKeyItem.replaceWith( newDefaultSortKeyItem );
			} else {
				newDefaultSortKeyItem = new ve.dm.MWDefaultSortMetaItem( newDefaultSortKeyItemData );
				this.metaList.insertMeta( newDefaultSortKeyItem );
			}
		} else if ( currentDefaultSortKeyItem ) {
			currentDefaultSortKeyItem.remove();
		}
	}

	// Return to normal tracking behavior
	surfaceModel.startHistoryTracking();
};

/**
 * Get default sort key item.
 *
 * @returns {string} Default sort key item
 */
ve.ui.MWMetaDialog.prototype.getDefaultSortKeyItem = function () {
	var items = this.metaList.getItemsInGroup( 'mwDefaultSort' );
	return items.length ? items[0] : null;
};

/**
 * Get array of category items from meta list
 *
 * @method
 * @returns {Object[]} items
 */
ve.ui.MWMetaDialog.prototype.getCategoryItems = function () {
	var i,
		items = [],
		categories = this.metaList.getItemsInGroup( 'mwCategory' );

	// Loop through MwCategories and build out items
	for ( i = 0; i < categories.length; i++ ) {
		items.push( this.getCategoryItemFromMetaListItem( categories[i] ) );
	}
	return items;
};

/**
 * Gets category item from meta list item
 *
 * @method
 * @param {Object} ve.dm.MWCategoryMetaItem
 * @returns {Object} item
 */
ve.ui.MWMetaDialog.prototype.getCategoryItemFromMetaListItem = function ( metaItem ) {
	var title, value = '';
	try {
		title = new mw.Title( metaItem.element.attributes.category );
		value = title.getMainText();
	} catch ( e ) { }
	return {
		'name': metaItem.element.attributes.category,
		'value': value,
		// TODO: sortkey is lcase, make consistent throughout CategoryWidget
		'sortKey': metaItem.element.attributes.sortkey,
		'metaItem': metaItem
	};
};

/**
 * Get metaList like object to insert from item
 *
 * @method
 * @param {Object} item category widget item
 * @param {Object} [oldData] Metadata object that was previously associated with this item, if any
 * @returns {Object} metaBase
 */
ve.ui.MWMetaDialog.prototype.getCategoryItemForInsertion = function ( item, oldData ) {
	var newData = {
		'attributes': { 'category': item.name, 'sortkey': item.sortKey || '' },
		'type': 'mwCategory'
	};
	if ( oldData ) {
		return ve.extendObject( {}, oldData, newData );
	}
	return newData;
};

/**
 * Gets language item from meta list item
 *
 * @method
 * @param {Object} ve.dm.MWLanguageMetaItem
 * @returns {Object} item
 */
ve.ui.MWMetaDialog.prototype.getLanguageItemFromMetaListItem = function ( metaItem ) {
	// TODO: get real values from metaItem once Parsoid actually provides them - bug 48970
	return {
		'lang': 'lang',
		'title': 'title',
		'metaItem': metaItem
	};
};

/**
 * Get array of language items from meta list
 *
 * @method
 * @returns {Object[]} items
 */
ve.ui.MWMetaDialog.prototype.getLocalLanguageItems = function () {
	var i,
		items = [],
		languages = this.metaList.getItemsInGroup( 'mwLanguage' ),
		languageslength = languages.length;

	// Loop through MWLanguages and build out items

	for ( i = 0; i < languageslength; i++ ) {
		items.push( this.getLanguageItemFromMetaListItem( languages[i] ) );
	}
	return items;
};

/**
 * Get array of language items from meta list
 *
 * @method
 * @returns {jQuery.Promise}
 */
ve.ui.MWMetaDialog.prototype.getAllLanguageItems = function () {
	var deferred = $.Deferred();
	// TODO: Detect paging token if results exceed limit
	$.ajax( {
		'url': mw.util.wikiScript( 'api' ),
		'data': {
			'action': 'query',
			'prop': 'langlinks',
			'lllimit': 500,
			'titles': mw.config.get( 'wgTitle' ),
			'indexpageids': 1,
			'format': 'json'
		},
		'dataType': 'json',
		'type': 'POST',
		// Wait up to 100 seconds before giving up
		'timeout': 100000,
		'cache': 'false',
		'success': ve.bind( this.onAllLanuageItemsSuccess, this, deferred ),
		'error': ve.bind( this.onAllLanuageItemsError, this, deferred )
	} );
	return deferred.promise();
};

/** */
ve.ui.MWMetaDialog.prototype.onAllLanuageItemsSuccess = function ( deferred, response ) {
	var i, iLen, languages = [], langlinks = response.query.pages[response.query.pageids[0]].langlinks;
	if ( langlinks ) {
		for ( i = 0, iLen = langlinks.length; i < iLen; i++ ) {
			languages.push( {
				'lang': langlinks[i].lang,
				'title': langlinks[i]['*'],
				'metaItem': null
			} );
		}
	}
	deferred.resolve( languages );
};

// TODO: This error function should probably not be empty.
ve.ui.MWMetaDialog.prototype.onAllLanuageItemsError = function () {};

/**
 * Handle category default sort change events.
 *
 * @param {string} value Default sort value
 */
ve.ui.MWMetaDialog.prototype.onDefaultSortChange = function ( value ) {
	this.categoryWidget.setDefaultSortKey( value === '' ? this.fallbackDefaultSortKey : value );
	this.defaultSortKeyChanged = true;
};

/**
 * Inserts new category into meta list
 *
 * @method
 * @param {Object} item
 */
ve.ui.MWMetaDialog.prototype.onNewCategory = function ( item ) {
	// Insert new metaList item
	this.insertMetaListItem( this.getCategoryItemForInsertion( item ) );
};

/**
 * Removes and re-inserts updated category widget item
 *
 * @method
 * @param {Object} item
 */
ve.ui.MWMetaDialog.prototype.onUpdateSortKey = function ( item ) {
	// Replace meta item with updated one
	item.metaItem.replaceWith( this.getCategoryItemForInsertion( item, item.metaItem.getElement() ) );
};

/**
 * Bound to MetaList insert event for adding meta dialog components.
 *
 * @method
 * @param {Object} ve.dm.MetaItem
 */
ve.ui.MWMetaDialog.prototype.onMetaListInsert = function ( metaItem ) {
	// Responsible for adding UI components
	if ( metaItem.element.type === 'mwCategory' ) {
		this.categoryWidget.addItems(
			[ this.getCategoryItemFromMetaListItem( metaItem ) ],
			this.metaList.findItem( metaItem.getOffset(), metaItem.getIndex(), 'mwCategory' )
		);
	}
};

/**
 * Bound to MetaList insert event for removing meta dialog components.
 *
 * @method
 * @param {Object} ve.dm.MetaItem
 */
ve.ui.MWMetaDialog.prototype.onMetaListRemove = function ( metaItem ) {
	var item;

	if ( metaItem.element.type === 'mwCategory' ) {
		item = this.getCategoryItemFromMetaListItem( metaItem );
		this.categoryWidget.removeItems( [item.value] );
	}
};

/**
 * Inserts a meta list item
 *
 * @param {Object} metaBase meta list insert object
 */
ve.ui.MWMetaDialog.prototype.insertMetaListItem = function ( metaBase ) {
	this.metaList.insertMeta( metaBase );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWMetaDialog );
