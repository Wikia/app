/*!
 * VisualEditor MediaWiki test utilities.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

ve.test.utils.createSurfaceFromDocument = function ( doc ) {
	// Prevent the target from setting up the surface immediately
	ve.init.platform.initialized = null;
	// HACK: MW targets are async and heavy, use an SA target but
	// override the global registration
	var target = new ve.init.sa.Target( $( '#qunit-fixture' ), doc ),
		mwTarget = new ve.init.mw.Target( $( '<div>' ).appendTo( $( '#qunit-fixture' ) ) );

	mwTarget = null;
	target.setup( doc );
	return target.surface;
};
