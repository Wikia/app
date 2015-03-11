/*global mw */

/**
 * UserInterface WikiaHelp tool.
 *
 * @class
 * @extends ve.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaHelpTool = function VeUiWikiaHelpTool( toolGroup, config ) {
	ve.ui.WikiaHelpTool.super.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaHelpTool, ve.ui.Tool );

/* Static Properties */

ve.ui.WikiaHelpTool.static.name = 'wikiaHelp';
ve.ui.WikiaHelpTool.static.icon = 'help';
ve.ui.WikiaHelpTool.static.title = OO.ui.deferMsg( 'visualeditor-help-tool' );

/* Methods */

ve.ui.WikiaHelpTool.prototype.onSelect = function () {
	window.open( new mw.Title( ve.msg( 'wikia-visualeditor-help-link' ) ).getUrl() );
	this.setActive( false );
};

/* Registration */

ve.ui.toolFactory.register( ve.ui.WikiaHelpTool );
