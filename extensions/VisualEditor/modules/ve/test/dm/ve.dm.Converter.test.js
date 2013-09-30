/*!
 * VisualEditor DataModel Converter tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.Converter' );

/* Tests */

// TODO rewrite to test getDataElementOrAnnotationFromDomElement
/*
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
*/

QUnit.test( 'getDomElementsFromDataElement', 20, function ( assert ) {
	var msg, conversion, doc;

	for ( msg in ve.dm.example.conversions ) {
		conversion = ve.dm.example.conversions[msg];
		doc = conversion.domElement.ownerDocument;
		assert.equalDomElement(
			ve.dm.converter.getDomElementsFromDataElement( conversion.dataElement, doc )[0],
			conversion.domElement,
			msg
		);
	}
} );

QUnit.test( 'getDataFromDom', function ( assert ) {
	ve.test.utils.runGetDataFromDomTests( assert, ve.copy( ve.dm.example.domToDataCases ) );
} );

QUnit.test( 'getDomFromData', function ( assert ) {
	ve.test.utils.runGetDomFromDataTests( assert, ve.copy( ve.dm.example.domToDataCases ) );
} );
