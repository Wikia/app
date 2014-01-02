/*!
 * VisualEditor ContentEditable NodeFactory tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.NodeFactory' );

/* Stubs */

ve.ce.NodeFactoryNodeStub = function VeCeNodeFactoryNodeStub( a, b ) {
	this.a = a;
	this.b = b;
};

ve.inheritClass( ve.ce.NodeFactoryNodeStub, ve.ce.LeafNode );

ve.ce.NodeFactoryNodeStub.static.name = 'node-factory-node-stub';

/* Tests */

QUnit.test( 'canNodeBeSplit', 2, function ( assert ) {
	var factory = new ve.ce.NodeFactory();

	assert.throws( function () {
			factory.canNodeBeSplit( 'node-factory-node-stub' );
		},
		Error,
		'throws an exception when getting split rules for a node of an unregistered type'
	);
	factory.register( ve.ce.NodeFactoryNodeStub );

	assert.strictEqual(
		factory.canNodeBeSplit( 'node-factory-node-stub' ),
		false,
		'gets split rules for registered nodes'
	);
} );

QUnit.test( 'initialization', 1, function ( assert ) {
	assert.ok( ve.ce.nodeFactory instanceof ve.ce.NodeFactory, 'factory is initialized at ve.ce.nodeFactory' );
} );
