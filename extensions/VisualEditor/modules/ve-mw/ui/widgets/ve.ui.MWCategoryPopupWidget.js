/*!
 * VisualEditor UserInterface MWCategoryPopupWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWCategoryPopupWidget object.
 *
 * @class
 * @extends OO.ui.PopupWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWCategoryPopupWidget = function VeUiMWCategoryPopupWidget( config ) {
	// Configuration initialization
	config = ve.extendObject( { autoClose: true }, config );

	// Parent constructor
	OO.ui.PopupWidget.call( this, config );

	// Properties
	this.category = null;
	this.origSortkey = null;
	this.removed = false;
	this.$title = this.$( '<label>' );
	this.$menu = this.$( '<div>' );
	this.removeButton = new OO.ui.ButtonWidget( {
		$: this.$,
		framed: false,
		icon: 'remove',
		title: ve.msg( 'visualeditor-inspector-remove-tooltip' )
	} );
	this.sortKeyInput = new OO.ui.TextInputWidget( { $: this.$ } );
	this.sortKeyField = new OO.ui.FieldLayout( this.sortKeyInput, {
		$: this.$,
		align: 'top',
		label: ve.msg ( 'visualeditor-dialog-meta-categories-sortkey-label' )
	} );
	this.$sortKeyForm = this.$( '<form>' ).addClass( 've-ui-mwCategoryPopupWidget-sortKeyForm' )
		.append( this.sortKeyField.$element );

	// Events
	this.connect( this, { toggle: 'onToggle' } );
	this.removeButton.connect( this, { click: 'onRemoveCategory' } );
	this.$sortKeyForm.on( 'submit', this.onSortKeySubmit.bind( this ) );

	// Initialization
	this.$element.addClass( 've-ui-mwCategoryPopupWidget' ).hide();
	this.$title
		.addClass( 've-ui-mwCategoryPopupWidget-title oo-ui-icon-tag' )
		.text( ve.msg( 'visualeditor-dialog-meta-categories-category' ) );
	this.$hiddenStatus = this.$( '<div>' );
	this.$menu
		.addClass( 've-ui-mwCategoryPopupWidget-content' )
		.append(
			this.$title,
			this.$hiddenStatus,
			this.removeButton.$element.addClass( 've-ui-mwCategoryPopupWidget-removeButton' ),
			this.$sortKeyForm
		);
	this.$body.append( this.$menu );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCategoryPopupWidget, OO.ui.PopupWidget );

/* Events */

/**
 * @event removeCategory
 * @param {string} category Category name
 */

/**
 * @event updateSortkey
 * @param {string} category Category name
 * @param {string} sortkey New sortkey
 */

/* Methods */

/**
 * Handle category remove events.
 *
 * @method
 * @fires removeCategory
 */
ve.ui.MWCategoryPopupWidget.prototype.onRemoveCategory = function () {
	this.removed = true;
	this.emit( 'removeCategory', this.category );
	this.closePopup();
};

/**
 * Handle sort key form submit events.
 *
 * @method
 * @param {jQuery.Event} e Form submit event
 * @fires updateSortkey
 */
ve.ui.MWCategoryPopupWidget.prototype.onSortKeySubmit = function () {
	this.closePopup();
	return false;
};

/**
 * Open a category item popup.
 *
 * @method
 * @param {ve.ui.MWCategoryItemWidget} item Category item
 */
ve.ui.MWCategoryPopupWidget.prototype.openPopup = function ( item ) {
	this.toggle( true );
	this.popupOpen = true;
	this.category = item.value;
	this.loadCategoryIntoPopup( item );
	this.setPopup( item );
};

/**
 * Handle popup toggle events.
 *
 * @param {boolean} show Widget is being made visible
 * @method
 */
ve.ui.MWCategoryPopupWidget.prototype.onToggle = function ( show ) {
	if ( show ) {
		return;
	}
	var newSortkey = this.sortKeyInput.$input.val();
	if ( !this.removed && newSortkey !== ( this.origSortkey || '' ) ) {
		this.emit( 'updateSortkey', this.category, this.sortKeyInput.$input.val() );
	}
};

/**
 * Load item information into the popup.
 *
 * @method
 * @param {ve.ui.MWCategoryItemWidget} item Category item
 */
ve.ui.MWCategoryPopupWidget.prototype.loadCategoryIntoPopup = function ( item ) {
	this.origSortkey = item.sortkey;
	if ( item.isHidden ) {
		this.$hiddenStatus.text( ve.msg( 'visualeditor-dialog-meta-categories-hidden' ) );
	} else if ( item.isMissing ) {
		this.$hiddenStatus.text( ve.msg( 'visualeditor-dialog-meta-categories-missing' ) );
	} else {
		this.$hiddenStatus.empty();
	}
	this.sortKeyInput.$input.val( item.sortKey );
};

/**
 * Close the popup.
 *
 * @method
 */
ve.ui.MWCategoryPopupWidget.prototype.closePopup = function () {
	this.toggle( false );
	this.popupOpen = false;
};

/**
 * Set the default sort key.
 *
 * @method
 * @param {string} value Default sort key value
 */
ve.ui.MWCategoryPopupWidget.prototype.setDefaultSortKey = function ( value ) {
	this.sortKeyInput.$input.attr( 'placeholder', value );
};

/**
 * Display the popup next to an item.
 *
 * @method
 * @param {ve.ui.MWCategoryItemWidget} item Category item
 */
ve.ui.MWCategoryPopupWidget.prototype.setPopup = function ( item ) {
	var pos = OO.ui.Element.static.getRelativePosition( item.$indicator, this.$element.offsetParent() );
	// Align to the middle of the indicator
	pos.left += item.$indicator.width() / 2;
	// Position below the indicator
	pos.top += item.$indicator.height();

	this.$element.css( pos );
	this.setSize( this.$menu.outerWidth( true ), this.$menu.outerHeight( true ) );
};
