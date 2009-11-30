CKEDITOR.plugins.add('rte-image',
{
	init: function(editor) {
		var self = this;

		editor.on('wysiwygModeReady', function() {
			// get all images
			var images = RTE.tools.getImages();
			RTE.log(images);

			self.setupImage(images);
		});

		// register "Add Image" command
		editor.addCommand('addimage', {
			exec: function(editor) {
				// call WikiaMiniUpload
				RTE.tools.callFunction(window.WMU_show);
			}
		});

		// register "Image" toolbar button
		editor.ui.addButton('Image', {
			title: 'Add picture',
			className: 'RTEImageButton',
			command: 'addimage'
		});

		RTE.imageEditor = {
			// add an image (wikitext will parser to HTML, params stored in metadata)
			add: function(wikitext, params) {
				RTE.log('adding an image');

				// parse wikitext: get image name
				var wikitextParams = wikitext.substring(2, wikitext.length-2).split('|');

				// set wikitext and metadata
				var data = {
					type: 'image',
					title: wikitextParams.shift().replace(/^[^:]+:/, ''), // get image name (without namespace prefix)
					params: params,
					wikitext: wikitext
				};

				RTE.log(data);

				// render an image and replace old one
				RTE.tools.parseRTE(wikitext, function(html) {
					var newImage = $(html).children('img');

					// set meta-data
					newImage.setData(data);

					// insert new image (don't reinitialize all placeholders)
					RTE.tools.insertElement(newImage, true);

					// setup added image
					self.setupImage(newImage);
				});
			},

			// update given image (wikitext will parser to HTML, params stored in metadata)
			update: function(image, wikitext, params) {
				RTE.log('updating an image'); RTE.log(arguments);

				// update wikitext and metadata
				var data = image.getData();
				data.params = params;
				data.wikitext = wikitext;

				// render an image and replace old one
				RTE.tools.parseRTE(wikitext, function(html) {
					var newImage = $(html).children('img');

					// replace old one with new one
					newImage.insertAfter(image);
					image.remove();

					newImage.setData(data);

					// setup added image
					self.setupImage(newImage);
				});
			}
		};
	},

	// show edit / delete menu
	showMenu: function(image) {
	},

	// hide edit / delete menu
	hideMenu: function(image) {
	},

	setupImage: function(image) {
		var self = this;

		// @see http://stackoverflow.com/questions/289433/firefox-designmode-disable-image-resizing-handles
		image.attr('contentEditable', false);

		// unbind previous events
		image.unbind('.image');

		// setup events
		image.bind('mouseover.image', function() {
			self.showMenu($(this));
		});

		image.bind('mouseout.image', function() {
			self.hideMenu($(this));
		});

		image.bind('contextmenu.image', function(ev) {
			// don't show CK context menu
			ev.stopPropagation();
		});

		image.bind('click.image', function(ev) {
			// remove resizing box
			ev.preventDefault();

			// don't show CK context menu
			ev.stopPropagation();

			RTE.log('Image clicked');
			RTE.log($(this).getData());

			// call WikiaMiniUpload and provide WMU with image clicked
			RTE.tools.callFunction(window.WMU_show,$(this));
		});

		// setup events once more on each drag&drop
		RTE.getEditor().unbind('dropped.image').bind('dropped.image', function(ev, extra) {
                        var target = $(ev.target);

			// filter out placeholders
			target = target.not('img[_rte_placeholder]');

			if (!target.exists()) {
				return;
			}

			self.setupImage(target);

			return;

			// check coordinates and try to re-align an image
			RTE.log(extra);

			// calculate relative positon
			var editorX = parseInt(extra.pageX - $('#editform').offset().left);
			var editorWidth = parseInt($('#editform').width());

			// choose new image alignment
			var align = (editorX < (editorWidth >> 1)) ? 'left':  'right';
			RTE.log('RTE: new image align: ' + align);

			// TODO: update image rte-data and wikitext

			// re-align image in editor
			target.removeClass('alignLeft alignRight').addClass(align == 'left' ? 'alignLeft' : 'alignRight');
		});
	}
});
