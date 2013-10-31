/*!
 * VisualEditor UserInterface AnnotationTool classes.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * UserInterface annotation tool.
 *
 * @class
 * @abstract
 * @extends ve.ui.Tool
 *
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.AnnotationTool = function VeUiAnnotationTool( toolbar, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.AnnotationTool, ve.ui.Tool );

/* Static Properties */

/**
 * Annotation name and data the tool applies.
 *
 * @abstract
 * @static
 * @property {Object}
 * @inheritable
 */
ve.ui.AnnotationTool.static.annotation = { 'name': '' };

/* Methods */

/**
 * Handle the tool being selected.
 *
 * @method
 */
ve.ui.AnnotationTool.prototype.onSelect = function () {
	this.toolbar.getSurface().execute(
		'annotation', 'toggle', this.constructor.static.annotation.name
	);
};

/**
 * Handle the toolbar state being updated.
 *
 * @method
 * @param {ve.dm.Node[]} nodes List of nodes covered by the current selection
 * @param {ve.dm.AnnotationSet} full Annotations that cover all of the current selection
 * @param {ve.dm.AnnotationSet} partial Annotations that cover some or all of the current selection
 */
ve.ui.AnnotationTool.prototype.onUpdateState = function ( nodes, full ) {
	this.setActive( full.hasAnnotationWithName( this.constructor.static.annotation.name ) );
};

