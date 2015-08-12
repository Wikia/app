/*!
 * VisualEditor MediaWiki UserInterface transclusion tool classes.
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

ve.ui.WikiaInfoboxDialogTool.static.group = 'object';

ve.ui.WikiaInfoboxDialogTool.static.icon = 'template';

ve.ui.WikiaInfoboxDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialogbutton-template-tooltip' );

ve.ui.WikiaInfoboxDialogTool.static.modelClasses = [ ve.dm.MWTransclusionNode ];

ve.ui.WikiaInfoboxDialogTool.static.commandName = 'infoboxTemplate';

/**
 * Only display tool for single-template transclusions of these templates.
 *
 * @property {string|string[]|null}
 * @static
 * @inheritable
 */
ve.ui.WikiaInfoboxDialogTool.static.template = null;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.WikiaInfoboxDialogTool.static.isCompatibleWith = function ( model ) {
	var compatible;

	// Parent method
	compatible = ve.ui.DialogTool.static.isCompatibleWith.call( this, model );

	if ( compatible && this.template ) {
		return model.isSingleTemplate( this.template );
	}

	return compatible;
};

/* Registration */

ve.ui.toolFactory.register( ve.ui.WikiaInfoboxDialogTool );
