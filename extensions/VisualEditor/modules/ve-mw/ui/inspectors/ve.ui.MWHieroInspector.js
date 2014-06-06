/*!
 * VisualEditor UserInterface MWHieroInspector class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki hieroglyphics inspector.
 *
 * @class
 * @extends ve.ui.MWExtensionInspector
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWHieroInspector = function VeUiMWHieroInspector( config ) {
	// Parent constructor
	ve.ui.MWExtensionInspector.call( this, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWHieroInspector, ve.ui.MWExtensionInspector );

/* Static properties */

ve.ui.MWHieroInspector.static.name = 'hiero';

ve.ui.MWHieroInspector.static.icon = 'hiero';

ve.ui.MWHieroInspector.static.title =
	OO.ui.deferMsg( 'visualeditor-mwhieroinspector-title' );

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
