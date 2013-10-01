/*!
 * VisualEditor UserInterface Actions ListAction tests.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

QUnit.module( 've.ui.ListAction' );

/* Tests */

function runListConverterTest( assert, html, method, style, range, expectedSelection, expectedData, expectedOriginalData, msg ) {
	var selection,
		surface = ve.test.utils.createSurfaceFromHtml( html || ve.dm.example.html ),
		listAction = new ve.ui.ListAction( surface ),
		data = ve.copy( surface.getModel().getDocument().getFullData() ),
		originalData = ve.copy( data );

	expectedData( data );
	if ( expectedOriginalData ) {
		expectedOriginalData( originalData );
	}
	surface.getModel().change( null, range );
	listAction[method]( style );

	assert.deepEqual( surface.getModel().getDocument().getFullData(), data, msg + ': data models match' );
	assert.deepEqual( surface.getModel().getSelection(), expectedSelection, msg + ': selections match' );

	selection = surface.getModel().undo();

	assert.deepEqual( surface.getModel().getDocument().getFullData(), originalData, msg + ' (undo): data models match' );
	assert.deepEqual( selection, range, msg + ' (undo): selections match' );

	surface.destroy();
}

QUnit.test( '(un)wrap', function ( assert ) {
	var i,
		cases = [
			{
				'range': new ve.Range( 56, 60 ),
				'method': 'wrap',
				'style': 'bullet',
				'expectedSelection': new ve.Range( 58, 64 ),
				'expectedData': function ( data ) {
					data.splice( 55, 0, { 'type': 'list', 'attributes': { 'style': 'bullet' } }, { 'type': 'listItem' } );
					data.splice( 60, 0, { 'type': '/listItem' }, { 'type': 'listItem' } );
					data.splice( 65, 0, { 'type': '/listItem' }, { 'type': '/list' } );
				},
				'msg': 'wrapping two paragraphs in a list'
			},
			{
				'html': ve.dm.example.isolationHtml,
				'range': new ve.Range( 191, 211 ),
				'method': 'unwrap',
				'style': 'bullet',
				'expectedSelection': new ve.Range( 187, 205 ),
				'expectedData': function ( data ) {
					delete data[190].internal;
					delete data[202].internal;
					data.splice( 186, 4 );
					data.splice( 196, 2 );
					data.splice( 206, 2,
						{ 'type': 'list', 'attributes': { 'style': 'bullet' } },
						{ 'type': 'listItem' },
						{ 'type': 'list', 'attributes': { 'style': 'number' } },
						{ 'type': 'listItem' }
					 );
				},
				'expectedOriginalData': function ( data ) {
					// generated: 'wrapper' is removed by the action and not restored by undo
					delete data[190].internal;
					delete data[202].internal;
				},
				'msg': 'unwrapping two double listed paragraphs'
			}
		];

	QUnit.expect( cases.length * 4 );
	for ( i = 0; i < cases.length; i++ ) {
		runListConverterTest( assert, cases[i].html, cases[i].method, cases[i].style, cases[i].range, cases[i].expectedSelection, cases[i].expectedData, cases[i].expectedOriginalData, cases[i].msg );
	}
} );
