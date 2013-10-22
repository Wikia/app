/*!
 * VisualEditor user interface MWSyntaxHighlightDialog class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * SimpleSurface is designed for MWSyntaxHighlight nodes which contains node model data and view.
 * Not compatible with other nodes.
 *
 * @class
 * @extends ve.Element
 *
 * @constructor
 * @param {String} data MWSyntaxHighlight model data
 * @param {String} lang The language being edited
 */
ve.ui.MWSyntaxHighlightSimpleSurface = function VeUiMWSyntaxHighlightSimpleSurface( data, lang ) {
	// Parent constructor
	ve.Element.call( this );
	// Surface properties
	this.lang = lang;
	// Character dimension; in px
	this.charDimension = { 'height' : 0, 'width' : 0 };
	// Node model data and tokenized data
	this.model = data;
	this.tokens = null;
	// Helpers
	this.tokenizer = null;
	this.highlighter = null;
	// Edit stack
	this.undoStack = [];
	this.redoStack = [];
	// Mouse input properties
	this.mouseDown = false;
	this.mouseMove = false;
	this.cursorInterval = null;	// Cursor blink timer
	this.selection = {
		'view' : {
			'start' : { 'x' : 0, 'y' : 0 },
			'end' : { 'x' : 0, 'y' : 0 }
		},
		'model' : { 'start': 0, 'end' : 0 },
		'modelSorted' : { 'start': 0, 'end' : 0 }
	};
	this.modelUnseleted = { 'left': '', 'right':'' };
	// Key input properties
	this.input = {
		'start' : -1,
		'old' : '',
		'newer' : '',
		'pushReady' : false
	};
	this.inputPushDelimiter = /\W/;
	// Cache
	this.cache = {
		'editboxHeight': Infinity,
		'editboxScroll': 0
	};

	// Element properties
	// Toolbar
	this.$toolbarLayer = this.$$( '<div>' );
	this.$toolbar = this.$$( '<div>' );
	this.$buttonUndo = this.$$( '<a>' );
	this.$buttonRedo = this.$$( '<a>' );
	this.$buttonIndent = this.$$( '<a>' );
	this.$buttonBeautify = this.$$( '<a>' );
	this.$langDropdown = this.$$( '<select>' );
	// Editbox
	this.$editboxLayer = this.$$( '<div>' );
	this.$lineNumberLayer = this.$$( '<div>' );
	this.$lineNumber = this.$$( '<div>' );
	this.$textLayer = this.$$( '<div>' );
	this.$text = this.$$( '<div>' );
	this.$lineWrap = this.$$( '<div>' );
	// Cursor
	this.$cursorLineOverlay = this.$$( '<div>' );
	this.$cursor = this.$$( '<div>' );
	// Selection & clipboard
	this.$selectionOverlay = this.$$( '<div>' );
	this.$selectionTextarea = this.$$( '<textarea>' );
	// Search & replace
	this.$searchContainer = this.$$( '<div>' );
	this.$searchBox = this.$$( '<input>' );
	this.$replaceBox = this.$$( '<input>' );
	this.$buttonSearch = this.$$( '<a>' );
	this.$buttonReplace = this.$$( '<a>' );
	this.searchRegex = null;
	this.searchHasResult = false;

	this.toolbar = new ve.ui.Toolbar( ve.ui.syntaxHighlightEditorToolFactory, { '$$': this.$$ });
	this.toolbar.setup([{
		'include':[ 'synhiUndo', 'synhiRedo', 'synhiIndent', 'synhiBeautify' ]
	}]);
	this.toolbar.context = this;
	// Initialization
	this.$
		.addClass( 've-ui-simplesurface' );
	this.$toolbarLayer
		.addClass( 've-ui-simplesurface-container-toolbar' )
		.append(
			this.$toolbar
				.addClass( 've-ui-simplesurface-toolbar' )/*
				.append(
					this.$buttonUndo.$
						.addClass('ve-ui-simplesurface-toolbar-button')
						.addClass('ve-ui-icon-undo') )
				)
				.append(
					this.$buttonRedo
						.addClass('ve-ui-simplesurface-toolbar-button')
						.addClass('ve-ui-icon-redo') )
				.append(
					this.$buttonIndent
						.addClass('ve-ui-simplesurface-toolbar-button')
						.addClass('ve-ui-icon-indent-list') )
				.append(
					this.$buttonBeautify
						.addClass('ve-ui-simplesurface-toolbar-button')
						.addClass('ve-ui-icon-reformat') )*/
				.append(
					this.$langDropdown
						.addClass('ve-ui-simplesurface-toolbar-dropdown') )
		);
	this.$editboxLayer
		.addClass( 've-ui-simplesurface-container-editbox' )
		.append( this.$lineNumberLayer
				.addClass( 've-ui-simplesurface-container-editbox-lineNumber' )
				.append( this.$lineNumber
						.addClass( 've-ui-simplesurface-lineNumber' ) ) )
		.append(
			this.$textLayer
				.addClass( 've-ui-simplesurface-container-editbox-text' )
				.append(
					this.$lineWrap
						.addClass( 've-ui-simplesurface-text-linewrap' ) )
				.append(
					this.$selectionOverlay
						.addClass( 've-ui-simplesurface-container-text-selection' ) )
				.append(
					this.$cursorLineOverlay
						.addClass( 've-ui-simplesurface-cursor-line' )
						.append(
							this.$cursor
								.addClass( 've-ui-simplesurface-cursor' ) ) )
				.append(
					this.$text
						.addClass( 've-ui-simplesurface-text' ) ) )
		.append(
			this.$selectionTextarea
				.addClass( 've-ui-simplesurface-textarea' ) );
	this.$searchContainer
		.addClass( 've-ui-simplesurface-container-search' )
		.append( this.$searchBox )
		.append( this.$buttonSearch
				.addClass('ve-ui-simplesurface-toolbar-button')
				.addClass('ve-ui-icon-search') )
		.append( this.$replaceBox )
		.append( this.$buttonReplace
				.addClass('ve-ui-simplesurface-toolbar-button')
				.addClass('ve-ui-icon-replace') );
	// Make instance globally accessible for debugging
	ve.instances.push( this );
};

