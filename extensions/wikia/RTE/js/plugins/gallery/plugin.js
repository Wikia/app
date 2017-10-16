CKEDITOR.plugins.add('rte-gallery',
{
	init: function(editor) {
		var self = this;

		editor.on('wysiwygModeReady', function() {
			// get all gallery placeholders
			var gallery = RTE.getEditor().find('.image-gallery');
			self.setupGallery(gallery);

			if ($.browser.msie ) {
				// bugid-47959 and bugid-68705 - Check if the first item on the page is a centered gallery. If it is, add a some white space before it in IE
				var firstGallery = gallery.eq(0),
					firstGalleryParent = firstGallery.parent();

				if(firstGallery.hasClass('alignCenter') && firstGalleryParent.parent().is('body') && firstGalleryParent.is(':first-child')) {
					firstGallery.parent().prepend("&nbsp;");
				}
			}
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

				// Do not show gallery editor if new galleries are enabled. Once we have a new gallery editor
				// to go along with the new galleries we can turn this back on. See VID-1990 and VID-1855.
				// When removing this, also remove check in app/extensions/wikia/RTE/js/plugins/media/plugin.js
				if (!window.wgEnableMediaGalleryExt) {
					WikiaPhotoGallery.showEditor({
						from: 'wysiwyg',
						gallery: gallery
					});
				}
			}).
			// tooltips
			attr('title', function() {
				var data = $(this).getData();

				var key = '';
				switch(data.type) {
					case 1:
						key = 'tooltip';
						break;
					case 2:
						key = 'tooltipSlideshow';
						break;
					case 3:
						key = 'tooltipSlider';
						break;
					default:
						break;
				}

				return RTE.getInstance().lang.photoGallery[key];
			});
	}
});
