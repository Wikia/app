var WikiaPhotoGallery = {
	// editor state
	editor: {
		currentPage: false,
		currentPageParams: {},
		from: false,
		gallery: {
			images: [],
			node: false,
			params: {},
			type: false,
			hash: false,
			id: 0
		},
		msg: {},
		source: false,
		width: false
	},

	// constants
	CHOOSE_TYPE_PAGE: 0,
	UPLOAD_FIND_PAGE: 1,
	UPLOAD_CONFLICT_PAGE: 2,
	CAPTION_LINK_PAGE: 3,
	GALLERY_PREVIEW_PAGE: 4,
	SLIDESHOW_PREVIEW_PAGE: 5,
	EDIT_CONFLICT_PAGE: 6,

	// type
	TYPE_GALLERY: 1,
	TYPE_SLIDESHOW: 2,

	// images list type
	RESULTS_RECENT_UPLOADS: 0,
	RESULTS_IMAGES_FROM_THIS_PAGE: 1,

	// send AJAX request to extension's ajax dispatcher in MW
	ajax: function(method, params, callback) {
		$.post(wgScript + '?action=ajax&rs=WikiaPhotoGalleryAjax&method=' + method, params, callback, 'json');
	},

	// track events
	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('photogallery' + fakeUrl);
	},

	// track pop-out events
	trackForView: function(fakeUrl) {
		window.jQuery.tracker.byStr('articleAction/photogallery' + fakeUrl);
	},

	// get current page related suffix for tracker fake URLs
	getPageTrackerSuffix: function() {
		var trackerSuffix = this.isSlideshow() ? 'slideshow/' : 'gallery/';

		switch(this.editor.currentPage) {
			case this.CHOOSE_TYPE_PAGE:
				trackerSuffix = 'choice';
				break;

			case this.UPLOAD_FIND_PAGE:
				trackerSuffix += 'find';
				break;

			case this.CAPTION_LINK_PAGE:
				trackerSuffix += 'options';
				break;

			case this.GALLERY_PREVIEW_PAGE:
			case this.SLIDESHOW_PREVIEW_PAGE:
				trackerSuffix += 'preview';
				break;

			default:
				trackerSuffix = false;
		}

		return trackerSuffix;
	},

	// console logging
	log: function(msg) {
		$().log(msg, 'WikiaPhotoGallery');
	},

	// add MW toolbar button (only in Monaco)
	addToolbarButton: function() {
		if ( (skin == 'monaco') && (typeof mwCustomEditButtons != 'undefined') ) {
			mwCustomEditButtons.push({
				'imageFile': window.wgExtensionsPath + '/wikia/WikiaPhotoGallery/images/gallery_add.png',
				'speedTip': window.WikiaPhotoGalleryAddGallery,
				'tagOpen': '',
				'tagClose': '',
				'sampleText': '',
				'imageId': 'mw-editbutton-wpg',
				'onclick': function() {
					WikiaPhotoGallery.showEditor({
						from: 'source'
					});
				}
			});
		}
	},

	// useful shortcut :)
	isSlideshow: function() {
		return (this.editor.gallery.type == this.TYPE_SLIDESHOW);
	},

	// setup selected page (change dialog title, render content)
	selectPage: function(selectedPage, params) {
		params = params || {};

		// store current and previous page
		params.source = this.editor.currentPage;
		this.editor.currentPage = selectedPage;

		// used in buttons handlers
		this.editor.currentPageParams = params;

		this.log('selecting page #' + selectedPage);
		this.log(params);

		// hide pages and setup selected one
		var pages = $('#WikiaPhotoGalleryEditor').find('.WikiaPhotoGalleryEditorPage');
		pages.hide();

		// messages shortcut
		var msg = this.editor.msg;

		// buttons
		var saveButton = $('#WikiaPhotoGalleryEditorSave');
		var cancelButton = $('#WikiaPhotoGalleryEditorCancel');

		// hide gallery options (slider, alignment option) in modal toolbar
		$('#WikiaPhotoGalleryEditorPreviewOptions').hide();

		// hide edit conflict buttons
		$('#WikiaPhotoGalleryEditConflictButtons').hide();

		// popup title
		var type = this.isSlideshow() ? 'slideshow' : 'gallery';
		var title = '';

		switch (selectedPage) {
			// Type chooser
			case this.CHOOSE_TYPE_PAGE:
				title = msg['wikiaPhotoGallery-choice-title'];

				saveButton.hide();
				cancelButton.hide();

				this.setupChooseTypePage(params);
				break;

			// Upload/Find page
			case this.UPLOAD_FIND_PAGE:
				title = msg['wikiaPhotoGallery-upload-title-' + type];

				saveButton.hide();
				if (params.source) {
					cancelButton.show();
				} else {
					cancelButton.hide();
				}

				this.setupUploadPage(params);
				break;

			// Upload conflict page
			case this.UPLOAD_CONFLICT_PAGE:
				title = msg['wikiaPhotoGallery-upload-title-' + type];

				saveButton.hide();
				cancelButton.show();

				this.setupUploadConflictPage(params);
				break;

			// Caption/Link page
			case this.CAPTION_LINK_PAGE:
				title = msg['wikiaPhotoGallery-photooptions-title-' + type];

				saveButton.show().text(msg['wikiaPhotoGallery-photooptions-done']);
				cancelButton.show();

				this.setupCaptionLinkPage(params);
				break;

			// Gallery preview page
			case this.GALLERY_PREVIEW_PAGE:
				title = msg['wikiaPhotoGallery-preview-title'];

				saveButton.show().text(msg['wikiaPhotoGallery-finish']);
				cancelButton.hide();

				this.setupGalleryPreviewPage(params);
				break;

			// Slideshow preview page
			case this.SLIDESHOW_PREVIEW_PAGE:
				title = msg['wikiaPhotoGallery-slideshowpreview-title'];

				saveButton.show().text(msg['wikiaPhotoGallery-finish']);
				cancelButton.hide();

				this.setupSlideshowPreviewPage(params);
				break;


			// Edit conflict page
			case this.EDIT_CONFLICT_PAGE:
				title += msg['wikiaPhotoGallery-conflict-title'];

				saveButton.hide();
				cancelButton.hide();

				this.setupEditConflictPage(params);
				break;
		}

		// show selected page
		pages.eq(selectedPage).show();

		// set editor dialog title
		$('#WikiaPhotoGalleryEditorTitle').text(title);
	},

	// save button handler
	onSave: function() {
		// variable shortcuts
		var params = this.editor.currentPageParams;
		var hideModal = true;

		this.log('onSave');
		this.log(params);

		var newPage = null;
		var newParams = {};

		// tracking
		var trackerSuffix = this.getPageTrackerSuffix();
		if (trackerSuffix) {
			this.track('/dialog/' + trackerSuffix + '/save');
		}

		switch (this.editor.currentPage) {
			case this.UPLOAD_FIND_PAGE:
				break;

			case this.UPLOAD_CONFLICT_PAGE:
				break;

			case this.CAPTION_LINK_PAGE:
				var caption = $('#WikiaPhotoGalleryEditorCaption').val();
				var link = '';
				var linktext = '';

				if (this.isSlideshow()) {
					newPage = this.SLIDESHOW_PREVIEW_PAGE;

					link = $('#WikiaPhotoSlideshowLink').val();
					linktext = $('#WikiaPhotoSlideshowLinkText').val();
				}
				else {
					newPage = this.GALLERY_PREVIEW_PAGE;

					link = $('#WikiaPhotoGalleryLink').val();
				}

				// remove wrapping brackets
				link.replace(/^(\[)+/, '').replace(/(\])+$/, '');

				var data = {
					caption: caption,
					link: link,
					linktext: linktext,
					name: params.imageName
				};

				if (params.imageId == null) {
					// add new image to gallery object
					this.editor.gallery.images.push(data);
				}
				else {
					// update gallery entry
					this.editor.gallery.images[ params.imageId ] = data;
				}

				// track options
				if (caption != '') {
					this.track('/dialog/' + trackerSuffix + '/caption');
				}

				if (this.isSlideshow()) {
					if (link != '') {
						this.track('/dialog/' + trackerSuffix + '/linkURL');
					}
					if (linktext != '') {
						this.track('/dialog/' + trackerSuffix + '/linkText');
					}
				}
				else {
					if (link != '') {
						this.track('/dialog/' + trackerSuffix + '/link');
					}
				}
				break;

			case this.GALLERY_PREVIEW_PAGE:
			case this.SLIDESHOW_PREVIEW_PAGE:
				// update gallery data, generate wikitext and store it in wikitext
				var gallery = this.editor.gallery;

				// get widths / alignment from sliders
				if (this.isSlideshow()) {
					gallery.params.widths = $('#WikiaPhotoGallerySlideshowWidthSlider').slider('value');
				}
				else {
					gallery.params.captionalign = $('#WikiaPhotoGalleryEditorPreviewAlign').val();
					gallery.params.widths = $('#WikiaPhotoGalleryEditorPreviewSlider').slider('value');
				}

				gallery.wikitext = this.JSONtoWikiText(gallery);

				// track usage of slideshow "smart" cropping
				if (this.isSlideshow()) {
					if (gallery.params.crop && gallery.params.crop == 'true') {
						this.track('/dialog/slideshow/preview/crop');
					}
				}

				// update / save gallery
				switch (this.editor.from) {
					case 'wysiwyg':
						var data = {
							images: gallery.images,
							params: gallery.params,
							wikitext: gallery.wikitext
						};

						this.log(data);

						// from RTE (wysiwyg mode)
						if (gallery.node) {
							// update existing gallery
							this.log('updating existing gallery');

							// clear metadata
							gallery.node.setData({
								images: false,
								params: false
							});

							// update metadata
							gallery.node.setData(data);
						}
						else {
							// add new gallery
							this.log('adding new gallery');

							var node = RTE.tools.createPlaceholder('image-gallery', data);

							node.
								removeClass('placeholder placeholder-ext').
								addClass('media-placeholder image-gallery').
								attr({
									height: '200',
									width: '200'
								});

							RTE.tools.insertElement(node);
						}

						// show "Save in progress" popup
						var messages = this.editor.msg;
						$.showModal(
							messages['wikiaPhotoGallery-preview-saving-title'],
							'<p>' + messages['wikiaPhotoGallery-preview-saving-intro'] + '</p>',
							{id: 'WikiaConfirm'});

						hideModal = false;

						// save the whole page
						$('#wpSave').click();
						break;

					case 'source':
						// from MW editor / source mode
						this.log('adding new gallery');
						this.log(gallery.wikitext);

						// add <gallery> wikitext
						var cursorPos = this.getCaretPosition();

						var textarea = this.getEditarea();
						var value = textarea.value;

						value = value.substring(0, cursorPos) + gallery.wikitext + value.substring(cursorPos);

						textarea.value = value;
						break;

					case 'view':
						hideModal = false;
						WikiaPhotoGallery.ajax('saveGalleryData', {hash:gallery.hash, wikitext:gallery.wikitext, title:wgPageName, starttime:gallery.starttime}, function(data) {
							if (data.info == 'ok') {
								$('#WikiaPhotoGalleryEditor').hideModal();
								location.hash = '#' + gallery.id;
								location.reload(true);
							} else if (data.info == 'conflict') {
								WikiaPhotoGallery.selectPage(WikiaPhotoGallery.EDIT_CONFLICT_PAGE);
							} else {
								$('#WikiaPhotoGalleryEditor').hideModal();
								WikiaPhotoGallery.showAlert(
									data.errorCaption,
									data.error
								);
							}
						});
						break;
				}

				// hide modal and leave
				if (hideModal) {
					$('#WikiaPhotoGalleryEditor').hideModal();
				}
				return;
		}

		if (newPage != null) {
			this.selectPage(newPage, newParams);
		} else {
			this.log('this button has no action in this context - it should be hidden');
		}
	},

	// cancel / "Back" button handler
	onCancel: function() {
		// variable shortcuts
		var editor = this.editor;
		var params = editor.currentPageParams;

		this.log('onCancel');
		this.log(params);

		var newPage = null;
		var newPageParams = {};

		// tracking
		var trackerSuffix = this.getPageTrackerSuffix();
		if (trackerSuffix) {
			this.track('/dialog/' + trackerSuffix + '/cancel');
		}

		switch (editor.currentPage) {
			case this.UPLOAD_FIND_PAGE:
				newPage = params.source;
				if (params.imageId != null) newPageParams.imageId = params.imageId;
				if (params.imageName) newPageParams.imageName = params.imageName;
				if (params.caption) newPageParams.caption = params.caption;
				if (params.link) newPageParams.link = params.link;
				break;

			case this.UPLOAD_CONFLICT_PAGE:
				newPage = this.UPLOAD_FIND_PAGE;
				break;

			case this.CAPTION_LINK_PAGE:
				newPage = params.source;

				// pass id of edited gallery entry when going back to upload page
				if (params.imageId != null) {
					newPageParams.imageId = params.imageId;
				}
				break;

			case this.GALLERY_PREVIEW_PAGE:
			case this.SLIDESHOW_PREVIEW_PAGE:
				break;
		}

		if (newPage != null) {
			this.selectPage(newPage, newPageParams);
		} else {
			this.log('this button has no action in this context - it should be hidden');
		}
	},

	// setup gallery editor content (select proper page, register event handlers)
	setupEditor: function(params) {
		// remove lock
		delete this.lock;

		var self = this;

		// choose first page as the default one
		var firstPage = this.CHOOSE_TYPE_PAGE;

		// clear internal gallery object
		this.editor.gallery = {
			id: false,
			params:{},
			images:[],
			node: false
		};

		this.log(params);

		switch (params.from) {
			case 'wysiwyg':
				if (typeof params.gallery == 'object') {
					this.log('editing existing gallery');
					this.log(params.gallery);

					// read gallery data from gallery node and store it in editor
					var data = params.gallery.getData();

					this.editor.gallery = {
						id: data.id,
						images: data.images,
						node: params.gallery,
						params: data.params,
						type: data.type
					};

					if (this.isSlideshow()) {
						firstPage = this.SLIDESHOW_PREVIEW_PAGE;
						this.track('/init/edit/editpage/slideshow');
					}
					else {
						firstPage = this.GALLERY_PREVIEW_PAGE;
						this.track('/init/edit/editpage/gallery');
					}
				} else {
					this.log('add new gallery');
					this.track('/init/new');
				}

				this.log(this.editor.gallery);
				break;

			case 'source':
				this.track('/init/new');
				break;

			case 'view':
				if (typeof params.gallery == 'object') {
					this.log('editing existing gallery');
					this.log(params.gallery);

					this.editor.gallery = params.gallery;

					if (this.isSlideshow()) {
						firstPage = this.UPLOAD_FIND_PAGE;
						this.track('/init/edit/view/slideshow');
					}
					else {
						firstPage = this.UPLOAD_FIND_PAGE;
						this.track('/init/edit/view/gallery');
					}
				}
				break;
		}
		this.editor.from = params.from;

		// setup upload / find page
		$('#WikiaPhotoGallerySearchForm').
			unbind('.find').
			bind('submit.find', function(ev) {
				self.onImageSearch.call(self, ev)
			});

		// setup image upload
		this.setupUpload();

		// setup search results (by default show recent uploads)
		this.setupSearchResults(self.RESULTS_RECENT_UPLOADS);

		// setup caption editor toolbar
		this.setupCaptionToolbar();

		// setup MW suggest for link editor
		this.setupLinkSuggest('WikiaPhotoGalleryLink');
		this.setupLinkSuggest('WikiaPhotoSlideshowLink');

		// setup slider and alignment dropdown (gallery)
		this.setupSliderAndDropDown();

		// setup slideshow slider (slideshow)
		this.setupSlideshowSlider();

		// add handlers to buttons
		$('#WikiaPhotoGalleryEditorSave').unbind('.save').bind('click.save', function() {self.onSave.apply(self)});
		$('#WikiaPhotoGalleryEditorCancel').unbind('.cancel').bind('click.cancel', function() {self.onCancel.apply(self)});

		// and render this page
		this.selectPage(firstPage);
	},

	// setup image upload
	setupUpload: function() {
		var self = this;

		// clicks on "Upload photo"
		$('#WikiaPhotoGalleryImageUpload').
			unbind('.upload').
			bind('click.upload', function(ev) {
				// tracking
				var trackerSuffix = self.getPageTrackerSuffix();
				self.track('/dialog/' + trackerSuffix + '/upload/button');
			});

		// upload form submittion
		$('#WikiaPhotoGalleryImageUploadForm').
			unbind('.upload').
			bind('change.upload', function(ev) {
				// perform an upload when user selects the file
				$(this).submit();
			}).
			bind('submit.upload', function(ev) {
				var uploadFileName = $('#WikiaPhotoGalleryImageUpload').val();
				if (uploadFileName == '') {
					self.log('no file selected to upload');

					ev.preventDefault();
					return;
				}

				self.log('uploading...');

				// show loading indicator and block "Upload" button
				$('#WikiaPhotoGalleryImageUploadButton').attr('disabled', true);
				$('#WikiaPhotoGalleryUploadProgress').show();

				$.AIM.submit(this /* form */, {
					onComplete: function(response) {
						self.log('response from upload: ' + response);

						var data = $.secureEvalJSON(response);

						self.log('upload done');
						self.log(data);

						// tracking
						var trackerSuffix = self.getPageTrackerSuffix();
						self.track('/dialog/' + trackerSuffix + '/upload/success');

						// hide loading indicator and unblock "Upload" button
						$('#WikiaPhotoGalleryImageUploadButton').attr('disabled', false);
						$('#WikiaPhotoGalleryUploadProgress').hide();

						// are we editing gallery entry?
						var imageId = self.editor.currentPageParams.imageId;

						if (data.success) {
							// proceed to the caption / link page
							self.selectPage(self.CAPTION_LINK_PAGE, {
								imageId: imageId,
								imageName: data.name
							});
						}
						else if (data.conflict) {
							// handle name conflicts

							// generate thumbnail of temporary uploaded file (and show it next to the current one from MW)
							var thumbnail = '<img src="' + data.thumbnail.url + '" alt="" border="0" ' +
								'width="' + data.thumbnail.width + '" height ="' + data.thumbnail.height + '" />';

							self.selectPage(self.UPLOAD_CONFLICT_PAGE, {
								imageId: imageId,
								imageName: data.name,
								nameParts: data.nameParts,
								tempId: data.tempId,
								thumbnail: thumbnail
							});
						}
						else {
							// error handling
							self.log('upload error #' + data.reason);

							self.showAlert(
								self.editor.msg['wikiaPhotoGallery-upload-title'],
								data.message
							);

							// clear upload form
							$('#WikiaPhotoGalleryImageUpload').val('');
						}
					}
				});
			});
	},

	// setup given search results area (clicks, tracking)
	setupSearchResults: function(type) {
		var self = this;

		var resultsTrackingType = (type == self.RESULTS_IMAGES_FROM_THIS_PAGE) ? 'images' : 'recent';

		// setup chooser links
		var chooserLinks = $('#WikiaPhotoGallerySearchResultsChooser').children('span');

		// add .active class
		var query = '[type=' + type + ']';
		chooserLinks.not(query).addClass('clickable');
		chooserLinks.filter(query).removeClass('clickable');

		// setup clicks
		chooserLinks.unbind('.chooser').bind('click.chooser', function(ev) {
			var type = parseInt($(this).attr('type'));
			self.setupSearchResults(type);
		});

		// get results lists
		var results = $('#WikiaPhotoGallerySearchResults').children('ul');

		// hide both types
		results.hide();

		// use the selected one
		results = results.eq(type);

		// highlight images (show on hover, keep when checkbox ticked)
		var selectImage = function(ev) {
			var target = $(ev.target);

			if (!target.is('li')) {
				target = target.parent();
			}

			target.addClass('accent selected');
		};
		var unselectImage = function(ev) {
			var target = $(ev.target);

			if (!target.is('li')) {
				target = target.parent();
			}

			var checkbox = target.children('input');

			if (!checkbox.attr('checked')) {
				target.removeClass('accent selected');
			}
		};

		// hovering
		results.find('li').unbind('.imageHover').
			bind({
				'mouseover.imageHover': selectImage,
				'mouseout.imageHover': unselectImage
			});

		// checkboxes
		results.find('input').unbind('.imageHover').
			bind('change.imageHover', function(ev) {
				var checkbox = $(this);

				if (checkbox.attr('checked')) {
					selectImage(ev);
				}
				else {
					unselectImage(ev);
				}
			});

		// setup clicks on image thumbnails
		results.find('a').unbind('.selectImage').bind('click.selectImage', function(ev) {
			ev.preventDefault();

			var node = $(this);
			var imageName = node.attr('title');

			// tracking
			var num = node.attr('num');
			self.track('/dialog/upload/' + resultsTrackingType + '/' + num);

			// are we editing gallery entry?
			var imageId = self.editor.currentPageParams.imageId;

			// proceed to the next page
			self.selectPage(self.CAPTION_LINK_PAGE, {
				imageId: imageId,
				imageName: imageName
			});
		});

		// setup clicks on "Select" button
		$('#WikiaPhotoGallerySearchResultsSelect').unbind('.selectImage').bind('click.selectImage', function(ev) {
			var selected = results.find('input[checked]');
			self.log(selected.length + ' image(s) selected')

			if (!selected.exists()) {
				// no images selected
				return;
			}

			// tracking
			var trackerSuffix = self.getPageTrackerSuffix();
			var listType = (results.attr('type') == 'uploaded') ? 'recent' : 'onpage';
			self.track('/dialog/' + trackerSuffix + '/list/' + listType + '/' + selected.length);

			if (selected.length == 1) {
				// one image selected - proceed to caption/link page
				var imageName = selected.attr('value');

				// are we editing gallery entry?
				var imageId = self.editor.currentPageParams.imageId;

				// proceed to the next page
				self.selectPage(self.CAPTION_LINK_PAGE, {
					imageId: imageId,
					imageName: imageName
				});
			}
			else {
				// 1+ images selected - add'em all and proceed to preview page
				selected.each(function() {
					var imageName = $(this).attr('value');

					// add an image to gallery
					var data = {
						caption: '',
						link: '',
						linktext: '',
						name: imageName
					};

					self.editor.gallery.images.push(data);
				});

				// proceed to the next page
				if (self.isSlideshow()) {
					self.selectPage(self.SLIDESHOW_PREVIEW_PAGE);
				}
				else {
					self.selectPage(self.GALLERY_PREVIEW_PAGE);
				}
			}

			// unselect selected images
			selected.attr('checked', false).each(function() {
				$(this).parent().removeClass('accent selected');
			});
		});

		// setup is done - show the results
		results.show();
	},

	// setup mini-MW toolbar for caption editor
	setupCaptionToolbar: function() {
		var captionEditor = $('#WikiaPhotoGalleryEditorCaption');
		var captionToolbar = $('#WikiaPhotoGalleryEditorCaptionToolbar').html('').hide();

		// show toolbar on focus / hide on blur
		var toolbarHideTimeout = false;

		$('#WikiaPhotoGalleryEditorCaption').unbind('.editor').
			bind('focus.editor', function(ev) {
				clearTimeout(toolbarHideTimeout);

				captionToolbar.show();
			}).
			bind('blur.editor', function(ev) {
				toolbarHideTimeout = setTimeout(function() {
					captionToolbar.hide();
				}, 250);
			});

		var messages = this.editor.msg;

		// toolbar buttons
		var toolbarButtons = [
			{
				image: 'bold',
				tagOpen: "'''",
				tagClose: "'''",
				title: messages['bold_tip']
			},
			{
				image: 'italic',
				tagOpen: "''",
				tagClose: "''",
				title: messages['italic_tip']
			},
			{
				image: 'link',
				tagOpen: "[[",
				tagClose: "]]",
				title: messages['link_tip']
			}
		];

		// handle clicks on toolbar buttons
		var self = this;
		var toolbarButtonOnClick = function(tagOpen, tagClose, sampleText) {
			self.log(tagOpen + 'foo' + tagClose);

			self.insertTags(captionEditor, tagOpen, tagClose, sampleText);

			// don't hide toolbar and bring focus back
			clearTimeout(toolbarHideTimeout);
			captionEditor.focus();
		};

		// add buttons
		for (var i=0; i < toolbarButtons.length; i++) {
			var data = toolbarButtons[i];

			$('<img />').
				appendTo(captionToolbar).
				attr({
					alt: '',
					height: 22,
					src: stylepath + '/common/images/button_' + data.image + '.png',
					tagClose: data.tagClose,
					tagOpen: data.tagOpen,
					title: data.title,
					width: 23
				}).
				click(function() {
					var button = $(this);
					toolbarButtonOnClick(button.attr('tagOpen'), button.attr('tagClose'), button.attr('title'));
				});
		}
	},

	// setup MW suggest for link field
	setupLinkSuggest: function(fieldId) {
		var self = this;

		// setup suggest just once
		if ($('#' + fieldId + 'Suggest').exists()) {
			return;
		}

		// prevent submittion of the form (it's needed only for MW suggest functions)
		document.getElementById('WikiaPhotoGalleryEditorForm').submit = function() {};

		// add MW suggest for Link field
		window.os_enableSuggestionsOn(fieldId, 'WikiaPhotoGalleryEditorForm');

		// create results container ...
		var container = $(window.os_createContainer(os_map[fieldId]));
		var fieldElem = $('#' + fieldId);

		// ... add it to suggestions wrapper
		container.appendTo('#' + fieldId + 'SuggestWrapper');

		// handle ENTER hits (hide suggestion's dropdown)
		$('#' + fieldId).keydown(function(ev) {
			if (ev.keyCode == 13) {
				$('#' + fieldId + 'Suggest').css('visibility', 'hidden');
			}
		});

		this.log('MW suggest set up for #' + fieldId);
	},

	// setup width slider and alignment dropdown
	setupSliderAndDropDown: function() {
		var tooltip = $('#WikiaPhotoGalleryEditorPreviewSlider').children('.ui-slider-tooltip').hide();
		var timeoutId = false;

		var self = this;

		// @see http://docs.jquery.com/UI/API/1.8/Slider
		$('#WikiaPhotoGalleryEditorPreviewSlider').slider({
			animate: true,
			min: 50,
			max: 300,

			// fired during sliding
			slide: function(ev, ui) {
				var value = ui.value;

				tooltip.show().text(value);

				// hide tooltip when sliding is done
				if (timeoutId) {
					clearTimeout(timeoutId);
				}

				timeoutId = setTimeout(function() {
					tooltip.fadeOut();
				}, 750);
			},

			// fired when sliding is done
			stop: function(ev, ui) {
				var value = ui.value;

				// change value of "widths" gallery parameter
				self.editor.gallery.params.widths = value;

				// refresh gallery preview
				self.renderGalleryPreview();

				self.track('/dialog/gallery/preview/changeSize');
			}
		});

		// setup alignment dropdown
		$('#WikiaPhotoGalleryEditorPreviewAlign').
			unbind('.dropdown').
			bind('change.dropdown', function() {
				var value = $(this).val();

				// change value of "captionalign" gallery parameter
				self.editor.gallery.params.captionalign = value;

				// refresh gallery preview
				self.renderGalleryPreview();

				self.track('/dialog/gallery/preview/captionAlignment/' + value);
			});
	},

	// image search event handler
	onImageSearch: function(ev) {
		ev.preventDefault();

		var self = this;

		// show loading indicator and block "Find" button
		$('#WikiaPhotoGallerySearchButton').attr('disabled', true);
		$('#WikiaPhotoGallerySearchProgress').show();

		var query = $('#WikiaPhotoGallerySearchQuery').val();

		this.ajax('getSearchResult', {query: query}, function(data) {
			// hide loading indicator and unblock "Find" button
			$('#WikiaPhotoGallerySearchButton').attr('disabled', false);
			$('#WikiaPhotoGallerySearchProgress').hide();

			// change search results heading
			$('#WikiaPhotoGallerySearchHeader').html(data.msg);

			// render results
			if (data.html) {
				$('#WikiaPhotoGallerySearchResults').html(data.html);
				self.setupSearchResults();
			}
			else {
				$('#WikiaPhotoGallerySearchResults').html('');
			}
		});

		// tracking
		if (query != '') {
			this.track('/dialog/upload/find/find/' + query.replace(/[^A-Za-z0-9]/g, '_'));
		}
	},

	// setup type choosing page
	setupChooseTypePage: function(params) {
		var self = this;
		var buttons = $('#WikiaPhotoGalleryEditor').find('.WikiaPhotoGalleryEditorChooseType').find('table').find('a');

		buttons.
			unbind('.choice').
			bind('click.choice', function(ev) {
				ev.preventDefault();

				var type = parseInt( $(this).attr('type') );

				// set the type: gallery / slideshow
				self.editor.gallery.type = type;
				self.log('choosen type is #' + type);

				if (self.isSlideshow()) {
					self.selectPage(self.UPLOAD_FIND_PAGE);
					self.track('/dialog/choice/slideshow');
				}
				else {
					self.selectPage(self.GALLERY_PREVIEW_PAGE);
					self.track('/dialog/choice/gallery');
				}
			});
	},

	// setup upload page
	setupUploadPage: function(params) {
		// reset fields value
		$('#WikiaPhotoGalleryImageUpload').val('');

		// unblock upload form
		$('#WikiaPhotoGalleryImageUploadButton').attr('disabled', false);
	},

	// setup upload conflict page
	setupUploadConflictPage: function(params) {
		var self = this;

		// fill in image name and its extension
		if (params.nameParts) {
			$('#WikiaPhotoGalleryEditorConflictNewName').val(params.nameParts[0]);
			$('#WikiaPhotoGalleryEditorConflictExtension').text('.' + params.nameParts[1]);
		}

		// show thumbnails (uploaded version vs current version)
		var thumbCells = $('#WikiaPhotoGalleryEditorConflictThumbs').children();

		thumbCells.eq(0).html(params.thumbnail);
		this.loadThumbnail(params.imageName, thumbCells.eq(1));

		//
		// setup clicks on buttons and link resolving the conflict
		//

		// are we editing gallery entry?
		var imageId = self.editor.currentPageParams.imageId;

		// rename photo
		$('#WikiaPhotoGalleryEditorConflictRename').unbind('.conflict').bind('submit.conflict', function(ev) {
			ev.preventDefault();

			var form = $(this).children('[type=submit]');
			form.attr('disabled', true);

			var newName = $('#WikiaPhotoGalleryEditorConflictNewName').val() + $('#WikiaPhotoGalleryEditorConflictExtension').text();
			self.log('renaming conflicting image to "' + newName + '"');

			self.ajax('conflictRename', {
				newName: newName,
				tempId: params.tempId
			}, function(data) {
				// unblock button
				form.attr('disabled', false);

				if (data.resolved) {
					// go to Link / Caption page
					self.selectPage(self.CAPTION_LINK_PAGE, {
						imageId: imageId,
						imageName: newName
					});
				}
				else {
					self.showAlert(
						self.editor.msg['wikiaPhotoGallery-upload-title'],
						data.msg
					);
				}
			});
		});

		// reuse existing photo
		$('#WikiaPhotoGalleryEditorConflictReuse').unbind('.conflict').bind('click.conflict', function(ev) {
			self.log('reusing existing image');

			// go to Link / Caption page
			self.selectPage(self.CAPTION_LINK_PAGE, {
				imageId: imageId,
				imageName: params.imageName
			});
		});

		// overwrite existing photo
		$('#WikiaPhotoGalleryEditorConflictOverwrite').unbind('.conflict').bind('click.conflict', function(ev) {
			self.log('overwriting existing image');

			// overwrite existing photo
			var form = $(this);
			form.attr('disabled', true);

			self.ajax('conflictOverwrite', {
				imageName: params.imageName,
				tempId: params.tempId
			}, function(data) {
				// unblock button
				form.attr('disabled', false);

				// go to Link / Caption page
				self.selectPage(self.CAPTION_LINK_PAGE, {
					imageId: imageId,
					imageName: params.imageName
				});
			});
		});
	},

	// setup link / caption page
	setupCaptionLinkPage: function(params) {
		// setup image preview (remove any previous image, show loading indicator)
		var imagePreview = $('#WikiaPhotoGalleryEditorCaptionImagePreview');

		imagePreview.
			html('').
			addClass('WikiaPhotoGalleryProgress');

		// get thumbnail for selected image
		this.loadThumbnail(params.imageName, imagePreview);

		// set value of caption / link / linktext fields
		var caption = '';
		var link = '';
		var linktext = '';

		// used when 'cancel' button pressed
		if (params.caption || params.link) {
			if (params.caption) caption = params.caption;
			if (params.link) link = params.link;
			if (params.linktext) linktext = params.linktext;
		}
		// editing existing image (and entering via 'modify' - not 'cancel')
		else if (params.imageId != null) {
			var image = this.editor.gallery.images[ params.imageId ];

			caption = image.caption;
			link = image.link;
			linktext = image.linktext;
		}

		$('#WikiaPhotoGalleryEditorCaption').val(caption);

		// show proper link editor and set fields values
		var galleryLinkEditor = $('#WikiaPhotoGalleryLinkEditor');
		var slideshowLinkEditor = $('#WikiaPhotoSlideshowLinkEditor');

		galleryLinkEditor.hide();
		slideshowLinkEditor.hide();

		if (this.isSlideshow()) {
			slideshowLinkEditor.show();

			$('#WikiaPhotoSlideshowLink').val(link);
			$('#WikiaPhotoSlideshowLinkText').val(linktext);
		}
		else {
			galleryLinkEditor.show();

			$('#WikiaPhotoGalleryLink').val(link);
		}
	},

	// generic method for rendering gallery/slideshow preview
	renderPreview: function(node, method, type) {
		var self = this;
		var gallery = this.editor.gallery;

		// show loading indicator
		var preview = $(node);
		preview.html('').addClass('WikiaPhotoGalleryProgress');

		// send JSON-encoded gallery data to backend to render HTML for it
		var galleryJSON = $.toJSON({
			images: gallery.images,
			params: gallery.params
		});

		this.ajax(method, {
			gallery: galleryJSON
		}, function(data) {
			// remove loading indicator
			preview.removeClass('WikiaPhotoGalleryProgress').html(data.html);

			// setup on-hover image menu
			preview.find('.WikiaPhotoGalleryPreviewItem').not('.WikiaPhotoGalleryPreviewItemPlaceholder').
				hover(
					function(ev) {
						var image = $(this);
						var imageId = parseInt(image.attr('imageid'));

						// highlight selected image
						image.addClass('accent WikiaPhotoGalleryPreviewItemHover');

						// setup modify / delete hover menu
						var menu = image.children('.WikiaPhotoGalleryPreviewItemMenu').show();

						// handle clicks on "modify" and "delete"
						var menuItems = menu.children('a').unbind('.menu');

						// "modify"
						menuItems.eq(0).bind('click.menu', function(ev) {
							ev.preventDefault();

							var trackerSuffix = self.getPageTrackerSuffix();
							self.track('/dialog/' + trackerSuffix + '/photo/modify');

							self.modifyPhoto(imageId);
						});

						// "delete"
						menuItems.eq(1).bind('click.menu', function(ev) {
							ev.preventDefault();

							var trackerSuffix = self.getPageTrackerSuffix();
							self.track('/dialog/' + trackerSuffix + '/photo/delete');

							self.removePhoto(imageId);
						});
					},
					function(ev) {
						// onmouseout
						var image = $(this);

						image.removeClass('accent WikiaPhotoGalleryPreviewItemHover');

						image.children('.WikiaPhotoGalleryPreviewItemMenu').hide();
					}
				);

			// setup image placeholders
			preview.find('.WikiaPhotoGalleryPreviewItemPlaceholder').find('a').click(function(ev) {
				ev.preventDefault();

				self.log('adding next picture...');
				self.track('/dialog/gallery/preview/addPhoto');

				self.selectPage(self.UPLOAD_FIND_PAGE, {});
			});

			// prevent clicks on caption links
			preview.find('.WikiaPhotoGalleryPreviewItemCaption').find('a').click(function(ev) {
				ev.preventDefault();
			});

			// clicks on "Add caption" and "Link" - edit given image
			preview.
				find('.WikiaPhotoGalleryPreviewItemCaption').
				add( preview.find('.WikiaPhotoGalleryPreviewItemLink') ).
				click(function(ev) {
					ev.preventDefault();

					var node = $(this);
					var imageId = parseInt( node.closest('.WikiaPhotoGalleryPreviewItem').attr('imageid') );

					// tracking
					var trackerSuffix = self.getPageTrackerSuffix();

					if (node.hasClass('WikiaPhotoGalleryPreviewItemLink')) {
						// link icon clicked
						self.track('/dialog/' + trackerSuffix + '/photo/link');
					}
					else if (node.hasClass('WikiaPhotoGalleryPreviewItemAddCaption')) {
						// "Add a caption" clicked
						self.track('/dialog/' + trackerSuffix + '/photo/captionNew');
					}
					else {
						// exisiting photo caption clicked
						self.track('/dialog/' + trackerSuffix + '/photo/captionEdit');
					}

					self.modifyPhoto(imageId);
				}
			);

			// setup images drag&drop
			var gallery = preview.find('.WikiaPhotoGalleryPreview');

			gallery.sortable({
				containment: 'document',
				delay: 100,
				forcePlaceholderSize: true,
				items: '> .WikiaPhotoGalleryPreviewDraggable',
				opacity: 0.5,
				placeholder: 'WikiaPhotoGalleryPreviewDDPlaceholder',
				revert: 200, // smooth animation

				// ondrag
				start: function(ev, ui) {
					// get dragged item
					var image = $(ui.item);

					// remove highlight and onhover menu
					image.removeClass('accent WikiaPhotoGalleryPreviewItemHover');

					image.children('.WikiaPhotoGalleryPreviewItemMenu').hide();
				},

				// ondrop
				stop: function(ev, ui) {
					// get dropped item
					var item = ui.item;

					// remove CSS from grabbed item
					item.css({left: '', top: ''});

					// get old and new ID of drag&dropped image
					var oldId = parseInt(item.attr('imageid'));
					var newId = 0;

					gallery.find('.WikiaPhotoGalleryPreviewDraggable').each( function(i) {
						if ($(this).attr('imageid') == oldId) {
							newId = i;
						}
					});

					self.log('drag&drop: #' + oldId + ' -> #' + newId);

					// useless D&D
					if (oldId == newId) {
						return;
					}

					// tracking
					var trackerSuffix = self.getPageTrackerSuffix();
					self.track('/dialog/' + trackerSuffix + '/photo/move');

					// switch #oldId and #newId images
					var images = self.editor.gallery.images;
					var temp = $.extend(true, images[oldId], {});

					//self.log(images);

					images.splice(oldId, 1);
					images.splice(newId, 0, temp);

					//self.log(images);

					// render preview
					self.renderGalleryPreview();
				}
			});
		});
	},

	// setup gallery preview page
	setupGalleryPreviewPage: function(params) {
		// show slider and alignment dropdown menu
		$('#WikiaPhotoGalleryEditorPreviewOptions').show();

		var params = this.editor.gallery.params;

		// set slider value
		var widths = parseInt(params.widths) || 120 /* default value */;
		$('#WikiaPhotoGalleryEditorPreviewSlider').slider('value', widths);

		// select proper alignment option
		$('#WikiaPhotoGalleryEditorPreviewAlign').val( params.captionalign || 'left' );

		// render preview
		this.renderGalleryPreview();
	},

	// render gallery preview
	renderGalleryPreview: function() {
		this.renderPreview('#WikiaPhotoGalleryEditorPreview', 'renderGalleryPreview', 'gallery');
	},

	// setup slideshow width slider
	setupSlideshowSlider: function() {
		var self = this;
		var field = $('#WikiaPhotoGallerySlideshowWidth');
		var slider = $('#WikiaPhotoGallerySlideshowWidthSlider');

		var sliderValues = {
			min: 200,
			max: 500
		};

		// set proper slider width
		slider.css('width', (sliderValues.max - sliderValues.min) + 'px')

		// @see http://docs.jquery.com/UI/API/1.8/Slider
		slider.slider({
			animate: true,
			min: sliderValues.min,
			max: sliderValues.max,

			// fired during sliding
			slide: function(ev, ui) {
				var value = ui.value;

				field.val(value);
			},

			// fired when sliding is done
			stop: function(ev, ui) {
				var value = ui.value;

				// change value of "widths" gallery parameter
				self.editor.gallery.params.widths = value;

				self.track('/dialog/slideshow/preview/changeSize');

				// regenerate slideshow preview with updated width
				self.renderSlideshowPreview();
			}
		});

		// changes made in field should be shown on slider
		field.bind('keyup blur', function(ev) {
			var value = parseInt($(this).val());

			// correct value when user leaves the field
			if (ev.type == 'blur' && isNaN(value)) {
				value = sliderValues.min;
				$(this).val(value);
			}

			// update the slider
			if (value > 0) {
				slider.slider('value', value);
				self.editor.gallery.params.widths = value;
			}

			// update preview when user leaves the field
			if (ev.type == 'blur') {
				self.renderSlideshowPreview();
			}
		});
	},

	// setup slideshow preview page
	setupSlideshowPreviewPage: function(params) {
		var self = this;
		var params = this.editor.gallery.params;

		// set slider value
		var widths = parseInt(params.widths) || 300 /* default value */;
		$('#WikiaPhotoGallerySlideshowWidthSlider').slider('value', widths);

		// "width" field
		$('#WikiaPhotoGallerySlideshowWidth').val(widths);

		// "crop" checkbox
		$('#WikiaPhotoGallerySlideshowCrop').
			attr('checked', (params.crop == 'true')).
			unbind('.crop').bind('change.crop', function(ev) {
				if ($(this).attr('checked')) {
					self.editor.gallery.params.crop = 'true';
				}
				else {
					delete self.editor.gallery.params.crop;
				}

				self.renderSlideshowPreview();
		});

		// "Add an Image" button
		$('#WikiaPhotoGallerySlideshowAddImage').unbind('.addimage').bind('click.addimage', function(ev) {
			ev.preventDefault();

			self.log('adding next picture...');
			self.track('/dialog/slideshow/preview/addPhoto');

			self.selectPage(self.UPLOAD_FIND_PAGE, {});
		});

		// render preview
		this.renderSlideshowPreview();
	},

	// render slideshow preview
	renderSlideshowPreview: function() {
		var gallery = this.editor.gallery;

		// debug
		this.log( this.JSONtoWikiText(gallery) );

		// show loading indicator
		this.renderPreview('#WikiaPhotoGallerySlideshowEditorPreview', 'renderSlideshowPreview', 'slideshow');
	},

	// setup edit conflict page
	setupEditConflictPage: function(params) {
		var self = this;

		$('#WikiaPhotoGalleryEditConflictButtons').show();

		var buttons = $('#WikiaPhotoGalleryEditConflictButtons').children('a');
		var wikitext = $('#WikiaPhotoGalleryEditConflictWikitext');

		var pageUrl = window.wgArticlePath.replace(/\$1/, window.wgPageName);

		// "View edit mode"
		buttons.eq(0).
			attr('href', pageUrl + (pageUrl.indexOf('?') != -1 ? '&' : '?') + 'action=edit').
			click(function() {
				self.track('/dialog/conflict/edit');
			});

		// "View the current article"
		buttons.eq(1).
			attr('href', pageUrl).
			click(function() {
				self.track('/dialog/conflict/view');
			});

		// generate wikitext
		wikitext.val(this.editor.gallery.wikitext);

		// tracking
		this.track('/dialog/conflict/init');
	},

	// modify selected photo
	modifyPhoto: function(photoId) {
		this.log('modifying photo #' + photoId);

		var image = this.editor.gallery.images[photoId];

		this.selectPage(this.CAPTION_LINK_PAGE, {
				imageId: photoId,
				imageName: image.name
		});
	},

	// removes selected photo from gallery and refreshes preview
	removePhoto: function(photoId) {
		var self = this;
		var messages = this.editor.msg;

		jQuery.confirm({
			title: messages['wikiaPhotoGallery-preview-delete-title'],
			content: messages['wikiaPhotoGallery-preview-delete'],
			onOk: function() {
				self.log('removing photo #' + photoId);

				self.editor.gallery.images.splice(photoId, 1);

				// render preview
				if (self.isSlideshow()) {
					self.renderSlideshowPreview();
				}
				else {
					self.renderGalleryPreview();
				}
			},
			okMsg: messages['ok'],
			cancelMsg: messages['cancel']
		});
	},

	// show "Save and quit dialog"
	showSaveAndQuitDialog: function() {
		var self = this;
		var messages = this.editor.msg;

		this.log('showSaveAndQuitDialog: show');

		var html = '<p>' + messages['wikiaPhotoGallery-quit-intro'] + '</p>' +
			'<div class="neutral modalToolbar">' +
			'<a class="wikia-button">' + messages['wikiaPhotoGallery-quit-savequit'] + '</a>' +
			'<a class="wikia-button secondary">' + messages['wikiaPhotoGallery-quit-quitonly'] + '</a>' +
			'<a class="wikia-button secondary">' + messages['cancel'] + '</a>' +
			'</div>';

		jQuery.showModal(
			messages['wikiaPhotoGallery-quit-title'],
			html,
			{
				id: 'WikiaPhotoGalleryShowSaveQuitDialog',
				callback: function() {
					// setup clicks
					var buttons = $('#WikiaPhotoGalleryShowSaveQuitDialog').find('.modalToolbar').children();

					// save & quit
					buttons.eq(0).click(function() {
						$('#WikiaPhotoGalleryShowSaveQuitDialog').closeModal();

						self.log('showSaveAndQuitDialog: save & quit');
						self.track('/dialog/quit/savequit');

						// save changes (let's pretend we're on gallery preview where user can click "Save")

						// apply any changes made on Caption / link page
						if (self.editor.currentPage == self.CAPTION_LINK_PAGE) {
							self.onSave();
						}

						self.editor.currentPage = self.GALLERY_PREVIEW_PAGE;
						self.onSave();
					});

					// discard changes
					buttons.eq(1).click(function() {
						$('#WikiaPhotoGalleryShowSaveQuitDialog').closeModal();

						self.log('showSaveAndQuitDialog: discard changes & quit');
						self.track('/dialog/quit/quit');

						$('#WikiaPhotoGalleryEditor').hideModal();
					});

					// cancel
					buttons.eq(2).click(function() {
						$('#WikiaPhotoGalleryShowSaveQuitDialog').closeModal();

						self.log('showSaveAndQuitDialog: cancel');
						self.track('/dialog/quit/cancel');
					});
				},
				onClose: function() {
					self.track('/dialog/quit/close');
				}
			}
		);
	},

	// fetch and show gallery editor -- this is an entry point
	showEditor: function(params) {
		var self = WikiaPhotoGallery;

		// for anons show ComboAjaxLogin
		if (typeof showComboAjaxForPlaceHolder == 'function') {
			if (showComboAjaxForPlaceHolder('', false, '', false, true)) { // last true shows the 'login required for this action' message.
				self.log('please login to use this feature');
				return;
			}
		}

		// check lock to catch double-clicks on toolbar button
		if (self.lock) {
			self.log('lock detected - please wait for dialog to load');
			return;
		}

		self.lock = true;

		// make params always be an object
		params = params || {};

		// get width of article to be used for editor
		var width = parseInt($('#article').width());
		width = Math.max(670, width);
		width = Math.min(1300, width);

		self.log('showEditor() - ' + width + 'px');
		self.log(params);

		self.editor.width = width;

		var editorPopup = $('#WikiaPhotoGalleryEditor');
		if (!editorPopup.exists()) {
			self.ajax('getEditorDialog', {title: wgPageName}, function(data) {
				// store messages
				self.editor.msg = data.msg;

				// render editor popup
				$.showModal('', data.html, {
					callback: function() {
						// remove loading indicator
						$('#WikiaPhotoGalleryEditorLoader').remove();

						// add <span> wrapping editor title
						$('#WikiaPhotoGalleryEditor').children('.modalTitle').
							append('<span id="WikiaPhotoGalleryEditorTitle"></span>');

						self.setupEditor(params);
					},
					onClose: function(type) {
						self.log('onClose');

						// prevent close event triggered by ESCAPE key
						if (type.keypress) {
							return false;
						}

						// tracking
						var trackerSuffix = self.getPageTrackerSuffix();
						if (trackerSuffix) {
							self.track('/dialog/' + trackerSuffix + '/close');
						}

						// X has been clicked
						var currentPage = self.editor.currentPage;
						if (type.click) {
							if (currentPage == self.EDIT_CONFLICT_PAGE) {
								// just close the dialog when on edit conflict page
								return;
							}
							else if (currentPage == self.CHOOSE_TYPE_PAGE) {
								// just close the dialog when on choice page
								return;
							}
							else {
								// show "Save and quit" popup for the rest
								self.showSaveAndQuitDialog();
								return false;
							}
						}
					},
					id: 'WikiaPhotoGalleryEditor',
					persistent: true, // don't remove popup when user clicks X
					width: self.editor.width
				});

				// load CSS for editor popup
				importStylesheetURI(wgExtensionsPath + '/wikia/WikiaPhotoGallery/css/WikiaPhotoGallery.editor.css?' + wgStyleVersion);
			});
		}
		else {
			self.setupEditor(params);
			editorPopup.showModal();
		}
	},

	// fetch and show pop out dialog for given slideshow
	showSlideshowPopOut: function(slideshowId, hash, index, isPageView) {
		var self = this;

		self.log('opening slideshow pop-out');

		var params = {
			'hash': hash,
			'maxwidth': $.getViewportWidth(),
                        'maxheight': $.getViewportHeight(),
			'title': wgPageName,
			'revid': window.wgRevisionId
		};

		WikiaPhotoGallery.ajax('getSlideshowPopOut', params, function(slideshow) {
			var dialogId = 'wikia-slideshow-popout-' + (new Date().getTime());

			$.showModal(slideshow.title, slideshow.html, {
				id: dialogId,
				className: 'wikia-slideshow-popout',
				width: parseInt(slideshow.width),
				onClose: function() {
					self.trackForView('/slideshow/popout/close');
				},
				callback: function() {
					var dialog = $('#' + dialogId);

					var addImageButton = dialog.find('.wikia-slideshow-popout-add-image');

					if (isPageView) {
						// handle clicks on "Add Image" button
						addImageButton.click(function(ev) {
							ev.preventDefault();

							self.trackForView('/slideshow/popout/addImage');

							// close slideshow pop-out
							dialog.closeModal();

							WikiaPhotoGallery.ajax('getGalleryData', {hash:hash, title:wgPageName}, function(data) {
								if (data && data.info == 'ok') {
									data.gallery.id = slideshowId;
									WikiaPhotoGallery.showEditor({
										from: 'view',
										gallery: data.gallery
									});
								} else {
									WikiaPhotoGallery.showAlert(
										data.errorCaption,
										data.error
									);
								}
							});
						});
					}
					else {
						// hide "Add Image" button when not in view mode
						addImageButton.hide();
					}

					var carouselItems = dialog.find('.wikia-slideshow-popout-carousel').find('li');

					// modify carousel and caption when prev/next image is shown
					dialog.bind('slide', function(ev, data) {
						var slides = dialog.find('.wikia-slideshow-popout-images').children('li');

						// update caption
						var caption = dialog.find('.wikia-slideshow-popout-caption');
						caption.html( slides.eq(data.currentSlideId).attr('caption') );

						// update counter (n of X)
						var counter = dialog.find('.wikia-slideshow-popout-counter');
						counter.text( counter.attr('value').replace(/\$1/, 1 + data.currentSlideId) );

						// update carousel
						carouselItems.each(function(i) {
							var carouselItem = $(this);
							var index = (data.currentSlideId + (i-2)) % data.totalSlides;

							if (index < 0) {
								index += data.totalSlides;
							}

							var image = slideshow.carousel[index][ (i == 2) ? 'current' : 'small' ];

							carouselItem.
								attr('index', index).
								css('background-image', 'url(' + image + ')');
						});
					});

					// track clicks on prev / next
					dialog.bind('onPrev', function() {
						self.trackForView('/slideshow/popout/previous');
					});

					dialog.bind('onNext', function() {
						self.trackForView('/slideshow/popout/next');
					});

					// handle clicks on slideshow images
					dialog.find('.wikia-slideshow-image-link').click(function(ev) {
						self.trackForView('/slideshow/popout/imageClick/link');
					});

					// start/stop animation
					var startStopLinks = dialog.find('.wikia-slideshow-popout-start-stop').children('a');

					dialog.bind('onStart', function(ev) {
						startStopLinks.hide();
						startStopLinks.eq(1).show();

						dialog.attr('state', 'playing');
					});

					dialog.bind('onStop', function(ev) {
						startStopLinks.hide();
						startStopLinks.eq(0).show();

						dialog.attr('state', 'stopped');
					});

					// start animation
					// move to the next slide after 1 sec, then slide every 5 sec
					startStopLinks.eq(0).click(function(ev) {
						var currentSlide = parseInt(dialog.data('currentSlide'));
						var slides = parseInt(dialog.data('slides'));

						var nextSlide = (currentSlide + 1) % slides;

						setTimeout(function() {
							dialog.trigger('selectSlide', {slideId: nextSlide});
						}, 1000);

						dialog.trigger('start');

						self.trackForView('/slideshow/popout/play');
					});

					// stop animation
					startStopLinks.eq(1).click(function(ev) {
						dialog.trigger('stop');

						self.trackForView('/slideshow/popout/stop');
					});

					// setup slideshow
					dialog.slideshow({
						buttonsClass: 'wikia-button',
						nextClass: 'wikia-slideshow-popout-next',
						prevClass: 'wikia-slideshow-popout-prev',
						slideWidth: slideshow.width + 'px',
						slidesClass: 'wikia-slideshow-popout-images'
					});

					// select slide (if function was called with "index" parameter)
					if (index > 0) {
						dialog.trigger('selectSlide', {slideId: index});
						self.log('slide #' + index + ' selected');
					}

					// setup prev/next toolbar
					dialog.find('.wikia-slideshow-popout-images-wrapper').
						mouseover(function(ev) {
							$(this).addClass('hover');
						}).
						mouseout(function(ev) {
							$(this).removeClass('hover');
						});

					self.log('slideshow pop out initialized');

					// setup clicks on carousel
					carouselItems.not('.wikia-slideshow-popout-carousel-current').
						click(function(ev) {
							var index = $(this).attr('index');
							dialog.trigger('selectSlide', {slideId: index});

							// and stop animation
							dialog.trigger('stop');
						});
				}
			});
		});

		// load CSS for slideshow popout
		importStylesheetURI(wgExtensionsPath + '/wikia/WikiaPhotoGallery/css/WikiaPhotoGallery.popout.css?' + wgStyleVersion);
	},

	// load thumbnail of image into given HTML node
	loadThumbnail: function(imageName, node) {
		this.ajax('getThumbnail', {imageName: imageName}, function(data) {
			node.
				removeClass('WikiaPhotoGalleryProgress').
				attr('title', imageName).
				html(data.thumbnail);
		});
	},

	// show modal version of alert() with Ok button
	showAlert: function(title, msg) {
		var id = 'WikiaPhotoGalleryAlert';

		var html = '<p>' + msg + '</p>' +
			'<div class="modalToolbar neutral"><a id="' + id + 'Ok" class="wikia-button"><span>Ok</span></a></div>';

		$.showModal(title, html, {
			callbackBefore: function() {
				$('#' + id + 'Ok').click(function() {
					$('#' + id).closeModal();
				});
			},
			id: id,
			zIndex: 5000
		});
	},

	// create wikitext from JSON data
	JSONtoWikiText: function(data) {
		var HTML = '<gallery';

		// add type="slideshow" tag attribute
		if (this.isSlideshow()) {
			data.params['type'] = 'slideshow';
		}

		// handle <gallery> tag attributes
		for (param in data.params) {
			//ignore default value
			if (param == 'captionalign' && data.params[param] == 'left') {
				continue;
			}
			if (data.params[param] != '') {
				HTML += ' ' + param + '="' + data.params[param] + '"';
			}
		}
		HTML += '>\n';

		// add images
		for (img in data.images) {
			var imageData = data.images[img];

			HTML += imageData.name;
			if (imageData.caption != '') {
				HTML += '|' + imageData.caption;
			}
			if (imageData.link != '') {
				HTML += '|link=' + imageData.link;
			}
			if (this.isSlideshow() && imageData.linktext != '') {
				HTML += '|linktext=' + imageData.linktext;
			}
			HTML += '\n';
		}
		HTML += '</gallery>';
		return HTML;
	},

	// apply tagOpen/tagClose to selection in textarea,
	// use sampleText instead of selection if there is none
	// taken from /skins/common/edit.js
	insertTags: function(txtarea, tagOpen, tagClose, sampleText) {
		var selText, isSample = false;

		// get pure DOM node
		txtarea = $(txtarea)[0];

		if (document.selection  && document.selection.createRange) { // IE/Opera
			//save window scroll position
			if (document.documentElement && document.documentElement.scrollTop)
				var winScroll = document.documentElement.scrollTop
			else if (document.body)
				var winScroll = document.body.scrollTop;
			//get current selection
			txtarea.focus();
			var range = document.selection.createRange();
			selText = range.text;
			//insert tags
			checkSelectedText();
			range.text = tagOpen + selText + tagClose;
			//mark sample text as selected
			if (isSample && range.moveStart) {
				if (window.opera)
					tagClose = tagClose.replace(/\n/g,'');
				range.moveStart('character', - tagClose.length - selText.length);
				range.moveEnd('character', - tagClose.length);
			}
			range.select();
			//restore window scroll position
			if (document.documentElement && document.documentElement.scrollTop)
				document.documentElement.scrollTop = winScroll
			else if (document.body)
				document.body.scrollTop = winScroll;

		} else if (txtarea.selectionStart || txtarea.selectionStart == '0') { // Mozilla

			//save textarea scroll position
			var textScroll = txtarea.scrollTop;
			//get current selection
			txtarea.focus();
			var startPos = txtarea.selectionStart;
			var endPos = txtarea.selectionEnd;
			selText = txtarea.value.substring(startPos, endPos);
			//insert tags
			checkSelectedText();
			txtarea.value = txtarea.value.substring(0, startPos)
				+ tagOpen + selText + tagClose
				+ txtarea.value.substring(endPos, txtarea.value.length);
			//set new selection
			if (isSample) {
				txtarea.selectionStart = startPos + tagOpen.length;
				txtarea.selectionEnd = startPos + tagOpen.length + selText.length;
			} else {
				txtarea.selectionStart = startPos + tagOpen.length + selText.length + tagClose.length;
				txtarea.selectionEnd = txtarea.selectionStart;
			}
			//restore textarea scroll position
			txtarea.scrollTop = textScroll;
		}

		function checkSelectedText(){
			if (!selText) {
				selText = sampleText;
				isSample = true;
			} else if (selText.charAt(selText.length - 1) == ' ') { //exclude ending space char
				selText = selText.substring(0, selText.length - 1);
				tagClose += ' '
			}
		}
	},

	// get DOM node of editarea (either of MW editor or RTE source mode)
	getEditarea: function() {
		if (typeof window.RTE == 'undefined') {
			// MW editor
			var control = document.getElementById('wpTextbox1');
		} else {
			// RTE
			var control = window.RTE.instance.textarea.$;
		}

		return control;
	},

	// get cursor position (source mode / MW editor)
	getCaretPosition: function() {
		var control = this.getEditarea();
		var caretPos = 0;

		// IE
		if(jQuery.browser.msie) {
			control.focus();
			var sel = document.selection.createRange();
			var sel2 = sel.duplicate();
			sel2.moveToElementText(control);
			var caretPos = -1;
			while(sel2.inRange(sel)) {
				sel2.moveStart('character');
				caretPos++;
			}
		}
		// Firefox
		else if (control.selectionStart || control.selectionStart == '0') {
			caretPos = control.selectionStart;
		}

		return caretPos;
	}

};