/* Inheritance */

ve.inheritClass( ve.ui.MWSyntaxHighlightSimpleSurface , ve.Element );

/* Methods */

/**
 * Initialization
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.initialize = function () {
	// Initialize helpers
	this.tokenizer = new ve.dm.MWSyntaxHighlightTokenizer();
	this.highlighter = new ve.ce.MWSyntaxHighlightHighlighter(this.lang);
	// Check language support
	if ( this.highlighter.isSupportedLanguage( this.lang ) ){
		if ( !this.highlighter.isEnabledLanguage( this.lang ) ){
			this.$.append( this.$$( '<div>' ).text( 'Cannot edit: ' + this.lang + '\nSupport has been disabled.' ) );
		} else {
			var langList = this.highlighter.getSupportedLanguages(), key, options = '',
				self;
			// Language dropdown
			for (key in langList){
				if (key === this.lang){
					options += '<option value="'+key+'" selected>'+key.charAt(0).toUpperCase() + key.slice(1)+'</option>';
				} else {
					options += '<option value="'+key+'">'+key.charAt(0).toUpperCase() + key.slice(1)+'</option>';
				}
			}
			this.$langDropdown.html(options);
			// Main editor interface
			this.$
				.append( this.$toolbarLayer )
				.append( this.toolbar.$ )
				.append( this.$editboxLayer.append( this.$searchContainer ) );
			// Event handlers
			this.$textLayer
				.on( 'mousedown', ve.bind(this.onMousedown, this))
				.on( 'mousemove mouseleave', ve.bind(this.onMousemove, this))
				.on( 'mouseup', ve.bind(this.onMouseup, this))
				.on( 'keypress', ve.bind(this.onKeypress, this))
				.on( 'keydown', ve.bind(this.onKeydown, this));
			this.$text.on( 'blur', ve.bind(this.hideCursor, this));
			this.$lineNumber.on( 'click', 'pre', ve.bind(this.selectLine, this));
			/*this.$buttonUndo.on( 'click',
				ve.bind(function(e){
					if (!this.$buttonUndo.hasClass('ve-ui-simplesurface-toolbar-button-disabled')){
						e.preventDefault();
						e.which = 90;
						e.ctrlKey = true;
						this.onKeydown(e);
					}
				}, this));
			this.$buttonRedo.on( 'click',
				ve.bind(function(e){
					if (!this.$buttonRedo.hasClass('ve-ui-simplesurface-toolbar-button-disabled')){
						e.preventDefault();
						e.which = 89;
						e.ctrlKey = true;
						this.onKeydown(e);
					}
				}, this));
			this.$buttonIndent.on( 'click', ve.bind(function(e){
					e.preventDefault();
					this.indent();
					return false;
				}, this));
			this.$buttonBeautify.on( 'click', ve.bind(function(e){
					e.preventDefault();
					this.doBeautify();
					return false;
				}, this) );
			*/
			this.$editboxLayer.on( 'scroll', ve.bind(function(){
					this.cacheUpdate();
					if (this.$searchContainer.css('display') !== 'none' ){
						this.$searchContainer
							.stop(true, true)
							.animate({top:this.cache.editboxScroll}, 100);
					}
				}, this) );
			this.$langDropdown.on( 'change', ve.bind(function(){
					this.reloadRules();
				}, this));
			this.$searchBox.on(
				'keydown mouseup cut paste change input select',
				ve.bind( this.onSearchInput, this )
			);
			this.$buttonSearch.on( 'click', ve.bind(this.searchStep, this) );
			this.$buttonReplace.on( 'click', ve.bind(this.searchReplace, this) );
			this.$selectionTextarea.on( 'copy paste cut', ve.bind(this.onClipboard, this) );
			$(window).bind('resize', ve.bind(this.cacheUpdate, this));	// Used to update cached css values

			// Initialize helpers
			this.highlighter.initialize();
			this.tokenize();
			this.refresh();
			// Measure character metric
			this.charDimension.height = parseInt(this.$lineNumber.find('pre:first').find('span').css('font-size'), 10) * 2;
			this.charDimension.width = this.$lineNumber.find('pre:first').find('span').width();
			// Line wrap position
			this.$lineWrap.css({'left':80 * this.charDimension.width});
			// Make focusable
			this.$text.attr('tabindex','-1');
			this.$selectionTextarea.attr('tabindex','-1');
			// Caching
			self = this;
			setTimeout(function(){
				self.cache.editboxScroll = self.$editboxLayer.scrollTop();
				self.cache.editboxHeight = self.$editboxLayer.outerHeight();
				}, 500);	// <500 ms not working
			// Initialize undo/redo buttons; show cursor
			this.checkStack();
			this.createSelection();
		}
	} else {
		this.$.append( this.$$( '<div>' ).text( 'Cannot edit: ' + this.lang + '\nLanguage not supported.') );
	}
};

