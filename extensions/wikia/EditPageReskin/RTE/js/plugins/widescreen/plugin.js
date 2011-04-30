CKEDITOR.plugins.add('rte-widescreen',
{
	init: function(editor) {
		// get toggle function and widescreen "state"
		var toggleFn = window.ToggleWideScreen;
        	var initialState = $('body').hasClass('editingWide') ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF;

		// register "widescreen" command
		editor.addCommand('widescreen', {
			exec: function(editor) {
				// toogle widescreen
				toggleFn.call()

				// toggle button state
				this.toggleState();

				// fire custom event
				editor.fire('widescreen');
			},
			state: initialState
		});

		// register "Widescreen" toolbar button
		editor.ui.addButton('Widescreen', {
			title: editor.lang.widescreen.toggle,
			className: 'RTEWidescreenButton',
			command: 'widescreen'
		});
	}
});
