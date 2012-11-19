/**
 * VisualEditor data model Converter tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.Converter' );

/* Tests */

QUnit.test( 'getDataElementFromDomElement', 20, function ( assert ) {
	var msg, conversion;

	for ( msg in ve.dm.example.conversions ) {
		conversion = ve.dm.example.conversions[msg];
		assert.deepEqual(
			ve.dm.converter.getDataElementFromDomElement( conversion.domElement ),
			conversion.dataElement,
			msg
		);
	}
} );

QUnit.test( 'getDomElementFromDataElement', 20, function ( assert ) {
	var msg, conversion;

	for ( msg in ve.dm.example.conversions ) {
		conversion = ve.dm.example.conversions[msg];
		assert.equalDomElement(
			ve.dm.converter.getDomElementFromDataElement( conversion.dataElement ),
			conversion.domElement,
			msg
		);
	}
} );

QUnit.test( 'getDataFromDom', 33, function ( assert ) {
	var msg,
		cases = ve.dm.example.domToDataCases;

	for ( msg in cases ) {
		if ( cases[msg].html !== null ) {
			ve.dm.example.preprocessAnnotations( cases[msg].data );
			assert.deepEqual(
				ve.dm.converter.getDataFromDom( $( '<div>' ).html( cases[msg].html )[0] ),
				cases[msg].data,
				msg
			);
		}
	}
} );

QUnit.test( 'getDomFromData', 35, function ( assert ) {
	var msg,
		cases = ve.dm.example.domToDataCases;

	for ( msg in cases ) {
		ve.dm.example.preprocessAnnotations( cases[msg].data );
		assert.equalDomElement(
			ve.dm.converter.getDomFromData( cases[msg].data ),
			$( '<div>' ).html( cases[msg].normalizedHtml || cases[msg].html )[0],
			msg
		);
	}
} );
