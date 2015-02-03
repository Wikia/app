define( 'wikia.ace.editor', ['wikia.window'], function(win){
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

	function initEditor( editorId ) {
		editorInstance = ace.edit( editorId );
		$editor = $('#' + editorId);
		editorSession = editorInstance.getSession();
	}

	function setTheme( theme ) {
		theme = theme || 'geshi';
		editorInstance.setTheme( 'ace/theme/' + theme );
	}

	function setMode( mode ) {
		mode = mode || 'css';
		editorSession.setMode( 'ace/mode/' + mode );
	}

	function setOptions( options ) {
		options = options || {};
		editorInstance.setOptions( options );
	}

	function setConfig( config ) {
		config = config || {};
		for(var prop in config ) {
			ace.config.set( prop, config[prop] );
		}
	}

	function getEditor() {
		return $editor;
	}

	function getEditorInstance() {
		return editorInstance;
	}

	function getContent() {
		return editorSession.getValue();
	}

	// set hidden field val
	function getInput() {
		return $input;
	}

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

	function getHeightToFit() {
		var topOffset = $editor.offset().top,
			viewportHeight = $window.height(),
			editorHeight;

		editorHeight = parseInt(viewportHeight - topOffset, 10);

		if (isWikiaBarEnabled && !$wikiaBar.hasClass('hidden')) {
			editorHeight = parseInt(editorHeight - $wikiaBar.height(), 10);
		}

		return editorHeight;
	}

	function resizeEditor() {
		var editorHeight = getHeightToFit();

		$editor.height( editorHeight );
	}

	function initEvents() {
		$window.resize(resizeEditor);
	}

	function showDiff( initConfig, modalCallback ) {
		require( [ 'wikia.ui.factory' ], function( uiFactory ){
			uiFactory.init( [ 'modal' ] ).then(function( uiModal ) {
				uiModal.createComponent( initConfig, function( previewModal ) {
					modalCallback(previewModal, ace);
				});
			});
		});
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
		setConfig: setConfig,
		showDiff: showDiff
	};
});
