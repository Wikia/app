/*!
 * VisualEditor UserInterface MWTransclusionButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface MediaWiki transclusion button tool.
 *
 * @class
 * @extends ve.ui.DialogButtonTool
 * @constructor
 * @param {ve.ui.Toolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.MWTransclusionButtonTool = function VeUiMWTransclusionButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.DialogButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWTransclusionButtonTool, ve.ui.DialogButtonTool );

/* Static Properties */

ve.ui.MWTransclusionButtonTool.static.name = 'object/transclusion/mw';

ve.ui.MWTransclusionButtonTool.static.icon = 'template';

ve.ui.MWTransclusionButtonTool.static.titleMessage = 'visualeditor-dialogbutton-transclusion-tooltip';

ve.ui.MWTransclusionButtonTool.static.dialog = 'mwTransclusion';

ve.ui.MWTransclusionButtonTool.static.modelClasses = [ ve.dm.MWTransclusionNode ];

/* Registration */

ve.ui.toolFactory.register( 'object/transclusion/mw', ve.ui.MWTransclusionButtonTool );
