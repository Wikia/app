/*!
 * VisualEditor Factory tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.Factory' );

/* Stubs */

ve.FactoryObjectStub = function VeFactoryObjectStub( a, b, c, d ) {
	this.a = a;
	this.b = b;
	this.c = c;
	this.d = d;
};

/* Tests */

QUnit.test( 'register', 3, function ( assert ) {
	var factory = new ve.Factory();
	assert.throws(
		function () {
			factory.register( 'factory-object-stub', 'not-a-function' );
		},
		Error,
		'Throws an exception when trying to register a non-function value as a constructor'
	);

	factory.register( ['factory-object-stub-1', 'factory-object-stub-2'], ve.FactoryObjectStub );
	assert.strictEqual( factory.lookup( 'factory-object-stub-1' ), ve.FactoryObjectStub );
	assert.strictEqual( factory.lookup( 'factory-object-stub-2' ), ve.FactoryObjectStub );
} );

QUnit.test( 'create', 3, function ( assert ) {
	var obj,
		factory = new ve.Factory();

	assert.throws(
		function () {
			factory.create( 'factory-object-stub', 23, 'foo', { 'bar': 'baz' } );
		},
		Error,
		'Throws an exception when trying to create a object of an unregistered type'
	);

	factory.register( 'factory-object-stub', ve.FactoryObjectStub );

	obj = factory.create( 'factory-object-stub', 16, 'foo', { 'baz': 'quux' }, 5 );

	assert.deepEqual(
		obj,
		new ve.FactoryObjectStub( 16, 'foo', { 'baz': 'quux' }, 5 ),
		'Creates an object of the registered type and passes through arguments'
	);

	assert.strictEqual(
		obj instanceof ve.FactoryObjectStub,
		true,
		'Creates an object that is an instanceof the registered constructor'
	);
} );

QUnit.test( 'lookup', 1, function ( assert ) {
	var factory = new ve.Factory();
	factory.register( 'factory-object-stub', ve.FactoryObjectStub );
	assert.strictEqual( factory.lookup( 'factory-object-stub' ), ve.FactoryObjectStub );
} );
