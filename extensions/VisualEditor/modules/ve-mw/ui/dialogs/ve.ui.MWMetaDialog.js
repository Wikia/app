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
 * @param {ve.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMetaDialog = function VeUiMWMetaDialog( windowSet, config ) {
	// Parent constructor
	ve.ui.MWDialog.call( this, windowSet, config );

	// Properties
	this.metaList = this.surface.getModel().metaList;
	this.defaultSortKeyTouched = false;
	this.fallbackDefaultSortKey = mw.config.get( 'wgTitle' );

	// Events
	this.metaList.connect( this, {
		'insert': 'onMetaListInsert',
		'remove': 'onMetaListRemove'
	} );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMetaDialog, ve.ui.MWDialog );

/* Static Properties */

ve.ui.MWMetaDialog.static.name = 'meta';

ve.ui.MWMetaDialog.static.titleMessage = 'visualeditor-dialog-meta-title';

ve.ui.MWMetaDialog.static.icon = 'settings';

/* Methods */

/**
 * Handle language items being loaded.
 */
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

/**
 * Handle language items failing to be loaded.
 *
 * TODO: This error function should probably not be empty.
 */
ve.ui.MWMetaDialog.prototype.onAllLanuageItemsError = function () {};

/**
 * Handle category default sort change events.
 *
 * @param {string} value Default sort value
 */
ve.ui.MWMetaDialog.prototype.onDefaultSortChange = function ( value ) {
	this.categoryWidget.setDefaultSortKey( value === '' ? this.fallbackDefaultSortKey : value );
	this.defaultSortKeyTouched = true;
};

/**
 * Inserts new category into meta list
 *
 * @param {Object} item
 */
ve.ui.MWMetaDialog.prototype.onNewCategory = function ( item ) {
	// Insert new metaList item
	this.insertMetaListItem( this.getCategoryItemForInsertion( item ) );
};

/**
 * Removes and re-inserts updated category widget item
 *
 * @param {Object} item
 */
ve.ui.MWMetaDialog.prototype.onUpdateSortKey = function ( item ) {
	// Replace meta item with updated one
	item.metaItem.replaceWith( this.getCategoryItemForInsertion( item, item.metaItem.getElement() ) );
};

/**
 * Bound to MetaList insert event for adding meta dialog components.
 *
 * @param {ve.dm.MetaItem} metaItem
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
 * @param {ve.dm.MetaItem} metaItem
 */
ve.ui.MWMetaDialog.prototype.onMetaListRemove = function ( metaItem ) {
	var item;

	if ( metaItem.element.type === 'mwCategory' ) {
		item = this.getCategoryItemFromMetaListItem( metaItem );
		this.categoryWidget.removeItems( [item.value] );
	}
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
 * @param {ve.dm.MWCategoryMetaItem} metaItem
 * @returns {Object} item
 */
ve.ui.MWMetaDialog.prototype.getCategoryItemFromMetaListItem = function ( metaItem ) {
	var title = mw.Title.newFromText( metaItem.element.attributes.category ),
		value = title ? title.getMainText() : '';

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
 * @param {ve.dm.MWLanguageMetaItem} metaItem
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
		'cache': 'false'
	} )
		.done( ve.bind( this.onAllLanuageItemsSuccess, this, deferred ) )
		.fail( ve.bind( this.onAllLanuageItemsError, this, deferred ) );
	return deferred.promise();
};

/**
 * Inserts a meta list item
 *
 * @param {Object} metaBase meta list insert object
 */
