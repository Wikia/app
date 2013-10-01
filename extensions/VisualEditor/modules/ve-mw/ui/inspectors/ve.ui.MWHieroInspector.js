/*!
 * VisualEditor UserInterface MWHieroInspector class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki hieroglyphics inspector.
 *
 * @class
 * @extends ve.ui.MWExtensionInspector
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHieroInspector = function VeUiMWHieroInspector( surface, config ) {
	// Parent constructor
	ve.ui.MWExtensionInspector.call( this, surface, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWHieroInspector, ve.ui.MWExtensionInspector );

/* Static properties */

ve.ui.MWHieroInspector.static.name = 'hiero';

ve.ui.MWHieroInspector.static.icon = 'hiero';

ve.ui.MWHieroInspector.static.titleMessage = 'visualeditor-mwhieroinspector-title';

ve.ui.MWHieroInspector.static.nodeView = ve.ce.MWHieroNode;

ve.ui.MWHieroInspector.static.nodeModel = ve.dm.MWHieroNode;


/* Methods */

ve.ui.MWHieroInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.MWExtensionInspector.prototype.initialize.call( this );

	this.input.$.addClass( 've-ui-mwHieroInspector-input' );
};

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.MWHieroInspector );
