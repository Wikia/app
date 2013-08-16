/*!
 * VisualEditor Document tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.Document' );

/* Stubs */

ve.DocumentStub = function VeDocumentStub( documentNode ) {
	// Parent constructor
	ve.Document.call( this, documentNode );
};

ve.inheritClass( ve.DocumentStub, ve.Document );

/* Tests */

QUnit.test( 'getDocumentNode', 1, function ( assert ) {
	var node = new ve.NodeStub(),
		doc = new ve.DocumentStub( node );
	assert.strictEqual( doc.getDocumentNode( node ), node );
} );
