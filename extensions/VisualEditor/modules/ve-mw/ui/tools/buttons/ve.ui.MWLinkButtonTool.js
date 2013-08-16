/*!
 * VisualEditor UserInterface MWLinkButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki link button tool.
 *
 * @class
 * @extends ve.ui.LinkButtonTool
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.MWLinkButtonTool = function VeUiMWLinkButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.LinkButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWLinkButtonTool, ve.ui.LinkButtonTool );

/* Static Members */

ve.ui.MWLinkButtonTool.static.name = 'mwLink';

ve.ui.MWLinkButtonTool.static.inspector = 'mwLink';

ve.ui.MWLinkButtonTool.static.modelClasses = [
	ve.dm.MWExternalLinkAnnotation, ve.dm.MWInternalLinkAnnotation
];

/* Registration */

ve.ui.toolFactory.register( 'mwLink', ve.ui.MWLinkButtonTool );

ve.ui.commandRegistry.register( 'mwLink', 'inspector', 'open', 'mwLink' );

ve.ui.triggerRegistry.register(
	'mwLink', { 'mac': new ve.ui.Trigger( 'cmd+k' ), 'pc': new ve.ui.Trigger( 'ctrl+k' ) }
);
