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
 * @param {ve.ui.WindowSet} windowSet Window set this inspector is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHieroInspector = function VeUiMWHieroInspector( windowSet, config ) {
	// Parent constructor
	ve.ui.MWExtensionInspector.call( this, windowSet, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWHieroInspector, ve.ui.MWExtensionInspector );

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

	this.input.$element.addClass( 've-ui-mwHieroInspector-input' );
};

ve.ui.MWHieroInspector.prototype.onOpen = function () {
	// Parent method
	ve.ui.MWExtensionInspector.prototype.onOpen.call( this );

	// Override directionality settings, inspector's input
	// should always be LTR:
	this.input.setRTL( false );
};

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.MWHieroInspector );
