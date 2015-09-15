/*!
 * VisualEditor UserInterface WikiaInfoboxInsertDialog tests.
 */

QUnit.module( 've.ui.WikiaInfoboxInsertDialog' );

/* Tests */

QUnit.test( 'sortTemplateTitles', function ( assert ) {
	var i,
		result,
		testCases = ve.ui.wikiaExample.sortTemplateTitlesCases,
		len = testCases.length,
		dialog = new ve.ui.WikiaInfoboxInsertDialog();

	QUnit.expect( len );
	for ( i = 0; i < len; i++ ) {
		result = dialog.sortTemplateTitles.apply( dialog, [ testCases[i].data ] );
		assert.equal( result, testCases[i].expected );
	}
} );