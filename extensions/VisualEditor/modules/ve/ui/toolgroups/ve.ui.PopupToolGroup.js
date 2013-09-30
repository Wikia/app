/*!
 * VisualEditor UserInterface PopupToolGroup class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface bar tool group.
 *
 * @class
 * @abstract
 * @extends ve.ui.ToolGroup
 * @mixins ve.ui.IconedElement
 * @mixins ve.ui.LabeledElement
 * @mixins ve.ui.ClippableElement
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.PopupToolGroup = function VeUiPopupToolGroup( toolbar, config ) {
	// Configuration initialization
	config = ve.extendObject( { 'icon': 'down' }, config );

	// Parent constructor
	ve.ui.ToolGroup.call( this, toolbar, config );

	// Mixin constructors
	ve.ui.IconedElement.call( this, this.$$( '<span>' ), config );
	ve.ui.LabeledElement.call( this, this.$$( '<span>' ) );
	ve.ui.ClippableElement.call( this, this.$group );

	// Properties
	this.active = false;
	this.dragging = false;
	this.onBlurHandler = ve.bind( this.onBlur, this );
	this.$handle = this.$$( '<span>' );

	// Events
	this.$handle.on( {
		'mousedown': ve.bind( this.onHandleMouseDown, this ),
		'mouseup': ve.bind( this.onHandleMouseUp, this )
	} );

	// Initialization
	this.$handle
		.addClass( 've-ui-popupToolGroup-handle' )
		.append( this.$label, this.$icon );
	this.$
		.addClass( 've-ui-popupToolGroup' )
		.prepend( this.$handle );
	this.setLabel( config.label ? ve.msg( config.label ) : '' );
};

/* Inheritance */

ve.inheritClass( ve.ui.PopupToolGroup, ve.ui.ToolGroup );

ve.mixinClass( ve.ui.PopupToolGroup, ve.ui.IconedElement );
ve.mixinClass( ve.ui.PopupToolGroup, ve.ui.LabeledElement );
ve.mixinClass( ve.ui.PopupToolGroup, ve.ui.ClippableElement );

/* Static Properties */

/* Methods */

/**
 * Handle focus being lost.
 *
 * The event is actually generated from a mouseup, so it is not a normal blur event object.
 *
 * @method
 * @param {jQuery.Event} e Mouse up event
 */
ve.ui.PopupToolGroup.prototype.onBlur = function ( e ) {
	// Only deactivate when clicking outside the dropdown element
	if ( $( e.target ).closest( '.ve-ui-popupToolGroup' )[0] !== this.$[0] ) {
		this.setActive( false );
	}
};

/**
 * @inheritdoc
 */
ve.ui.PopupToolGroup.prototype.onMouseUp = function ( e ) {
	this.setActive( false );
	return ve.ui.ToolGroup.prototype.onMouseUp.call( this, e );
};

/**
 * @inheritdoc
 */
ve.ui.PopupToolGroup.prototype.onMouseDown = function ( e ) {
	return ve.ui.ToolGroup.prototype.onMouseDown.call( this, e );
};

/**
 * Handle mouse up events.
 *
 * @method
 * @param {jQuery.Event} e Mouse up event
 */
ve.ui.PopupToolGroup.prototype.onHandleMouseUp = function () {
	return false;
};

/**
 * Handle mouse down events.
 *
 * @method
 * @param {jQuery.Event} e Mouse down event
 */
ve.ui.PopupToolGroup.prototype.onHandleMouseDown = function ( e ) {
	if ( !this.disabled && e.which === 1 ) {
		this.setActive( !this.active );
	}
	return false;
};

/**
 * Switch into active mode.
 *
 * When active, mouseup events anywhere in the document will trigger deactivation.
 *
 * @method
 */
ve.ui.PopupToolGroup.prototype.setActive = function ( value ) {
	value = !!value;
	if ( this.active !== value ) {
		this.active = value;
		if ( value ) {
			this.setClipping( true );
			this.$.addClass( 've-ui-popupToolGroup-active' );
			this.getElementDocument().addEventListener( 'mouseup', this.onBlurHandler, true );
		} else {
			this.setClipping( false );
			this.$.removeClass( 've-ui-popupToolGroup-active' );
			this.getElementDocument().removeEventListener( 'mouseup', this.onBlurHandler, true );
		}
	}
};
