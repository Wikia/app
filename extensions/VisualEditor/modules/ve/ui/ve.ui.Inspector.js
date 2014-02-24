/*!
 * VisualEditor UserInterface Inspector class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Non-modal interface in a child frame.
 *
 * @class
 * @abstract
 * @extends OO.ui.Window
 *
 * @constructor
 * @param {OO.ui.WindowSet} windowSet Window set this dialog is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.Inspector = function VeUiInspector( windowSet, config ) {
	// Parent constructor
	OO.ui.Window.call( this, windowSet, config );

	// Properties
	this.surface = windowSet.getSurface();

	// Initialization
	this.$element.addClass( 've-ui-inspector' );
};

/* Inheritance */

OO.inheritClass( ve.ui.Inspector, OO.ui.Window );

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
 * Handle close button click events.
 *
 * @method
 */
ve.ui.Inspector.prototype.onCloseButtonClick = function () {
	var label = ve.track.nameToLabel( this.constructor.static.name );
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'inspector-' + label + '-button-close'
	} );
	this.close( { 'action': 'back' } );
};

/**
 * Handle remove button click events.
 *
 * @method
 */
ve.ui.Inspector.prototype.onRemoveButtonClick = function () {
	var label = ve.track.nameToLabel( this.constructor.static.name );
	ve.track( 'wikia', {
		'action': ve.track.actions.CLICK,
		'label': 'inspector-' + label + '-button-remove'
	} );
	this.close( { 'action': 'remove' } );
};

/**
 * Handle form submission events.
 *
 * @method
 * @param {jQuery.Event} e Form submit event
 */
ve.ui.Inspector.prototype.onFormSubmit = function () {
	this.close( { 'action': 'apply' } );
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
	if ( e.which === OO.ui.Keys.ESCAPE ) {
		this.close( { 'action': 'back' } );
		return false;
	}
};

/**
 * @inheritdoc
 */
ve.ui.Inspector.prototype.initialize = function () {
	// Parent method
	OO.ui.Window.prototype.initialize.call( this );

	// Initialization
	this.frame.$content.addClass( 've-ui-inspector-content' );
	this.$form = this.$( '<form>' );
	this.closeButton = new OO.ui.IconButtonWidget( {
		'$': this.$, 'icon': 'previous', 'title': OO.ui.msg( 'ooui-inspector-close-tooltip' )
	} );
	if ( this.constructor.static.removeable ) {
		this.removeButton = new OO.ui.IconButtonWidget( {
			'$': this.$, 'icon': 'remove', 'title': OO.ui.msg( 'ooui-inspector-remove-tooltip' )
		} );
	}

	// Events
	this.$form.on( {
		'submit': OO.ui.bind( this.onFormSubmit, this ),
		'keydown': OO.ui.bind( this.onFormKeyDown, this )
	} );
	this.closeButton.connect( this, { 'click': 'onCloseButtonClick' } );
	if ( this.constructor.static.removeable ) {
		this.removeButton.connect( this, { 'click': 'onRemoveButtonClick' } );
	}

	// Initialization
	this.closeButton.$element.addClass( 've-ui-inspector-closeButton' );
	this.$head.prepend( this.closeButton.$element );
	if ( this.constructor.static.removeable ) {
		this.removeButton.$element.addClass( 've-ui-inspector-removeButton' );
		this.$head.append( this.removeButton.$element );
	}
	this.$body.append( this.$form );
};

/**
 * @inheritdoc
 */
ve.ui.Inspector.prototype.setup = function ( data ) {
	// Parent method
	OO.ui.Window.prototype.setup.call( this, data );

	ve.track( 'wikia', {
		'action': ve.track.actions.OPEN,
		'label': 'inspector-' + ve.track.nameToLabel( this.constructor.static.name )
	} );

	// Wait for animation to complete
	setTimeout( ve.bind( function () {
		this.ready();
	}, this ), 200 );
};

/**
 * Inspector is done animating and ready to be interacted with.
 */
ve.ui.Inspector.prototype.ready = function () {
	//
};

/**
 * Handle inspector close events.
 *
 * @method
 */
ve.ui.Inspector.prototype.teardown = function ( data ) {
	// Parent method
	OO.ui.Window.prototype.teardown.call( this, data );

	ve.track( 'wikia', {
		'action': ve.track.actions.CLOSE,
		'label': 'inspector-' + ve.track.nameToLabel( this.constructor.static.name )
	} );
};
