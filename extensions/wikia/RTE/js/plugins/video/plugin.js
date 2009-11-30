CKEDITOR.plugins.add('rte-video',
{
	init: function(editor) {
		// VET is not compatible with CK, yet
		return;

		// check for existance of VideoEmbedTool
		if (typeof window.VET_show != 'function') {
			RTE.log('VET is not enabled here - disabling "Video" button');
			return;
		}

		var self = this;
/*
		editor.on('wysiwygModeReady', function() {
			// get all images
			var videos = RTE.tools.getVideos();
			RTE.log(videos);

			self.setupVideos(videos);
		});
*/
		// register "Add Video" command
		editor.addCommand('addvideo', {
			exec: function(editor) {
				// call VideoEmbedTool
				RTE.tools.callFunction(window.VET_show);
			}
		});

		// register "Video" toolbar button
		editor.ui.addButton('Video', {
			title: 'Add a video',
			className: 'RTEVideoButton',
			command: 'addvideo'
		});
	},

	setupVideo: function(video) {

	}
});
