/*!
 * VisualEditor UserInterface MWCategoryItemWidget class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWCategoryItemWidget object.
 *
 * @class
 * @abstract
 * @extends OO.ui.ButtonWidget
 * @mixins OO.ui.mixin.DraggableElement
 *
 * @constructor
 * @param {Object} [config] Configuration options
 * @cfg {Object} [item] Category item
 * @cfg {boolean} [hidden] Whether the category is hidden or not
 * @cfg {boolean} [missing] Whether the category's description page is missing
 * @cfg {string} [redirectTo] The name of the category this category's page redirects to.
 */
ve.ui.MWCategoryItemWidget = function VeUiMWCategoryItemWidget( config ) {
	// Config initialization
	config = ve.extendObject( { indicator: 'down' }, config );

	// Parent constructor
	OO.ui.ButtonWidget.call( this, config );

	// Mixin constructors
	OO.ui.mixin.DraggableElement.call( this, config );

	// Properties
	this.name = config.item.name;
	this.value = config.item.value;
	this.sortKey = config.item.sortKey || '';
	this.metaItem = config.item.metaItem;
	this.isHidden = config.hidden;
	this.isMissing = config.missing;

	// Events
	this.$button.on( {
		mousedown: this.onMouseDown.bind( this )
	} );

	// Initialization
	this.setLabel( config.redirectTo || this.value );
	if ( config.redirectTo ) {
		ve.init.platform.linkCache.styleElement( mw.Title.newFromText(
			config.redirectTo,
			mw.config.get( 'wgNamespaceIds' ).category
		).getPrefixedText(), this.$label );
	} else {
		ve.init.platform.linkCache.styleElement( this.name, this.$label );
	}

	this.$element.addClass( 've-ui-mwCategoryItemWidget' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWCategoryItemWidget, OO.ui.ButtonWidget );

OO.mixinClass( ve.ui.MWCategoryItemWidget, OO.ui.mixin.DraggableElement );

/* Events */

/**
 * @event savePopupState
 */

/**
 * @event togglePopupMenu
 * @param {ve.ui.MWCategoryItemWidget} item Item to load into popup
 */

/* Methods */

/**
 * Handle mouse down events.
 *
 * @method
 * @param {jQuery.Event} e Mouse down event
 * @fires savePopupState on mousedown.
 */
ve.ui.MWCategoryItemWidget.prototype.onMouseDown = function () {
	this.emit( 'savePopupState' );

	// Parent method
	return ve.ui.MWCategoryItemWidget.super.prototype.onMouseDown.apply( this, arguments );
};

/**
 * Handle mouse click events.
 *
 * @method
 * @param {jQuery.Event} e Mouse click event
 * @fires togglePopupMenu on mousedown.
 */
ve.ui.MWCategoryItemWidget.prototype.onClick = function () {
	this.emit( 'togglePopupMenu', this );

	// Parent method
	return ve.ui.MWCategoryItemWidget.super.prototype.onClick.apply( this, arguments );
};
