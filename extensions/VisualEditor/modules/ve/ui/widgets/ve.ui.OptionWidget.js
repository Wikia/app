/*!
 * VisualEditor UserInterface OptionWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.OptionWidget object.
 *
 * @class
 * @abstract
 * @extends ve.ui.Widget
 * @mixins ve.ui.LabeledElement
 *
 * @constructor
 * @param {Mixed} data Option data
 * @param {Object} [config] Configuration options
 * @cfg {jQuery|string} [label] Option label
 * @cfg {string} [icon] Symbolic name of icon
 * @cfg {boolean} [selected=false] Select option
 * @cfg {boolean} [highlighted=false] Highlight option
 * @cfg {string} [rel] Value for `rel` attribute in DOM, allowing per-option styling
 */
ve.ui.OptionWidget = function VeUiOptionWidget( data, config ) {
	// Config intialization
	config = config || {};

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Mixin constructors
	ve.ui.LabeledElement.call( this, this.$$( '<span>' ), config );

	// Properties
	this.data = data;
	this.selected = false;
	this.highlighted = false;

	// Initialization
	this.$
		.data( 've-ui-optionWidget', this )
		.attr( 'rel', config.rel )
		.addClass( 've-ui-optionWidget' )
		.append( this.$label );
	this.setSelected( config.selected );
	this.setHighlighted( config.highlighted );

	// Options
	if ( config.icon ) {
		this.$icon = this.$$( '<div>' )
			.addClass( 've-ui-optionWidget-icon ve-ui-icon-' + config.icon )
			.appendTo( this.$ );
	}
};

/* Inheritance */

ve.inheritClass( ve.ui.OptionWidget, ve.ui.Widget );

ve.mixinClass( ve.ui.OptionWidget, ve.ui.LabeledElement );

/* Static Properties */

ve.ui.OptionWidget.static.tagName = 'li';

ve.ui.OptionWidget.static.selectable = true;

ve.ui.OptionWidget.static.highlightable = true;

ve.ui.OptionWidget.static.scrollIntoViewOnSelect = false;

/* Methods */

/**
 * Check if option can be selected.
 *
 * @method
 * @returns {boolean} Item is selectable
 */
ve.ui.OptionWidget.prototype.isSelectable = function () {
	return this.constructor.static.selectable && !this.disabled;
};

/**
 * Check if option can be highlighted.
 *
 * @method
 * @returns {boolean} Item is highlightable
 */
ve.ui.OptionWidget.prototype.isHighlightable = function () {
	return this.constructor.static.highlightable && !this.disabled;
};

/**
 * Check if option is selected.
 *
 * @method
 * @returns {boolean} Item is selected
 */
ve.ui.OptionWidget.prototype.isSelected = function () {
	return this.selected;
};

/**
 * Check if option is highlighted.
 *
 * @method
 * @returns {boolean} Item is highlighted
 */
ve.ui.OptionWidget.prototype.isHighlighted = function () {
	return this.highlighted;
};

/**
 * Set selected state.
 *
 * @method
 * @param {boolean} [state=false] Select option
 * @chainable
 */
ve.ui.OptionWidget.prototype.setSelected = function ( state ) {
	if ( !this.disabled && this.constructor.static.selectable ) {
		this.selected = !!state;
		if ( this.selected ) {
			this.$.addClass( 've-ui-optionWidget-selected' );
			if ( this.constructor.static.scrollIntoViewOnSelect ) {
				this.scrollElementIntoView();
			}
		} else {
			this.$.removeClass( 've-ui-optionWidget-selected' );
		}
	}
	return this;
};

/**
 * Set highlighted state.
 *
 * @method
 * @param {boolean} [state=false] Highlight option
 * @chainable
 */
ve.ui.OptionWidget.prototype.setHighlighted = function ( state ) {
	if ( !this.disabled && this.constructor.static.highlightable ) {
		this.highlighted = !!state;
		if ( this.highlighted ) {
			this.$.addClass( 've-ui-optionWidget-highlighted' );
		} else {
			this.$.removeClass( 've-ui-optionWidget-highlighted' );
		}
	}
	return this;
};

/**
 * Make the option's highlight flash.
 *
 * @method
 * @param {Function} [done] Callback to execute when flash effect is complete.
 */
ve.ui.OptionWidget.prototype.flash = function ( done ) {
	var $this = this.$;

	if ( !this.disabled && this.constructor.static.highlightable ) {
		$this.removeClass( 've-ui-optionWidget-highlighted' );
		setTimeout( ve.bind( function () {
			$this.addClass( 've-ui-optionWidget-highlighted' );
			if ( done ) {
				setTimeout( done, 100 );
			}
		}, this ), 100 );
	}
};

/**
 * Get option data.
 *
 * @method
 * @returns {Mixed} Option data
 */
ve.ui.OptionWidget.prototype.getData = function () {
	return this.data;
};
