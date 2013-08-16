/*!
 * VisualEditor DataModel DocumentSynchronizer tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.DocumentSynchronizer' );

/* Tests */

QUnit.test( 'getDocument', 1, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		ds = new ve.dm.DocumentSynchronizer( doc );
	assert.strictEqual( ds.getDocument(), doc );
} );

QUnit.test( 'synchronize', 6, function ( assert ) {
	var doc = ve.dm.example.createExampleDocument(),
		ds = new ve.dm.DocumentSynchronizer( doc ),
		firstTextNodeUpdates = 0,
		firstTextNodeAnnotations = 0,
		firstTextNodeLengthChanges = [],
		secondTextNodeUpdates = 0,
		secondTextNodeAnnotations = 0,
		secondTextNodeLengthChanges = [];

	// Annotate "a" with bold formatting
	doc.data[1] = ['a', new ve.dm.AnnotationSet( doc.getStore(),
		doc.getStore().index( new ve.dm.TextStyleBoldAnnotation() ) )];
	ds.pushAnnotation( new ve.Range( 1, 2 ) );
	// Insert "xyz" between "a" and "b"
	doc.data.batchSplice( 2, 0, [ 'x', 'y', 'z' ] );
	ds.pushResize( doc.getDocumentNode().getNodeFromOffset( 2 ), 3 );
	// Annotate "d" with italic formatting (was at 10, now at 13)
	doc.data[13] = ['d', new ve.dm.AnnotationSet( doc.getStore(),
		doc.getStore().index( new ve.dm.TextStyleItalicAnnotation() ) )];
	ds.pushAnnotation( new ve.Range( 10, 11 ) );

	doc.getDocumentNode().getChildren()[0].getChildren()[0].on( 'update', function () {
		firstTextNodeUpdates++;
	} );
	doc.getDocumentNode().getChildren()[0].getChildren()[0].on( 'annotation', function () {
		firstTextNodeAnnotations++;
	} );
	doc.getDocumentNode().getChildren()[0].getChildren()[0].on( 'lengthChange', function ( diff ) {
		firstTextNodeLengthChanges.push( diff );
	} );
	doc.getDocumentNode().getChildren()[1].getChildren()[0].getChildren()[0].getChildren()[0].getChildren()[0].getChildren()[0]
		.on( 'update', function () {
			secondTextNodeUpdates++;
		} );
	doc.getDocumentNode().getChildren()[1].getChildren()[0].getChildren()[0].getChildren()[0].getChildren()[0].getChildren()[0]
		.on( 'annotation', function () {
			secondTextNodeAnnotations++;
		} );
	doc.getDocumentNode().getChildren()[1].getChildren()[0].getChildren()[0].getChildren()[0].getChildren()[0].getChildren()[0]
		.on( 'lengthChange', function ( diff ) {
			secondTextNodeLengthChanges.push( diff );
		} );
	ds.synchronize();

	// TODO technically this should be 1, not 2, see DocumentSynchronizer.synchronizers.resize
	assert.deepEqual( firstTextNodeUpdates, 2, 'annotation and insertion each trigger update event (1st paragraph)' );
	assert.deepEqual( firstTextNodeAnnotations, 1, 'annotation triggers annotation event (1st paragraph)' );
	assert.deepEqual( firstTextNodeLengthChanges, [ 3 ], 'insertion triggers lengthChange event (1st paragraph)' );
	assert.deepEqual( secondTextNodeUpdates, 1, 'annotation triggers update event (2nd paragraph)' );
	assert.deepEqual( secondTextNodeAnnotations, 1, 'annotation triggers annotation event (2nd paragraph)' );
	assert.deepEqual( secondTextNodeLengthChanges, [], 'lengthChange not triggered for 2nd paragraph' );
} );
