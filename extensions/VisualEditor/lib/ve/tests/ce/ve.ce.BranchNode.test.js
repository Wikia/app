/*!
 * VisualEditor ContentEditable BranchNode tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.ce.BranchNode' );

/* Stubs */

ve.ce.BranchNodeStub = function VeCeBranchNodeStub( model, $element ) {
	// Parent constructor
	ve.ce.BranchNode.call( this, model, $element );
};

OO.inheritClass( ve.ce.BranchNodeStub, ve.ce.BranchNode );

ve.ce.BranchNodeStub.static.name = 'branch-stub';

ve.ce.BranchNodeStub.static.splitOnEnter = true;

ve.ce.BranchNodeStub.prototype.getTagName = function () {
	var style = this.model.getAttribute( 'style' ),
		types = { a: 'a', b: 'b' };

	return types[style];
};

ve.ce.nodeFactory.register( ve.ce.BranchNodeStub );

/* Tests */

QUnit.test( 'splitOnEnter', 1, function ( assert ) {
	var node = new ve.ce.BranchNodeStub( new ve.dm.BranchNodeStub() );

	assert.strictEqual( node.splitOnEnter(), true );
} );

QUnit.test( 'canHaveChildren', 1, function ( assert ) {
	var node = new ve.ce.BranchNodeStub( new ve.dm.BranchNodeStub() );

	assert.strictEqual( node.canHaveChildren(), true );
} );

QUnit.test( 'canHaveChildrenNotContent', 1, function ( assert ) {
	var node = new ve.ce.BranchNodeStub( new ve.dm.BranchNodeStub() );

	assert.strictEqual( node.canHaveChildrenNotContent(), true );
} );

QUnit.test( 'updateTagName', 4, function ( assert ) {
	var attributes = { style: 'a' },
		node = new ve.ce.BranchNodeStub( new ve.dm.BranchNodeStub( {
			type: 'branch-stub',
			attributes: attributes
		} ) );

	// Add content to the node
	node.$element.text( 'hello' );

	// Modify attribute
	attributes.style = 'b';
	node.updateTagName();

	assert.strictEqual( node.$element.get( 0 ).nodeName.toLowerCase(), 'b', 'DOM element type gets converted' );
	assert.strictEqual( node.$element.hasClass( 've-ce-branchNode' ), true, 'old classes are added to new wrapper' );
	assert.strictEqual( !!node.$element.data( 'view' ), true, 'data added to new wrapper' );
	assert.strictEqual( node.$element.text(), 'hello', 'contents are added to new wrapper' );
} );

QUnit.test( 'onSplice', 7, function ( assert ) {
	var modelA = new ve.dm.BranchNodeStub(),
		modelB = new ve.dm.BranchNodeStub(),
		modelC = new ve.dm.BranchNodeStub(),
		viewA = new ve.ce.BranchNodeStub( modelA );

	// Insertion tests
	modelA.splice( 0, 0, modelB, modelC );

	assert.strictEqual( viewA.getChildren().length, 2 );
	assert.deepEqual( viewA.getChildren()[0].getModel(), modelB );
	assert.deepEqual( viewA.getChildren()[1].getModel(), modelC );

	// Removal tests
	modelA.splice( 0, 1 );

	assert.strictEqual( viewA.getChildren().length, 1 );
	assert.deepEqual( viewA.getChildren()[0].getModel(), modelC );

	// Removal and insertion tests
	modelA.splice( 0, 1, modelB );

	assert.strictEqual( viewA.getChildren().length, 1 );
	assert.deepEqual( viewA.getChildren()[0].getModel(), modelB );
} );
