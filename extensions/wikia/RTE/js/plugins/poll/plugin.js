CKEDITOR.plugins.add('rte-poll',
{
	init: function(editor) {
		var self = this;

		/*
		editor.on('wysiwygModeReady', function() {
			// get all gallery placeholders
			var gallery = RTE.getEditor().find('.image-gallery');

			self.setupGallery(gallery);
		});
		*/
		
		// check existance of WikiaPoll extension
		if (typeof window.CreateWikiaPoll != 'undefined') {
			// register "Add Poll" command
			editor.addCommand('addpoll', {
				exec: function(editor) {
					// call editor
					CreateWikiaPoll.showEditor({
						from: 'wysiwyg'
					});
				}
			});

			// register "Image" toolbar button
			editor.ui.addButton('Poll', {
				title: editor.lang.poll.add,
				className: 'RTEPollButton',
				command: 'addpoll'
			});

			// ... and block it when cursor is placed within a header (RT #67987)
			RTE.tools.blockCommandInHeader('addpoll');
		}
		else {
			RTE.log('WikiaPoll is not enabled here - disabling "Poll" button');
			return;
		}
	},
});