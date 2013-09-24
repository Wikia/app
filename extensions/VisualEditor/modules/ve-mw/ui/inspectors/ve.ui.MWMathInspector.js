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
 * @param {Object} [config] Config options
 */
ve.ui.MWMathInspector = function VeUiMWMathInspector( surface, config ) {
	// Parent constructor
	ve.ui.MWExtensionInspector.call( this, surface, config );
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

/** */
ve.ui.MWMathInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.MWExtensionInspector.prototype.initialize.call( this );

	this.input.$.addClass( 've-ui-mwMathInspector-input' );
};

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.MWMathInspector );
