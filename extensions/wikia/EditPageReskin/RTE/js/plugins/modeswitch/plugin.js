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
		editor.on('modeSwitch', $.proxy(function(){
			this.sourceCommand.disable();
			this.wysiwygCommand.disable();
		}, this));

		// enable button switching to the "opposite" mode
		editor.on('modeSwitchCancelled', $.proxy(function(ev){
			if (ev.editor.mode == 'source') {
				this.wysiwygCommand.enable();
			}
			else {
				this.sourceCommand.enable();
			}
		}, this));

		// update switching tabs tooltips
		editor.on('mode', $.proxy(this.updateTooltips, this));
		editor.on('mode', $.proxy(this.mode, this));
		editor.on('modeSwitch', $.proxy(this.modeSwitch, this));
		editor.on('dataReady', $.proxy(this.dataReady, this));
		editor.on('wysiwygModeReady', $.proxy(this.wysiwygModeReady, this));
	},

	modeSwitch: function(ev) {
		var editor = ev.editor,
			content = editor.getData();

				RTE.log('switching from "' + editor.mode +'" mode');

		// BugId:1852 - error handling
		var onError = function() {
			RTE.log('error occured during mode switch');

			// remove loading indicator, don't switch mode
			editor.fire('modeSwitchCancelled');

			// track errors
			RTE.track('switchMode', 'error');

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
					editor.setData(data.wikitext);

					RTE.track('switchMode', 'wysiwyg2source');
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

						// tracking
						RTE.track('switchMode', 'edgecase', data.edgecase.type);
						return;
					}

					editor.setMode('wysiwyg');
					editor.setData(data.html);

					// RT #84586: update instanceId
					RTE.instanceId = data.instanceId;

					RTE.track('switchMode', 'source2wysiwyg');
				});
				break;
		}
	},
	
	mode: function(ev) {
		RTE.log('mode "' + ev.editor.mode + '" is loaded');
	},

	dataReady: function(ev) {
		if (ev.editor.mode == 'wysiwyg') {
			ev.editor.fire('wysiwygModeReady');
		}
	},

	wysiwygModeReady: function(ev) {
		RTE.log('onWysiwygModeReady');

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

		this.getSwitchTab('source').attr('title', sourceTabLabel);
		this.getSwitchTab('wysiwyg').attr('title', wysiwygTabLabel);
	},

	// get jQuery object for mode switching tab
	getSwitchTab: function(mode) {
		var nodeId = this[mode + 'Command'].uiItems[0]._.id;
		return $('#' + nodeId);
	},

	addCommands: function(editor) {
		this.sourceCommand = editor.addCommand('ModeSource', {
			modes: {wysiwyg:1},
			editorFocus : false,
			canUndo : false,
			exec: function() {
				if (editor.mode != 'source')
					editor.execCommand('source');
			}
		});

		this.wysiwygCommand = editor.addCommand('ModeWysiwyg', {
			modes: {source:1},
			exec: function() {
				if (editor.mode == 'source')
					editor.execCommand('source');
			}
		});

		editor.ui.addButton( 'ModeSource', {
			label : this.messages.toSource,
			hasIcon: false,
			command : 'ModeSource'
		});

		editor.ui.addButton( 'ModeWysiwyg', {
			label : this.messages.toWysiwyg,
			hasIcon: false,
			command : 'ModeWysiwyg'
		});
	}
});
