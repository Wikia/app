/*!
 * VisualEditor UserInterface Actions LinkAction tests.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

QUnit.module( 've.ui.LinkAction' );

/* Tests */

function runAutolinkTest( assert, html, method, range, expectedRange, expectedData, expectedOriginalData, msg ) {
	var status, actualData,
		expectFail = /^Don't/.test( msg ),
		surface = ve.test.utils.createModelOnlySurfaceFromHtml( html || ve.dm.example.html ),
		linkAction = new ve.ui.LinkAction( surface ),
		data = ve.copy( surface.getModel().getDocument().getFullData() ),
		originalData = ve.copy( data ),
		makeLinkAnnotation = function ( linktext ) {
			return linkAction.getLinkAnnotation( linktext ).element;
		};

	expectedData( data, makeLinkAnnotation );
	if ( expectedOriginalData ) {
		expectedOriginalData( originalData );
	}
	surface.getModel().setLinearSelection( range );
	status = linkAction[ method ]();
	assert.equal( status, !expectFail, msg + ': action return value' );

	actualData = surface.getModel().getDocument().getFullData();
	ve.dm.example.postprocessAnnotations( actualData, surface.getModel().getDocument().getStore() );
	assert.equalLinearData( actualData, data, msg + ': data models match' );
	assert.equalRange( surface.getModel().getSelection().getRange(), expectedRange, msg + ': ranges match' );

	if ( status ) {
		surface.getModel().undo();
	}

	assert.equalLinearData( surface.getModel().getDocument().getFullData(), originalData, msg + ' (undo): data models match' );
	assert.equalRange( surface.getModel().getSelection().getRange(), expectedRange, msg + ' (undo): ranges match' );
}

QUnit.test( 'autolink', function ( assert ) {
	var i,
		cases = [
			{
				html: '<p>http://example.com xyz</p>',
				range: new ve.Range( 1, 20 ),
				method: 'autolinkUrl',
				expectedRange: new ve.Range( 20, 20 ),
				expectedData: function ( data, makeAnnotation ) {
					var i,
						a = makeAnnotation( 'http://example.com' );
					for ( i = 1; i < 19; i++ ) {
						data[ i ] = [ data[ i ], [ a ] ];
					}
				},
				msg: 'Autolink after space'
			},
			{
				html: '<p>http://example.com</p><p>xyz</p>',
				range: new ve.Range( 1, 21 ),
				method: 'autolinkUrl',
				expectedRange: new ve.Range( 21, 21 ),
				expectedData: function ( data, makeAnnotation ) {
					var i,
						a = makeAnnotation( 'http://example.com' );
					for ( i = 1; i < 19; i++ ) {
						data[ i ] = [ data[ i ], [ a ] ];
					}
				},
				msg: 'Autolink after newline'
			},
			{
				html: '<p>Http://Example.COm xyz</p>',
				range: new ve.Range( 1, 20 ),
				method: 'autolinkUrl',
				expectedRange: new ve.Range( 20, 20 ),
				expectedData: function ( data, makeAnnotation ) {
					var i,
						a = makeAnnotation( 'Http://Example.COm' );
					for ( i = 1; i < 19; i++ ) {
						data[ i ] = [ data[ i ], [ a ] ];
					}
				},
				msg: 'Autolink with mixed case'
			},
			{
				html: '<p>http://example.com.) xyz</p>',
				range: new ve.Range( 1, 22 ),
				method: 'autolinkUrl',
				expectedRange: new ve.Range( 22, 22 ),
				expectedData: function ( data, makeAnnotation ) {
					var i,
						a = makeAnnotation( 'http://example.com' );
					for ( i = 1; i < 19; i++ ) {
						data[ i ] = [ data[ i ], [ a ] ];
					}
				},
				msg: 'Strip trailing punctuation'
			},
			{
				html: '<p>"http://example.com" xyz</p>',
				range: new ve.Range( 2, 22 ),
				method: 'autolinkUrl',
				expectedRange: new ve.Range( 22, 22 ),
				expectedData: function ( data, makeAnnotation ) {
					var i,
						a = makeAnnotation( 'http://example.com' );
					for ( i = 2; i < 20; i++ ) {
						data[ i ] = [ data[ i ], [ a ] ];
					}
				},
				msg: 'Strip trailing quotes'
			},
			{
				html: '<p>http://.) xyz</p>',
				range: new ve.Range( 1, 11 ),
				method: 'autolinkUrl',
				expectedRange: new ve.Range( 1, 11 ),
				expectedData: function ( /*data, makeAnnotation*/ ) {
					/* no change, no link */
				},
				msg: 'Don\'t link if stripping leaves bare protocol'
			}
		];

	QUnit.expect( cases.length * 5 );
	for ( i = 0; i < cases.length; i++ ) {
		runAutolinkTest( assert, cases[ i ].html, cases[ i ].method, cases[ i ].range, cases[ i ].expectedRange, cases[ i ].expectedData, cases[ i ].expectedOriginalData, cases[ i ].msg );
	}
} );
