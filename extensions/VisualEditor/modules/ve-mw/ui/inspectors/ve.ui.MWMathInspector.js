/*!
 * VisualEditor UserInterface MWMathInspector class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki math inspector.
 *
 * @class
 * @extends ve.ui.MWExtensionInspector
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this inspector is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMathInspector = function VeUiMWMathInspector( windowSet, config ) {
	// Parent constructor
	ve.ui.MWExtensionInspector.call( this, windowSet, config );

	this.onChangeHandler = ve.debounce( ve.bind( this.updatePreview, this ), 250 );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWMathInspector, ve.ui.MWExtensionInspector );

/* Static properties */

ve.ui.MWMathInspector.static.name = 'math';

ve.ui.MWMathInspector.static.icon = 'math';

ve.ui.MWMathInspector.static.titleMessage = 'visualeditor-mwmathinspector-title';

ve.ui.MWMathInspector.static.nodeView = ve.ce.MWMathNode;

ve.ui.MWMathInspector.static.nodeModel = ve.dm.MWMathNode;

/* Methods */

/**
 * Update the math node rendering to reflect the content entered into the inspector.
 */
ve.ui.MWMathInspector.prototype.updatePreview = function () {
	var newsrc = this.input.getValue();
	if ( this.visible ) {
		this.node.update( { 'extsrc': newsrc } );
	}
};

/**
 * @inheritdoc
 */
ve.ui.MWMathInspector.prototype.setup = function ( data ) {
	// Parent method
	ve.ui.MWExtensionInspector.prototype.setup.call( this, data );

	var mw, surfaceModel = this.surface.getModel();

	this.node = this.surface.getView().getFocusedNode();
	if ( !this.node ) {
		// Create a dummy node, needed for live preview
		mw = {
			'name': 'math',
			'attrs': {},
			'body': {
				'extsrc': ''
			}
		};
		surfaceModel.getFragment().collapseRangeToEnd().insertContent( [
			{
				'type': 'mwMath',
				'attributes': {
					'mw': mw
				}
			},
			{ 'type': '/mwMath' }
		] );
		this.node = this.surface.getView().getFocusedNode();
	}

	this.input.on( 'change', this.onChangeHandler );

	// Override directionality settings, inspector's input
	// should always be LTR:
	this.input.setRTL( false );
};

/**
 * @inheritdoc
 */
ve.ui.MWMathInspector.prototype.teardown = function ( data ) {
	var newsrc = this.input.getValue(),
		surfaceModel = this.surface.getModel();

	this.input.off( 'change', this.onChangeHandler );

	if ( newsrc !== '' ) {
		// Parent method
		ve.ui.MWExtensionInspector.prototype.teardown.call( this, data );
	} else {
		// The user tried to empty the node, remove it
		surfaceModel.change( ve.dm.Transaction.newFromRemoval(
			surfaceModel.getDocument(), this.node.getOuterRange()
		) );
		// Grandparent method; we're overriding the parent behavior in this case
		ve.ui.Inspector.prototype.teardown.call( this, data );
	}
};

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.MWMathInspector );
