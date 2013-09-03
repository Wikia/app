/*!
 * VisualEditor UserInterface BoldButtonTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface bold button tool.
 *
 * @class
 * @extends ve.ui.AnnotationButtonTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.BoldButtonTool = function VeUiBoldButtonTool( toolbar, config ) {
	// Parent constructor
	ve.ui.AnnotationButtonTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.BoldButtonTool, ve.ui.AnnotationButtonTool );

/* Static Properties */

ve.ui.BoldButtonTool.static.name = 'textStyle/bold';

ve.ui.BoldButtonTool.static.icon = {
	'default': 'bold-a',
	'be': 'bold-cyrl-te',
	'cs': 'bold-b',
	'da': 'bold-f',
	'de': 'bold-f',
	'en': 'bold-b',
	'es': 'bold-n',
	'eu': 'bold-l',
	'fr': 'bold-g',
	'gl': 'bold-n',
	'he': 'bold-b',
	'hu': 'bold-f',
	'it': 'bold-g',
	'ka': 'bold-geor-man',
	'ky': 'bold-cyrl-zhe',
	'ml': 'bold-b',
	'nl': 'bold-v',
	'nn': 'bold-f',
	'no': 'bold-f',
	'os': 'bold-cyrl-be',
	'pl': 'bold-b',
	'pt': 'bold-n',
	'ru': 'bold-cyrl-zhe',
	'sv': 'bold-f'
};

ve.ui.BoldButtonTool.static.titleMessage = 'visualeditor-annotationbutton-bold-tooltip';

ve.ui.BoldButtonTool.static.annotation = { 'name': 'textStyle/bold' };

/* Registration */

ve.ui.toolFactory.register( 'textStyle/bold', ve.ui.BoldButtonTool );

ve.ui.commandRegistry.register( 'textStyle/bold', 'annotation', 'toggle', 'textStyle/bold' );

ve.ui.triggerRegistry.register(
	'textStyle/bold',
	{ 'mac': new ve.ui.Trigger( 'cmd+b' ), 'pc': new ve.ui.Trigger( 'ctrl+b' ) }
);
