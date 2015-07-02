define(
	'wikia.editpage.ace.editor',
	['wikia.ace.editor', 'editpage.events', 'wikia.window'],
	function (ace, editpageEvents, win)
{
	'use strict';

	var theme = 'solarized_light',
		isEditorWide = false,
		inputAttr = {
			name: 'wpTextbox1',
			id: 'wpTextbox1'
		},
		$editPage = $('#EditPage'),
		$editPageToolbar = $('#EditPageToolbar'),
		wideClassName = 'editpage-sourcewidemode-on',
		narrowClassName = 'editpage-sourcewidemode-off',
		editorInitContent,
		disableBeforeUnload = false;

	function init() {
		chooseTheme();
		initConfig();
		beforeEditorInit();
		ace.init('editarea', inputAttr);
		initOptions();
		initStyles();
		ace.setTheme(theme);
		ace.setMode(win.codePageType);

		editorInitContent = ace.getContent();

		initEvents();
	}

	/**
	 * Init ace editor config
	 */
	function initConfig() {
		var config = {
				workerPath: win.aceScriptsPath
			};

		ace.setConfig(config);
	}

	function beforeEditorInit() {
		$('.loading-indicator').remove();
		$('#wpSave').removeAttr('disabled');
		$editPage.addClass('editpage-sourcewidemode mode-source ' + narrowClassName);
	}

	/**
	 * Init ace editor options
	 */
	function initOptions() {
		var options = {
			showPrintMargin: false,
			fontFamily: 'Monaco, Menlo, Ubuntu Mono, Consolas, source-code-pro, monospace'
		};

		ace.setOptions(options);
	}

	/**
	 * Init ace editor custom styles
	 */
	function initStyles() {
		var editor = ace.getEditor();

		editor.css('fontSize', '14px');
	}

	/**
	 * Init submit action
	 */
	function initSubmit() {
		$('#editform').submit(function(e) {
			var hiddenInput = ace.getInput().val(ace.getContent());

			disableBeforeUnload = true;

			$(this).unbind('submit').append(hiddenInput).submit();

			e.preventDefault();
		});
	}

	/**
	 * Make sure that user doesn't leave the page by accident
	 */
	function beforeUnload() {
		$(win).bind('beforeunload', function () {
			if (!disableBeforeUnload && editorInitContent !== ace.getContent()) {
				return $.msg('wikia-editor-leaveconfirm-message');
			}
		});
	}

	/**
	 * Choose ace editor theme depending on wiki theme (light or dark)
	 */
	function chooseTheme() {
		if (win.wgIsDarkTheme) {
			theme = 'solarized_dark';
		}
	}

	function initDiff() {
		editpageEvents.attachDiff('wpDiff');
	}

	/**
	 * Change editor mode (narrow/wide)
	 */
	function editorModeChange() {
		if (isEditorWide) {
			$editPage.removeClass(wideClassName).addClass(narrowClassName);
			$editPageToolbar.removeClass('ace-editor-wide');
			ace.getEditorInstance().resize();
			isEditorWide = false;
		} else {
			$editPage.removeClass(narrowClassName).addClass(wideClassName);
			$editPageToolbar.addClass('ace-editor-wide');
			ace.getEditorInstance().resize();
			isEditorWide = true;
		}
	}

	/**
	 * Init ace editor events
	 */
	function initEvents() {
		initSubmit();
		initDiff();
		beforeUnload();

		if (win.showPagePreview) {
			editpageEvents.attachDesktopPreview('wpPreview');
			editpageEvents.attachMobilePreview('wpPreviewMobile');
		}

		$('.editpage-widemode-trigger').click(editorModeChange);
	}

	return {
		init: init
	};
});
