/*!
 * VisualEditor UserInterface LinearContextItem class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Item in a context.
 *
 * @class
 * @extends ve.ui.ContextItem
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
ve.ui.LinearContextItem = function VeUiLinearContextItem() {
	// Parent constructor
	ve.ui.LinearContextItem.super.apply( this, arguments );

	// Properties
	this.$head = $( '<div>' );
	this.$title = $( '<div>' );
	this.$actions = $( '<div>' );
	this.$body = $( '<div>' );
	this.$info = $( '<div>' );
	this.$description = $( '<div>' );
	if ( !this.context.isMobile() ) {
		this.editButton = new OO.ui.ButtonWidget( {
			label: ve.msg( 'visualeditor-contextitemwidget-label-secondary' ),
			flags: [ 'progressive' ]
		} );
		this.deleteButton = new OO.ui.ButtonWidget( {
			label: ve.msg( 'visualeditor-contextitemwidget-label-remove' ),
			flags: [ 'destructive' ]
		} );
	} else {
		this.editButton = new OO.ui.ButtonWidget( {
			framed: false,
			icon: 'edit',
			flags: [ 'progressive' ]
		} );
		this.deleteButton = new OO.ui.ButtonWidget( {
			framed: false,
			icon: 'remove',
			flags: [ 'destructive' ]
		} );
	}
	this.actionButtons = new OO.ui.ButtonGroupWidget();
	if ( this.isDeletable() ) {
		this.actionButtons.addItems( [ this.deleteButton ] );
	}
	if ( this.isEditable() ) {
		this.actionButtons.addItems( [ this.editButton ] );
	}

	// Events
	this.editButton.connect( this, { click: 'onEditButtonClick' } );
	this.deleteButton.connect( this, { click: 'onDeleteButtonClick' } );

	// Initialization
	this.$label.addClass( 've-ui-linearContextItem-label' );
	this.$icon.addClass( 've-ui-linearContextItem-icon' );
	this.$description.addClass( 've-ui-linearContextItem-description' );
	this.$info
		.addClass( 've-ui-linearContextItem-info' )
		.append( this.$description );
	this.$title
		.addClass( 've-ui-linearContextItem-title' )
		.append( this.$icon, this.$label );
	this.$actions
		.addClass( 've-ui-linearContextItem-actions' )
		.append( this.actionButtons.$element );
	this.$head
		.addClass( 've-ui-linearContextItem-head' )
		.append( this.$title, this.$info, this.$actions );
	this.$body.addClass( 've-ui-linearContextItem-body' );
	this.$element
		.addClass( 've-ui-linearContextItem' )
		.append( this.$head, this.$body );
};

/* Inheritance */

OO.inheritClass( ve.ui.LinearContextItem, ve.ui.ContextItem );

/* Events */

/**
 * @event command
 */

/* Static Properties */

ve.ui.LinearContextItem.static.editable = true;

ve.ui.LinearContextItem.static.deletable = true;

/**
 * Whether the context item should try (if space permits) to go inside the node,
 * rather than below with an arrow
 *
 * @static
 * @property {boolean}
 * @inheritable
 */
ve.ui.LinearContextItem.static.embeddable = true;

/* Methods */

/**
 * Handle edit button click events.
 *
 * @localdoc Executes the command related to #static-commandName on the context's surface
 *
 * @protected
 */
ve.ui.LinearContextItem.prototype.onEditButtonClick = function () {
	var command = this.getCommand();

	if ( command ) {
		command.execute( this.context.getSurface() );
		this.emit( 'command' );
	}
};

/**
 * Handle delete button click events.
 */
ve.ui.LinearContextItem.prototype.onDeleteButtonClick = function () {
	this.getFragment().removeContent();
};

/**
 * Check if item is editable.
 *
 * @return {boolean} Item is editable
 */
ve.ui.LinearContextItem.prototype.isEditable = function () {
	return this.constructor.static.editable && ( !this.model || this.model.isEditable() );
};

/**
 * Check if item is deletable.
 *
 * @return {boolean} Item is deletable
 */
ve.ui.LinearContextItem.prototype.isDeletable = function () {
	return this.constructor.static.deletable && this.isNode() && this.context.showDeleteButton();
};

/**
 * Get the description.
 *
 * @localdoc Override for custom description content
 * @return {string} Item description
 */
ve.ui.LinearContextItem.prototype.getDescription = function () {
	return '';
};

/**
 * Render the body.
 *
 * @localdoc Renders the result of #getDescription, override for custom body rendering
 */
ve.ui.LinearContextItem.prototype.renderBody = function () {
	this.$body.text( this.getDescription() );
};

/**
 * Render the description.
 *
 * @localdoc Renders the result of #getDescription, override for custom description rendering
 */
ve.ui.LinearContextItem.prototype.renderDescription = function () {
	this.$description.text( this.getDescription() );
};

/**
 * @inheritdoc
 */
ve.ui.LinearContextItem.prototype.setup = function () {
	if ( this.context.isMobile() ) {
		this.renderDescription();
	} else {
		this.renderBody();
	}

	return this;
};

/**
 * @inheritdoc
 */
ve.ui.LinearContextItem.prototype.teardown = function () {
	this.$description.empty();
	this.$body.empty();
	return this;
};
