
foo();


function foo(){
if(window.mw.msg('rte-ck-unlink') == '<rte-ck-unlink>'){
setTimeout(foo,10);
}

CKEDITOR.plugins.setLang( 'toolbar', window.wgUserLanguage, {
	toolbarCollapse: window.mw.msg('rte-ck-toolbarCollapse'),
	toolbarExpand: window.mw.msg('rte-ck-toolbarExpand'),
	toolbarGroups: {
		document: window.mw.msg('rte-ck-toolbarGroups-document'),
		clipboard: window.mw.msg('rte-ck-toolbarGroups-clipboard'),
		editing: window.mw.msg('rte-ck-toolbarGroups-editing'),
		forms: window.mw.msg('rte-ck-toolbarGroups-forms'),
		basicstyles: window.mw.msg('rte-ck-toolbarGroups-basicstyles'),
		paragraph: window.mw.msg('rte-ck-toolbarGroups-paragraph'),
		links: window.mw.msg('rte-ck-toolbarGroups-links'),
		insert: window.mw.msg('rte-ck-toolbarGroups-insert'),
		styles: window.mw.msg('rte-ck-toolbarGroups-styles'),
		colors: window.mw.msg('rte-ck-toolbarGroups-colors'),
		tools: window.mw.msg('rte-ck-toolbarGroups-tools')
	},
	toolbars: window.mw.msg('rte-ck-toolbars')

} );


CKEDITOR.plugins.setLang( 'basicstyles', window.wgUserLanguage, {
	bold: window.mw.msg('rte-ck-basicstyles-bold'),
	italic:  window.mw.msg('rte-ck-basicstyles-italic'),
	strike: window.mw.msg('rte-ck-basicstyles-strike'),
	subscript: window.mw.msg('rte-ck-basicstyles-subscript'),
	superscript: window.mw.msg('rte-ck-basicstyles-superscript'),
	underline: window.mw.msg('rte-ck-basicstyles-underline'),
} );

CKEDITOR.plugins.setLang( 'contextmenu', window.wgUserLanguage, {
	options: window.mw.msg('rte-ck-contextmenu-options')
} );

CKEDITOR.plugins.setLang( 'button', window.wgUserLanguage, {
	selectedLabel: '%1 (Selected)'
} );

CKEDITOR.plugins.setLang( 'clipboard', window.wgUserLanguage, {
	copy: window.mw.msg('rte-ck-copy'),
	copyError: window.mw.msg('rte-ck-clipboard-copyError'),
	cut: window.mw.msg('rte-ck-cut'),
	cutError: window.mw.msg('rte-ck-clipboard-cutError'),
	paste: window.mw.msg('rte-ck-paste'),
	pasteNotification: window.mw.msg('rte-ck-clipboard-pasteMsg')
} );


CKEDITOR.plugins.setLang( 'fakeobjects', window.wgUserLanguage, {
	anchor: 'Anchor',
	flash: 'Flash Animation',
	hiddenfield: 'Hidden Field',
	iframe: 'IFrame',
	unknown: 'Unknown Object'
} );

CKEDITOR.plugins.setLang( 'format', window.wgUserLanguage, {
	label: window.mw.msg('rte-ck-format-label'),
	panelTitle: window.mw.msg('rte-ck-format-panelTitle'),
	tag_address: window.mw.msg('rte-ck-format-tag_address'),
	tag_div: window.mw.msg('rte-ck-format-tag_div'),
	tag_h1: window.mw.msg('rte-ck-format-tag_h1'),
	tag_h2: window.mw.msg('rte-ck-format-tag-h2'),
	tag_h3: window.mw.msg('rte-ck-format-tag-h3'),
	tag_h4: window.mw.msg('rte-ck-format-tag-h4'),
	tag_h5: window.mw.msg('rte-ck-format-tag-h5'),
	tag_h6: window.mw.msg('rte-ck-format-tag_h6'),
	tag_p: window.mw.msg('rte-ck-format-tag_p'),
	tag_pre: window.mw.msg('rte-ck-format-tag_pre'),
} );

CKEDITOR.plugins.setLang( 'indent', window.wgUserLanguage, {
	indent: window.mw.msg('rte-ck-indent'),
	outdent: window.mw.msg('rte-ck-outdent'),
} );

//CKEDITOR.plugins.setLang( 'justify', window.wgUserLanguage, {
//	block: window.mw.msg('rte-ck-justify-block'),
//	center: window.mw.msg('rte-ck-justify-center'),
//	left: window.mw.msg('rte-ck-justify-left'),
//	right: window.mw.msg('rte-ck-justify-right'),
//} );


//CKEDITOR.plugins.setLang( 'rte-link', window.wgUserLanguage, {
//	acccessKey: window.mw.msg('rte-ck-'),
//	advanced: window.mw.msg('rte-ck-'),
//	advisoryContentType: window.mw.msg('rte-ck-'),
//	advisoryTitle: window.mw.msg('rte-ck-'),
//	anchor: window.mw.msg('rte-ck-'),
//		toolbar: window.mw.msg('rte-ck-'),
//		menu: window.mw.msg('rte-ck-'),
//		title: window.mw.msg('rte-ck-'),
//		name: window.mw.msg('rte-ck-'),
//		errorName: window.mw.msg('rte-ck-'),
//		remove: window.mw.msg('rte-ck-'),
//	},
//	anchorId: window.mw.msg('rte-ck-'),
//	anchorName: window.mw.msg('rte-ck-'),
//	charset: window.mw.msg('rte-ck-'),
//	cssClasses: window.mw.msg('rte-ck-'),
//	download: window.mw.msg('rte-ck-'),
//	displayText: window.mw.msg('rte-ck-'),
//	emailAddress: window.mw.msg('rte-ck-'),
//	emailBody: window.mw.msg('rte-ck-'),
//	emailSubject: window.mw.msg('rte-ck-'),
//	id: window.mw.msg('rte-ck-'),
//	info: window.mw.msg('rte-ck-'),
//	langCode: window.mw.msg('rte-ck-'),
//	langDir: window.mw.msg('rte-ck-'),
//	langDirLTR: window.mw.msg('rte-ck-'),
//	langDirRTL: window.mw.msg('rte-ck-'),
//	menu: window.mw.msg('rte-ck-'),
//	name: window.mw.msg('rte-ck-'),
//	noAnchors: window.mw.msg('rte-ck-'),
//	noEmail: window.mw.msg('rte-ck-'),
//	noUrl: window.mw.msg('rte-ck-'),
//	other: window.mw.msg('rte-ck-'),
//	popupDependent: window.mw.msg('rte-ck-'),
//	popupFeatures: window.mw.msg('rte-ck-'),
//	popupFullScreen: window.mw.msg('rte-ck-'),
//	popupLeft: window.mw.msg('rte-ck-'),
//	popupLocationBar: window.mw.msg('rte-ck-'),
//	popupMenuBar: window.mw.msg('rte-ck-'),
//	popupResizable: window.mw.msg('rte-ck-'),
//	popupScrollBars: window.mw.msg('rte-ck-'),
//	popupStatusBar: window.mw.msg('rte-ck-'),
//	popupToolbar: window.mw.msg('rte-ck-'),
//	popupTop: window.mw.msg('rte-ck-'),
//	rel: window.mw.msg('rte-ck-'),
//	selectAnchor: window.mw.msg('rte-ck-'),
//	styles: window.mw.msg('rte-ck-'),
//	tabIndex: window.mw.msg('rte-ck-'),
//	target: window.mw.msg('rte-ck-'),
//	targetFrame: window.mw.msg('rte-ck-'),
//	targetFrameName: window.mw.msg('rte-ck-'),
//	targetPopup: window.mw.msg('rte-ck-'),
//	targetPopupName: window.mw.msg('rte-ck-'),
//	title: window.mw.msg('rte-ck-'),
//	toAnchor: window.mw.msg('rte-ck-'),
//	toEmail: window.mw.msg('rte-ck-'),
//	toUrl: window.mw.msg('rte-ck-'),
//	toolbar: window.mw.msg('rte-ck-'),
//	type: window.mw.msg('rte-ck-'),
//	unlink: window.mw.msg('rte-ck-'),
//	upload: window.mw.msg('rte-ck-'),
//} );

CKEDITOR.plugins.setLang( 'list', window.wgUserLanguage, {
	bulletedlist: window.mw.msg('rte-ck-bulletedlist'),
	numberedlist: window.mw.msg('rte-ck-numberedlist'),
} );

//CKEDITOR.plugins.setLang( 'notification', window.wgUserLanguage, {
//	closed: window.mw.msg('rte-ck-'),
//} );

CKEDITOR.plugins.setLang( 'pastetext', window.wgUserLanguage, {
	button: window.mw.msg('rte-ck-pasteText-button'),
	pasteNotification: window.mw.msg('rte-ck-clipboard-pasteMsg'),
} );

CKEDITOR.plugins.setLang( 'removeformat', window.wgUserLanguage, {
	toolbar: window.mw.msg('rte-ck-removeformat'),
	//notsurehere
} );


CKEDITOR.plugins.setLang( 'sourcearea', window.wgUserLanguage, {
	toolbar: window.mw.msg('rte-ck-source'),
} );


CKEDITOR.plugins.setLang( 'undo', window.wgUserLanguage, {
	redo: window.mw.msg('rte-ck-undo'),
	undo: window.mw.msg('rte-ck-redo'),
} );



CKEDITOR.plugins.setLang( 'table', window.wgUserLanguage, {
	border: window.mw.msg('rte-ck-table-button'),
	caption: window.mw.msg('rte-ck-table-caption'),
	cell: {
		menu: window.mw.msg('rte-ck-table-cell-menu'),
		insertBefore: window.mw.msg('rte-ck-table-cell-insertBefore'),
		insertAfter: window.mw.msg('rte-ck-table-cell-insertAfter'),
		deleteCell: window.mw.msg('rte-ck-table-cell-deleteCell'),
		merge: window.mw.msg('rte-ck-table-cell-merge'),
		mergeRight: window.mw.msg('rte-ck-table-cell-mergeRight'),
		mergeDown: window.mw.msg('rte-ck-table-cell-mergeDown'),
		splitHorizontal: window.mw.msg('rte-ck-table-cell-splitHorizontal'),
		splitVertical: window.mw.msg('rte-ck-table-cell-splitVertical'),
		title: window.mw.msg('rte-ck-table-cell-title'),
		cellType: window.mw.msg('rte-ck-table-cell-cellType'),
		rowSpan: window.mw.msg('rte-ck-table-cell-rowSpan'),
		colSpan: window.mw.msg('rte-ck-table-cell-colSpan'),
		wordWrap: window.mw.msg('rte-ck-table-cell-wordWrap'),
		hAlign: window.mw.msg('rte-ck-table-cell-hAlign'),
		vAlign: window.mw.msg('rte-ck-table-cell-vAlign'),
		alignBaseline: window.mw.msg('rte-ck-table-cell-alignBaseline'),
		bgColor: window.mw.msg('rte-ck-table-cell-bgColor'),
		borderColor: window.mw.msg('rte-ck-table-cell-borderColor'),
		data: window.mw.msg('rte-ck-table-cell-data'),
		header: window.mw.msg('rte-ck-table-cell-header'),
		yes: window.mw.msg('rte-ck-table-cell-yes'),
		no: window.mw.msg('rte-ck-table-cell-no'),
		invalidWidth: window.mw.msg('rte-ck-table-cell-invalidWidth'),
		invalidHeight: window.mw.msg('rte-ck-table-cell-invalidHeight'),
		invalidRowSpan: window.mw.msg('rte-ck-table-cell-invalidRowSpan'),
		invalidColSpan: window.mw.msg('rte-ck-table-cell-invalidColSpan'),
		chooseColor: window.mw.msg('rte-ck-table-cell-chooseColor'),
	},
	cellPad: window.mw.msg('rte-ck-table-cellPad'),
	cellSpace: window.mw.msg('rte-ck-table-cellSpace'),
	column: {
		menu: window.mw.msg('rte-ck-table-column-menu'),
		insertBefore: window.mw.msg('rte-ck-table-column-insertBefore'),
		insertAfter: window.mw.msg('rte-ck-table-column-insertAfter'),
		deleteColumn: window.mw.msg('rte-ck-table-column-deleteColumn'),
	},
	columns: window.mw.msg('rte-ck-table-column'),
	deleteTable: window.mw.msg('rte-ck-table-deleteTable'),
	headers: window.mw.msg('rte-ck-table-headers'),
	headersBoth: window.mw.msg('rte-ck-table-headersBoth'),
	headersColumn: window.mw.msg('rte-ck-table-headersColumn'),
	headersNone: window.mw.msg('rte-ck-table-headersNone'),
	headersRow: window.mw.msg('rte-ck-table-headersRow'),
	invalidBorder: window.mw.msg('rte-ck-table-invalidBorder'),
	invalidCellPadding: window.mw.msg('rte-ck-table-invalidCellPadding'),
	invalidCellSpacing: window.mw.msg('rte-ck-table-invalidCellPadding'),
	invalidCols: window.mw.msg('rte-ck-table-invalidCols'),
	invalidHeight: window.mw.msg('rte-ck-table-invalidHeight'),
	invalidRows: window.mw.msg('rte-ck-table-invalidRows'),
	invalidWidth: window.mw.msg('rte-ck-table-invalidWidth'),
	menu: window.mw.msg('rte-ck-table-menu'),
	row: {
		menu: window.mw.msg('rte-ck-table-row-menu'),
		insertBefore: window.mw.msg('rte-ck-table-row-insertBefore'),
		insertAfter: window.mw.msg('rte-ck-table-row-insertAfter'),
		deleteRow: window.mw.msg('rte-ck-table-row-deleteRow'),
	},
	rows: window.mw.msg('rte-ck-table-rows'),
	summary: window.mw.msg('rte-ck-table-summary'),
	title: window.mw.msg('rte-ck-table-title'),
	toolbar: window.mw.msg('rte-ck-table-toolbar'),
	widthPc: window.mw.msg('rte-ck-table-widthPc'),
	widthPx: window.mw.msg('rte-ck-table-widthPx'),
	widthUnit: window.mw.msg('rte-ck-table-widthUnit'),
} );

}
