bar();

function bar(){
if(window.mw.msg('rte-ck-unlink') == '<rte-ck-unlink>'){
setTimeout(bar,1000);
}

CKEDITOR.lang[ window.wgUserLanguage ] = {
	// ARIA description.
	editor: window.mw.msg('rte-ck-editor'),
	editorPanel: 'Rich Text Editor panel',//not included

	// Common messages and labels.
	common: {
		// Screenreader titles. Please note that screenreaders are not always capable
		// of reading non-English words. So be careful while translating it.
		editorHelp: window.mw.msg('rte-ck-common-editorHelp'),

		browseServer: window.mw.msg('rte-ck-common-browseServer'),
		url: window.mw.msg('rte-ck-common-url'),
		protocol: window.mw.msg('rte-ck-common-protocol'),
		upload: window.mw.msg('rte-ck-common-upload'),
		uploadSubmit: window.mw.msg('rte-ck-common-uploadSubmit'),
		image: window.mw.msg('rte-ck-common-image'),
		flash: window.mw.msg('rte-ck-common-flash'),
		form: window.mw.msg('rte-ck-common-form'),
		checkbox: window.mw.msg('rte-ck-common-checkbox'),
		radio: window.mw.msg('rte-ck-common-radio'),
		textField: window.mw.msg('rte-ck-common-textField'),
		textarea: window.mw.msg('rte-ck-common-textarea'),
		hiddenField: window.mw.msg('rte-ck-common-hiddenField'),
		button: window.mw.msg('rte-ck-common-button'),
		select: window.mw.msg('rte-ck-common-select'),
		imageButton: window.mw.msg('rte-ck-common-imageButton'),
		notSet: window.mw.msg('rte-ck-common-notSet'),
		id: window.mw.msg('rte-ck-common-id'),
		name: window.mw.msg('rte-ck-common-name'),
		langDir: window.mw.msg('rte-ck-common-langDir'),
		langDirLtr: window.mw.msg('rte-ck-common-langDirLtr'),
		langDirRtl: window.mw.msg('rte-ck-common-langDirRtl'),
		langCode: window.mw.msg('rte-ck-common-langCode'),
		longDescr: window.mw.msg('rte-ck-common-longDescr'),
		cssClass: window.mw.msg('rte-ck-common-cssClass'),
		advisoryTitle: window.mw.msg('rte-ck-common-advisoryTitle'),
		cssStyle: window.mw.msg('rte-ck-common-cssStyle'),
		ok: window.mw.msg('rte-ck-common-ok'),
		cancel: window.mw.msg('rte-ck-common-cancel'),
		close: window.mw.msg('rte-ck-common-close'),
		preview: window.mw.msg('rte-ck-common-preview'),
		resize: window.mw.msg('rte-ck-common-resize'),
		generalTab: window.mw.msg('rte-ck-common-generalTab'),
		advancedTab: window.mw.msg('rte-ck-common-advancedTab'),
		validateNumberFailed: window.mw.msg('rte-ck-common-validateNumberFailed'),
		confirmNewPage: window.mw.msg('rte-ck-common-confirmNewPage'),
		confirmCancel: window.mw.msg('rte-ck-common-confirmCancel'),
		options: window.mw.msg('rte-ck-common-options'),
		target: window.mw.msg('rte-ck-common-target'),
		targetNew: window.mw.msg('rte-ck-common-targetNew'),
		targetTop: window.mw.msg('rte-ck-common-targetTop'),
		targetSelf: window.mw.msg('rte-ck-common-targetSelf'),
		targetParent: window.mw.msg('rte-ck-common-targetParent'),
		langDirLTR: window.mw.msg('rte-ck-common-langDirLTR'),
		langDirRTL: window.mw.msg('rte-ck-common-langDirRTL'),
		styles: window.mw.msg('rte-ck-common-styles'),
		cssClasses: window.mw.msg('rte-ck-common-cssClasses'),
		width: window.mw.msg('rte-ck-common-width'),
		height: window.mw.msg('rte-ck-common-height'),
		align: window.mw.msg('rte-ck-common-align'),
		alignLeft: window.mw.msg('rte-ck-common-alignLeft'),
		alignRight: window.mw.msg('rte-ck-common-alignRight'),
		alignCenter: window.mw.msg('rte-ck-common-alignCenter'),
		alignJustify: window.mw.msg('rte-ck-common-alignJustify'),
		alignTop: window.mw.msg('rte-ck-common-alignTop'),
		alignMiddle: window.mw.msg('rte-ck-common-alignMiddle'),
		alignBottom: window.mw.msg('rte-ck-common-alignBottom'),
		alignNone: window.mw.msg('rte-ck-common-alignNone'),
		invalidValue: window.mw.msg('rte-ck-common-invalidValue'),
		invalidHeight: window.mw.msg('rte-ck-common-invalidHeight'),
		invalidWidth: window.mw.msg('rte-ck-common-invalidWidth'),
		invalidCssLength: window.mw.msg('rte-ck-common-invalidCssLength'),
		invalidHtmlLength: window.mw.msg('rte-ck-common-invalidHtmlLength'),
		invalidInlineStyle: window.mw.msg('rte-ck-common-invalidInlineStyle'),
		cssLengthTooltip: window.mw.msg('rte-ck-common-cssLengthTooltip'),

		// Put the voice-only part of the label in the span.
		unavailable: window.mw.msg('rte-ck-common-unavailable'),

		// Keyboard keys translations used for creating shortcuts descriptions in tooltips, context menus and ARIA labels.
		keyboard: {
			8: 'Backspace',
			13: 'Enter',
			16: 'Shift',
			17: 'Ctrl',
			18: 'Alt',
			32: 'Space',
			35: 'End',
			36: 'Home',
			46: 'Delete',
			224: 'Command'
		},

		// Prepended to ARIA labels with shortcuts.
		keyboardShortcut: 'Keyboard shortcut'
	}
}
}
