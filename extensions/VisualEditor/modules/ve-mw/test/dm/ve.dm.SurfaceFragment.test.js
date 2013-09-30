/*!
 * VisualEditor DataModel MediaWiki-specific SurfaceFragment tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.SurfaceFragment' );

/* Tests */

QUnit.test( 'isolateAndUnwrap (MWheading)', 3, function ( assert ) {
	ve.test.utils.runIsolateTest( assert, 'mwHeading', new ve.Range( 12, 20 ), function ( data ) {
		data.splice( 11, 0, { 'type': '/list' } );
		data.splice( 12, 1 );
		data.splice( 20, 1, { 'type': 'list', 'attributes': { 'style': 'bullet' } } );
	}, 'isolating paragraph in list item "Item 2" for MWheading' );

	ve.test.utils.runIsolateTest( assert, 'mwHeading', new ve.Range( 89, 97 ), function ( data ) {
		data.splice( 88, 1,
			{ 'type': '/tableRow' },
			{ 'type': '/tableSection' },
			{ 'type': '/table' }
		);
		data.splice( 99, 1,
			{ 'type': 'table' },
			{ 'type': 'tableSection', 'attributes': { 'style': 'body' } },
			{ 'type': 'tableRow' }
		);
	}, 'isolating "Cell 2" for MWheading' );

	ve.test.utils.runIsolateTest( assert, 'mwHeading', new ve.Range( 202, 212 ), function ( data ) {
		data.splice( 201, 1,
			{ 'type': '/list' }, { 'type': '/listItem' }, { 'type': '/list' }
		);
		data.splice( 214, 1,
			{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
			{ 'type': 'listItem' },
			{ 'type': 'list', 'attributes': { 'style': 'number' } }
		);
	}, 'isolating paragraph in list item "Nested 2" for MWheading' );
} );
