/*!
 * VisualEditor UserInterface WikiaInfoboxInsertDialog tests.
 */

QUnit.module( 've.ui.WikiaInfoboxInsertDialog' );

/* Tests */

QUnit.test( 'sortTemplateTitles', function () {
	var i,
		result,
		dialog = new ve.ui.WikiaInfoboxInsertDialog(),
		testCases = ve.ui.wikiaExample.sortTemplateTitlesCases,
		len = testCases.length;

	QUnit.expect( len );
	for ( i = 0; i < len; i++ ) {
		result = dialog.sortTemplateTitles.apply( dialog, [testCases[i].data] );
		QUnit.assert.deepEqual( result, testCases[i].expected );
	}
} );