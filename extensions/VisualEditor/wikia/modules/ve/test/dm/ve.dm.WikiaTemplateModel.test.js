/*!
 * VisualEditor DataModel WikiaTemplateModel tests.
 */

QUnit.module( 've.dm.WikiaTemplateModel' );

/* Tests */

QUnit.test( 'WikiaTemplateModel', function ( assert ) {
	var templateModel, serialize, wikitext, originalData = {
		'target': { 'wt': 'foo' },
		'params': {
			'name': { 'wt': 'Christian' }
		}
	};

	// Create template model with originalData
	// MWTemplateModel.newFromData method actually creates instance of WikiaTemplateModel.
	templateModel = ve.dm.MWTemplateModel.newFromData(
		new ve.dm.WikiaTransclusionModel(),
		originalData
	);
	// Add a parameter
	templateModel.addParameter( new ve.dm.MWParameterModel( templateModel, 'ignoreme' ) );

	serialize = templateModel.serialize();
	wikitext = templateModel.getWikitext();

	QUnit.expect( 2 );

	assert.deepEqual( serialize.template.params, originalData.params, 'serialize' );
	assert.equal( wikitext, '{{foo|name=Christian}}', 'wikitext' );
} );