// add toolbar button
WikiaPhotoGallery.addToolbarButton();

/**
*
* AJAX IFRAME METHOD (AIM) rewritten for jQuery
* http://www.webtoolkit.info/
*
**/
jQuery.AIM = {
	// AIM entry point - used to handle submit event of upload forms
	submit : function(form, options) {
		var iframeName = jQuery.AIM.createIFrame(options);

		// upload "into" iframe
		$(form).
			attr('target', iframeName).
			log('AIM: uploading into "' + iframeName + '"');

		if (options && typeof(options.onStart) == 'function') {
			return options.onStart();
		} else {
			return true;
		}
	},

	// create iframe to handle uploads and return value of its "name" attribute
	createIFrame : function(options) {
		var name = 'aim' + Math.floor(Math.random() * 99999);
		var iframe = $('<iframe id="' + name + '" name="' + name + '" src="about:blank" style="display:none" />');

		// function to be fired when upload is done
		iframe.bind('load', function() {
			jQuery.AIM.loaded($(this).attr('name'));
		});

		// wrap iframe inside <div> and it to <body>
		$('<div>').
			append(iframe).
			appendTo('body');

		// add custom callback to be fired when upload is completed
		if (options && typeof(options.onComplete) == 'function') {
			iframe[0].onComplete = options.onComplete;
		}

		return name;
	},

	// handle upload completed event
	loaded : function(id) {
		$().log('AIM: upload into "' + id + '" completed');

		var i = document.getElementById(id);
		if (i.contentDocument) {
			var d = i.contentDocument;
		} else if (i.contentWindow) {
			var d = i.contentWindow.document;
		} else {
			var d = window.frames[id].document;
		}
		if (d.location.href == "about:blank") {
			return;
		}

		if (typeof(i.onComplete) == 'function') {
			i.onComplete(d.body.innerHTML);
		}
	}
}
