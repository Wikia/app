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
		editor.on('modeSwitchCancelled', $.proxy(function(){
			if (editor.mode == 'source') {
				this.wysiwygCommand.enable();
			}
			else {
				this.sourceCommand.enable();
			}
		}, this));

		// update switching tabs tooltips
		editor.on('mode', $.proxy(this.updateTooltips, this));
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
