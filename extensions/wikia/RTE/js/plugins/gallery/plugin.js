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
			self.addButton(editor,{
				type: WikiaPhotoGallery.TYPE_GALLERY,
				commandName: 'addgallery',
				buttonName: 'Gallery',
				buttonLabel: editor.lang.photoGallery.gallery,
				buttonTooltip: editor.lang.photoGallery.addGallery,
				buttonClass: 'RTEGalleryButton'
			});
			self.addButton(editor,{
				type: WikiaPhotoGallery.TYPE_SLIDESHOW,
				commandName: 'addslideshow',
				buttonName: 'Slideshow',
				buttonLabel: editor.lang.photoGallery.slideshow,
				buttonTooltip: editor.lang.photoGallery.addSlideshow,
				buttonClass: 'RTESlideshowButton'
			});
			self.addButton(editor,{
				type: WikiaPhotoGallery.TYPE_SLIDER,
				commandName: 'addslider',
				buttonName: 'Slider',
				buttonLabel: editor.lang.photoGallery.slider,
				buttonTooltip: editor.lang.photoGallery.addSlider,
				buttonClass: 'RTESliderButton'
			});
		}
		else {
			RTE.log('WikiaPhotoGallery is not enabled here - disabling "Gallery" button');
			return;
		}
	},
	
	addButton: function(editor,params){
		editor.addCommand(params.commandName, {
			exec: function(editor) {
				// call editor
				WikiaPhotoGallery.showEditor({
					from: 'wysiwyg',
					type: params.type
				});
			}
		});

		// register "Image" toolbar button
		editor.ui.addButton(params.buttonName, {
			label: params.buttonLabel,
			title: params.buttonTooltip,
			className: params.buttonClass,
			command: params.commandName
		});
	},

	setupGallery: function(gallery) {
		// show gallery editor when [edit] in hover menu or placeholder is clicked
		gallery.
			unbind('.gallery').
			bind('click.gallery edit.gallery', function(ev) {
				var gallery = $(this);

				// call editor
				if ( (wgUserName == null) && (UserLogin) ) {
					UserLogin.rteForceLogin();
				}
				else {
					WikiaPhotoGallery.showEditor({
						from: 'wysiwyg',
						gallery: gallery
					});
				}
			}).
			// tooltips
			attr('title', function() {
				var data = $(this).getData();
				var key = (data.type == 1) ? 'tooltip' : 'tooltipSlideshow';

				return RTE.getInstance().lang.photoGallery[key];
			});
	}
});
