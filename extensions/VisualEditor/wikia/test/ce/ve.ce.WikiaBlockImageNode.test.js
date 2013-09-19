/*!
 * VisualEditor ContentEditable WikiaBlockImageNode tests.
 */

QUnit.module( 've.ce.WikiaBlockImageNode' );

/* Tests */

QUnit.test( 'Build NodeView from HTMLDOM', function ( assert ) {
	ve.wikiaTest.utils.media.runHtmlDomToNodeViewTests(
		assert,
		'block',
		'mw:Image',
		function( documentNode ) {
			return documentNode.getChildren()[0];
		}
	);
} );

/*
QUnit.test( 'NodeView changes', function ( assert ) {
	var attributes,
		attributesDiffed,
		attributesMerged,
		doc,
		documentModel,
		documentView,
		i,
		l,
		nodeView,
		previousAttributes = this.permutations[0],
		surface,
		surfaceModel,
		surfaceView,
		target,
		expectCount = 0;

	doc = ve.createDocumentFromHtml(
		ve.ce.wikiaExample.getMediaHtmlDom( this.displayType, this.rdfaType, previousAttributes )
	);

	target = new ve.init.sa.Target( this.$fixture, doc );
	surface = target.surface;
	surfaceModel = surface.getModel();
	surfaceView = surface.getView();
	documentModel = surfaceModel.getDocument();
	documentView = surfaceView.getDocument();
	nodeView = documentView.getDocumentNode().getChildren()[0];

	expectCount += ve.wikiaTest.utils.assertEqualNodeView(
		assert,
		nodeView,
		ve.ce.wikiaExample.getBlockImageHtml( previousAttributes ),
		ve.wikiaTest.utils.getAssertMessageFromAttributes( 'Default: ', previousAttributes )
	);

	for ( i = 1, l = this.permutations.length; i < l; i++ ) {
		attributes = this.permutations[i];
		attributesDiffed = ve.wikiaTest.utils.getAttributeChanges( previousAttributes, attributes );
		attributesMerged = ve.wikiaTest.utils.getAttributeChanges( previousAttributes, attributes, true );

		surfaceModel.change(
			ve.dm.Transaction.newFromAttributeChanges(
				documentModel,
				nodeView.getOffset(),
				attributesDiffed
			)
		);

		expectCount += ve.wikiaTest.utils.assertEqualNodeView(
			assert,
			nodeView,
			ve.ce.wikiaExample.getBlockImageHtml( attributesMerged ),
			ve.wikiaTest.utils.getAssertMessageFromAttributes( 'Changes: ', attributesDiffed )
		);

		previousAttributes = attributesMerged;
	}

	QUnit.expect( expectCount );
} );*/