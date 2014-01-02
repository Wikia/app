/*!
 * VisualEditor LeafNode tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.LeafNode' );

/* Stubs */

ve.LeafNodeStub = function VeLeafNodeStub() {
	// Parent constructor
	ve.LeafNode.call( this );
};

ve.inheritClass( ve.LeafNodeStub, ve.LeafNode );

ve.LeafNodeStub.static.name = 'leaf-stub';

/* Tests */
