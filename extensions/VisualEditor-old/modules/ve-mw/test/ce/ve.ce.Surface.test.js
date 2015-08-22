/*!
 * VisualEditor ContentEditable Surface tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.Surface' );

/* Tests */

QUnit.test( 'handleDelete', function ( assert ) {
	var i,
		cases = [
			{
				'html':
					'<p>Foo</p>' +
					ve.dm.mwExample.MWTransclusion.blockOpen + ve.dm.mwExample.MWTransclusion.blockContent +
					'<p>Bar</p>',
				'range': new ve.Range( 4 ),
				'operations': ['delete'],
				'expectedData': function () {},
				'expectedRange': new ve.Range( 5, 7 ),
				'msg': 'Block transclusion is focused not deleted'
			},
			{
				'html':
					'<p>Foo</p>' +
					ve.dm.mwExample.MWTransclusion.blockOpen + ve.dm.mwExample.MWTransclusion.blockContent +
					'<p>Bar</p>',
				'range': new ve.Range( 4 ),
				'operations': ['delete', 'delete'],
				'expectedData': function ( data ) {
					data.splice( 5, 2 );
				},
				'expectedRange': new ve.Range( 5, 5 ),
				'msg': 'Block transclusion is deleted with two keypresses'
			},
			{
				'html':
					'<p>Foo</p>' +
					ve.dm.mwExample.MWBlockImage.html +
					'<p>Bar</p>',
				'range': new ve.Range( 4 ),
				'operations': ['delete'],
				'expectedData': function () { },
				'expectedRange': new ve.Range( 5, 14 ),
				'msg': 'Block image is focused not deleted'
			},
			{
				'html':
					ve.dm.mwExample.MWBlockImage.html +
					'<ul><li><p>Foo</p></li><li><p>Bar</p></li></ul>',
				'range': new ve.Range( 12 ),
				'operations': ['backspace'],
				// TODO: This action should probably unwrap the list item as
				'expectedData': function () {},
				'expectedRange': new ve.Range( 12 ),
				'msg': 'Backspace in a list next to a block image doesn\'t merge into the caption'
			}
		];

	QUnit.expect( cases.length * 2 );

	for ( i = 0; i < cases.length; i++ ) {
		ve.test.utils.runSurfaceHandleSpecialKeyTest(
			assert, cases[i].html, cases[i].range, cases[i].operations,
			cases[i].expectedData, cases[i].expectedRange, cases[i].msg
		);
	}
} );