/**
 * Destroy the surface, removing all DOM elements and event listeners.
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.destroy = function () {
	ve.instances.splice( ve.instances.indexOf( this ), 1 );
	// Turn off event handlers
	this.$textLayer.off( 'mousedown mousemove mouseup mouseleave keypress keydown' );
	this.$text.off( 'blur' );
	this.$lineNumber.off( 'click' );/*
	this.$buttonUndo.off( 'click' );
	this.$buttonRedo.off( 'click' );
	this.$buttonIndent.off( 'click' );
	this.$buttonBeautify.off( 'click' );*/
	this.$editboxLayer.off( 'scroll' );
	this.$langDropdown.off( 'change' );
	this.$searchBox.off( 'keydown mouseup cut paste change input select' );
	this.$buttonSearch.off( 'click' );
	this.$buttonReplace.off( 'click' );
	this.$selectionTextarea.off( 'copy paste cut' );
	$(window).unbind('resize', this.cacheUpdate);
	// Clean up
	this.$.empty();
	this.stopBlinkCursor();
};

/**
 * Get the surface's model
 *
 * @method
 * @returns {string} Node model data
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.getModel = function () {
	return this.model;
};

/**
 * Update cache
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.cacheUpdate = function () {
	this.cache.editboxScroll = this.$editboxLayer.scrollTop();
	this.cache.editboxHeight = this.$editboxLayer.outerHeight();
};

/**
 * Reload rules
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.reloadRules = function () {
	this.lang = this.$langDropdown.val();
	this.highlighter.loadRules(this.lang);
	this.tokenize();
	this.refresh();
};

/**
 * Get the language that this surface is working on
 *
 * @method
 * @returns {string} Language name
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.getLang = function () {
	return this.lang;
};

/**
 * Tokenize model data;
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.tokenize = function () {
	this.tokens = this.tokenizer.tokenize(this.model);
};

/**
 * Display tokenized data
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.refresh = function () {
	// Highlight
	this.tokens = this.highlighter.mark( this.tokens, this.model, false );
	// Validate
	this.tokens = this.highlighter.mark( this.tokens, this.model, true );
	var marked = this.highlighter.display( this.tokens );
	this.$text.html( marked.tokenDisplay );
	this.$lineNumber.html( marked.lineNumber );
};

/**
 * Auto indentation
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.indent = function () {
	this.pushStack();
	var r = [
		[/\{/, /\}/],
		[/\[/, /\]/],
		[/\(/, /\)/]
	],
	i;
	for ( i = 0; i < r.length; i++ ){
		this.doIndent(r[i]);
	}
	// Reset cursor
	this.selection.model.start = 0;
	this.selection.model.end = 0;
	this.createSelection();
};

/**
 * Helper method for auto indentation
 *
 * @method
 * @param {Array} regexGroup RegExp objects
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.doIndent = function ( regexGroup ) {
	var a = [], c,
		l = [],
		match,
		A = regexGroup[0],
		B = regexGroup[1],
		regex = new RegExp('['+A.source + B.source+']', 'g'),
		i, j,
		lineArray = this.model.split('\n');
	// Stack based search; record block levels
	while ( (match = regex.exec( this.model ) ) !== null ){
		if (A.test(match[0])){
			a.push(match.index);
		} else {
			if (a.length !== 0){
				c = a.pop();
				l.push({
					'idx': [this.modelToView(c).y, this.modelToView(match.index).y],
					'lvl': a.length + 1
				});
			}
		}
	}
	l.sort(function(a, b){return a.idx[0] - b.idx[0];});
	// Replace whitespaces within each block
	for ( i = 0; i < l.length; i++ ){
		for ( j = l[i].idx[0] + 1; j < l[i].idx[1]; j++ ){
			lineArray[j] = lineArray[j].replace(/^[ \t]*/, new Array( l[i].lvl + 1 ).join('\t'));
		}
	}
	// Treat changes as one edit
	this.selection.model.start = 0;
	this.selection.model.end = this.model.length;
	this.createSelection();
	this.input.newer = lineArray.join('\n');
	this.edit();
	this.clearStack();
};

