/*!
 * VisualEditor MediaWiki test utilities.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

ve.test.utils.createSurfaceFromDocument = function ( doc ) {
	// Prevent the target from setting up the surface immediately
	ve.init.platform.initialized = $.Deferred();
	// HACK: MW targets are async and heavy, use an SA target but
	// override the global registration
	var target = new ve.init.sa.Target(),
		mwTarget = new ve.init.mw.Target();

	$( '#qunit-fixture' ).append( target.$element );
	target.addSurface( doc );

	ve.init.platform.initialized.resolve();
	mwTarget = null;
	target.addSurface( doc );
	return target.surface;
};
