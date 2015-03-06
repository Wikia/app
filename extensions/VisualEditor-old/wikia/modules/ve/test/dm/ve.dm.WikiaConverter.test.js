/*!
 * VisualEditor DataModel Wikia Converter tests.
 */

QUnit.module( 've.dm.WikiaConverter' );

/* Tests */

QUnit.test( 'getModelFromDom', function ( assert ) {
	var msg,
		cases = ve.dm.wikiaExample.domToDataCases;
	// TODO: this is a hack similar to one in ve.test.utils.js to make
	// WikiaBlockImageNode and WikiaBlockVideoNode the most recently registered,
	// instead of the MW version
	ve.dm.modelRegistry.register( ve.dm.WikiaBlockImageNode );
	ve.dm.modelRegistry.register( ve.dm.WikiaBlockVideoNode );

	QUnit.expect( ve.test.utils.countGetModelFromDomTests( cases ) );

	for ( msg in cases ) {
		ve.test.utils.runGetModelFromDomTest( assert, ve.copy( cases[msg] ), msg );
	}
} );

QUnit.test( 'getDomFromModel', function ( assert ) {
	var msg,
		cases = ve.dm.wikiaExample.domToDataCases;

	QUnit.expect( 2 * ve.getObjectKeys( cases ).length );

	for ( msg in cases ) {
		ve.test.utils.runGetDomFromModelTest( assert, ve.copy( cases[msg] ), msg );
	}
} );
