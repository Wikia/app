/*!
 * VisualEditor UserInterface ContextItem class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Item in a context.
 *
 * @class
 * @extends OO.ui.Widget
 * @mixins OO.ui.mixin.IconElement
 * @mixins OO.ui.mixin.LabelElement
 * @mixins OO.ui.mixin.PendingElement
 *
 * @constructor
 * @param {ve.ui.Context} context Context item is in
 * @param {ve.dm.Model} [model] Model item is related to
 * @param {Object} [config] Configuration options
 * @cfg {boolean} [basic] Render only basic information
 */
ve.ui.ContextItem = function VeUiContextItem( context, model, config ) {
	// Parent constructor
	ve.ui.ContextItem.super.call( this, config );

	// Mixin constructors
	OO.ui.mixin.IconElement.call( this, config );
	OO.ui.mixin.LabelElement.call( this, config );
	OO.ui.mixin.PendingElement.call( this, config );

	// Properties
	this.context = context;
	this.model = model;
	this.fragment = null;

	// Events
	this.$element.on( 'mousedown', false );

	// Initialization
	this.$element.addClass( 've-ui-contextItem' );
};

/* Inheritance */

OO.inheritClass( ve.ui.ContextItem, OO.ui.Widget );
OO.mixinClass( ve.ui.ContextItem, OO.ui.mixin.IconElement );
OO.mixinClass( ve.ui.ContextItem, OO.ui.mixin.LabelElement );
OO.mixinClass( ve.ui.ContextItem, OO.ui.mixin.PendingElement );

/* Events */

/**
 * @event command
 */

/* Static Properties */

/**
 * Whether this item exclusively handles any model class
 *
 * @static
 * @property {boolean}
 * @inheritable
 */
ve.ui.ContextItem.static.exclusive = true;

ve.ui.ContextItem.static.commandName = null;

/**
 * Annotation or node models this item is related to.
 *
 * Used by #isCompatibleWith.
 *
 * @static
 * @property {Function[]}
 * @inheritable
 */
ve.ui.ContextItem.static.modelClasses = [];

/* Methods */

/**
 * Check if this item is compatible with a given model.
 *
 * @static
 * @inheritable
 * @param {ve.dm.Model} model Model to check
 * @return {boolean} Item can be used with model
 */
ve.ui.ContextItem.static.isCompatibleWith = function ( model ) {
	return ve.isInstanceOfAny( model, this.modelClasses );
};

/**
 * Check if model is a node
 *
 * @return {boolean} Model is a nodel
 */
ve.ui.ContextItem.prototype.isNode = function () {
	return this.model && this.model instanceof ve.dm.Node;
};

/**
 * Get the command for this item.
 *
 * @return {ve.ui.Command} Command
 */
ve.ui.ContextItem.prototype.getCommand = function () {
	return ve.init.target.commandRegistry.lookup( this.constructor.static.commandName );
};

/**
 * Get a surface fragment covering the related model node, or the current selection otherwise
 *
 * @return {ve.dm.SurfaceFragment} Surface fragment
 */
ve.ui.ContextItem.prototype.getFragment = function () {
	var surfaceModel;
	if ( !this.fragment ) {
		surfaceModel = this.context.getSurface().getModel();
		this.fragment = this.isNode() ?
			surfaceModel.getLinearFragment( this.model.getOuterRange() ) :
			surfaceModel.getFragment();
	}
	return this.fragment;
};

/**
 * Setup the item.
 *
 * @chainable
 */
ve.ui.ContextItem.prototype.setup = function () {
	return this;
};

/**
 * Teardown the item.
 *
 * @chainable
 */
ve.ui.ContextItem.prototype.teardown = function () {
	return this;
};
