/*!
 * VisualEditor DataModel WikiaTemplateModel tests.
 */

QUnit.module( 've.dm.WikiaTemplateModel' );

/* Tests */

QUnit.test( 'WikiaTemplateModel', function ( assert ) {
	var templateModel,
	originalData = {
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

	QUnit.expect( 2 );

	assert.deepEqual(
		templateModel.serialize().template.params,
		originalData.params,
		'Auto-suggested and unused parameter is not present in serialize() output'
	);
	assert.equal(
		templateModel.getWikitext(),
		'{{foo|name=Christian}}',
		'Auto-suggested and unused parameter is not present in getWikitext() output'
	);
} );
