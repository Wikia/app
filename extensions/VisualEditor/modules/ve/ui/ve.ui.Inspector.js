/**
 * VisualEditor user interface Inspector class.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.Inspector object.
 *
 * @class
 * @constructor
 * @extends {ve.EventEmitter}
 * @param {ve.ui.Context} context
 */
ve.ui.Inspector = function VeUiInspector( context ) {
	// Inheritance
	ve.EventEmitter.call( this );

	if ( !context ) {
		return;
	}

	// Properties
	this.context = context;
	this.$ = $( '<div class="ve-ui-inspector"></div>', context.frameView.doc );
	this.$closeButton = $(
		'<div class="ve-ui-inspector-button ve-ui-inspector-closeButton ve-ui-icon-close"></div>',
		context.frameView.doc
	);
	this.$form = $( '<form>', context.frameView.doc );

	// DOM Changes
	this.$.append(
		this.$closeButton,
		$( '<div class="ve-ui-inspector-icon ve-ui-icon-' + this.constructor.static.icon + '"></div>' ),
		this.$form
	);

	// Events
	this.$closeButton.on( {
		'click': function () {
			// Close inspector with save.
			context.closeInspector( true );
		}
	} );
	this.$form.on( {
		'submit': ve.bind( this.onSubmit, this ),
		'keydown': ve.bind( this.onKeyDown, this )
	} );
};

/* Inheritance */

ve.inheritClass( ve.ui.Inspector, ve.EventEmitter );

ve.ui.Inspector.static.icon = 'button';

/* Methods */

ve.ui.Inspector.prototype.onSubmit = function ( e ) {
	e.preventDefault();
	if ( this.$.hasClass( 've-ui-inspector-disabled' ) ) {
		return;
	}
	this.context.closeInspector( true );
	return false;
};

ve.ui.Inspector.prototype.onKeyDown = function ( e ) {
	// Escape
	if ( e.which === 27 ) {
		this.context.closeInspector( false );
		e.preventDefault();
		return false;
	}
};

ve.ui.Inspector.prototype.open = function () {
	// Prepare to open
	if ( this.prepareOpen ) {
		this.prepareOpen();
	}
	// Show
	this.$.show();
	// Open
	if ( this.onOpen ) {
		this.onOpen();
	}
	this.emit( 'open' );
};

ve.ui.Inspector.prototype.close = function ( accept ) {
	this.$.hide();
	if ( this.onClose ) {
		this.onClose( accept );
	}
	this.emit( 'close' );
};
