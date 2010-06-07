CKEDITOR.plugins.add('rte-gallery',
{
	init: function(editor) {
		var self = this;

		editor.on('wysiwygModeReady', function() {
			// get all gallery placeholders
			var gallery = RTE.getEditor().find('.image-gallery');

			self.setupGallery(gallery);
		});

		// check existance of WikiaPhotoGallery extension
		if (typeof window.WikiaPhotoGallery != 'undefined') {
			// register "Add Image" command
			editor.addCommand('addphotogallery', {
				exec: function(editor) {
					// call editor
					WikiaPhotoGallery.showEditor({
						from: 'wysiwyg'
					});
				}
			});

			// register "Image" toolbar button
			editor.ui.addButton('Gallery', {
				title: editor.lang.photoGallery.add,
				className: 'RTEGalleryButton',
				command: 'addphotogallery'
			});
		}
		else {
			RTE.log('WikiaPhotoGallery is not enabled here - disabling "Gallery" button');
			return;
		}
	},

	setupGallery: function(gallery) {
		gallery.
			unbind('.gallery').
			bind('edit.gallery', function(ev) {
				var gallery = $(this);

				// call editor
				WikiaPhotoGallery.showEditor({
					from: 'wysiwyg',
					gallery: gallery
				});
			}).
			// tooltips
			attr('title', function() {
				var data = $(this).getData();
				var key = (data.type == 1) ? 'tooltip' : 'tooltipSlideshow';

				return RTE.instance.lang.photoGallery[key];
			});
	}
});
