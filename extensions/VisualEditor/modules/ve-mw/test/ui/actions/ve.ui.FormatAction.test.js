/*!
 * VisualEditor UserInterface Actions FormatAction tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ui.FormatAction' );

/* Tests */

QUnit.test( 'convert (MW-specific types)', function ( assert ) {
	var i,
		cases = [
			{
				'range': new ve.Range( 14, 16 ),
				'type': 'mwHeading',
				'attributes': { level: 2 },
				'expectedSelection': new ve.Range( 14, 16 ),
				'expectedData': function ( data ) {
					data.splice( 11, 2, { 'type': '/list' }, { 'type': 'mwHeading', 'attributes': { 'level': 2 } } );
					data.splice( 19, 2, { 'type': '/mwHeading' }, { 'type': 'list', 'attributes': { 'style': 'bullet' } } );
				},
				'msg': 'converting partial selection of list item "Item 2" to level 2 mwHeading'
			},
			{
				'range': new ve.Range( 15, 50 ),
				'type': 'mwHeading',
				'attributes': { level: 3 },
				'expectedSelection': new ve.Range( 15, 44 ),
				'expectedData': function ( data ) {
					data.splice( 11, 2, { 'type': '/list' }, { 'type': 'mwHeading', 'attributes': { 'level': 3 } } );
					data.splice( 19, 4, { 'type': '/mwHeading' }, { 'type': 'mwHeading', 'attributes': { 'level': 3 } } );
					data.splice( 27, 4, { 'type': '/mwHeading' }, { 'type': 'mwHeading', 'attributes': { 'level': 3 } } );
					data.splice( 38, 4, { 'type': '/mwHeading' }, { 'type': 'mwHeading', 'attributes': { 'level': 3 } } );
					data.splice( 46, 2, { 'type': '/mwHeading' }, { 'type': 'list', 'attributes': { 'style': 'bullet' } } );
				},
				'msg': 'converting partial selection across two lists surrounding a paragraph'
			},
			{
				'range': new ve.Range( 4, 28 ),
				'type': 'mwHeading',
				'attributes': { level: 1 },
				'expectedSelection': new ve.Range( 2, 22 ),
				'expectedData': function ( data ) {
					data.splice( 0, 3, { 'type': 'mwHeading', 'attributes': { 'level': 1 } } );
					data.splice( 7, 4, { 'type': '/mwHeading' }, { 'type': 'mwHeading', 'attributes': { 'level': 1 } } );
					data.splice( 15, 4, { 'type': '/mwHeading' }, { 'type': 'mwHeading', 'attributes': { 'level': 1 } } );
					data.splice( 23, 3, { 'type': '/mwHeading' } );
				},
				'msg': 'converting partial selection of all list items to level 1 MWheadings'
			},
			{
				'range': new ve.Range( 5, 26 ),
				'type': 'mwPreformatted',
				'attributes': undefined,
				'expectedSelection': new ve.Range( 3, 20 ),
				'expectedData': function ( data ) {
					data.splice( 0, 3, { 'type': 'mwPreformatted' } );
					data.splice( 7, 4, { 'type': '/mwPreformatted' }, { 'type': 'mwPreformatted' } );
					data.splice( 15, 4, { 'type': '/mwPreformatted' }, { 'type': 'mwPreformatted' } );
					data.splice( 23, 3, { 'type': '/mwPreformatted' } );
				},
				'msg': 'converting partial selection of some list items to mwPreformatted text'
			}
		];

	QUnit.expect( cases.length * 4 );
	for ( i = 0; i < cases.length; i++ ) {
		ve.test.utils.runFormatConverterTest( assert, cases[i].range, cases[i].type, cases[i].attributes, cases[i].expectedSelection, cases[i].expectedData, cases[i].msg );
	}
} );
