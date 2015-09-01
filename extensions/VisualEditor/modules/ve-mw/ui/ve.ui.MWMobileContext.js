/*!
 * VisualEditor UserInterface MobileContext class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
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
ve.ui.MWMobileContext.prototype.getRelatedSources = function () {
	var sources;

	if ( !this.relatedSources ) {
		sources = ve.ui.MobileContext.super.prototype.getRelatedSources.call( this );

		// Filter out sources not supported in mobile mode
		// FIXME: This is a temporary hack. Ideally, we don't want to load any code
		// that is not supported on a given platform. However, present implementation
		// of citation dialog forces us to load sources that we don't want on mobile.
		this.availableSources = sources.filter( function ( source ) {
			return (
				source.model instanceof ve.dm.LinkAnnotation ||
				(
					source.model instanceof ve.dm.MWReferenceNode &&
					source.tool !== ve.ui.MWReferenceDialogTool
				)
			);
		} );
	}

	return this.availableSources;
};
