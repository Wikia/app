/*!
 * VisualEditor UserInterface WikiaMediaInsertButtonTool class.
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
ve.ui.WikiaMediaInsertButtonTool = function VeUiWikiaMediaInsertButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.IconTextButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaInsertButtonTool, ve.ui.IconTextButtonTool );

/* Static Properties */

ve.ui.WikiaMediaInsertButtonTool.static.name = 'insertMedia';

ve.ui.WikiaMediaInsertButtonTool.static.icon = 'media';

ve.ui.WikiaMediaInsertButtonTool.static.labelMessage = 'visualeditor-wikiamediainsertbuttontool-label';

ve.ui.WikiaMediaInsertButtonTool.static.titleMessage = 'visualeditor-dialogbutton-media-tooltip';

ve.ui.WikiaMediaInsertButtonTool.static.dialog = 'wikiaMediaInsert';

/* Registration */

ve.ui.toolFactory.register( 'insertMedia', ve.ui.WikiaMediaInsertButtonTool );
