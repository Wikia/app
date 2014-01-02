/*!
 * VisualEditor DataModel Wikia Converter tests.
 */

QUnit.module( 've.dm.WikiaConverter' );

/* Tests */

QUnit.test( 'getDataFromDom', function ( assert ) {
	// TODO: this is a hack similar to one in ve.test.utils.js to make
	// WikiaBlockImageNode and WikiaBlockVideoNode the most recently registered,
	// instead of the MW version
	ve.dm.modelRegistry.register( ve.dm.WikiaBlockImageNode );
	ve.dm.modelRegistry.register( ve.dm.WikiaBlockVideoNode );
	ve.test.utils.runGetDataFromDomTests( assert, ve.copy( ve.dm.wikiaExample.domToDataCases ) );
} );

QUnit.test( 'getDomFromData', function ( assert ) {
	ve.test.utils.runGetDomFromDataTests( assert, ve.copy( ve.dm.wikiaExample.domToDataCases ) );
} );
