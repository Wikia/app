/*!
 * VisualEditor UserInterface LinkButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface link button tool.
 *
 * @class
 * @extends ve.ui.InspectorButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.LinkButtonTool = function VeUiLinkButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.InspectorButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.LinkButtonTool, ve.ui.InspectorButtonTool );

/* Static Properties */

ve.ui.LinkButtonTool.static.name = 'link';

ve.ui.LinkButtonTool.static.icon = 'link';

ve.ui.LinkButtonTool.static.titleMessage = 'visualeditor-annotationbutton-link-tooltip';

ve.ui.LinkButtonTool.static.inspector = 'link';

ve.ui.LinkButtonTool.static.modelClasses = [ ve.dm.LinkAnnotation ];

/* Registration */

ve.ui.toolFactory.register( 'link', ve.ui.LinkButtonTool );

ve.ui.commandRegistry.register( 'link', 'inspector', 'open', 'link' );

ve.ui.triggerRegistry.register(
	'link', { 'mac': new ve.ui.Trigger( 'cmd+k' ), 'pc': new ve.ui.Trigger( 'ctrl+k' ) }
);
