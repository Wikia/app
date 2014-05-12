/*!
 * VisualEditor UserInterface Inspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
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
 * @param {Object} [config] Configuration options
 * @cfg {jQuery} [$contextOverlay] Context overlay layer
 */
ve.ui.Inspector = function VeUiInspector( config ) {
	// Parent constructor
	OO.ui.Window.call( this, config );

	// Properties
	this.$contextOverlay = config.$contextOverlay;
	this.fragment = null;

	// Initialization
	this.$element.addClass( 've-ui-inspector' );
};

/* Inheritance */

OO.inheritClass( ve.ui.Inspector, OO.ui.Window );

/* Static Properties */

/**
 * Symbolic name of inspector.
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
ve.ui.Inspector.static.removable = true;

/* Methods */

/**
 * @param {ve.dm.SurfaceFragment} fragment Surface fragment
 * @param {Object} data Inspector opening data
 * @param {string} data.dir Directionality of fragment
 */
ve.ui.Inspector.prototype.open = function ( fragment, data ) {
	this.fragment = fragment;

	// Parent method
	OO.ui.Window.prototype.open.call( this, data );
};

/**
 * @inheritdoc
 */
ve.ui.Inspector.prototype.close = function () {
	// Parent method
	OO.ui.Window.prototype.close.apply( this, arguments );

	this.fragment = null;
};

/**
 * Get the surface fragment the inspector is for
 *
 * @returns {ve.dm.SurfaceFragment|null} Surface fragment the inspector is for, null if the inspector is closed
 */
ve.ui.Inspector.prototype.getFragment = function () {
	return this.fragment;
};

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
	this.closeButton = new OO.ui.ButtonWidget( {
		'$': this.$,
		'frameless': true,
		'icon': 'previous',
		'title': ve.msg( 'visualeditor-inspector-close-tooltip' )
	} );
	if ( this.constructor.static.removable ) {
		this.removeButton = new OO.ui.ButtonWidget( {
			'$': this.$,
			'frameless': true,
			'icon': 'remove',
			'title': ve.msg( 'visualeditor-inspector-remove-tooltip' )
		} );
	}

	// Events
	this.$form.on( {
		'submit': OO.ui.bind( this.onFormSubmit, this ),
		'keydown': OO.ui.bind( this.onFormKeyDown, this )
	} );
	this.closeButton.connect( this, { 'click': 'onCloseButtonClick' } );
	if ( this.constructor.static.removable ) {
		this.removeButton.connect( this, { 'click': 'onRemoveButtonClick' } );
	}

	// Initialization
	this.closeButton.$element.addClass( 've-ui-inspector-closeButton' );
	this.$head.prepend( this.closeButton.$element );
	if ( this.constructor.static.removable ) {
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
 * @inheritdoc
 */
ve.ui.Inspector.prototype.teardown = function ( data ) {
	// Parent method
	OO.ui.Window.prototype.teardown.call( this, data );

	ve.track( 'wikia', {
		'action': ve.track.actions.CLOSE,
		'label': 'inspector-' + ve.track.nameToLabel( this.constructor.static.name )
	} );
};
