/*!
 * VisualEditor UserInterface MobileContext class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface context that displays inspector full screen.
 *
 * @class
 * @extends ve.ui.Context
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MobileContext = function VeUiMobileContext( surface, config ) {
	// Parent constructor
	ve.ui.MobileContext.super.call( this, surface, config );

	// Properties
	this.transitioning = null;

	// Events
	this.inspectors.connect( this, {
		setup: [ 'toggle', true ],
		teardown: [ 'toggle', false ]
	} );

	// Initialization
	this.$element
		.addClass( 've-ui-mobileContext' )
		.append( this.menu.$element )
		// Mobile context uses a class to toggle visibility
		.show();
	this.menu.$element.addClass( 've-ui-mobileContext-menu' );
	this.inspectors.$element.addClass( 've-ui-mobileContext-inspectors' );
	this.surface.getGlobalOverlay().$element.append( this.inspectors.$element );
};

/* Inheritance */

OO.inheritClass( ve.ui.MobileContext, ve.ui.Context );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MobileContext.prototype.createInspectorWindowManager = function () {
	return new ve.ui.MobileWindowManager( {
		factory: ve.ui.windowFactory,
		overlay: this.surface.getGlobalOverlay()
	} );
};

/**
 * @inheritdoc
 */
ve.ui.Context.prototype.createItem = function ( tool ) {
	return new ve.ui.MobileContextOptionWidget(
		tool.tool, tool.model, { $: this.$, data: tool.tool.static.name }
	);
};

/**
 * @inheritdoc
 */
ve.ui.MobileContext.prototype.toggle = function ( show ) {
	var deferred = $.Deferred();

	show = show === undefined ? !this.visible : !!show;
	if ( show !== this.visible ) {
		this.visible = show;
		this.$element.toggleClass( 've-ui-mobileContext-visible', show );
		setTimeout( function () {
			deferred.resolve();
		}, 300 );
	} else {
		deferred.resolve();
	}

	return deferred.promise();
};
