/*!
 * VisualEditor UserInterface Actions IndentationAction tests.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.ui.IndentationAction' );

/* Tests */

function runIndentationChangeTest( assert, range, method, expectedRange, expectedData, expectedOriginalData, msg ) {
	var surface = ve.test.utils.createSurfaceFromHtml( ve.dm.example.isolationHtml ),
		indentationAction = new ve.ui.IndentationAction( surface ),
		data = ve.copy( surface.getModel().getDocument().getFullData() ),
		originalData = ve.copy( data );

	expectedData( data );
	if ( expectedOriginalData ) {
		expectedOriginalData( originalData );
	}

	surface.getModel().setLinearSelection( range );
	indentationAction[method]();

	assert.deepEqual( surface.getModel().getDocument().getFullData(), data, msg + ': data models match' );
	assert.equalRange( surface.getModel().getSelection().getRange(), expectedRange, msg + ': ranges match' );

	surface.getModel().undo();

	assert.deepEqual( surface.getModel().getDocument().getFullData(), originalData, msg + ' (undo): data models match' );
	assert.equalRange( surface.getModel().getSelection().getRange(), range, msg + ' (undo): ranges match' );

	surface.destroy();
}

QUnit.test( 'increase/decrease', 2, function ( assert ) {
	var i,
		cases = [
			{
				range: new ve.Range( 14, 16 ),
				method: 'decrease',
				expectedRange: new ve.Range( 14, 16 ),
				expectedData: function ( data ) {
					data.splice( 11, 2, { type: '/list' }, { type: 'paragraph' } );
					data.splice( 19, 2, { type: '/paragraph' }, { type: 'list', attributes: { style: 'bullet' } } );
				},
				expectedOriginalData: function ( data ) {
					// generated: 'wrapper' is removed by the action and not restored by undo
					delete data[12].internal;
				},
				msg: 'decrease indentation on partial selection of list item "Item 2"'
			},
			{
				range: new ve.Range( 3, 19 ),
				method: 'decrease',
				expectedRange: new ve.Range( 1, 15 ),
				expectedData: function ( data ) {
					data.splice( 0, 2 );
					data.splice( 8, 2 );
					data.splice( 16, 1, { type: 'list', attributes: { style: 'bullet' } } );
					delete data[0].internal;
					delete data[8].internal;
				},
				expectedOriginalData: function ( data ) {
					// generated: 'wrapper' is removed by the action and not restored by undo
					delete data[2].internal;
					delete data[12].internal;
				},
				msg: 'decrease indentation on Items 1 & 2'
			},
			{
				range: new ve.Range( 3, 19 ),
				method: 'increase',
				expectedRange: new ve.Range( 5, 21 ),
				expectedData: function ( data ) {
					data.splice( 0, 0, { type: 'list', attributes: { style: 'bullet' } }, { type: 'listItem' } );
					data.splice( 23, 0, { type: '/list' }, { type: '/listItem' } );
				},
				msg: 'increase indentation on Items 1 & 2'
			}
		];

	QUnit.expect( cases.length * 4 );
	for ( i = 0; i < cases.length; i++ ) {
		runIndentationChangeTest( assert, cases[i].range, cases[i].method, cases[i].expectedRange, cases[i].expectedData, cases[i].expectedOriginalData, cases[i].msg );
	}
} );
