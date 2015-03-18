/*!
 * VisualEditor UserInterface LinkInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Inspector for linked content.
 *
 * @class
 * @extends ve.ui.AnnotationInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.LinkInspector = function VeUiLinkInspector( config ) {
	// Parent constructor
	ve.ui.AnnotationInspector.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.LinkInspector, ve.ui.AnnotationInspector );

/* Static properties */

ve.ui.LinkInspector.static.name = 'link';

ve.ui.LinkInspector.static.title = OO.ui.deferMsg( 'visualeditor-linkinspector-title' );

ve.ui.LinkInspector.static.linkTargetInputWidget = ve.ui.LinkTargetInputWidget;

ve.ui.LinkInspector.static.modelClasses = [ ve.dm.LinkAnnotation ];

ve.ui.LinkInspector.static.actions = ve.ui.LinkInspector.super.static.actions.concat( [
	{
		action: 'open',
		label: OO.ui.deferMsg( 'visualeditor-linkinspector-open' )
	}
] );

/* Methods */

/**
 * Handle target input change events.
 *
 * Updates the open button's hyperlink location.
 *
 * @param {string} value New target input value
 */
ve.ui.LinkInspector.prototype.onTargetInputChange = function () {
	var href = this.targetInput.getHref(),
		inspector = this;
	this.targetInput.isValid().done( function ( valid ) {
		inspector.actions.forEach( { actions: 'open' }, function ( action ) {
			action.setHref( href ).setTarget( '_blank' ).setDisabled( !valid );
			// HACK: Chrome renders a dark outline around the action when it's a link, but causing it to
			// re-render makes it magically go away; this is incredibly evil and needs further
			// investigation
			action.$element.hide().fadeIn( 0 );
		} );
	} );
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.shouldRemoveAnnotation = function () {
	return !this.targetInput.getValue().length;
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.getInsertionText = function () {
	return this.targetInput.getValue();
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.getAnnotation = function () {
	return this.targetInput.getAnnotation();
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.getAnnotationFromFragment = function ( fragment ) {
	return new ve.dm.LinkAnnotation( {
		type: 'link',
		attributes: { href: fragment.getText() }
	} );
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.initialize = function () {
	var overlay = this.manager.getOverlay();

	// Parent method
	ve.ui.LinkInspector.super.prototype.initialize.call( this );

	// Properties
	this.targetInput = new this.constructor.static.linkTargetInputWidget( {
		$: this.$,
		$overlay: overlay ? overlay.$element : this.$frame,
		disabled: true,
		classes: [ 've-ui-linkInspector-target' ]
	} );

	// Events
	this.targetInput.connect( this, { change: 'onTargetInputChange' } );

	// Initialization
	this.$content.addClass( 've-ui-linkInspector-content' );
	this.form.$element.append( this.targetInput.$element );
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.getSetupProcess = function ( data ) {
	return ve.ui.LinkInspector.super.prototype.getSetupProcess.call( this, data )
		.next( function () {
			// Disable surface until animation is complete; will be reenabled in ready()
			this.getFragment().getSurface().disable();
			this.targetInput.setAnnotation( this.initialAnnotation );
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.getReadyProcess = function ( data ) {
	return ve.ui.LinkInspector.super.prototype.getReadyProcess.call( this, data )
		.next( function () {
			this.targetInput.setDisabled( false ).focus().select();
			this.getFragment().getSurface().enable();
			this.onTargetInputChange();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.getHoldProcess = function ( data ) {
	return ve.ui.LinkInspector.super.prototype.getHoldProcess.call( this, data )
		.next( function () {
			this.targetInput.setDisabled( true ).blur();
		}, this );
};

/**
 * @inheritdoc
 */
ve.ui.LinkInspector.prototype.getTeardownProcess = function ( data ) {
	return ve.ui.LinkInspector.super.prototype.getTeardownProcess.call( this, data )
		.next( function () {
			this.targetInput.setAnnotation( null );
		}, this );
};

/* Registration */

ve.ui.windowFactory.register( ve.ui.LinkInspector );