/**
 * Beautify code
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.doBeautify = function () {
	this.pushStack();
	// Head & tail spaces
	var headTail = /(\w *?)([\+\-\*\/\=><\|\&\%\!\:\?]+)( *?\w)/g,
	// Inbetween spaces
		between = /(\( *?.+ *?\)|\[ *?.+ *?\]|\{ *?.+ *?\}|< *?.+ *?>)/g,
	// Tail only spaces
		tail = /(\w *?)([,;])(?=\w)/g,
	// Tab spaces
		tabSpace = /( {4}| {8})/g,
	// Compress duplicate spaces
		dupSpace = /( {2,})/g,
	// Delete trailing whitespaces
		trailSpace = /([\t ]+)(?=$)/gm,
	// Exclusion
		exclude = [ new RegExp('(\"[^]*?\")','g'), /('[^]*?')/g ],
		match, exclusions = [], i,
		modelCache = [],
	// Helper for inbetween spaces
		betweenFunc = function(match){
			return match.slice(0,1) + ' '+match.slice(1,match.length-1)+' '+match.slice(match.length-1);
		};
	// Calculate exclusions
	for ( i = 0; i < exclude.length; i++ ){
		while ( (match = exclude[i].exec( this.model ) ) !== null ){
			exclusions.push({'a': match.index, 'b': match.index + match[1].length});
		}
	}
	exclusions.sort(function(a, b){ return a.a - b.a; });
	// Slice model
	if (exclusions.length === 0){
		modelCache.push({
			'text':this.model,
			'after':''
		});
	} else {
		for ( i = 0; i < exclusions.length; i++ ){
			if ( i >= 1 ){
				modelCache.push({
					'text':this.model.slice(exclusions[i-1].b, exclusions[i].a),
					'after':this.model.slice(exclusions[i].a, exclusions[i].b)
				});
			} else {
				modelCache.push({
					'text':this.model.slice(0, exclusions[i].a),
					'after':this.model.slice(exclusions[i].a, exclusions[i].b)
				});
			}
			if ( i === exclusions.length - 1){
				if (exclusions[i].b < this.model.length){
					modelCache.push({
						'text':this.model.slice(exclusions[i].b),
						'after':''
					});
				}
			}
		}
	}
	// Reformat
	for ( i = 0; i < modelCache.length; i++ ){
		modelCache[i].text = modelCache[i].text.replace( headTail, '$1 $2 $3');
		modelCache[i].text = modelCache[i].text.replace( between, betweenFunc);
		modelCache[i].text = modelCache[i].text.replace( tail, '$1$2 ');
		modelCache[i].text = modelCache[i].text.replace( tabSpace, '\t');
		modelCache[i].text = modelCache[i].text.replace( dupSpace, ' ');
		modelCache[i].text = modelCache[i].text.replace( trailSpace, '');
		modelCache[i] = modelCache[i].text + modelCache[i].after;
	}
	// Treat changes as one edit
	this.selection.model.start = 0;
	this.selection.model.end = this.model.length;
	this.createSelection();
	this.input.newer = modelCache.join('');
	this.edit();
	this.clearStack();
	// Auto indent
	this.indent();
};

/**
 * Toolbar button handler
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.onButtonUndo = function () {
	var e = jQuery.Event();
	e.which = 90;
	e.ctrlKey = true;
	this.onKeydown(e);
};

/**
 * Toolbar button handler
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.onButtonRedo = function () {
	var e = jQuery.Event();
	e.which = 89;
	e.ctrlKey = true;
	this.onKeydown(e);
};

/**
 * Mouse down handler
 *
 * @method
 * @param {jQuery.Event} event
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.onMousedown = function ( event ) {
	event.preventDefault();
	this.stopBlinkCursor();
	this.pushStack();
	this.mouseDown = true;
	var model = this.viewToModel(
		this.checkViewBounding( this.findLocalView(event, this.$textLayer) )
	);
	if (this.mouseMove){
		this.selection.model.end = model;
		this.createSelection();
		this.showSelection();
	} else {
		this.hideSelection();
		this.selection.model.start = model;
		this.selection.model.end = model;
		this.createSelection();
	}
	return false;
};

/**
 * Mouse move and mouse leave handler
 *
 * @method
 * @param {jQuery.Event} event
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.onMousemove = function ( event ) {
	event.preventDefault();
	if (this.mouseDown){
		if (event.type === 'mousemove'){
			this.selection.model.end = this.viewToModel(
				this.checkViewBounding( this.findLocalView(event, this.$textLayer) )
			);
			this.mouseMove = true;
			this.createSelection();
			this.showSelection();
		}
	}
	return false;
};

/**
 * Mouse up handler
 *
 * @method
 * @param {jQuery.Event} event
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.onMouseup = function ( event ) {
	event.preventDefault();
	this.mouseDown = false;
	this.mouseMove = false;
	return false;
};

/**
 * Select a line
 *
 * @method
 * @param {jQuery.Event} event
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.selectLine = function ( event ) {
	var lineIndex = this.findLocalView(event, this.$lineNumber).y;
	event.preventDefault();
	this.pushStack();
	this.selection.model.start = this.viewToModel({ 'x': 0 , 'y': lineIndex });
	this.selection.model.end = this.viewToModel(this.checkViewBounding({ 'x' : 0 , 'y' : lineIndex + 1}));
	if (this.selection.model.start === this.selection.model.end){
		this.selection.model.end = this.viewToModel(this.checkViewBounding({ 'x' : Infinity, 'y': lineIndex}));
	}
	this.createSelection();
	this.showSelection();
	if (this.mouseMove){ this.mouseMove = false; }
	if (this.mouseDown){ this.mouseDown = false; }
	return false;
};

/**
 * User input handler; characters
 *
 * @method
 * @param {jQuery.Event} event
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.onKeypress = function ( event ) {
	var charIn = String.fromCharCode(event.which);
	if ( event.which === 13 ){
		charIn = '\n';
	}
	this.input.newer += charIn;
	this.input.pushReady = true;
	this.edit(false);
	if (this.inputPushDelimiter.test(charIn)){
		this.pushStack();
	}
	return false;
};

/**
 * User input handler; non-characters
 *
 * @method
 * @param {jQuery.Event} event
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.onKeydown = function ( event ) {
	var key = event.which,
		ctrl = event.ctrlKey,
		shift = event.shiftKey;
	this.stopBlinkCursor();
	if ( key === 9 ){	// Tab
		event.preventDefault();
		// Previous operation
		this.pushStack();
		if (this.selection.model.start === this.selection.model.end){
			// Simple insertion
			event.which = 9;
			this.onKeypress(event);
		} else {
			// Initialize selection range
			this.selection.modelSorted.start = this.selection.view.start.y > this.selection.view.end.y ?
				parseInt(this.$text.find('pre:eq('+this.selection.view.end.y+')').find('span:first').attr('idx'),10) :
				parseInt(this.$text.find('pre:eq('+this.selection.view.start.y+')').find('span:first').attr('idx'),10);
			this.input.start = this.selection.modelSorted.start;
			this.input.old = this.model.slice(this.selection.modelSorted.start, this.selection.modelSorted.end);
			this.modelUnseleted.left = this.model.slice(0, this.selection.modelSorted.start);
			this.modelUnseleted.right = this.model.slice( this.selection.modelSorted.end );
			// Insert / remove tabs
			if (shift){
				this.input.newer = this.input.old.replace(/^\t/gm, '');
			} else {
				this.input.newer = this.input.old.replace(/^/gm, '\t');
			}
			this.hideSelection();
			// Edit
			this.model = [this.modelUnseleted.left,
				this.input.newer,
				this.modelUnseleted.right].join('');
			this.input.pushReady = true;
			// Refresh
			this.pushStack();
			this.tokenize();
			this.refresh();
			this.selection.model.end = this.modelUnseleted.left.length + this.input.newer.length;
			this.createSelection();
		}
	} else if ( key === 8 ){	// Backspace
		event.preventDefault();
		this.pushStack();	// Previous operation
		if (this.selection.model.start === this.selection.model.end){
			// Delete one character
			this.selection.model.start = this.checkViewBounding(this.selection.model.start - 1);
			this.createSelection();
		}
		this.input.newer = '';
		this.edit(false);
		// This operation
		this.input.pushReady = true;
		this.pushStack();
	} else if ( key === 46 ){	// Delete
		event.preventDefault();
		this.pushStack();	// Previous operation
		if (this.selection.model.start === this.selection.model.end){
			// Delete one character
			this.selection.model.end = this.checkModelBounding(this.selection.model.end + 1);
			this.createSelection();
		}
		this.input.newer = '';
		this.edit(false);
		// This operation
		this.input.pushReady = true;
		this.pushStack();
	} else if ( key === 90 && ctrl ){	// Ctrl + Z, undo
		event.preventDefault();
		this.pushStack();	// Undo the current unstacked operation, if any
		this.undo();
	} else if ( key === 89 && ctrl ){	// Ctrl + Y, redo
		event.preventDefault();
		this.redo();
	} else if ( key === 65 && ctrl ){	// Ctrl + A, select all
		event.preventDefault();
		this.selection.model.start = 0;
		this.selection.model.end = this.checkModelBounding(Infinity);
		this.createSelection();
		this.showSelection();
	} else if ( key >= 37 && key <= 40 ){	// Arrow keys
		event.preventDefault();
		this.pushStack();	// Previous operation
		this.hideSelection();
		if ( key === 37 ){	// Left
			this.selection.model.end = this.checkModelBounding( this.selection.model.end - 1);
		} else if ( key === 39 ){	// Right
			this.selection.model.end = this.checkModelBounding( this.selection.model.end + 1);
		} else if ( key === 38 ){	// Up
			this.selection.model.end = this.viewToModel(
				this.checkViewBounding({
					'x': this.selection.view.end.x,
					'y': this.selection.view.end.y - 1 })
			);
		} else if ( key === 40 ){	// Down
			this.selection.model.end = this.viewToModel(
				this.checkViewBounding({
					'x': this.selection.view.end.x,
					'y': this.selection.view.end.y + 1 })
			);
		}
		if ( !shift ){
			this.selection.model.start = this.selection.model.end;
		}
		this.createSelection();
		if (shift){
			this.showSelection();
		}
	} else if ( key === 70 && ctrl ){	// Ctrl + F, search & replace
		event.preventDefault();
		this.pushStack();
		this.$searchContainer.css('display','inline-block');
		this.$searchBox.focus();
	} else if ( key === 67 && ctrl ){	// Ctrl + C, copy; preliminary actions
		this.pushStack();
		if (this.selection.model.start !== this.selection.model.end){
			this.$selectionTextarea.focus();
		}
	} else if ( key === 86 && ctrl ){	// Ctrl + V, paste; preliminary actions
		this.pushStack();	// Previous operation
		this.$selectionTextarea.focus();
	} else if ( key === 88 && ctrl ){	// Ctrl + X, cut; preliminary actions
		this.pushStack();
		if (this.selection.model.start !== this.selection.model.end){
			this.$selectionTextarea.focus();
		}
	} else if ( key === 27 ){	// Esc
		this.pushStack();
		return false;
	}
};

/**
 * User input handler; clipboard events
 *
 * @method
 * @param {jQuery.Event} event
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.onClipboard = function ( event ) {
	var which = event.type,
		self = this;
	if ( which === 'copy' ){
		this.$selectionTextarea.get(0).value = this.model.slice(this.selection.modelSorted.start, this.selection.modelSorted.end);
		this.$selectionTextarea.select();
		// Callback after event is handled by browser
		setTimeout(function(){
			self.$text.focus();
			self.showCursor();
			self.startBlinkCursor();
		},0);
	} else if ( which === 'paste' ){
		this.$selectionTextarea.select();
		// Callback after event is handled by browser
		setTimeout(function(){
			self.input.newer = self.$selectionTextarea.get(0).value;
			self.edit(false);
			// This operation
			self.input.pushReady = true;
			self.pushStack();
		},0);
	} else if ( which === 'cut' ){
		this.$selectionTextarea.get(0).value = this.model.slice(this.selection.modelSorted.start, this.selection.modelSorted.end);
		this.$selectionTextarea.select();
		// Callback after event is handled by browser
		setTimeout(function(){
			event.which = 8;
			self.onKeydown(event);
		},0);
	}
};

/**
 * Edit model data based on current operation
 *
 * @method
 * @param {boolean} setOld (optional) Parameter passed to createSelection()
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.edit = function ( setOld ) {
	this.hideSelection();
	this.model = [this.modelUnseleted.left,
		this.input.newer,
		this.modelUnseleted.right].join('');
	this.tokenize();
	this.refresh();
	this.selection.model.start = this.modelUnseleted.left.length;
	this.selection.model.end = this.modelUnseleted.left.length + this.input.newer.length;
	this.createSelection(setOld);
};

/**
 * Push operation to history
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.pushStack = function () {
	if (this.input.pushReady){
		this.input.pushReady = false;
		this.undoStack.push(this.copyStack(this.input));
		this.clearStack();
		this.checkStack();
	}
};

/**
 * Clear & reset current operation
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.clearStack = function () {
	this.input.start = -1;
	this.input.old = '';
	this.input.newer = '';
	this.input.pushReady = false;
	this.selection.model.start = this.selection.model.end;
	this.createSelection();
};

/**
 * Reverse operation
 *
 * @method
 * @param {Object} stack Operation
 * @returns {Object} Reversed operation
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.reverseStack = function ( stack ) {
	return {
		'start':stack.start,
		'old':stack.newer,
		'newer':stack.old,
		'pushReady':stack.pushReady
	};
};

/**
 * Deep copy operation
 *
 * @method
 * @param {Object} stack Operation
 * @returns {Object} Deep copy of the operation
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.copyStack = function ( stack ) {
	return {
		'start':stack.start,
		'old':stack.old,
		'newer':stack.newer,
		'pushReady':stack.pushReady
	};
};

/**
 * Redo operations; one at each time
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.redo = function () {
	if (this.redoStack.length !== 0){
		this.input = this.redoStack.pop();
		this.selection.model.start = this.input.start;
		this.selection.model.end = this.input.start + this.input.old.length;
		this.createSelection();
		this.edit(false);
		this.input.pushReady = true;
		this.pushStack();
	}
};

/**
 * Undo operations; one at each time
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.undo = function () {
	var toDo;
	if (this.undoStack.length !== 0){
		toDo = this.undoStack.pop();
		this.input = this.reverseStack(toDo);
		this.selection.model.start = this.input.start;
		this.selection.model.end = this.input.start + this.input.old.length;
		this.createSelection();
		this.edit();
		this.redoStack.push(this.copyStack(toDo));
		this.clearStack();
		this.checkStack();
	}
};

/**
 * Check stack height and style undo, redo buttons
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.checkStack = function () {
	this.toolbar.emit( 'updateState' );
	/*
	if ( this.undoStack.length === 0 ){	// Grey out
		this.$buttonUndo.addClass('ve-ui-simplesurface-toolbar-button-disabled');
	} else {
		this.$buttonUndo.removeClass('ve-ui-simplesurface-toolbar-button-disabled');
	}
	if ( this.redoStack.length === 0 ){	// Grey out
		this.$buttonRedo.addClass('ve-ui-simplesurface-toolbar-button-disabled');
	} else {
		this.$buttonRedo.removeClass('ve-ui-simplesurface-toolbar-button-disabled');
	}
	*/
};

