CKEDITOR.plugins.add('rte-modeswitch',
{
	sourceButton: false,

	init: function(editor) {
		var self = this;

		this.addCommands(editor);

		editor.on('instanceReady', function(ev) {
			self.updateSourceButtonTooltip(editor);
			self.updateModeInfo(editor);
		});

		editor.on('mode', function(ev) {
			self.updateSourceButtonTooltip(editor);
			self.updateModeInfo(editor);
		});
	},

	// get reference to source button
	getSourceButton: function(editor) {
		if (this.sourceButton == false) {
			var sourceCommand = editor.getCommand( 'source' );
			var uiItem = sourceCommand.uiItems[0];

			if (uiItem) {
				this.sourceButton = $('#' + uiItem._.id);
			}
		}
		return this.sourceButton;
	},

	// change tooltip for "Source" button
	updateSourceButtonTooltip: function(editor) {
		var sourceButton = this.getSourceButton(editor),
			msgKey = (editor.mode == 'wysiwyg') ? 'toSource' : 'toWysiwyg';
			msg = editor.lang.modeSwitch[msgKey];

		if (sourceButton) {
			sourceButton.attr('title', msg);
			sourceButton.find('.cke_label').text(msg);
		}
	},

	updateModeInfo: function(editor) {
		// set class for body indicating current editor mode (used mainly by automated tests)
		$('body').removeClass('rte_wysiwyg').removeClass('rte_source').addClass('rte_' + editor.mode);

		// this hidden editform field is used by RTE backend to parse HTML back to wikitext
		$('#RTEMode').attr('value', editor.mode);
	},

	addCommands: function(editor) {
		var self = this;
		this.sourceCommand = editor.addCommand('ModeSource',{
			modes: {wysiwyg:1},
			editorFocus : false,
			canUndo : false,
			exec: function() {
				if (editor.mode != 'source')
					editor.execCommand('source');
			}
		});
		this.wysiwygCommand = editor.addCommand('ModeWysiwyg',{
			modes: {source:1},
			exec: function() {
				if (editor.mode == 'source')
					editor.execCommand('source');
			}
		});

		editor.on('modeSwitch',function(){
			self.sourceCommand.disable();
			self.wysiwygCommand.disable();
		});
		editor.on('modeSwitchCancelled',function(){
			if (editor.mode == 'source')
				self.wysiwygCommand.enable();
			else
				self.sourceCommand.enable();
		});

		editor.ui.addButton( 'ModeSource', {
			label : editor.lang.modeSwitch.toSource,
			hasIcon: false,
			command : 'ModeSource'
		});
		editor.ui.addButton( 'ModeWysiwyg', {
			label : editor.lang.modeSwitch.toWysiwyg,
			hasIcon: false,
			command : 'ModeWysiwyg'
		});
	}
});
