/*!
 * VisualEditor UserInterface Actions FormatAction tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ui.FormatAction' );

/* Tests */

QUnit.test( 'convert', function ( assert ) {
	var i,
		cases = [
			{
				'range': new ve.Range( 14, 16 ),
				'type': 'heading',
				'attributes': { level: 2 },
				'expectedSelection': new ve.Range( 14, 16 ),
				'expectedData': function ( data ) {
					data.splice( 12, 1, { 'type': 'heading', 'attributes': { 'level': 2 } } );
					data.splice( 19, 1, { 'type': '/heading' } );
				},
				'msg': 'converting partial selection of list item "Item 2" to level 2 heading'
			},
			{
				'range': new ve.Range( 15, 50 ),
				'type': 'heading',
				'attributes': { level: 3 },
				'expectedSelection': new ve.Range( 15, 50 ),
				'expectedData': function ( data ) {
					data.splice( 12, 1, { 'type': 'heading', 'attributes': { 'level': 3 } } );
					data.splice( 19, 1, { 'type': '/heading' } );
					data.splice( 22, 1, { 'type': 'heading', 'attributes': { 'level': 3 } } );
					data.splice( 29, 1, { 'type': '/heading' } );
					data.splice( 32, 1, { 'type': 'heading', 'attributes': { 'level': 3 } } );
					data.splice( 42, 1, { 'type': '/heading' } );
					data.splice( 45, 1, { 'type': 'heading', 'attributes': { 'level': 3 } } );
					data.splice( 52, 1, { 'type': '/heading' } );
				},
				'msg': 'converting partial selection across two lists surrounding a paragraph'
			},
			{
				'range': new ve.Range( 4, 28 ),
				'type': 'heading',
				'attributes': { level: 1 },
				'expectedSelection': new ve.Range( 4, 28 ),
				'expectedData': function ( data ) {
					data.splice( 2, 1, { 'type': 'heading', 'attributes': { 'level': 1 } } );
					data.splice( 9, 1, { 'type': '/heading' } );
					data.splice( 12, 1, { 'type': 'heading', 'attributes': { 'level': 1 } } );
					data.splice( 19, 1, { 'type': '/heading' } );
					data.splice( 22, 1, { 'type': 'heading', 'attributes': { 'level': 1 } } );
					data.splice( 29, 1, { 'type': '/heading' } );
				},
				'msg': 'converting partial selection of all list items to level 1 headings'
			},
			{
				'range': new ve.Range( 5, 26 ),
				'type': 'preformatted',
				'attributes': undefined,
				'expectedSelection': new ve.Range( 5, 26 ),
				'expectedData': function ( data ) {
					data.splice( 2, 1, { 'type': 'preformatted' } );
					data.splice( 9, 1, { 'type': '/preformatted' } );
					data.splice( 12, 1, { 'type': 'preformatted' } );
					data.splice( 19, 1, { 'type': '/preformatted' } );
					data.splice( 22, 1, { 'type': 'preformatted' } );
					data.splice( 29, 1, { 'type': '/preformatted' } );
				},
				'msg': 'converting partial selection of some list items to preformatted text'
			},
			{
				'range': new ve.Range( 146, 159 ),
				'type': 'paragraph',
				'attributes': undefined,
				'expectedSelection': new ve.Range( 146, 159 ),
				'expectedData': function ( data ) {
					data.splice( 145, 1, { 'type': 'paragraph' } );
					data.splice( 159, 1, { 'type': '/paragraph' } );
				},
				'msg': 'converting heading in list item to paragraph'
			},
			{
				'range': new ve.Range( 165, 180 ),
				'type': 'paragraph',
				'attributes': undefined,
				'expectedSelection': new ve.Range( 165, 180 ),
				'expectedData': function ( data ) {
					data.splice( 162, 1, { 'type': 'paragraph' } );
					data.splice( 183, 1, { 'type': '/paragraph' } );
				},
				'msg': 'converting preformatted in list item to paragraph'
			}
		];

	QUnit.expect( cases.length * 4 );
	for ( i = 0; i < cases.length; i++ ) {
		ve.test.utils.runFormatConverterTest( assert, cases[i].range, cases[i].type, cases[i].attributes, cases[i].expectedSelection, cases[i].expectedData, cases[i].msg );
	}
} );