/**
 * UserInterface bold tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.BoldAnnotationTool = function VeUiBoldAnnotationTool( toolbar, config ) {
	ve.ui.AnnotationTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.BoldAnnotationTool, ve.ui.AnnotationTool );
ve.ui.BoldAnnotationTool.static.name = 'bold';
ve.ui.BoldAnnotationTool.static.group = 'textStyle';
ve.ui.BoldAnnotationTool.static.icon = {
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
ve.ui.BoldAnnotationTool.static.titleMessage = 'visualeditor-annotationbutton-bold-tooltip';
ve.ui.BoldAnnotationTool.static.annotation = { 'name': 'textStyle/bold' };
ve.ui.toolFactory.register( ve.ui.BoldAnnotationTool );

/**
 * UserInterface italic tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.ItalicAnnotationTool = function VeUiItalicAnnotationTool( toolbar, config ) {
	ve.ui.AnnotationTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.ItalicAnnotationTool, ve.ui.AnnotationTool );
ve.ui.ItalicAnnotationTool.static.name = 'italic';
ve.ui.ItalicAnnotationTool.static.group = 'textStyle';
ve.ui.ItalicAnnotationTool.static.icon = {
	'default': 'italic-a',
	'be': 'italic-cyrl-ka',
	'cs': 'italic-i',
	'da': 'italic-k',
	'de': 'italic-k',
	'en': 'italic-i',
	'es': 'italic-c',
	'eu': 'italic-e',
	'fr': 'italic-i',
	'gl': 'italic-c',
	'he': 'italic-i',
	'hu': 'italic-d',
	'it': 'italic-c',
	'ka': 'italic-geor-kan',
	'ky': 'italic-cyrl-ka',
	'ml': 'italic-i',
	'nl': 'italic-c',
	'nn': 'italic-k',
	'no': 'italic-k',
	'os': 'italic-cyrl-ka',
	'pl': 'italic-i',
	'pt': 'italic-i',
	'ru': 'italic-cyrl-ka',
	'sv': 'italic-k'
};
ve.ui.ItalicAnnotationTool.static.titleMessage = 'visualeditor-annotationbutton-italic-tooltip';
ve.ui.ItalicAnnotationTool.static.annotation = { 'name': 'textStyle/italic' };
ve.ui.toolFactory.register( ve.ui.ItalicAnnotationTool );

/**
 * UserInterface code tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.CodeAnnotationTool = function VeUiCodeAnnotationTool( toolbar, config ) {
	ve.ui.AnnotationTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.CodeAnnotationTool, ve.ui.AnnotationTool );
ve.ui.CodeAnnotationTool.static.name = 'code';
ve.ui.CodeAnnotationTool.static.group = 'textStyle';
ve.ui.CodeAnnotationTool.static.icon = 'code';
ve.ui.CodeAnnotationTool.static.titleMessage = 'visualeditor-annotationbutton-code-tooltip';
ve.ui.CodeAnnotationTool.static.annotation = { 'name': 'textStyle/code' };
ve.ui.toolFactory.register( ve.ui.CodeAnnotationTool );

/**
 * UserInterface strikethrough tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.StrikethroughAnnotationTool = function VeUiStrikethroughAnnotationTool( toolbar, config ) {
	ve.ui.AnnotationTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.StrikethroughAnnotationTool, ve.ui.AnnotationTool );
ve.ui.StrikethroughAnnotationTool.static.name = 'strikethrough';
ve.ui.StrikethroughAnnotationTool.static.group = 'textStyle';
ve.ui.StrikethroughAnnotationTool.static.icon = {
	'default': 'strikethrough-a',
	'en': 'strikethrough-s'
};
ve.ui.StrikethroughAnnotationTool.static.titleMessage =
	'visualeditor-annotationbutton-strikethrough-tooltip';
ve.ui.StrikethroughAnnotationTool.static.annotation = { 'name': 'textStyle/strike' };
ve.ui.toolFactory.register( ve.ui.StrikethroughAnnotationTool );

/**
 * UserInterface underline tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.UnderlineAnnotationTool = function VeUiUnderlineAnnotationTool( toolbar, config ) {
	ve.ui.AnnotationTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.UnderlineAnnotationTool, ve.ui.AnnotationTool );
ve.ui.UnderlineAnnotationTool.static.name = 'underline';
ve.ui.UnderlineAnnotationTool.static.group = 'textStyle';
ve.ui.UnderlineAnnotationTool.static.icon = {
	'default': 'underline-a',
	'en': 'underline-u'
};
ve.ui.UnderlineAnnotationTool.static.titleMessage =
	'visualeditor-annotationbutton-underline-tooltip';
ve.ui.UnderlineAnnotationTool.static.annotation = { 'name': 'textStyle/underline' };
ve.ui.toolFactory.register( ve.ui.UnderlineAnnotationTool );

/**
 * UserInterface subscript tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.SubscriptAnnotationTool = function VeUiSubscriptAnnotationTool( toolbar, config ) {
	ve.ui.AnnotationTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.SubscriptAnnotationTool, ve.ui.AnnotationTool );
ve.ui.SubscriptAnnotationTool.static.name = 'subscript';
ve.ui.SubscriptAnnotationTool.static.group = 'textStyle';
ve.ui.SubscriptAnnotationTool.static.icon = 'subscript';
ve.ui.SubscriptAnnotationTool.static.titleMessage =
	'visualeditor-annotationbutton-subscript-tooltip';
ve.ui.SubscriptAnnotationTool.static.annotation = { 'name': 'textStyle/subscript' };
ve.ui.toolFactory.register( ve.ui.SubscriptAnnotationTool );

/**
 * UserInterface superscript tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Configuration options
 */
ve.ui.SuperscriptAnnotationTool = function VeUiSuperscriptAnnotationTool( toolbar, config ) {
	ve.ui.AnnotationTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.SuperscriptAnnotationTool, ve.ui.AnnotationTool );
ve.ui.SuperscriptAnnotationTool.static.name = 'superscript';
ve.ui.SuperscriptAnnotationTool.static.group = 'textStyle';
ve.ui.SuperscriptAnnotationTool.static.icon = 'superscript';
ve.ui.SuperscriptAnnotationTool.static.titleMessage =
	'visualeditor-annotationbutton-superscript-tooltip';
ve.ui.SuperscriptAnnotationTool.static.annotation = { 'name': 'textStyle/superscript' };
ve.ui.toolFactory.register( ve.ui.SuperscriptAnnotationTool );
