CKEDITOR.plugins.add('rte-modeswitch',
{
	sourceButton: false,
	messages: {},

	init: function(editor) {
		this.messages = editor.lang.modeSwitch;

		this.addCommands(editor);

		// update <body> node classes
		editor.on('instanceReady', $.proxy(this.updateModeInfo, this));
		editor.on('mode', $.proxy(this.updateModeInfo, this));

		// disable buttons while switching between modes
		editor.on('modeSwitch', $.proxy(function(ev){
			ev.editor.getCommand('ModeSource').disable();
			ev.editor.getCommand('ModeWysiwyg').disable();
		}, this));

		// enable button switching to the "opposite" mode
		editor.on('modeSwitchCancelled', $.proxy(function(ev){
			if (ev.editor.mode == 'source') {
				ev.editor.getCommand('ModeWysiwyg').enable();
			}
			else {
				ev.editor.getCommand('ModeSource').enable();
			}
		}, this));

		// update switching tabs tooltips
		editor.on('mode', $.proxy(this.updateTooltips, this));
		editor.on('mode', $.proxy(this.mode, this));
		editor.on('modeSwitch', $.proxy(this.modeSwitch, this));
		editor.on('dataReady', $.proxy(this.dataReady, this));
		editor.on('wysiwygModeReady', $.proxy(this.wysiwygModeReady, this));
		editor.on('sourceModeReady', $.proxy(this.sourceModeReady, this));
	},

	modeSwitch: function(ev) {
		var editor = ev.editor,
			wikiaEditor = WikiaEditor.getInstance(editor.name),
			content = editor.getData();

		// modeSwitch needs to be aware of wikiaEditor readiness (BudId:20297)
		if (!wikiaEditor.ready) {
			RTE.log('cannot switch modes until editor is ready');
			editor.fire('modeSwitchCancelled');
			return;
		}

		RTE.log('switching from "' + editor.mode +'" mode');

		// BugId:1852 - error handling
		var onError = function() {
			RTE.log('error occured during mode switch');

			// remove loading indicator, don't switch mode
			editor.fire('modeSwitchCancelled');

			// modal with a message
			$.showModal(editor.lang.errorPopupTitle, editor.lang.modeSwitch.error, {width: 400});
		};

		switch (editor.mode) {
			case 'wysiwyg':
				RTE.ajax('html2wiki', {html: content, title: window.wgPageName}, function(data) {
					if (!data) {
						onError();
						return;
					}

					editor.setMode('source');
					editor.setData(data.wikitext, function() {
						editor.textarea.$.scrollTop = 0;
						editor.textarea.$.setSelectionRange(0, 0);
					});
				});
				break;

			case 'source':
				RTE.ajax('wiki2html', {wikitext: content, title: window.wgPageName}, function(data) {
					if (!data) {
						onError();
						return;
					}

					// RT #36073 - don't allow mode switch when __NOWYSIWYG__ is found in another article section
					if ( (typeof window.RTEEdgeCase != 'undefined') && (window.RTEEdgeCase == 'nowysiwyg') ) {
						RTE.log('article contains __NOWYSIWYG__ magic word');

						data.edgecase = {
							type: window.RTEEdgeCase,
							info: {
								title: window.RTEMessages.edgecase.title,
								content: window.RTEMessages.edgecase.content
							}
						};
					}

					if (data.edgecase) {
						RTE.log('edgecase found!');
						RTE.tools.alert(data.edgecase.info.title, data.edgecase.info.content);

						// stay in source mode
						editor.fire('modeSwitchCancelled');
						return;
					}

					// set data first and then set mode to avoid duplicated iframe inclusion and WysiwygModeReady event triggering (BugId:15655)
					editor.setData(data.html);
					editor.setMode('wysiwyg');

					// RT #84586: update instanceId
					RTE.instanceId = data.instanceId;
				});
				break;
		}
	},

	mode: function(ev) {
		var editor = ev.editor;

		RTE.log('mode "' + editor.mode + '" is loaded');

		// (BugId:19807)
		if (editor.config.startupFocus) {
			editor.focus();
		}
	},

	dataReady: function(ev) {
		var editor = ev.editor;

		if (editor.mode == 'wysiwyg') {
			editor.fire('wysiwygModeReady');

		} else if (editor.mode == 'source') {
			editor.fire('sourceModeReady');
		}
	},

	wysiwygModeReady: function(ev) {
		RTE.log('wysiwygModeReady');

		var editor = ev.editor,
			body = jQuery(editor.document.$.body);

		body.
			// set ID, so CSS rules from MW can be applied
			attr('id', editor.config.bodyId).
			// set CSS class with content language of current wiki (used by RT #40248)
			addClass('lang-' + window.wgContentLanguage);

		// RT #38516: remove first <BR> tag (fix strange Opera bug)
		setTimeout(function() {
			if (CKEDITOR.env.opera) {
				var firstChild = jQuery(editor.document.$.body).children().eq(0);

				// first child is <br> without any attributes
				if (firstChild.is('br')) {
					firstChild.remove();
				}
			}
		}, 750);
	},

	sourceModeReady: function(ev) {
		RTE.log('sourceModeReady');
	},

	updateModeInfo: function(ev) {
		// set class for body indicating current editor mode (used mainly by automated tests)
		$('body').
			removeClass('rte_wysiwyg').removeClass('rte_source').
			addClass('rte_' + ev.editor.mode);

		// this hidden editform field is used by RTE backend to parse HTML back to wikitext
		$('#RTEMode').attr('value', ev.editor.mode);
	},

	updateTooltips: function(ev) {
		var mode = ev.editor.mode,
			sourceTabLabel = this.messages['toSource' + (mode == 'source' ? '' : 'Tooltip')],
			wysiwygTabLabel = this.messages['toWysiwyg' + (mode == 'wysiwyg' ? '' : 'Tooltip')];

		this.getSwitchTab(ev.editor, 'ModeSource').attr('title', sourceTabLabel);
		this.getSwitchTab(ev.editor, 'ModeWysiwyg').attr('title', wysiwygTabLabel);
	},

	// get jQuery object for mode switching tab
	getSwitchTab: function(editor, commandName) {
		var nodeId = editor.getCommand(commandName).uiItems[0]._.id;
		return $('#' + nodeId);
	},

	addCommands: function(editor) {
		editor.addCommand('ModeSource', {
			modes: {wysiwyg:1},
			editorFocus : editor.config.isMiniEditor,
			canUndo : false,
			exec: function() {
				if (editor.mode != 'source'){
					editor.fire('switchToSource');
					editor.execCommand('source');
				}
			}
		});

		editor.addCommand('ModeWysiwyg', {
			modes: {source:1},
			exec: function() {
				if (editor.mode == 'source'){
					editor.execCommand('source');
				}
			}
		});

		editor.ui.addButton( 'ModeSource', {
			label : this.messages.toSource,
			hasIcon: editor.config.isMiniEditor,
			command : 'ModeSource'
		});

		editor.ui.addButton( 'ModeWysiwyg', {
			label : this.messages.toWysiwyg,
			hasIcon: editor.config.isMiniEditor,
			command : 'ModeWysiwyg'
		});
	}
});