/**
 * Check rounded view index against view borders
 *
 * @method
 * @param {Object} roundedIndex Rounded line / column index
 * @returns {Object} Bounded line / column index
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.checkViewBounding = function ( roundedIndex ){
	var lineLength, docHeight,
		tmp;
	// vertical bound
	docHeight = this.$text.find('div').children('pre').length;
	if (roundedIndex.y >= docHeight){
		roundedIndex.y = docHeight - 1;
	} else if (roundedIndex.y < 0){
		roundedIndex.y = 0;
	}
	// horizontal bound
	tmp = this.$text.find('div pre:eq('+roundedIndex.y+')');
	// ignore line breaks & phantom
	lineLength =
		tmp.find('span:last').text() === '\n' || tmp.find('span:last').attr('ph') ?
			parseInt(tmp.attr('length'), 10) - 1 : parseInt(tmp.attr('length'), 10);
	if (roundedIndex.x < 0){
		roundedIndex.x = 0;
	} else {
		roundedIndex.x = roundedIndex.x > lineLength ? lineLength : roundedIndex.x;
	}
	return roundedIndex;
};

/**
 * Check model index against model borders
 *
 * @method
 * @param {int} model Model index
 * @returns {int} Bounded model index
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.checkModelBounding = function ( model ){
	if (model < 0){
		model = 0;
	} else if (model > this.model.length){
		model = this.model.length;
	}
	return model;
};

/**
 * Convert mouse coordinate to local view coordinate
 *
 * @method
 * @param {jQuery.Event} event
 * @param {jQuery.Object} localTarget Editor element object
 * @returns {Object} Line / column coordinate
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.findLocalView = function ( event, localTarget ){
	var x = (event.pageX - localTarget.offset().left) / this.charDimension.width,
		y = (event.pageY - localTarget.offset().top) / this.charDimension.height;
	if ( y >= Math.ceil(y) - 0.1 ){	// Advance to next line
		y = Math.ceil(y);
	} else {	// Keep within current line
		y = Math.floor(y);
	}
	x = Math.round(x);
	return {
		'x' : x,
		'y' : y
	};
};

/**
 * Start blinking cursor
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.startBlinkCursor = function () {
	if (!this.cursorInterval){
		var self = this;
		this.cursorInterval = setInterval( function(){
			if (self.$cursor.css('display') === 'none'){
				self.$cursor.css('display','block');
			} else {
				self.$cursor.css('display','none');
			}
		} , 500);
	}
};

/**
 * Stop blinking cursor
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.stopBlinkCursor = function () {
	if (this.cursorInterval){
		clearInterval( this.cursorInterval );
		this.cursorInterval = null;
	}
};

/**
 * Sort selection model indices, initialize an operation, show cursor view
 *
 * @method
 * @param {boolean} setOld (optional) Whether to affect operation's .old value; default is true
 * @param {boolean} suppressFocus (optional) Whether to prevent focusing editing area; default is false
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.createSelection = function ( setOld, suppressFocus ) {
	if (setOld === undefined ){
		setOld = true;
	}
	if (suppressFocus === undefined ){
		suppressFocus = false;
	}
	this.selection.view.start = this.modelToView( this.selection.model.start );
	this.selection.view.end = this.modelToView( this.selection.model.end );
	this.selection.modelSorted.start = this.selection.model.start > this.selection.model.end ?
		this.selection.model.end : this.selection.model.start;
	this.selection.modelSorted.end = this.selection.model.start > this.selection.model.end ?
		this.selection.model.start : this.selection.model.end;
	this.input.start = this.selection.modelSorted.start;
	if (setOld){
		this.input.old = this.model.slice(this.selection.modelSorted.start, this.selection.modelSorted.end);
	}
	this.modelUnseleted.left = this.model.slice(0, this.selection.modelSorted.start);
	this.modelUnseleted.right = this.model.slice( this.selection.modelSorted.end );
	if (!suppressFocus){
		this.$text.focus();
	}
	this.showCursor();
};

/**
 * Show cursor; scroll editor window if necessary
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.showCursor = function () {
	this.$cursorLineOverlay.css({
		'left':0,
		'top':this.selection.view.end.y * this.charDimension.height,
		'height':this.charDimension.height,
		'width':this.$editboxLayer.width() - parseInt(this.$textLayer.css('margin-left'), 10) - 1,
		'display':'block'
	});
	this.$cursor.css({
		'left': this.selection.view.end.x * this.charDimension.width,
		'width':this.charDimension.width,
		'display':'block'
	});
	this.startBlinkCursor();
	var bottomDiff = (this.selection.view.end.y + 1) * this.charDimension.height - this.cache.editboxScroll - this.cache.editboxHeight,
		topDiff = this.cache.editboxScroll - this.selection.view.end.y * this.charDimension.height;
	if ( bottomDiff > 0 ){
		this.$editboxLayer
			.stop(true, true)
			.animate({scrollTop:this.cache.editboxScroll + bottomDiff}, 100);
	} else if ( topDiff > 0 ){
		this.$editboxLayer
			.stop(true, true)
			.animate({scrollTop: this.selection.view.end.y * this.charDimension.height}, 100);
	}
};

/**
 * Hide cursor
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.hideCursor = function () {
	this.stopBlinkCursor();
	this.$cursorLineOverlay.css({
		'display':'none'
	});
	this.$cursor.css({
		'display':'none'
	});
};

/**
 * Show selection highlight
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.showSelection = function () {
	this.$selectionOverlay.empty();
	var startLineIdx = this.selection.view.start.y,
		endLineIdx = this.selection.view.end.y,
		startCharIdx = this.selection.view.start.x,
		endCharIdx = this.selection.view.end.x,
		i;
	if (startLineIdx === endLineIdx){	// Same line
		if ( startCharIdx > endCharIdx ){
			startCharIdx = [endCharIdx, endCharIdx = startCharIdx][0];
		}
		this.$selectionOverlay
			.append(
				this.$$('<div>').addClass('ve-ui-simplesurface-text-selected')
				.css({
					'left':startCharIdx * this.charDimension.width,
					'top':startLineIdx * this.charDimension.height,
					'width':(endCharIdx - startCharIdx) * this.charDimension.width,
					'height':this.charDimension.height
				}) );
	} else {	// Different lines
		if ( startLineIdx > endLineIdx ) {
			startLineIdx = [endLineIdx, endLineIdx = startLineIdx][0];
			startCharIdx = [endCharIdx, endCharIdx = startCharIdx][0];
		}
		// First & last line
		this.$selectionOverlay
			.append(
				this.$$('<div>').addClass('ve-ui-simplesurface-text-selected')
				.css({
					'left':startCharIdx * this.charDimension.width,
					'top':startLineIdx * this.charDimension.height,
					'width':
						(this.checkViewBounding( {'x':Infinity,'y':startLineIdx } ).x + 1 - startCharIdx) *
							this.charDimension.width,
					'height':this.charDimension.height
				}) )
			.append(
				this.$$('<div>').addClass('ve-ui-simplesurface-text-selected')
				.css({
					'left':0,
					'top':endLineIdx * this.charDimension.height,
					'width': endCharIdx * this.charDimension.width,
					'height':this.charDimension.height
				}) );
		// Middle lines
		for ( i = startLineIdx + 1; i < endLineIdx; i++ ){
			this.$selectionOverlay
				.append(
					this.$$('<div>').addClass('ve-ui-simplesurface-text-selected')
					.css({
						'left': 0,
						'top': i * this.charDimension.height,
						'width': (this.checkViewBounding( {'x':Infinity, 'y':i } ).x + 1) * this.charDimension.width,
						'height':this.charDimension.height
					})
				);
		}
	}
	// Display to view
	this.$selectionOverlay.css('display','block');
};

/**
 * Hide selection highlight
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.hideSelection = function () {
	this.$selectionOverlay.empty();
	this.$selectionOverlay.css('display','none');
};

/**
 * Convert model index to view index
 *
 * @method
 * @param {int} model Model index
 * @returns {Object} View index
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.modelToView = function ( model ) {
	var match = [],
		$line = this.$text.find('pre'),
		i;
	for ( i = 0; i < $line.length; i++ ){
		if (parseInt($line.eq(i).attr('m'),10) <= model &&
				parseInt($line.eq(i).attr('n'),10) > model){
			break;
		}
	}
	$line = $line.eq(i).find('span');
	match = jQuery.grep($line,function(e){
		return (parseInt(e.getAttribute('idx'),10) <= model &&
			parseInt(e.getAttribute('idx'),10) + e.innerText.length > model);
	});
	return {
		'x': parseInt(match[match.length-1].getAttribute('col'), 10) +
				(model - parseInt(match[match.length-1].getAttribute('idx'), 10)),
		'y': i
	};
};

/**
 * Convert view index to model index
 *
 * @method
 * @param {Object} view View index
 * @returns {int} Model index
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.viewToModel = function ( view ) {
	var $lineChildren = this.$text.find('pre:eq('+view.y+')').find('span'),
		match = jQuery.grep( $lineChildren, function(e){
			return (
				parseInt(e.getAttribute('col'), 10) <= view.x &&
				parseInt(e.getAttribute('col'), 10) + e.innerText.length > view.x
			);
		}),
		model = match[match.length-1].hasAttribute('tb') ?
			parseInt(match[match.length-1].getAttribute('idx'), 10) :
				parseInt(match[match.length-1].getAttribute('idx'), 10) +
				view.x - parseInt(match[match.length-1].getAttribute('col'),10);
	return model;
};

/**
 * Search
 *
 * @method
 * @param {string} value Value to search
 * @returns {boolean} Whether there is a match
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.search = function ( value ) {
	var regex = new RegExp( value, 'g' );
	if ( !regex.test( this.model ) ){
		return false;
	} else {
		return true;
	}
};

/**
 * Search input handler
 *
 * @method
 * @param {jQuery.Event} event
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.onSearchInput = function ( event ) {
	if ( event.which === 27 ){	// Esc
		this.$searchContainer.css('display','none');
		this.$text.focus();
		return false;
	} else {
		setTimeout( ve.bind( function () {
			var value = this.$searchBox.get(0).value;
			if ( event === undefined ){
				event = {'which':0};
			}
			if ( event.which === 13 ){	// Enter key
				this.searchStep();
			} else if ( value !== '' ){
				if ( !this.search( value ) ){	// No match
					this.searchHasResult = false;
					this.$searchBox.css({
						'background':'red'
					});
				} else {
					this.searchRegex = new RegExp( this.$searchBox.get(0).value, 'g' );
					this.searchRegex.lastIndex = 0;
					this.searchHasResult = true;
					this.$searchBox.css({
						'background':'transparent'
					});
					this.searchStep();
				}
			} else {
				this.$searchBox.css({
					'background':'transparent'
				});
				this.hideSelection();
			}
		}, this ) );
	}
};

/**
 * Step search results
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.searchStep = function () {
	var match;
	if ( this.searchRegex && (match = this.searchRegex.exec( this.model )) !== null ){
		this.selection.model.start = match.index;
		this.selection.model.end = match.index + match[0].length;
		this.createSelection(undefined, true);
		this.showSelection();
	} else {
		this.onSearchInput();
	}
};

/**
 * Replace search result
 *
 * @method
 */
ve.ui.MWSyntaxHighlightSimpleSurface.prototype.searchReplace = function () {
	if ( this.searchHasResult ){
		this.input.newer = this.$replaceBox.get(0).value;
		this.input.pushReady = true;
		this.edit();
		this.pushStack();
		this.searchStep();
	}
};