/*!
 * VisualEditor DataModel MediaWiki-specific Converter tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

QUnit.module( 've.dm.Converter' );

/* Tests */

function setMwConfig( newConfig ) {
	var key, oldConfig = {};
	for ( key in newConfig ) {
		// Store orignal value
		oldConfig[key] = mw.config.get( key );
		// Override config setting
		mw.config.set( key, newConfig[key] );
	}
	return oldConfig;
}

QUnit.test( 'getModelFromDom', function ( assert ) {
	var msg, caseItem,
		originalConfig,
		cases = ve.dm.mwExample.domToDataCases;

	QUnit.expect( ve.test.utils.countGetModelFromDomTests( cases ) );

	for ( msg in cases ) {
		caseItem = ve.copy( cases[msg] );
		if ( caseItem.mwConfig ) {
			originalConfig = setMwConfig( caseItem.mwConfig );
		}

		ve.test.utils.runGetModelFromDomTest( assert, caseItem, msg );

		if ( caseItem.mwConfig ) {
			setMwConfig( originalConfig );
		}
	}
} );

QUnit.test( 'getDomFromModel', function ( assert ) {
	var msg, caseItem,
		originalConfig,
		cases = ve.dm.mwExample.domToDataCases;

	QUnit.expect( 2 * ve.getObjectKeys( cases ).length );

	for ( msg in cases ) {
		caseItem = ve.copy( cases[msg] );
		if ( caseItem.mwConfig ) {
			originalConfig = setMwConfig( caseItem.mwConfig );
		}

		ve.test.utils.runGetDomFromModelTest( assert, caseItem, msg );

		if ( caseItem.mwConfig ) {
			setMwConfig( originalConfig );
		}
	}
} );
