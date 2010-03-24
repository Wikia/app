CKEDITOR.plugins.add('rte-gallery',
{
	init: function(editor) {
		var self = this;

		editor.on('wysiwygModeReady', function() {
			// get all gallery placeholders
			var gallery = RTE.getEditor().find('.image-gallery');

			self.setupGallery(gallery);
		});

		// handle clicks on WMU/VET buttons in source mode (RT #35276)
		editor.on('toolbarReady', function(toolbar) {/*
			$('#mw-toolbar').children('#mw-editbutton-wmu').click(function(ev) {
				window.WMU_show(ev);
			});

			$('#mw-toolbar').children('#mw-editbutton-vet').click(function(ev) {
				window.VET_show(ev);
			});*/
		});

		// check existance of WikiaImageGallery extension
		if (typeof window.WikiaImageGallery != 'undefined') {
			// register "Add Image" command
			editor.addCommand('addgallery', {
				exec: function(editor) {
					// call editor
					WikiaImageGallery.showEditor();
				}
			});

			// register "Image" toolbar button
			editor.ui.addButton('Gallery', {
				title: editor.lang.picturegallery.add,
				className: 'RTEGalleryButton',
				command: 'addgallery'
			});
		}
		else {
			RTE.log('WikiaImageGallery is not enabled here - disabling "Gallery" button');
			return;
		}
	},

	setupGallery: function(gallery) {
		gallery.
			attr('title', RTE.instance.lang.picturegallery.tooltip).
			unbind('.gallery').
			bind('edit.gallery', function(ev) {
				var gallery = $(this);
				var data = gallery.getData();

				RTE.log(data);

				alert(data.wikitext);

				// call editor and provide it with gallery clicked + inform it's placeholder
				//RTE.tools.callFunction(window.WMU_show,$(this), {isPlaceholder: true});
			});
	}
});
