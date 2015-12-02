/*!
 * VisualEditor ContentEditable MediaWiki-specific Surface tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.Surface' );

/* Tests */

QUnit.test( 'handleLinearDelete', function ( assert ) {
	var i,
		cases = [
			// This asserts that getRelativeRange (via getRelativeOffset) doesn't try to
			// enter a handleOwnChildren node
			{
				html:
					ve.dm.mwExample.MWBlockImage.html +
					'<ul><li><p>Foo</p></li><li><p>Bar</p></li></ul>',
				range: new ve.Range( 12 ),
				operations: ['backspace'],
				// TODO: This action should probably unwrap the list item as
				expectedData: function () {},
				expectedRange: new ve.Range( 12 ),
				msg: 'Backspace in a list next to a block image doesn\'t merge into the caption'
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
