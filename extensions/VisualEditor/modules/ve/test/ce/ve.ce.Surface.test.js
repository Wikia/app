/*!
 * VisualEditor ContentEditable Surface tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ce.Surface' );

/* Tests */

QUnit.test( 'handleDelete', function ( assert ) {
	var i,
		surface = ve.test.utils.createSurfaceFromHtml( ve.dm.example.html ),
		view = surface.getView(),
		model = surface.getModel(),
		data = ve.copy( model.getDocument().getFullData() ),
		originalData = ve.copy( data ),
		deleteArgs = {
			'backspace': [ {}, true ],
			'delete': [ {}, false ],
			'modifiedBackspace': [ { 'ctrlKey': true }, true ],
			'modifiedDelete': [ { 'ctrlKey': true }, false ]
		},
		cases = [
			{
				'range': new ve.Range( 2 ),
				'operations': ['backspace'],
				'expectedData': function ( data ) {
					data.splice( 1, 1 );
				},
				'expectedRange': new ve.Range( 1 ),
				'msg': 'Character deleted by backspace'
			},
			{
				'range': new ve.Range( 2 ),
				'operations': ['delete'],
				'expectedData': function ( data ) {
					data.splice( 2, 1 );
				},
				'expectedRange': new ve.Range( 2 ),
				'msg': 'Character deleted by delete'
			},
			{
				'range': new ve.Range( 1, 4 ),
				'operations': ['backspace'],
				'expectedData': function ( data ) {
					data.splice( 1, 3 );
				},
				'expectedRange': new ve.Range( 1 ),
				'msg': 'Selection deleted by backspace'
			},
			{
				'range': new ve.Range( 1, 4 ),
				'operations': ['delete'],
				'expectedData': function ( data ) {
					data.splice( 1, 3 );
				},
				'expectedRange': new ve.Range( 1 ),
				'msg': 'Selection deleted by delete'
			},
			{
				'range': new ve.Range( 4 ),
				'operations': ['modifiedBackspace'],
				'expectedData': function ( data ) {
					data.splice( 1, 3 );
				},
				'expectedRange': new ve.Range( 1 ),
				'msg': 'Whole word deleted by modified backspace'
			},
			{
				'range': new ve.Range( 1 ),
				'operations': ['modifiedDelete'],
				'expectedData': function ( data ) {
					data.splice( 1, 3 );
				},
				'expectedRange': new ve.Range( 1 ),
				'msg': 'Whole word deleted by modified delete'
			},
			{
				'range': new ve.Range( 1, 4 ),
				'operations': ['delete', 'delete'],
				'expectedData': function ( data ) {
					data.splice( 0, 5 );
				},
				'expectedRange': new ve.Range( 1 ),
				'msg': 'Empty node deleted by delete'
			}
		];

	function testRunner( range, operations, expectedData, expectedRange, msg ) {
		var i, args, data = ve.copy( originalData );
		model.change( null, range );
		for ( i = 0; i < operations.length; i++ ) {
			args = deleteArgs[operations[i]];
			view.handleDelete( args[0], args[1] );
		}
		expectedData( data );

		assert.deepEqual( model.getDocument().getFullData(), data, msg + ': data' );
		assert.deepEqual( model.getSelection(), expectedRange, msg + ': range' );

		// Roll back the test Surface
		while ( model.undo() ) {
			/*jshint noempty:false */
		}
	}

	QUnit.expect( cases.length * 2 );

	for ( i = 0; i < cases.length; i++ ) {
		testRunner( cases[i].range, cases[i].operations, cases[i].expectedData, cases[i].expectedRange, cases[i].msg );
	}
} );

/* Methods with return values */
// TODO: ve.ce.Surface.static.getClipboardHash
// TODO: ve.ce.Surface#hasSlugAtOffset
// TODO: ve.ce.Surface#getClickCount
// TODO: ve.ce.Surface#needsPawn
// TODO: ve.ce.Surface#getSurface
// TODO: ve.ce.Surface#getModel
// TODO: ve.ce.Surface#getDocument
// TODO: ve.ce.Surface#getFocusedNode
// TODO: ve.ce.Surface#isRenderingLocked
// TODO: ve.ce.Surface#getDir

/* Methods without return values */
// TODO: ve.ce.Surface.static.textPattern
// TODO: ve.ce.Surface#getSelectionRect
// TODO: ve.ce.Surface#initialize
// TODO: ve.ce.Surface#enable
// TODO: ve.ce.Surface#disable
// TODO: ve.ce.Surface#destroy
// TODO: ve.ce.Surface#focus
// TODO: ve.ce.Surface#documentOnFocus
// TODO: ve.ce.Surface#documentOnBlur
// TODO: ve.ce.Surface#onDocumentMouseDown
// TODO: ve.ce.Surface#onDocumentMouseUp
// TODO: ve.ce.Surface#onDocumentMouseMove
// TODO: ve.ce.Surface#onDocumentDragOver
// TODO: ve.ce.Surface#onDocumentDrop
// TODO: ve.ce.Surface#onDocumentKeyDown
// TODO: ve.ce.Surface#onDocumentKeyPress
// TODO: ve.ce.Surface#afterDocumentKeyPress
// TODO: ve.ce.Surface#onDocumentKeyUp
// TODO: ve.ce.Surface#onCut
// TODO: ve.ce.Surface#onCopy
// TODO: ve.ce.Surface#onPaste
// TODO: ve.ce.Surface#beforePaste
// TODO: ve.ce.Surface#afterPaste
// TODO: ve.ce.Surface#onDocumentCompositionEnd
// TODO: ve.ce.Surface#onChange
// TODO: ve.ce.Surface#onSelectionChange
// TODO: ve.ce.Surface#onContentChange
// TODO: ve.ce.Surface#onLock
// TODO: ve.ce.Surface#onUnlock
// TODO: ve.ce.Surface#startRelocation
// TODO: ve.ce.Surface#endRelocation
// TODO: ve.ce.Surface#handleLeftOrRightArrowKey
// TODO: ve.ce.Surface#handleUpOrDownArrowKey
// TODO: ve.ce.Surface#handleInsertion
// TODO: ve.ce.Surface#handleEnter
// TODO: ve.ce.Surface#handleDelete
// TODO: ve.ce.Surface#showSelection
// TODO: ve.ce.Surface#replacePhantoms
// TODO: ve.ce.Surface#replaceHighlight
// TODO: ve.ce.Surface#getNearestCorrectOffset
// TODO: ve.ce.Surface#incRenderLock
// TODO: ve.ce.Surface#decRenderLock
