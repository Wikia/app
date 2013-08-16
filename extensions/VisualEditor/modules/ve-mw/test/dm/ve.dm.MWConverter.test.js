/*!
 * VisualEditor DataModel MediaWiki Converter tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.MWConverter' );

/* Tests */

QUnit.test( 'getDataFromDom', function ( assert ) {
	ve.test.utils.runGetDataFromDomTests( assert, ve.copy( ve.dm.mwExample.domToDataCases ) );
} );

QUnit.test( 'getDomFromData', function ( assert ) {
	ve.test.utils.runGetDomFromDataTests( assert, ve.copy( ve.dm.mwExample.domToDataCases ) );
} );
