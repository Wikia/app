/*!
 * VisualEditor UserInterface Tool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface tool.
 *
 * @class
 * @abstract
 * @extends ve.ui.Widget
 * @mixins ve.ui.IconedElement
 * @mixins ve.ui.LabeledElement
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.Tool = function VeUiTool( toolbar, config ) {
	var titleMessage = this.constructor.static.titleMessage;

	// Parent constructor
	ve.ui.Widget.call( this, config );

	// Mixin constructors
	ve.ui.IconedElement.call( this, this.$$( '<span>' ) );
	ve.ui.LabeledElement.call( this, this.$$( '<span>' ) );

	// Properties
	this.toolbar = toolbar;
	this.active = false;

	// Events
	this.toolbar.connect( this, { 'updateState': 'onUpdateState' } );

	// Initialization
	this.$
		.data( 've-ui-tool', this )
		.addClass(
			've-ui-tool ve-ui-tool-' +
			this.constructor.static.name.replace( /^([^\/]+)\/([^\/]+).*$/, '$1-$2' )
		)
		.append( this.$icon, this.$label );
	this.setLabel( titleMessage ? ve.msg( titleMessage ) : '' );
	this.setIcon( this.constructor.static.icon );
};

/* Inheritance */

ve.inheritClass( ve.ui.Tool, ve.ui.Widget );

ve.mixinClass( ve.ui.Tool, ve.ui.IconedElement );
ve.mixinClass( ve.ui.Tool, ve.ui.LabeledElement );

/* Events */

/**
 * @event select
 */

/* Static Properties */

ve.ui.Tool.static.tagName = 'a';

/**
 * Symbolic name of tool.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.Tool.static.name = '';

/**
 * Tool group.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.Tool.static.group = '';

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
ve.ui.Tool.static.icon = '';

/**
 * Message key for tool title.
 *
 * Title is used as a tooltip when the tool is part of a bar tool group, or a label when the tool
 * is part of a list or menu tool group. If a trigger is associated with an action by the same name
 * as the tool, a description of its keyboard shortcut for the appropriate platform will be
 * appended to the title if the tool is part of a bar tool group.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.Tool.static.titleMessage = '';

/**
 * Tool can be automatically added to toolgroups.
 *
 * @static
 * @property {boolean}
 * @inheritable
 */
ve.ui.Tool.static.autoAdd = true;

/**
 * Check if this tool can be used on a model.
 *
 * @method
 * @static
 * @inheritable
 * @param {ve.dm.Model} model Model to check
 * @returns {boolean} Tool can be used to edit model
 */
ve.ui.Tool.static.canEditModel = function () {
	return false;
};

/* Methods */

/**
 * Handle the toolbar state being updated.
 *
 * This is an abstract method that must be overridden in a concrete subclass.
 *
 * @abstract
 * @method
 */
ve.ui.Tool.prototype.onUpdateState = function () {
	throw new Error(
		've.ui.Tool.onUpdateState not implemented in this subclass:' + this.constructor
	);
};

/**
 * Handle the tool being selected.
 *
 * This is an abstract method that must be overridden in a concrete subclass.
 *
 * @abstract
 * @method
 */
ve.ui.Tool.prototype.onSelect = function () {
	throw new Error(
		've.ui.Tool.onSelect not implemented in this subclass:' + this.constructor
	);
};

/**
 * Check if the button is active.
 *
 * @method
 * @param {boolean} Button is active
 */
ve.ui.Tool.prototype.isActive = function () {
	return this.active;
};

/**
 * Make the button appear active or inactive.
 *
 * @method
 * @param {boolean} state Make button appear active
 */
ve.ui.Tool.prototype.setActive = function ( state ) {
	this.active = !!state;
	if ( this.active ) {
		this.$.addClass( 've-ui-tool-active' );
	} else {
		this.$.removeClass( 've-ui-tool-active' );
	}
};

/**
 * Sets the tool title attribute in the DOM.
 *
 * @method
 * @param {string} [title] Title text, omit to remove title
 * @chainable
 */
ve.ui.Tool.prototype.setTitle = function ( title ) {
	if ( typeof title === 'string' && title.length ) {
		this.$.attr( 'title', title );
	} else {
		this.$.removeAttr( 'title' );
	}
	return this;
};

/**
 * Destroy tool.
 *
 * @method
 */
ve.ui.Tool.prototype.destroy = function () {
	this.toolbar.disconnect( this );
	this.$.remove();
};
