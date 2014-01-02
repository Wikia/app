/*!
 * VisualEditor UserInterface WikiaSourceModeButtonTool class.
 */

/**
 * UserInterface MediaWiki media insert button tool.
 *
 * @class
 * @extends ve.ui.IconTextButtonTool
 *
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.WikiaSourceModeButtonTool = function VeUiWikiaSourceModeButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.DialogTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaSourceModeButtonTool, ve.ui.DialogTool );

/* Static Properties */

ve.ui.WikiaSourceModeButtonTool.static.name = 'wikiaSourceMode';

ve.ui.WikiaSourceModeButtonTool.static.group = 'object';

ve.ui.WikiaSourceModeButtonTool.static.icon = 'source';

ve.ui.WikiaSourceModeButtonTool.static.titleMessage = 'wikia-visualeditor-dialogbutton-wikiasourcemode-tooltip';

ve.ui.WikiaSourceModeButtonTool.static.dialog = 'wikiaSourceMode';

/* Registration */

ve.ui.toolFactory.register( ve.ui.WikiaSourceModeButtonTool );
