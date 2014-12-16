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
ve.ui.MWTransclusionDialogTool = function VeUiMWTransclusionDialogTool( toolGroup, config ) {
	ve.ui.DialogTool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWTransclusionDialogTool, ve.ui.DialogTool );

/* Static Properties */

ve.ui.MWTransclusionDialogTool.static.name = 'transclusion';

ve.ui.MWTransclusionDialogTool.static.group = 'object';

ve.ui.MWTransclusionDialogTool.static.icon = 'template';

ve.ui.MWTransclusionDialogTool.static.title =
	OO.ui.deferMsg( 'visualeditor-dialogbutton-template-tooltip' );

ve.ui.MWTransclusionDialogTool.static.modelClasses = [ ve.dm.MWTransclusionNode ];

ve.ui.MWTransclusionDialogTool.static.commandName = 'transclusion';

/**
 * Only display tool for single-template transclusions of these templates.
 *
 * @property {string|string[]|null}
 * @static
 * @inheritable
 */
ve.ui.MWTransclusionDialogTool.static.template = null;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.MWTransclusionDialogTool.static.isCompatibleWith = function ( model ) {
	var compatible;

	// Parent method
	compatible = ve.ui.DialogTool.static.isCompatibleWith.call( this, model );

	if ( compatible && this.template ) {
		return model.isSingleTemplate( this.template );
	}

	return compatible;
};

/* Registration */

ve.ui.toolFactory.register( ve.ui.MWTransclusionDialogTool );
