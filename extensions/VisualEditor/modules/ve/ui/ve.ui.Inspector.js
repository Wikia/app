/*!
 * VisualEditor UserInterface Inspector class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface inspector.
 *
 * @class
 * @abstract
 * @extends ve.ui.Window
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.Inspector = function VeUiInspector( surface, config ) {
	// Parent constructor
	ve.ui.Window.call( this, surface, config );

	// Properties
	this.initialSelection = null;

	// Initialization
	this.$.addClass( 've-ui-inspector' );
};

/* Inheritance */

ve.inheritClass( ve.ui.Inspector, ve.ui.Window );

/* Static Properties */

ve.ui.Inspector.static.titleMessage = 've-ui-inspector-title';

/**
 * Symbolic name of dialog.
 *
 * @abstract
 * @static
 * @property {string}
 * @inheritable
 */
ve.ui.Inspector.static.name = '';

/**
 * The inspector comes with a remove button

 * @static
 * @inheritable
 * @property {boolean}
 */
ve.ui.Inspector.static.removeable = true;

/* Methods */

/**
 * Handle frame ready events.
 *
 * @method
 */
ve.ui.Inspector.prototype.initialize = function () {
	// Parent method
	ve.ui.Window.prototype.initialize.call( this );

	// Initialization
	this.frame.$content.addClass( 've-ui-inspector-content' );
	this.$form = this.$$( '<form>' );
	this.closeButton = new ve.ui.IconButtonWidget( {
		'$$': this.$$, 'icon': 'previous', 'title': ve.msg( 'visualeditor-inspector-close-tooltip' )
	} );
	if ( this.constructor.static.removeable ) {
		this.removeButton = new ve.ui.IconButtonWidget( {
			'$$': this.$$, 'icon': 'remove', 'title': ve.msg( 'visualeditor-inspector-remove-tooltip' )
		} );
	}

	// Events
	this.$form.on( {
		'submit': ve.bind( this.onFormSubmit, this ),
		'keydown': ve.bind( this.onFormKeyDown, this )
	} );
	this.closeButton.connect( this, { 'click': 'onCloseButtonClick' } );
	if ( this.constructor.static.removeable ) {
		this.removeButton.connect( this, { 'click': 'onRemoveButtonClick' } );
	}

	// Initialization
	this.closeButton.$.addClass( 've-ui-inspector-closeButton' );
	this.$head.prepend( this.closeButton.$ );
	if ( this.constructor.static.removeable ) {
		this.removeButton.$.addClass( 've-ui-inspector-removeButton' );
		this.$head.append( this.removeButton.$ );
	}
	this.$body.append( this.$form );
};

/**
 * Handle close button click events.
 *
 * @method
 */
ve.ui.Inspector.prototype.onCloseButtonClick = function () {
	this.close( 'back' );
};

/**
 * Handle remove button click events.
 *
 * @method
 */
ve.ui.Inspector.prototype.onRemoveButtonClick = function () {
	this.close( 'remove' );
};

/**
 * Handle form submission events.
 *
 * @method
 * @param {jQuery.Event} e Form submit event
 */
ve.ui.Inspector.prototype.onFormSubmit = function () {
	this.close( 'apply' );
	return false;
};

/**
 * Handle form keydown events.
 *
 * @method
 * @param {jQuery.Event} e Key down event
 */
ve.ui.Inspector.prototype.onFormKeyDown = function ( e ) {
	// Escape
	if ( e.which === ve.Keys.ESCAPE ) {
		this.close( 'back' );
		return false;
	}
};

/**
 * Handle inspector setup events.
 *
 * @method
 */
ve.ui.Inspector.prototype.onSetup = function () {
	this.previousSelection = this.surface.getModel().getSelection();
};

/**
 * Handle inspector open events.
 *
 * @method
 */
ve.ui.Inspector.prototype.onOpen = function () {
	this.initialSelection = this.surface.getModel().getSelection();
};
