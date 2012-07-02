/*global CreateWikiaPoll:true */
CKEDITOR.plugins.add('rte-poll',
{
	init: function(editor) {
		editor.on('wysiwygModeReady', $.proxy(function() {
			// get all gallery placeholders
			var poll = RTE.getEditor().find('.placeholder-poll');

			this.setupPoll(poll);
		}, this));

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
				label: editor.lang.poll.poll,
				title: editor.lang.poll.add,
				className: 'RTEPollButton',
				command: 'addpoll'
			});
		}
		else {
			RTE.log('WikiaPoll is not enabled here - disabling "Poll" button');
			return;
		}
	},

	setupPoll: function(poll) {
		// show poll editor when [edit] in hover menu or placeholder is clicked
		poll
			.unbind('.poll')
			.bind('click.poll edit.poll', function(ev) {
				CreateWikiaPoll.showEditor(ev);
			});
	}

});
