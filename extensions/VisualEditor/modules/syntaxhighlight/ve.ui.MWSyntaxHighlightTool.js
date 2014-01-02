/*!
 * VisualEditor UserInterface MWSyntaxHighlightTool class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * SyntaxHighlight tool group.
 *
 * @class
 * @extends ve.ui.DialogTool
 * @constructor
 * @param {ve.ui.SurfaceToolbar} toolbar
 * @param {Object} [config] Config options
 */
ve.ui.MWSyntaxHighlightTool = function VeUiMWSyntaxHighlightTool( toolbar, config ) {
	// Parent constructor
	ve.ui.DialogTool.call( this, toolbar, config );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWSyntaxHighlightTool, ve.ui.DialogTool );

/* Static Properties */

ve.ui.MWSyntaxHighlightTool.static.name = 'mwSyntaxHighlight';
ve.ui.MWSyntaxHighlightTool.static.icon = 'syntaxHighlight';
ve.ui.MWSyntaxHighlightTool.static.titleMessage = 'visualeditor-dialogbutton-syntaxhighlight-tooltip';
ve.ui.MWSyntaxHighlightTool.static.dialog = 'mwSyntaxHighlight';
ve.ui.MWSyntaxHighlightTool.static.modelClasses = [ ve.dm.MWSyntaxHighlightNode ];
ve.ui.MWSyntaxHighlightTool.static.group = 'syntaxHighlight';
ve.ui.MWSyntaxHighlightTool.static.autoAdd = true;

/* Registration */

ve.ui.toolFactory.register( ve.ui.MWSyntaxHighlightTool );

/*
 * Factory for SyntaxHighlight tools.
 */
ve.ui.syntaxHighlightEditorToolFactory = new ve.ui.ToolFactory();

/* SyntaxHighlight Editor Tools */

ve.ui.MWSyntaxHighlightEditorTool = function VeUiMWSyntaxHighlightEditorTool( toolbar, config ) {
	// Parent constructor
	ve.ui.Tool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWSyntaxHighlightEditorTool, ve.ui.Tool );

ve.ui.MWSyntaxHighlightEditorTool.prototype.onSelect = function () {
	this.toolbar.context[this.constructor.static.method]();
	this.setActive( false );
};

ve.ui.MWSyntaxHighlightEditorTool.prototype.onUpdateState = function () {
	if ( this.constructor.static.name === 'synhiUndo' ){
		this.setDisabled( this.toolbar.context.undoStack.length === 0 );
	} else if ( this.constructor.static.name === 'synhiRedo' ){
		this.setDisabled( this.toolbar.context.redoStack.length === 0 );
	}
};

ve.ui.MWSynHiUndoTool = function VeUiMWSynhiUndoTool( toolbar, config ) {
	ve.ui.MWSyntaxHighlightEditorTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWSynHiUndoTool, ve.ui.MWSyntaxHighlightEditorTool );
ve.ui.MWSynHiUndoTool.static.name = 'synhiUndo';
ve.ui.MWSynHiUndoTool.static.group = 'synhiEditorTool';
ve.ui.MWSynHiUndoTool.static.method = 'undo';
ve.ui.MWSynHiUndoTool.static.icon = 'undo';
ve.ui.MWSynHiUndoTool.static.titleMessage = 'visualeditor-historybutton-undo-tooltip';
ve.ui.MWSynHiUndoTool.static.autoAdd = false;
ve.ui.syntaxHighlightEditorToolFactory.register( ve.ui.MWSynHiUndoTool );

ve.ui.MWSynHiRedoTool = function VeUiMWSynHiRedoTool( toolbar, config ) {
	ve.ui.MWSyntaxHighlightEditorTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWSynHiRedoTool, ve.ui.MWSyntaxHighlightEditorTool );
ve.ui.MWSynHiRedoTool.static.name = 'synhiRedo';
ve.ui.MWSynHiRedoTool.static.group = 'synhiEditorTool';
ve.ui.MWSynHiRedoTool.static.method = 'redo';
ve.ui.MWSynHiRedoTool.static.icon = 'redo';
ve.ui.MWSynHiRedoTool.static.titleMessage = 'visualeditor-historybutton-redo-tooltip';
ve.ui.MWSynHiRedoTool.static.autoAdd = false;
ve.ui.syntaxHighlightEditorToolFactory.register( ve.ui.MWSynHiRedoTool );

ve.ui.MWSynHiIndentTool = function VeUiMWSynHiIndentTool( toolbar, config ) {
	ve.ui.MWSyntaxHighlightEditorTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWSynHiIndentTool, ve.ui.MWSyntaxHighlightEditorTool );
ve.ui.MWSynHiIndentTool.static.name = 'synhiIndent';
ve.ui.MWSynHiIndentTool.static.group = 'synhiEditorTool';
ve.ui.MWSynHiIndentTool.static.method = 'indent';
ve.ui.MWSynHiIndentTool.static.icon = 'indent-list';
ve.ui.MWSynHiIndentTool.static.titleMessage = '';
ve.ui.MWSynHiIndentTool.static.autoAdd = false;
ve.ui.syntaxHighlightEditorToolFactory.register( ve.ui.MWSynHiIndentTool );

ve.ui.MWSynHiBeautifyTool = function VeUiMWSynHiBeautifyTool( toolbar, config ) {
	ve.ui.MWSyntaxHighlightEditorTool.call( this, toolbar, config );
};
ve.inheritClass( ve.ui.MWSynHiBeautifyTool, ve.ui.MWSyntaxHighlightEditorTool );
ve.ui.MWSynHiBeautifyTool.static.name = 'synhiBeautify';
ve.ui.MWSynHiBeautifyTool.static.group = 'synhiEditorTool';
ve.ui.MWSynHiBeautifyTool.static.method = 'doBeautify';
ve.ui.MWSynHiBeautifyTool.static.icon = 'reformat';
ve.ui.MWSynHiBeautifyTool.static.titleMessage = '';
ve.ui.MWSynHiBeautifyTool.static.autoAdd = false;
ve.ui.syntaxHighlightEditorToolFactory.register( ve.ui.MWSynHiBeautifyTool );