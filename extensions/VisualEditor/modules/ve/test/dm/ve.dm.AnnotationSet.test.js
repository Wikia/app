/*!
 * VisualEditor AnnotationSet tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.dm.AnnotationSet' );

/* Tests */

QUnit.test( 'Basic usage', 32, function ( assert ) {
	var annotationSet3,
		store = new ve.dm.IndexValueStore(),
		bold = new ve.dm.TextStyleBoldAnnotation(),
		italic = new ve.dm.TextStyleItalicAnnotation(),
		underline = new ve.dm.TextStyleUnderlineAnnotation(),
		annotationSet = new ve.dm.AnnotationSet( store, store.indexes( [ bold, italic ] ) ),
		annotationSet2 = new ve.dm.AnnotationSet( store, store.indexes( [ italic, underline ] ) ),
		emptySet = new ve.dm.AnnotationSet( store );

	assert.equal( annotationSet.getLength(), 2, 'getLength is 2' );
	assert.equal( annotationSet.isEmpty(), false, 'isEmpty is false' );
	assert.deepEqual( annotationSet.get( 0 ), bold, 'get(0) is bold' );
	assert.equal( annotationSet.contains( italic ), true, 'contains italic' );
	assert.equal( annotationSet.contains( underline ), false, 'doesn\'t contain underline' );
	assert.equal( annotationSet.containsIndex( 1 ), true, 'contains italic by index' );
	assert.equal( annotationSet.containsIndex( 2 ), false, 'doesn\'t contain underline by index' );
	assert.equal( annotationSet.containsAnyOf( annotationSet2 ), true, 'containsAnyOf set2 is true' );
	assert.equal( annotationSet.containsAnyOf( emptySet ), false, 'containsAnyOf empty set is false' );
	assert.equal( annotationSet.containsAllOf( annotationSet2 ), false, 'containsAllOf set2 set is false' );
	assert.equal( annotationSet.containsAllOf( annotationSet ), true, 'containsAllOf self is true' );
	assert.equal( annotationSet.offsetOf( italic ), 1, 'offsetOf italic is 1' );
	assert.equal( annotationSet.offsetOf( underline ), -1, 'offsetOf underline is -1' );
	assert.deepEqual(
		annotationSet.filter( function ( annotation ) { return annotation.name === 'textStyle/bold'; } ).get(),
		[ bold ], 'filter for name=textStyle/bold returns just bold annotation'
	);
	assert.equal( annotationSet.hasAnnotationWithName( 'textStyle/bold' ), true, 'hasAnnotationWithName textStyle/bold is true' );
	assert.equal( annotationSet.hasAnnotationWithName( 'textStyle/underline' ), false, 'hasAnnotationWithName underline is false' );

	annotationSet2.add( bold, 1 );
	assert.equal( annotationSet2.offsetOf( bold ), 1, 'set2 contains bold at 1 after add at 1' );
	annotationSet2.remove( bold );
	assert.equal( annotationSet2.contains( bold ), false, 'set2 doesn\'t contain bold after remove' );
	annotationSet2.add( bold, 0 );
	assert.equal( annotationSet2.offsetOf( bold ), 0, 'set2 contains bold at 0 after add at 0' );
	annotationSet2.add( bold, 0 );
	assert.equal( annotationSet2.getLength(), 3, 'adding existing annotation doesn\'t change length' );
	// set is now [ bold, italic, underline ]
	annotationSet2.removeAt( 2 );
	assert.equal( annotationSet2.contains( underline ), false, 'set2 doesn\'t contain underline after removeAt 2' );
	annotationSet2.removeAll();
	assert.equal( annotationSet2.isEmpty(), true, 'set2 is empty after removeAll' );
	annotationSet2.addSet( annotationSet );
	assert.equal( annotationSet.getLength(), 2, 'set2 has length 2 after addSet' );
	annotationSet2.removeSet( annotationSet );
	assert.equal( annotationSet2.isEmpty(), true, 'set2 is empty after removeSet' );
	annotationSet2.push( bold );
	annotationSet2.push( italic );
	assert.deepEqual( annotationSet2.get(), [bold, italic], 'set2 contains bold then italic after two pushes' );

	annotationSet2 = new ve.dm.AnnotationSet( store, store.indexes( [ italic, underline ] ) );
	annotationSet2.removeNotInSet( annotationSet );
	assert.equal( annotationSet.contains( italic ) && !annotationSet.contains( underline ), true, 'contains italic not underline after removeNotInSet' );
	annotationSet2.add( underline, 1 );
	annotationSet3 = annotationSet2.reversed();
	assert.equal( annotationSet3.offsetOf( underline ), 0, 'underline has offsetOf 0 after reverse' );
	annotationSet3 = annotationSet.mergeWith( annotationSet2 );
	assert.equal( annotationSet3.getLength(), 3, 'set merged with set2 has length 3' );
	annotationSet3 = annotationSet.diffWith( annotationSet2 );
	assert.equal( annotationSet3.getLength(), 1, 'set diffed with set2 has length 1' );
	assert.equal( annotationSet3.contains( bold ), true, 'set diffed with set2 contains bold' );
	annotationSet3 = annotationSet.intersectWith( annotationSet2 );
	assert.equal( annotationSet3.getLength(), 1, 'set intersected with set2 has length 1' );
	assert.equal( annotationSet3.contains( italic ), true, 'set intersected with set2 contains italic' );
} );