ve.ui.MWMetaDialog.prototype.insertMetaListItem = function ( metaBase ) {
	this.metaList.insertMeta( metaBase );
};

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.initialize = function () {
	var languagePromise;

	// Parent method
	ve.ui.MWDialog.prototype.initialize.call( this );

	// Properties
	this.pagedOutlineLayout = new OO.ui.PagedOutlineLayout( { '$': this.$ } );
	this.categoriesFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-meta-categories-data-label' ),
		'icon': 'tag'
	} );
	this.categoryOptionsFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-meta-categories-options' ),
		'icon': 'settings'
	} );
	this.categoryWidget = new ve.ui.MWCategoryWidget( {
		'$': this.$, '$overlay': this.$overlay
	} );
	this.defaultSortInput = new OO.ui.TextInputWidget( {
		'$': this.$, 'placeholder': this.fallbackDefaultSortKey
	} );
	this.defaultSortLabel = new OO.ui.InputLabelWidget( {
		'$': this.$,
		'input': this.defaultSortInput,
		'label': ve.msg( 'visualeditor-dialog-meta-categories-defaultsort-label' )
	} );
	this.languagesFieldset = new OO.ui.FieldsetLayout( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-meta-languages-label' ),
		'icon': 'language'
	} );
	this.applyButton = new OO.ui.PushButtonWidget( {
		'$': this.$,
		'label': ve.msg( 'visualeditor-dialog-action-apply' ),
		'flags': ['primary']
	} );

	// Events
	this.categoryWidget.connect( this, {
		'newCategory': 'onNewCategory',
		'updateSortkey': 'onUpdateSortKey'
	} );
	this.defaultSortInput.connect( this, {
		'change': 'onDefaultSortChange'
	} );
	this.applyButton.connect( this, { 'click': [ 'close', { 'action': 'apply' } ] } );

	// Initialization
	this.categoryWidget.addItems( this.getCategoryItems() );

	this.$body.append( this.pagedOutlineLayout.$element );
	this.$foot.append( this.applyButton.$element );

	this.pagedOutlineLayout.addPage( 'categories', {
		'$content': [ this.categoriesFieldset.$element, this.categoryOptionsFieldset.$element ],
		'label': ve.msg( 'visualeditor-dialog-meta-categories-section' ),
		'icon': 'tag'
	} ).addPage( 'languages', {
		'$content': this.languagesFieldset.$element,
		'label': ve.msg( 'visualeditor-dialog-meta-languages-section' ),
		'icon': 'language'
	} );

	this.categoriesFieldset.$element.append( this.categoryWidget.$element );
	this.categoryOptionsFieldset.$element.append(
		this.defaultSortLabel.$element,
		this.defaultSortInput.$element
	);
	this.languagesFieldset.$element.append(
		this.$( '<span>' )
			.text( ve.msg( 'visualeditor-dialog-meta-languages-readonlynote' ) )
	);

	languagePromise = this.getAllLanguageItems();
	languagePromise.done( ve.bind( function ( languages ) {
		var i, $languagesTable = this.$( '<table>' ), languageslength = languages.length;

		$languagesTable
			.addClass( 've-ui-mwMetaDialog-languages-table' )
			.append( this.$( '<tr>' )
				.append(
					this.$( '<th>' )
						.append( ve.msg( 'visualeditor-dialog-meta-languages-code-label' ) )
				)
				.append(
					this.$( '<th>' )
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
				.append( this.$( '<tr>' )
					.append( this.$( '<td>' ).append( languages[i].lang ) )
					.append( this.$( '<td>' ).append( languages[i].title )
						.attr( 'lang', languages[i].safelang )
						.attr( 'dir', languages[i].dir ) )
				);
		}

		this.languagesFieldset.$element.append( $languagesTable );
	}, this ) );
};

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.MWDialog.prototype.setup.call( this, data );

	// Data initialization
	data = data || {};

	var surfaceModel = this.surface.getModel(),
		categoryWidget = this.categoryWidget,
		defaultSortKeyItem = this.getDefaultSortKeyItem();

	if ( data.page && this.pagedOutlineLayout.getPage( data.page ) ) {
		this.pagedOutlineLayout.setPage( data.page );
	}

	this.defaultSortInput.setValue(
		defaultSortKeyItem ? defaultSortKeyItem.getAttribute( 'content' ) : ''
	);
	this.defaultSortKeyTouched = false;

	// Force all previous transactions to be separate from this history state
	surfaceModel.breakpoint();
	surfaceModel.stopHistoryTracking();

	// Update input position once visible
	setTimeout( function () {
		categoryWidget.fitInput();
	} );
};

/**
 * @inheritdoc
 */
ve.ui.MWMetaDialog.prototype.teardown = function ( data ) {
	// Data initialization
	data = data || {};

	var hasTransactions,
		surfaceModel = this.surface.getModel(),

		// Category sort key items
		currentDefaultSortKeyItem = this.getDefaultSortKeyItem(),
		newDefaultSortKey = this.defaultSortInput.getValue(),
		newDefaultSortKeyData = {
			'type': 'mwDefaultSort',
			'attributes': { 'content': newDefaultSortKey }
		};

	// Place transactions made while dialog was open in a common history state
	hasTransactions = surfaceModel.breakpoint();

	// Undo everything done in the dialog and prevent redoing those changes
	if ( data.action === 'cancel' && hasTransactions ) {
		surfaceModel.undo();
		surfaceModel.truncateUndoStack();
	}

	// Alter the default sort key iff it's been touched & is actually different
	if ( this.defaultSortKeyTouched ) {
		if ( newDefaultSortKey === '' ) {
			if ( currentDefaultSortKeyItem ) {
				currentDefaultSortKeyItem.remove();
			}
		} else {
			if ( !currentDefaultSortKeyItem ) {
				this.metaList.insertMeta( newDefaultSortKeyData );
			} else if ( currentDefaultSortKeyItem.getValue() !== newDefaultSortKey ) {
				currentDefaultSortKeyItem.replaceWith(
					ve.extendObject( true, {},
						currentDefaultSortKeyItem.getElement(),
						newDefaultSortKeyData
					)
				);
			}
		}
	}

	// Return to normal tracking behavior
	surfaceModel.startHistoryTracking();

	// Parent method
	ve.ui.MWDialog.prototype.teardown.call( this, data );
};

/* Registration */

ve.ui.dialogFactory.register( ve.ui.MWMetaDialog );
