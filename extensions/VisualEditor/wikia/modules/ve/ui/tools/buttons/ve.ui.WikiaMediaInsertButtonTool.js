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
	ve.ui.DialogTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.WikiaMediaInsertButtonTool, ve.ui.DialogTool );

/* Static Properties */

ve.ui.WikiaMediaInsertButtonTool.static.name = 'wikiaMediaInsert';

ve.ui.WikiaMediaInsertButtonTool.static.group = 'object';

ve.ui.WikiaMediaInsertButtonTool.static.icon = 'media';

ve.ui.WikiaMediaInsertButtonTool.static.titleMessage = 'visualeditor-wikiamediainsertbuttontool-label';

ve.ui.WikiaMediaInsertButtonTool.static.dialog = 'wikiaMediaInsert';

/* Registration */

ve.ui.toolFactory.register( ve.ui.WikiaMediaInsertButtonTool );
