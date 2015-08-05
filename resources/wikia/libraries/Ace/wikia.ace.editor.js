define( 'wikia.ace.editor', ['wikia.window', 'jquery'], function(win, $){
	'use strict';

	var ace = win.ace, editorInstance, editorSession,
		$editor, $window = $(win), $input,
		editorMinHeight = 300,
		$wikiaBar = $('#WikiaBarWrapper'),
		isWikiaBarEnabled = win.wgEnableWikiaBarExt && $wikiaBar.length;

	ace.config.set('workerPath', win.aceScriptsPath);

	function init( editorId, inputAttr ) {
		initEditor(editorId);
		createHiddenTextField(inputAttr);

		resizeEditor();
		initEvents();
	}

	/**
	 * Init ace editor variables
	 *
	 * @param editorId editor identifier
	 */
	function initEditor( editorId ) {
		editorInstance = ace.edit( editorId );
		$editor = $('#' + editorId);
		editorSession = editorInstance.getSession();
	}

	/**
	 * Set editor theme.
	 * Default theme is geshi
	 *
	 * @param theme name of theme
	 */
	function setTheme( theme ) {
		theme = theme || 'geshi';
		editorInstance.setTheme( 'ace/theme/' + theme );
	}

	/**
	 * Set editor mode (code type)
	 * Default mode is css
	 *
	 * @param mode code type
	 */
	function setMode( mode ) {
		mode = mode || 'css';
		editorSession.setMode( 'ace/mode/' + mode );
	}

	/**
	 * Set editor options
	 *
	 * @param options
	 */
	function setOptions( options ) {
		options = options || {};
		editorInstance.setOptions( options );
	}

	/**
	 * Set editor config
	 *
	 * @param config
	 */
	function setConfig( config ) {
		config = config || {};
		for(var prop in config ) {
			ace.config.set( prop, config[prop] );
		}
	}

	/**
	 * Get editor object
	 *
	 * @returns {Element} editor object
	 */
	function getEditor() {
		return $editor;
	}

	/**
	 * Get ace editor instance
	 *
	 * @returns ace editor instance
	 */
	function getEditorInstance() {
		return editorInstance;
	}

	/**
	 * Get ace editor content
	 *
	 * @returns {string} content
	 */
	function getContent() {
		return editorSession.getValue();
	}

	/**
	 * Get hidden input object
	 *
	 * @returns {Element} hidden input object
	 */
	function getInput() {
		return $input;
	}

	/**
	 * Create hidden input.
	 * Ace editor code need to be copied there to save only raw text
	 *
	 * @param inputAttr hidden input field attributes
	 */
	function createHiddenTextField( inputAttr ) {
		if ( inputAttr.name ) {
			$input = $( '<input/>' )
				.attr( 'type', 'hidden' )
				.attr( 'name', inputAttr.name );

			if ( inputAttr.id ) {
				$input.attr('id', inputAttr.id);
			}

			if ( inputAttr.classes ) {
				$input.attr('class', inputAttr.classes);
			}
		}
	}

	/**
	 * Count proper editor height
	 *
	 * @returns {Number} editor height
	 */
	function getHeightToFit() {
		var topOffset = $editor.offset().top,
			viewportHeight = $window.height(),
			editorHeight;

		editorHeight = parseInt(viewportHeight - topOffset, 10);

		if (isWikiaBarEnabled && !$wikiaBar.hasClass('hidden')) {
			editorHeight = parseInt(editorHeight - $wikiaBar.height(), 10);
		}

		if (editorHeight < editorMinHeight) {
			editorHeight = editorMinHeight;
		}

		return editorHeight;
	}

	/**
	 * Change editor height after browser resize
	 */
	function resizeEditor() {
		var editorHeight = getHeightToFit();

		$editor.height( editorHeight );
	}

	/**
	 * Init events
	 */
	function initEvents() {
		$window.resize(resizeEditor);
	}

	/**
	 * Public API
	 */
	return {
		init: init,
		getContent: getContent,
		getEditor: getEditor,
		getEditorInstance: getEditorInstance,
		getInput: getInput,
		setTheme: setTheme,
		setMode: setMode,
		setOptions: setOptions,
		setConfig: setConfig
	};
});
