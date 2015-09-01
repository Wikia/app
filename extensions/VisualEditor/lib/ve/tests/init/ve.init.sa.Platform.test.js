/*!
 * VisualEditor tests for ve.init.sa.Platform.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.init.sa.Platform', {
	setup: function () {
		this.purgeKeys = function () {
			var i, keys = [];
			for ( i = 0; i < localStorage.length; i++ ) {
				keys.push( localStorage.key( i ) );
			}
			// Get keys first since key index is live
			keys.forEach( function ( key ) {
				if ( key.indexOf( 've-test-' ) === 0 ) {
					localStorage.removeItem( key );
				}
			} );
		};
		this.purgeKeys();
	},
	teardown: function () {
		this.purgeKeys();
	}
} );

QUnit.test( 'getUserConfig', 4, function ( assert ) {
	var platform = new ve.init.sa.Platform();

	assert.strictEqual( platform.getUserConfig( 'test-1' ), null, 'unknown key' );
	assert.propEqual(
		platform.getUserConfig( [ 'test-1', 'test-2' ] ),
		{ 'test-1': null, 'test-2': null },
		'multiple unknown keys'
	);

	platform.setUserConfig( { 'test-1': 'a', 'test-2': 'b' } );

	assert.strictEqual( platform.getUserConfig( 'test-1' ), 'a', 'get value' );
	assert.propEqual(
		platform.getUserConfig( [ 'test-1', 'test-2' ] ),
		{ 'test-1': 'a', 'test-2': 'b' },
		'get multiple values'
	);
} );

QUnit.test( 'setUserConfig', 4, function ( assert ) {
	var platform = new ve.init.sa.Platform();

	assert.strictEqual( platform.setUserConfig( 'test-1', 'one' ), true, 'set key' );
	assert.strictEqual( platform.getUserConfig( 'test-1' ), 'one', 'value persists' );

	assert.strictEqual(
		platform.setUserConfig( { 'test-1': 'one more', 'test-2': 'two' } ),
		true,
		'set multiple keys'
	);
	assert.propEqual(
		platform.getUserConfig( [ 'test-1', 'test-2' ] ),
		{ 'test-1': 'one more', 'test-2': 'two' },
		'multiple values persist'
	);
} );
