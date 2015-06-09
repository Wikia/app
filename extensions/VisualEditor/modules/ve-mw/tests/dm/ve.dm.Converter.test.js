/*!
 * VisualEditor DataModel MediaWiki-specific Converter tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.Converter', QUnit.newMwEnvironment() );

QUnit.test( 'getModelFromDom', function ( assert ) {
	var msg, caseItem,
		cases = ve.dm.mwExample.domToDataCases;

	// TODO: this is a hack similar to one in ve.test.utils.js
	// to make MWBlockImageNode the most recently registered,
	// instead of the Wikia version
	ve.dm.modelRegistry.register( ve.dm.MWBlockImageNode );

	QUnit.expect( ve.test.utils.countGetModelFromDomTests( cases ) );

	for ( msg in cases ) {
		caseItem = ve.copy( cases[msg] );
		if ( caseItem.mwConfig ) {
			mw.config.set( caseItem.mwConfig );
		}

		ve.test.utils.runGetModelFromDomTest( assert, caseItem, msg );
	}
} );

QUnit.test( 'getDomFromModel', function ( assert ) {
	var msg, caseItem,
		cases = ve.dm.mwExample.domToDataCases;

	QUnit.expect( 2 * ve.getObjectKeys( cases ).length );

	for ( msg in cases ) {
		caseItem = ve.copy( cases[msg] );
		if ( caseItem.mwConfig ) {
			mw.config.set( caseItem.mwConfig );
		}

		ve.test.utils.runGetDomFromModelTest( assert, caseItem, msg );
	}
} );
