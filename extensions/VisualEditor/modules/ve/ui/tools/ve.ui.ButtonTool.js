/*!
 * VisualEditor UserInterface ButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface button tool.
 *
 * @class
 * @abstract
 * @extends ve.ui.Tool
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.ButtonTool = function VeUiButtonTool( toolbar, config ) {
	var icon = this.constructor.static.icon,
		lang = ve.init.platform.getUserLanguage();

	// Parent constructor
	ve.ui.Tool.call( this, toolbar, config );

	// Properties
	this.active = false;
	this.$icon = this.$$( '<span>' );

	// Events
	this.$.on( {
		'mousedown': ve.bind( this.onMouseDown, this ),
		'mouseup': ve.bind( this.onMouseUp, this )
	} );

	// Initialization
	this.$icon.addClass( 've-ui-buttonTool-icon' );
	if ( icon ) {
		if ( ve.isPlainObject( icon ) ) {
			icon = lang in icon ? icon[lang] : icon['default'];
		}
		this.$icon.addClass( 've-ui-icon-' + icon );
	}
	this.$.addClass( 've-ui-buttonTool' ).append( this.$icon );
};

/* Inheritance */

ve.inheritClass( ve.ui.ButtonTool, ve.ui.Tool );

/* Static Properties */

/**
 * Symbolic name of icon.
 *
 * Value should be the unique portion of an icon CSS class name, such as 'up' for 've-ui-icon-up'.
 *
 * For i18n purposes, this property can be an object containing a `default` icon name property and
 * additional icon names keyed by language code.
 *
 * Example of i18n icon definition:
 *     { 'default': 'bold-a', 'en': 'bold-b', 'de': 'bold-f' }
 *
 * @abstract
 * @static
 * @property {string|Object}
 * @inheritable
 */
ve.ui.ButtonTool.static.icon = '';

ve.ui.ButtonTool.static.tagName = 'a';

/* Methods */

/**
 * Handle the mouse button being pressed.
 *
 * @method
 * @param {jQuery.Event} e Mouse down event
 */
ve.ui.ButtonTool.prototype.onMouseDown = function ( e ) {
	if ( e.which === 1 ) {
		return false;
	}
};

/**
 * Handle the mouse button being released.
 *
 * @method
 * @param {jQuery.Event} e Mouse up event
 */
ve.ui.ButtonTool.prototype.onMouseUp = function ( e ) {
	if ( e.which === 1 && !this.disabled ) {
		return this.onClick( e );
	}
};

/**
 * Handle the button being clicked.
 *
 * This is an abstract method that must be overridden in a concrete subclass.
 *
 * @abstract
 * @method
 */
ve.ui.ButtonTool.prototype.onClick = function () {
	throw new Error(
		've.ui.ButtonTool.onClick not implemented in this subclass: ' + this.constructor
	);
};

/**
 * Check if the button is active.
 *
 * @method
 * @param {boolean} Button is active
 */
ve.ui.ButtonTool.prototype.isActive = function () {
	return this.active;
};

/**
 * Make the button appear active or inactive.
 *
 * @method
 * @param {boolean} state Make button appear active
 */
ve.ui.ButtonTool.prototype.setActive = function ( state ) {
	this.active = !!state;
	if ( this.active ) {
		this.$.addClass( 've-ui-buttonTool-active' );
	} else {
		this.$.removeClass( 've-ui-buttonTool-active' );
	}
};
