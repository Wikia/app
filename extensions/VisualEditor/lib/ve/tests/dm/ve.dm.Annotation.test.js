/*!
 * VisualEditor DataModel Annotation tests.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.dm.Annotation' );

QUnit.test( 'getHashObject', function ( assert ) {
	var	i, l,
		cases = [
			{
				msg: 'Bold',
				annotation: new ve.dm.BoldAnnotation( {
					type: 'textStyle/bold',
					attributes: { nodeName: 'b' },
					originalDomElements: $( '<b>Foo</b>' ).toArray()
				} ),
				expected: {
					type: 'textStyle/bold',
					attributes: { nodeName: 'b' },
					originalDomElements: '<b></b>'
				}
			},
			{
				msg: 'Bold with different content',
				annotation: new ve.dm.BoldAnnotation( {
					type: 'textStyle/bold',
					attributes: { nodeName: 'b' },
					originalDomElements: $( '<b>Bar</b>' ).toArray()
				} ),
				expected: {
					type: 'textStyle/bold',
					attributes: { nodeName: 'b' },
					originalDomElements: '<b></b>'
				}
			},
			{
				msg: 'Italic with attributes',
				annotation: new ve.dm.ItalicAnnotation( {
					type: 'textStyle/italic',
					attributes: { nodeName: 'i' },
					originalDomElements: $( '<i style="color:red;">Foo</i>' ).toArray()
				} ),
				expected: {
					type: 'textStyle/italic',
					attributes: { nodeName: 'i' },
					originalDomElements: '<i style="color:red;"></i>'
				}
			}
		];

	QUnit.expect( cases.length );

	for ( i = 0, l = cases.length; i < l; i++ ) {
		assert.deepEqual( cases[ i ].annotation.getHashObject(), cases[ i ].expected, cases[ i ].msg );
	}
} );
