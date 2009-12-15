CKEDITOR.plugins.add('rte-source',
{
	button: false,

	init: function(editor) {
		var self = this;

		editor.on('instanceReady', function(ev) {
			self.updateButtonTooltip();
		});

		editor.on('mode', function(ev) {
			self.updateButtonTooltip();
		});
	},

	// get reference to source button
	getButton: function() {
		if (this.button == false) {
			var sourceCommand = RTE.instance.getCommand( 'source' );
			var uiItem = sourceCommand.uiItems[0];

			this.button = $('#' + uiItem._.id);
		}
		return this.button;
	},

	updateButtonTooltip: function() {
		var button = this.getButton();
		var msgKey = (RTE.instance.mode == 'wysiwyg') ? 'toSource' : 'toWysiwyg';

		button.attr('title', RTE.instance.lang.modeSwitch[msgKey]);
	}
});
