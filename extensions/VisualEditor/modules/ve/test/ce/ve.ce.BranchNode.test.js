/**
 * VisualEditor content editable BranchNode tests.
 *
 * @copyright 2011-2012 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.BranchNode' );

/* Stubs */

ve.ce.BranchNodeStub = function VeCeBranchNodeStub( model, $element ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, 'branch-stub', model, $element );
};

ve.inheritClass( ve.ce.BranchNodeStub, ve.ce.BranchNode );

ve.ce.BranchNodeStub.rules = {
	'canBeSplit': true
};

ve.ce.BranchNodeStub.domWrapperElementTypes = {
	'a': 'a',
	'b': 'b'
};

ve.ce.nodeFactory.register( 'branch-stub', ve.ce.BranchNodeStub );

/* Tests */

QUnit.test( 'canBeSplit', 1, function ( assert ) {
	var node = new ve.ce.BranchNodeStub( new ve.dm.BranchNodeStub() );

	assert.equal( node.canBeSplit(), true );
} );

QUnit.test( 'canHaveChildren', 1, function ( assert ) {
	var node = new ve.ce.BranchNodeStub( new ve.dm.BranchNodeStub() );

	assert.equal( node.canHaveChildren(), true );
} );

QUnit.test( 'canHaveGrandchildren', 1, function ( assert ) {
	var node = new ve.ce.BranchNodeStub( new ve.dm.BranchNodeStub() );

	assert.equal( node.canHaveGrandchildren(), true );
} );

QUnit.test( 'updateDomWrapper', 3, function ( assert ) {
	var node = new ve.ce.BranchNodeStub( new ve.dm.BranchNodeStub( [], {
		'type': 'a'
	} ) );

	// Add classes and content to the node
	node.$.addClass( 'test' ).text( 'hello' );

	// Modify attribute
	node.getModel().attributes.type = 'b';
	node.updateDomWrapper( 'type' );

	assert.equal( node.$.get( 0 ).nodeName.toLowerCase(), 'b', 'DOM element type gets converted' );
	assert.equal( node.$.hasClass( 'test' ), true, 'old classes are added to new wrapper' );
	assert.equal( node.$.text(), 'hello', 'contents are added to new wrapper' );
} );

QUnit.test( 'onSplice', 7, function ( assert ) {
	var modelA = new ve.dm.BranchNodeStub(),
		modelB = new ve.dm.BranchNodeStub(),
		modelC = new ve.dm.BranchNodeStub(),
		viewA = new ve.ce.BranchNodeStub( modelA );

	// Insertion tests
	modelA.splice( 0, 0, modelB, modelC );

	assert.equal( viewA.getChildren().length, 2 );
	assert.deepEqual( viewA.getChildren()[0].getModel(), modelB );
	assert.deepEqual( viewA.getChildren()[1].getModel(), modelC );

	// Removal tests
	modelA.splice( 0, 1 );

	assert.equal( viewA.getChildren().length, 1 );
	assert.deepEqual( viewA.getChildren()[0].getModel(), modelC );

	// Removal and insertion tests
	modelA.splice( 0, 1, modelB );

	assert.equal( viewA.getChildren().length, 1 );
	assert.deepEqual( viewA.getChildren()[0].getModel(), modelB );
} );
