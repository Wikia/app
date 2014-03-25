/*!
 * VisualEditor UserInterface MWAlienExtensionInspector class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki alien extension inspector.
 *
 * @class
 * @extends ve.ui.MWExtensionInspector
 *
 * @constructor
 * @param {ve.ui.WindowSet} windowSet Window set this inspector is part of
 * @param {Object} [config] Configuration options
 */
ve.ui.MWAlienExtensionInspector = function VeUiMWAlienExtensionInspector( windowSet, config ) {
	// Parent constructor
	ve.ui.MWExtensionInspector.call( this, windowSet, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWAlienExtensionInspector, ve.ui.MWExtensionInspector );

/* Static properties */

ve.ui.MWAlienExtensionInspector.static.name = 'alienExtension';

ve.ui.MWAlienExtensionInspector.static.icon = 'alienextension';

ve.ui.MWAlienExtensionInspector.static.nodeView = ve.ce.MWAlienExtensionNode;

ve.ui.MWAlienExtensionInspector.static.nodeModel = ve.dm.MWAlienExtensionNode;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWAlienExtensionInspector.prototype.getTitle = function () {
	return this.surface.getView().getFocusedNode().getModel().getExtensionName();
};

/**
 * @inheritdoc
 */
ve.ui.MWAlienExtensionInspector.prototype.initialize = function () {
	// Parent method
	ve.ui.MWExtensionInspector.prototype.initialize.call( this );

	this.input.$element.addClass( 've-ui-mwAlienExtensionInspector-input' );
};

/* Registration */

ve.ui.inspectorFactory.register( ve.ui.MWAlienExtensionInspector );
