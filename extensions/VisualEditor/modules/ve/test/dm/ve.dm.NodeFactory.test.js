/*!
 * VisualEditor DataModel NodeFactory tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.NodeFactory' );

/* Stubs */

ve.dm.NodeFactoryNodeStub = function VeDmNodeFactoryNodeStub( a, b ) {
	this.a = a;
	this.b = b;
};

ve.inheritClass( ve.dm.NodeFactoryNodeStub, ve.dm.LeafNode );

ve.dm.NodeFactoryNodeStub.static.name = 'node-factory-node-stub';

ve.dm.NodeFactoryNodeStub.static.isContent = true;

ve.dm.NodeFactoryNodeStub.static.matchTagNames = [];

/* Tests */

QUnit.test( 'getChildNodeTypes', 2, function ( assert ) {
	var factory = new ve.dm.NodeFactory();
	assert.throws( function () {
			factory.getChildNodeTypes( 'node-factory-node-stub', 23, { 'bar': 'baz' } );
		},
		Error,
		'throws an exception when getting allowed child nodes of a node of an unregistered type'
	);
	factory.register( ve.dm.NodeFactoryNodeStub );
	assert.deepEqual(
		factory.getChildNodeTypes( 'node-factory-node-stub' ),
		[],
		'gets child type rules for registered nodes'
	);
} );

QUnit.test( 'getParentNodeTypes', 2, function ( assert ) {
	var factory = new ve.dm.NodeFactory();
	assert.throws( function () {
			factory.getParentNodeTypes( 'node-factory-node-stub', 23, { 'bar': 'baz' } );
		},
		Error,
		'throws an exception when getting allowed parent nodes of a node of an unregistered type'
	);
	factory.register( ve.dm.NodeFactoryNodeStub );
	assert.deepEqual(
		factory.getParentNodeTypes( 'node-factory-node-stub' ),
		null,
		'gets parent type rules for registered nodes'
	);
} );

QUnit.test( 'canNodeHaveChildren', 2, function ( assert ) {
	var factory = new ve.dm.NodeFactory();
	assert.throws( function () {
			factory.canNodeHaveChildren( 'node-factory-node-stub', 23, { 'bar': 'baz' } );
		},
		Error,
		'throws an exception when checking if a node of an unregistered type can have children'
	);
	factory.register( ve.dm.NodeFactoryNodeStub );
	assert.strictEqual(
		factory.canNodeHaveChildren( 'node-factory-node-stub' ),
		false,
		'gets child rules for registered nodes'
	);
} );

QUnit.test( 'canNodeHaveChildrenNotContent', 2, function ( assert ) {
	var factory = new ve.dm.NodeFactory();
	assert.throws( function () {
			factory.canNodeHaveChildrenNotContent( 'node-factory-node-stub', 23, { 'bar': 'baz' } );
		},
		Error,
		'throws an exception when checking if a node of an unregistered type can have grandchildren'
	);
	factory.register( ve.dm.NodeFactoryNodeStub );
	assert.strictEqual(
		factory.canNodeHaveChildrenNotContent( 'node-factory-node-stub' ),
		false,
		'gets grandchild rules for registered nodes'
	);
} );

QUnit.test( 'initialization', 1, function ( assert ) {
	assert.ok( ve.dm.nodeFactory instanceof ve.dm.NodeFactory, 'factory is initialized at ve.dm.nodeFactory' );
} );
