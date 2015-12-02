/*!
 * VisualEditor UserInterface MobileContext class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface context that displays inspector full screen.
 *
 * @class
 * @extends ve.ui.MobileContext
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMobileContext = function VeUiMWMobileContext() {
	// Parent constructor
	ve.ui.MWMobileContext.super.apply( this, arguments );

	// Initialization
	this.$element.addClass( 've-ui-mwMobileContext' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMobileContext, ve.ui.MobileContext );

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWMobileContext.prototype.getAvailableTools = function () {
	var tools = ve.ui.MobileContext.super.prototype.getAvailableTools.call( this );

	// Filter out tools not supported in mobile mode
	// FIXME: This is a temporary hack. Ideally, we don't want to load any code
	// that is not supported on a given platform. However, present implementation
	// of citation dialog forces us to load tools that we don't want on mobile.
	this.availableTools = tools.filter( function ( tool ) {
		return (
			tool.model instanceof ve.dm.LinkAnnotation ||
			( tool.model instanceof ve.dm.MWReferenceNode && tool.tool !== ve.ui.MWReferenceDialogTool )
		);
	} );

	return this.availableTools;
};
