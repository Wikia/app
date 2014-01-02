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
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MWMathInspector = function VeUiMWMathInspector( surface, config ) {
	// Parent constructor
	ve.ui.MWExtensionInspector.call( this, surface, config );

	this.onChangeHandler = ve.debounce( ve.bind( this.updatePreview, this ), 250 );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWMathInspector, ve.ui.MWExtensionInspector );

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
 * Handle the inspector being opened.
 */
ve.ui.MWMathInspector.prototype.onOpen = function () {
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

	// Parent method
	ve.ui.MWExtensionInspector.prototype.onOpen.call( this );
};

/**
 * Handle the inspector being closed.
 *
 * @param {string} action Action that caused the window to be closed
 */
ve.ui.MWMathInspector.prototype.onClose = function ( action ) {
	var newsrc = this.input.getValue(),
		surfaceModel = this.surface.getModel();

	if ( newsrc !== '' ) {
		// Parent method
		ve.ui.MWExtensionInspector.prototype.onClose.call( this, action );
	} else {
		// Grandparent method; we're overriding the parent behavior in this case
		ve.ui.Inspector.prototype.onClose.call( this, action );

		// The user tried to empty the node, remove it
		surfaceModel.change( ve.dm.Transaction.newFromRemoval(
			surfaceModel.getDocument(), this.node.getOuterRange()
		) );
	}

	this.input.off( 'change', this.onChangeHandler );
};

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.MWMathInspector );
