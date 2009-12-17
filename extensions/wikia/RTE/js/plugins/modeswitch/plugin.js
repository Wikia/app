CKEDITOR.plugins.add('rte-modeswitch',
{
	sourceButton: false,

	init: function(editor) {
		var self = this;

		editor.on('instanceReady', function(ev) {
			self.updateSourceButtonTooltip();
			self.updateModeInfo();
		});

		editor.on('mode', function(ev) {
			self.updateSourceButtonTooltip();
			self.updateModeInfo();
		});
	},

	// get reference to source button
	getSourceButton: function() {
		if (this.sourceButton == false) {
			var sourceCommand = RTE.instance.getCommand( 'source' );
			var uiItem = sourceCommand.uiItems[0];

			this.sourceButton = $('#' + uiItem._.id);
		}
		return this.sourceButton;
	},

	// change tooltip for "Source" button
	updateSourceButtonTooltip: function() {
		var sourceButton = this.getSourceButton();
		var msgKey = (RTE.instance.mode == 'wysiwyg') ? 'toSource' : 'toWysiwyg';

		sourceButton.attr('title', RTE.instance.lang.modeSwitch[msgKey]);
	},

	updateModeInfo: function() {
		// set class for body indicating current editor mode (used mainly by automated tests)
		$('body').removeClass('rte_wysiwyg').removeClass('rte_source').addClass('rte_' + RTE.instance.mode);

		// this hidden editform field is used by RTE backend to parse HTML back to wikitext
		$('#RTEMode').attr('value', RTE.instance.mode);
	}
});
