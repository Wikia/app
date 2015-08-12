/*!
 * VisualEditor MediaWiki Infobox Dialog transclusion tool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki UserInterface transclusion tool.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.WikiaInfoboxDialogTool = function VeUiWikiaInfoboxDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaInfoboxDialogTool, ve.ui.DialogTool );

/* Static Properties */

ve.ui.WikiaInfoboxDialogTool.static.name = 'infoboxTemplate';

ve.ui.WikiaInfoboxDialogTool.static.icon = 'source';

ve.ui.WikiaInfoboxDialogTool.static.title = OO.ui.deferMsg( 'visualeditor-dialogbutton-infobox-tooltip' );

ve.ui.WikiaInfoboxDialogTool.static.modelClasses = [ ve.dm.WikiaInfoboxTransclusionBlockNode ];

ve.ui.WikiaInfoboxDialogTool.static.commandName = 'infoboxTemplate';

/**
 * Only display tool for single-template transclusions of these templates.
 *
 * @property {string|string[]|null}
 * @static
 * @inheritable
 */
ve.ui.WikiaInfoboxDialogTool.static.template = null;

/* Registration */

ve.ui.toolFactory.register( ve.ui.WikiaInfoboxDialogTool );
