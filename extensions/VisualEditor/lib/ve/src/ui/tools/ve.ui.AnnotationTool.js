/*!
 * VisualEditor UserInterface AnnotationTool classes.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * UserInterface annotation tool.
 *
 * @class
 * @abstract
 * @extends ve.ui.Tool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.AnnotationTool = function VeUiAnnotationTool( toolGroup, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolGroup, config );
};

/* Inheritance */

OO.inheritClass( ve.ui.AnnotationTool, ve.ui.Tool );

/* Static Properties */

/**
 * Annotation name and data the tool applies.
 *
 * @abstract
 * @static
 * @property {Object}
 * @inheritable
 */
ve.ui.AnnotationTool.static.annotation = { name: '' };

ve.ui.AnnotationTool.static.deactivateOnSelect = false;

/* Methods */

/**
 * @inheritdoc
 */
ve.ui.AnnotationTool.prototype.onUpdateState = function ( fragment ) {
	// Parent method
	ve.ui.Tool.prototype.onUpdateState.apply( this, arguments );

	this.setActive(
		fragment && fragment.getAnnotations().hasAnnotationWithName( this.constructor.static.annotation.name )
	);
};

/**
 * UserInterface bold tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.BoldAnnotationTool = function VeUiBoldAnnotationTool( toolGroup, config ) {
	ve.ui.AnnotationTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.BoldAnnotationTool, ve.ui.AnnotationTool );
ve.ui.BoldAnnotationTool.static.name = 'bold';
ve.ui.BoldAnnotationTool.static.group = 'textStyle';
ve.ui.BoldAnnotationTool.static.icon = {
	default: 'bold-a',
	ar: 'bold-arab-ain',
	be: 'bold-cyrl-te',
	cs: 'bold-b',
	da: 'bold-f',
	de: 'bold-f',
	en: 'bold-b',
	es: 'bold-n',
	eu: 'bold-l',
	fa: 'bold-arab-dad',
	fi: 'bold-l',
	fr: 'bold-g',
	gl: 'bold-n',
	he: 'bold-b',
	hu: 'bold-f',
	hy: 'bold-armn-to',
	it: 'bold-g',
	ka: 'bold-geor-man',
	ksh: 'bold-f',
	ky: 'bold-cyrl-zhe',
	ml: 'bold-b',
	nl: 'bold-v',
	nn: 'bold-f',
	no: 'bold-f',
	os: 'bold-cyrl-be',
	pl: 'bold-b',
	pt: 'bold-n',
	ru: 'bold-cyrl-zhe',
	sv: 'bold-f'
};
ve.ui.BoldAnnotationTool.static.title =
	OO.ui.deferMsg( 'visualeditor-annotationbutton-bold-tooltip' );
ve.ui.BoldAnnotationTool.static.annotation = { name: 'textStyle/bold' };
ve.ui.BoldAnnotationTool.static.commandName = 'bold';
ve.ui.toolFactory.register( ve.ui.BoldAnnotationTool );

/**
 * UserInterface italic tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.ItalicAnnotationTool = function VeUiItalicAnnotationTool( toolGroup, config ) {
	ve.ui.AnnotationTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.ItalicAnnotationTool, ve.ui.AnnotationTool );
ve.ui.ItalicAnnotationTool.static.name = 'italic';
ve.ui.ItalicAnnotationTool.static.group = 'textStyle';
ve.ui.ItalicAnnotationTool.static.icon = {
	default: 'italic-a',
	ar: 'italic-arab-meem',
	be: 'italic-cyrl-ka',
	cs: 'italic-i',
	da: 'italic-k',
	de: 'italic-k',
	en: 'italic-i',
	es: 'italic-c',
	eu: 'italic-e',
	fa: 'italic-arab-keheh-jeem',
	fi: 'italic-k',
	fr: 'italic-i',
	gl: 'italic-c',
	he: 'italic-i',
	hu: 'italic-d',
	hy: 'italic-armn-sha',
	it: 'italic-c',
	ka: 'italic-geor-kan',
	ksh: 'italic-s',
	ky: 'italic-cyrl-ka',
	ml: 'italic-i',
	nl: 'italic-c',
	nn: 'italic-k',
	no: 'italic-k',
	os: 'italic-cyrl-ka',
	pl: 'italic-i',
	pt: 'italic-i',
	ru: 'italic-cyrl-ka',
	sv: 'italic-k'
};
ve.ui.ItalicAnnotationTool.static.title =
	OO.ui.deferMsg( 'visualeditor-annotationbutton-italic-tooltip' );
ve.ui.ItalicAnnotationTool.static.annotation = { name: 'textStyle/italic' };
ve.ui.ItalicAnnotationTool.static.commandName = 'italic';
ve.ui.toolFactory.register( ve.ui.ItalicAnnotationTool );

/**
 * UserInterface code tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.CodeAnnotationTool = function VeUiCodeAnnotationTool( toolGroup, config ) {
	ve.ui.AnnotationTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.CodeAnnotationTool, ve.ui.AnnotationTool );
ve.ui.CodeAnnotationTool.static.name = 'code';
ve.ui.CodeAnnotationTool.static.group = 'textStyle';
ve.ui.CodeAnnotationTool.static.icon = 'code';
ve.ui.CodeAnnotationTool.static.title =
	OO.ui.deferMsg( 'visualeditor-annotationbutton-code-tooltip' );
ve.ui.CodeAnnotationTool.static.annotation = { name: 'textStyle/code' };
ve.ui.CodeAnnotationTool.static.commandName = 'code';
ve.ui.toolFactory.register( ve.ui.CodeAnnotationTool );

/**
 * UserInterface strikethrough tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.StrikethroughAnnotationTool = function VeUiStrikethroughAnnotationTool( toolGroup, config ) {
	ve.ui.AnnotationTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.StrikethroughAnnotationTool, ve.ui.AnnotationTool );
ve.ui.StrikethroughAnnotationTool.static.name = 'strikethrough';
ve.ui.StrikethroughAnnotationTool.static.group = 'textStyle';
ve.ui.StrikethroughAnnotationTool.static.icon = {
	default: 'strikethrough-a',
	en: 'strikethrough-s',
	fi: 'strikethrough-y'
};
ve.ui.StrikethroughAnnotationTool.static.title =
	OO.ui.deferMsg( 'visualeditor-annotationbutton-strikethrough-tooltip' );
ve.ui.StrikethroughAnnotationTool.static.annotation = { name: 'textStyle/strikethrough' };
ve.ui.StrikethroughAnnotationTool.static.commandName = 'strikethrough';
ve.ui.toolFactory.register( ve.ui.StrikethroughAnnotationTool );

/**
 * UserInterface underline tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.UnderlineAnnotationTool = function VeUiUnderlineAnnotationTool( toolGroup, config ) {
	ve.ui.AnnotationTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.UnderlineAnnotationTool, ve.ui.AnnotationTool );
ve.ui.UnderlineAnnotationTool.static.name = 'underline';
ve.ui.UnderlineAnnotationTool.static.group = 'textStyle';
ve.ui.UnderlineAnnotationTool.static.icon = {
	default: 'underline-a',
	en: 'underline-u'
};
ve.ui.UnderlineAnnotationTool.static.title =
	OO.ui.deferMsg( 'visualeditor-annotationbutton-underline-tooltip' );
ve.ui.UnderlineAnnotationTool.static.annotation = { name: 'textStyle/underline' };
ve.ui.UnderlineAnnotationTool.static.commandName = 'underline';
ve.ui.toolFactory.register( ve.ui.UnderlineAnnotationTool );

/**
 * UserInterface superscript tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.SuperscriptAnnotationTool = function VeUiSuperscriptAnnotationTool( toolGroup, config ) {
	ve.ui.AnnotationTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.SuperscriptAnnotationTool, ve.ui.AnnotationTool );
ve.ui.SuperscriptAnnotationTool.static.name = 'superscript';
ve.ui.SuperscriptAnnotationTool.static.group = 'textStyle';
ve.ui.SuperscriptAnnotationTool.static.icon = 'superscript';
ve.ui.SuperscriptAnnotationTool.static.title =
	OO.ui.deferMsg( 'visualeditor-annotationbutton-superscript-tooltip' );
ve.ui.SuperscriptAnnotationTool.static.annotation = { name: 'textStyle/superscript' };
ve.ui.SuperscriptAnnotationTool.static.commandName = 'superscript';
ve.ui.toolFactory.register( ve.ui.SuperscriptAnnotationTool );

/**
 * UserInterface subscript tool.
 *
 * @class
 * @extends ve.ui.AnnotationTool
 * @constructor
 * @param {OO.ui.ToolGroup} toolGroup
 * @param {Object} [config] Configuration options
 */
ve.ui.SubscriptAnnotationTool = function VeUiSubscriptAnnotationTool( toolGroup, config ) {
	ve.ui.AnnotationTool.call( this, toolGroup, config );
};
OO.inheritClass( ve.ui.SubscriptAnnotationTool, ve.ui.AnnotationTool );
ve.ui.SubscriptAnnotationTool.static.name = 'subscript';
ve.ui.SubscriptAnnotationTool.static.group = 'textStyle';
ve.ui.SubscriptAnnotationTool.static.icon = 'subscript';
ve.ui.SubscriptAnnotationTool.static.title =
	OO.ui.deferMsg( 'visualeditor-annotationbutton-subscript-tooltip' );
ve.ui.SubscriptAnnotationTool.static.annotation = { name: 'textStyle/subscript' };
ve.ui.SubscriptAnnotationTool.static.commandName = 'subscript';
ve.ui.toolFactory.register( ve.ui.SubscriptAnnotationTool );
