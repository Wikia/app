/**
 * VisualEditor content editable Document tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.Document' );

/* Tests */

QUnit.test( 'selectNodes', 21, function ( assert ) {
	var i, len,
		doc = new ve.ce.Document( new ve.dm.Document( ve.copyArray( ve.dm.example.data ) ) ),
		cases = ve.example.getSelectNodesCases( doc );
	for ( i = 0, len = cases.length; i < len; i++ ) {
		assert.equalNodeSelection( cases[i].actual, cases[i].expected, cases[i].msg );
	}
} );
