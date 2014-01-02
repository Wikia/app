/*!
 * VisualEditor UserInterface Trigger tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ui.Trigger' );

/* Tests */

QUnit.test( 'constructor', function ( assert ) {
	function event( options ) {
		return jQuery.Event( 'keydown', options );
	}
	var i, len,
		tests = [
			{
				'trigger': 'ctrl+b',
				'event': event( { 'ctrlKey': true, 'which': 66 } )
			}
		];
	QUnit.expect( 2 * tests.length );
	for ( i = 0, len = tests.length; i < len; i++ ) {
		assert.equal(
			new ve.ui.Trigger( tests[i].trigger ).toString(),
			tests[i].trigger,
			'trigger is parsed correctly'
		);
		assert.equal(
			new ve.ui.Trigger( tests[i].event ).toString(),
			tests[i].trigger,
			'event is parsed correctly'
		);
	}
} );
