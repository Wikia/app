/*!
 * VisualEditor UserInterface MWCategoryPopupWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
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
ve.ui.MWCategoryPopupWidget = function VeUiMWCategoryPopupWidget ( config ) {
	// Configuration initialization
	config = ve.extendObject( { 'autoClose': true }, config );

	// Parent constructor
	OO.ui.PopupWidget.call( this, config );

	// Properties
	this.category = null;
	this.origSortkey = null;
	this.removed = false;
	this.$title = this.$( '<label>' );
	this.$menu = this.$( '<div>' );
	this.removeButton = new OO.ui.IconButtonWidget( {
		'$': this.$, 'icon': 'remove', 'title': ve.msg( 'visualeditor-inspector-remove-tooltip' )
	} );
	this.sortKeyInput = new OO.ui.TextInputWidget( { '$': this.$ } );
	this.sortKeyLabel = new OO.ui.InputLabelWidget(
		{ '$': this.$, '$input': this.sortKeyInput, 'label': ve.msg ( 'visualeditor-dialog-meta-categories-sortkey-label' ) }
	);
	this.$sortKeyForm = this.$( '<form>' ).addClass( 've-ui-mwCategoryPopupWidget-sortKeyForm' )
		.append( this.sortKeyLabel.$element, this.sortKeyInput.$element );

	// Events
	this.connect( this, { 'hide': 'onHide' } );
	this.removeButton.connect( this, { 'click': 'onRemoveCategory' } );
	this.$sortKeyForm.on( 'submit', ve.bind( this.onSortKeySubmit, this ) );

	// Initialization
	this.$element.addClass( 've-ui-mwCategoryPopupWidget' ).hide();
	this.$title
		.addClass( 've-ui-mwCategoryPopupWidget-title oo-ui-icon-tag' )
		.text( ve.msg( 'visualeditor-dialog-meta-categories-category' ) );
	this.$menu
		.addClass( 've-ui-mwCategoryPopupWidget-content' )
		.append(
			this.$title,
			this.removeButton.$element.addClass( 've-ui-mwCategoryPopupWidget-removeButton' ),
			this.$sortKeyForm
		);
	this.$body.append( this.$menu );
	config.$overlay.append( this.$element );
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
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'dialog-page-settings-button-remove-category'
	} );
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
	ve.track( 'wikia', {
		'action': ve.track.actions.SUBMIT,
		'label': 'dialog-page-settings-change-sortkey'
	} );
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
	this.show();
	this.popupOpen = true;
	this.category = item.value;
	this.loadCategoryIntoPopup( item );
	this.setPopup( item );
};

/**
 * Handle popup hide events.
 *
 * @method
 */
ve.ui.MWCategoryPopupWidget.prototype.onHide = function() {
	var newSortkey = this.sortKeyInput.$input.val();
	if ( !this.removed && newSortkey !== this.origSortkey ) {
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
	this.sortKeyInput.$input.val( item.sortKey );
};

/**
 * Close the popup.
 *
 * @method
 */
ve.ui.MWCategoryPopupWidget.prototype.closePopup = function () {
	this.hide();
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
	var left = item.$arrow.offset().left + ( item.$arrow.width() / 2 ),
		top = item.$arrow.offset().top + item.$arrow.height(),
		width = this.$menu.outerWidth( true ),
		height = this.$menu.outerHeight( true );

	// Flip for RTL:
	if ( this.$container.attr( 'dir' ) === 'rtl' ) {
		// flip me, I'm a mirror:
		this.$element.css( {
			'right': this.$container.outerWidth( true ) - left,
			'top': top
		} );
	} else {
		this.$element.css( { 'left': left, 'top': top } );
	}

	this.display( width, height );
};
