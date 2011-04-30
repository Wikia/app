CKEDITOR.plugins.add('rte-temporary-save',
{
	init: function(editor) {
		// set inital value of mode
		editor.on('instanceReady', function() {
			// restore previously saved content
			var mode = $('#RTETemporarySaveType').attr('value');

			if (mode) {
				RTE.log('restoring temporary save (using "' + mode + '" mode)');

				var content = $('#RTETemporarySaveContent').attr('value');

				// force to set mode with given content
				editor.setMode(mode);
				editor.setData(content)

				RTE.track('temporarySave', 'restore');
			}
		});

		// store current mode and content on editor unload
		$(window).bind('beforeunload', function(ev) {
			RTE.log('onbeforeunload: performing temporary save');

			$('#RTETemporarySaveType').attr('value', RTE.instance.mode);
			$('#RTETemporarySaveContent').attr('value', RTE.instance.getData());

			RTE.track('temporarySave', 'store');
		});
	}
});
