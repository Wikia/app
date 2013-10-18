/*!
 * VisualEditor DataModel MediaWiki Converter tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.MWConverter' );

/* Tests */

QUnit.test( 'getDataFromDom', function ( assert ) {
	// TODO: this is a hack similar to one in ve.test.utils.js
	// to make MWBlockImageNode the most recently registered,
	// instead of the Wikia version
	ve.dm.modelRegistry.register( ve.dm.MWBlockImageNode );
	ve.test.utils.runGetDataFromDomTests( assert, ve.copy( ve.dm.mwExample.domToDataCases ) );
} );

QUnit.test( 'getDomFromData', function ( assert ) {
	ve.test.utils.runGetDomFromDataTests( assert, ve.copy( ve.dm.mwExample.domToDataCases ) );
} );
