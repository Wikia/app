(function( window, $ ) {
	var Wikia = window.Wikia;

	var WikiaPhotoGallery = {
		// editor state
		editor: {
			currentPage: false,
			currentPageParams: {},
			from: false,
			gallery: {
				images: [],
				externalImages: [],
				node: false,
				params: {},
				type: false,
				hash: false,
				id: 0
			},
			msg: {},
			defaultParamValues: {},
			source: false,
			// dimensions of editor's popup (RT #55203, RT #55210)
			height: false,
			width: false
		},

		// constants
		CHOOSE_TYPE_PAGE: 0,
		UPLOAD_FIND_PAGE: 1,
		UPLOAD_CONFLICT_PAGE: 2,
		CAPTION_LINK_PAGE: 3,
		GALLERY_PREVIEW_PAGE: 4,
		SLIDESHOW_PREVIEW_PAGE: 5,
		SLIDER_PREVIEW_PAGE: 6,
		EDIT_CONFLICT_PAGE: 7,

		// type
		TYPE_GALLERY: 1,
		TYPE_SLIDESHOW: 2,
		TYPE_SLIDER: 3,

		// images list type
		RESULTS_RECENT_UPLOADS: 0,
		RESULTS_IMAGES_FROM_THIS_PAGE: 1,
		RESULTS_SEARCH: 2,

		// slider dimensions
		GALLERY_SLIDER_WIDTH: 660,
		GALLERY_SLIDER_HEIGHT: 360,

		// send AJAX request to extension's ajax dispatcher in MW
		ajax: function(method, params, callback) {
			return $.post(wgScript + '?action=ajax&rs=WikiaPhotoGalleryAjax&method=' + method, params, callback, 'json');
		},

		// console logging
		log: function(msg) {
			$().log(msg, 'WikiaPhotoGallery');
		},

		// useful shortcut :)
		isSlideshow: function() {
			return (this.editor.gallery.type == this.TYPE_SLIDESHOW);
		},

		isSlider: function() {
			return (this.editor.gallery.type == this.TYPE_SLIDER);
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
			var selectImageButton = $('#WikiaPhotoGallerySearchResultsSelect');

			// hide edit conflict buttons
			$('#WikiaPhotoGalleryEditConflictButtons').hide();
			selectImageButton.hide();

			// popup title
			var type = this.isSlideshow() ? 'slideshow' : this.isSlider() ? 'slider' : 'gallery';
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

					selectImageButton.show();

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

				// Slider preview page
				case this.SLIDER_PREVIEW_PAGE:
					$('#WikiaPhotoGalleryImageUploadSize').show();
					title = msg['wikiaPhotoGallery-sliderpreview-title'];

					saveButton.show().text(msg['wikiaPhotoGallery-finish']);
					cancelButton.hide();

					this.setupSliderPreviewPage(params);
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
			var params = this.editor.currentPageParams,
				hideModal = true,
				data,
				newPage = null,
				newParams = {},
				position;

			switch (this.editor.currentPage) {
				case this.UPLOAD_FIND_PAGE:
					break;

				case this.UPLOAD_CONFLICT_PAGE:
					break;

				case this.CAPTION_LINK_PAGE:
					var caption = $('#WikiaPhotoGalleryEditorCaption').val(),
						link = '',
						linktext = '';

					if (this.isSlideshow()) {
						newPage = this.SLIDESHOW_PREVIEW_PAGE;

						link = $('#WikiaPhotoSlideshowLink').val();
						linktext = $('#WikiaPhotoSlideshowLinkText').val();

					} else if ( this.isSlider()) {

						newPage = this.SLIDER_PREVIEW_PAGE;
						link = $('#WikiaPhotoSliderLink').val();
						linktext = $('#WikiaPhotoSliderLinkText').val();

					} else {
						newPage = this.GALLERY_PREVIEW_PAGE;
						link = $('#WikiaPhotoGalleryLink').val();
					}

					// remove wrapping brackets
					link.replace(/^(\[)+/, '').replace(/(\])+$/, '');

					data = {
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
					break;

				case this.SLIDER_PREVIEW_PAGE:
				case this.GALLERY_PREVIEW_PAGE:
				case this.SLIDESHOW_PREVIEW_PAGE:
					// update gallery data, generate wikitext and store it in wikitext
					var gallery = this.editor.gallery;

					// get widths / alignment from sliders
					if (this.isSlideshow()) {
						gallery.params.widths = this.sliderInput.val();
					} else if ( !this.isSlider() ) {
						gallery.params.captionalign = $('#WikiaPhotoGalleryEditorGalleryCaptionAlignment').val();
						gallery.params.widths = this.sliderInput.val();
						gallery.params.position = $('#WikiaPhotoGalleryEditorGalleryPosition').val();
					}

					gallery.wikitext = this.JSONtoWikiText(gallery);

					// update / save gallery
					switch (this.editor.from) {
						case 'wysiwyg':
							data = {
								images: gallery.images,
								params: gallery.params,
								wikitext: gallery.wikitext
							};

							this.log(data);

							// from RTE (wysiwyg mode)
							if (gallery.node) {
								// update existing gallery
								this.log('updating existing gallery/slideshow');

								// clear metadata
								gallery.node.setData('externalImages', false);

								// update metadata
								gallery.node.setData(data);

								position = gallery.params.position || 'right';
								gallery.node.removeClass('alignLeft alignRight alignCenter')
								.addClass('align' + position.substr(0,1).toUpperCase() + position.substr(1));
							} else {
								// add new gallery
								this.log('adding new gallery/slideshow');

								//the type property of data gets overwritten in createPlaceholder, we should use another name
								//this code is a temporary fix since it screws RTE tracking
								var node = RTE.tools.createPlaceholder('image-gallery', data);
								node.setData('type', gallery.type);

								node.removeClass('placeholder placeholder-ext').addClass('media-placeholder image-gallery');

								var dimensions = {};

								if(this.isSlideshow()) {
									position = gallery.params.position || 'right';

									node.addClass('image-slideshow');
									node.addClass('align' + position.substr(0,1).toUpperCase() + position.substr(1));

									dimensions.width = '300';
									dimensions.height = '225';
								} else if ( this.isSlider()) {
									node.addClass('image-gallery-slider');

									dimensions.width = this.GALLERY_SLIDER_WIDTH;
									dimensions.height = this.GALLERY_SLIDER_HEIGHT;
								} else {
									position = gallery.params.position || 'right';
									node.addClass('align' + position.substr(0,1).toUpperCase() + position.substr(1));
									dimensions.width = '185';
									dimensions.height = '185';
								}

								node.attr(dimensions);

								RTE.tools.insertElement(node);
							}

							//Autosaving the page without notifying the user is BAD UX! Commenting out. (by Lox)
							// show "Save in progress" popup
							/*var messages = this.editor.msg;
							$.showModal(
								messages['wikiaPhotoGallery-preview-saving-title'],
								'<p>' + messages['wikiaPhotoGallery-preview-saving-intro'] + '</p>',
								{id: 'WikiaConfirm'});

							hideModal = false;

							// save the whole page
							$('#wpSave').click();*/
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
							var event = jQuery.Event("beforeSaveGalleryData");
							var element_id = this.editor.allparams.element_id || 0;
							$("body").trigger(event, [element_id, gallery, $('#WikiaPhotoGalleryEditor')]);
							if ( event.isDefaultPrevented() ) {
								return false;
							}
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
			var newPage = null;
			var newPageParams = {};

			switch (editor.currentPage) {
				case this.UPLOAD_FIND_PAGE:
					newPage = params.source;
					if (params.imageId != null) { newPageParams.imageId = params.imageId; }
					if (params.imageName) { newPageParams.imageName = params.imageName; }
					if (params.caption) { newPageParams.caption = params.caption; }
					if (params.link) { newPageParams.link = params.link; }
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
			delete this.lockEditor;

			var self = this;

			// choose first page as the default one
			var firstPage = this.CHOOSE_TYPE_PAGE;

			// clear internal gallery object
			this.editor.gallery = {
				id: false,
				params:{},
				images:[],
				externalImages:[],
				node: false
			};

			switch (params.from) {
				case 'wysiwyg':
					if (typeof params.gallery == 'object') {

						// read gallery data from gallery node and store it in editor
						var data = params.gallery.getData();

						// use $.extend to avoid having "undefined" as value of externalImages
						this.editor.gallery = $.extend(this.editor.gallery, {
							id: data.id,
							images: data.images,
							externalImages: data.externalImages,
							node: params.gallery,
							params: data.params,
							type: data.type
						});

						if (this.isSlideshow()) {
							firstPage = this.SLIDESHOW_PREVIEW_PAGE;
						} else if (this.isSlider()){
							firstPage = this.SLIDER_PREVIEW_PAGE;
						} else {
							firstPage = this.GALLERY_PREVIEW_PAGE;
						}
					} else if (typeof params.type == 'number') {
						this.editor.gallery.type = params.type;
						if (this.isSlideshow()) {
							firstPage = this.SLIDESHOW_PREVIEW_PAGE;
						} else if (this.isSlider()){
							firstPage = this.SLIDER_PREVIEW_PAGE;
						} else {
							firstPage = this.GALLERY_PREVIEW_PAGE;
						}
					}
					break;

				case 'source':
					if (typeof params.type == 'number') {
						this.editor.gallery.type = params.type;
						if (this.isSlideshow()) {
							firstPage = this.SLIDESHOW_PREVIEW_PAGE;
						} else if (this.isSlider()){
							firstPage = this.SLIDER_PREVIEW_PAGE;
						} else {
							firstPage = this.GALLERY_PREVIEW_PAGE;
						}
					}
					break;

				case 'view':
					if (typeof params.gallery == 'object') {
						this.editor.gallery = params.gallery;
						this.editor.allparams = params;

						if (this.isSlideshow()) {
							firstPage = this.SLIDESHOW_PREVIEW_PAGE;
						} else if (this.isSlider()){
							firstPage = this.SLIDER_PREVIEW_PAGE;
						} else {
							firstPage = this.GALLERY_PREVIEW_PAGE;
						}
					}
					break;
			}
			this.editor.from = params.from;
			this.target = params.target;

			this.track({
				action: Wikia.Tracker.ACTIONS.OPEN
			});

			// setup search field
			this.setupSearch();

			// setup image upload
			this.setupUpload();

			// setup search results (by default show recent uploads)
			this.setupSearchResults(this.RESULTS_RECENT_UPLOADS);

			// setup caption editor toolbar
			this.setupCaptionToolbar();

			// setup MW suggest for link editor
			this.setupLinkSuggest('WikiaPhotoGalleryLink');
			this.setupLinkSuggest('WikiaPhotoSlideshowLink');

			// add handlers to buttons
			$('#WikiaPhotoGalleryEditorSave').unbind('.save').bind('click.save', function() {
				self.track({
					label: 'button-finish'
				});

				self.onSave.apply(self);
			});
			$('#WikiaPhotoGalleryEditorCancel').unbind('.cancel').bind('click.cancel', function() {
				self.track({
					label: 'button-back'
				});

				self.onCancel.apply(self);
			});

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
					self.track({
						label: 'button-upload-photo'
					});

					if ( self.isSlider() ) {
					 	$('#WikiaPhotoGalleryImageUploadSize').show();
					}
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

					// show loading indicator and block "Upload" button
					$('#WikiaPhotoGalleryImageUploadButton').attr('disabled', true);
					$('#WikiaPhotoGalleryUploadProgress').show();

					$.AIM.submit(this /* form */, {
						onComplete: function(response) {
							var data = $.parseJSON(response);

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
							} else if (data.conflict) {
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
							} else {
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

		// setup given search results area
		setupSearchResults: function(type) {
			var self = this;

			// setup chooser links
			var chooserLinks = $('#WikiaPhotoGallerySearchResultsChooser').children('span');

			// add .active class
			var query = '[type=' + type + ']';
			chooserLinks.not(query).addClass('clickable');
			chooserLinks.filter(query).removeClass('clickable');

			// setup clicks
			chooserLinks.unbind('.chooser').bind('click.chooser', function(ev) {
				var type = parseInt($(this).attr('type'));
				if (type === 0) {
					self.track({
						label: 'find-recent-uploads'
					});
				} else if (type === 1) {
					self.track({
						label: 'find-this-page'
					});
				}
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

					self.track({
						label: 'find-select-photo'
					});

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
				var selected = results.find('input:checked');

				self.track({
					label: 'button-select'
				});

				if (!selected.exists()) {
					// no images selected
					return;
				}

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
					} else if (self.isSlider()) {
						self.selectPage(self.SLIDER_PREVIEW_PAGE);
					} else {
						self.selectPage(self.GALLERY_PREVIEW_PAGE);
					}
				}

				// unselect selected images
				selected.attr('checked', false).each(function() {
					$(this).parent().removeClass('accent selected');
				});

				$(this).hide();

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
			var field = $('#' + fieldId);
			if (field.data('suggestSetUp')) {
				return;
			}

			// @see http://www.mediawiki.org/wiki/ResourceLoader/JavaScript_Deprecations#mwsuggest.js
			// uses CSS rules from 'wikia.jquery.ui' module
			field.autocomplete({
				minLength: 2,
				source: function( request, response ) {
					$.getJSON(
						mw.util.wikiScript( 'api' ),
						{
							format: 'json',
							action: 'opensearch',
							search: request.term
						},
						function( arr ) {
							if ( arr && arr.length > 1 ) {
								response( arr[1] );
							}
							else {
								response( [] );
							}
						}
					);
				}
			});
			field.data('suggestSetUp', true);

			this.log('MW suggest set up for #' + fieldId);
		},

		// setup tooltip and submit
		setupSearch: function() {
			var self = this,
				form = $('#WikiaPhotoGallerySearch');

			form.
				unbind('.search').
				bind('submit.search', function(ev) {
					self.onImageSearch.call(self, ev);
				});

			// setup search field tooltip
			form.children('input[placeholder]').
				placeholder();
		},

		// image search event handler
		onImageSearch: function(ev) {
			ev.preventDefault();

			var self = this,
				form = $('#WikiaPhotoGallerySearch'),
				field = form.children('input[placeholder]'),
				button = form.children('button'),
				results = $('#WikiaPhotoGallerySearchResults'),
				query = field.val();

			// check whether input field is not empty (or contains tooltip)
			if ((query == '') || (query == field.attr('placeholder'))) {
				return;
			}

			self.track({
				action: Wikia.Tracker.ACTIONS.SUBMIT,
				label: 'find-search-photos'
			});

			// block "Find" button and add loading indicator
			button.attr('disabled', true);
			results.addClass('WikiaPhotoGalleryProgress');

			// get search results
			this.ajax('getSearchResult', {query: query}, function(data) {
				// unblock "Find" button and remove loading indicator
				button.attr('disabled', false);
				results.removeClass('WikiaPhotoGalleryProgress');

				// remove previous results
				results.children('[type="results"]').remove();

				// render results
				if (data.html) {
					results.append(data.html);
				}

				self.setupSearchResults(self.RESULTS_SEARCH);
			});

			if (query != '') {
				if ( self.isSlider() ) {
					$('#WikiaPhotoGalleryImageUploadSize').show();
				}
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

					if (self.isSlideshow()) {
						self.selectPage(self.SLIDESHOW_PREVIEW_PAGE);
					} else if (self.isSlider()) {
						self.selectPage(self.SLIDER_PREVIEW_PAGE);
					} else {
						self.selectPage(self.GALLERY_PREVIEW_PAGE);
					}
				});
		},

		// setup upload page
		setupUploadPage: function(params) {
			// reset fields value
			$('#WikiaPhotoGalleryImageUpload').val('');

			// unblock upload form
			$('#WikiaPhotoGalleryImageUploadButton').attr('disabled', false);

			// resize images list (RT #55203 / BugId:11679)
			// at this time page is not shown yet, wait 50 ms...
			setTimeout($.proxy(function() {
				var resultsWrapper = $('#WikiaPhotoGallerySearchResults'),
					offsetTop = resultsWrapper.position().top;

				resultsWrapper.height(this.editor.height - offsetTop);
			}, this), 50);
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
			var sliderLinkEditor = $('#WikiaPhotoSliderLinkEditor');
			var imageCaption = $('#WikiaPhotoGalleryEditorCaption');

			galleryLinkEditor.hide();
			slideshowLinkEditor.hide();
			sliderLinkEditor.hide();
			imageCaption.removeAttr('maxlength');

			if (this.isSlideshow()) {
				slideshowLinkEditor.show();
				$('#WikiaPhotoSlideshowLink').val(link);
				$('#WikiaPhotoSlideshowLinkText').val(linktext);
			} else if ( this.isSlider() ){
				sliderLinkEditor.show();
				imageCaption.attr('maxlength', '50');
				$('#WikiaPhotoSliderLink').val(link);
				$('#WikiaPhotoSliderLinkText').val(linktext);
			} else {
				galleryLinkEditor.show();

				$('#WikiaPhotoGalleryLink').val(link);
			}
		},

		// generic method for rendering gallery/slideshow preview
		renderPreview: function(node, method, type) {
			var self = this;
			var gallery = this.editor.gallery;

			// debug
			this.log(this.JSONtoWikiText(gallery));

			// show loading indicator
			var preview = $(node);
			preview.html('').addClass('WikiaPhotoGalleryProgress');

			// send JSON-encoded gallery data to backend to render HTML for it
			var galleryJSON = JSON.stringify({
				images: gallery.images,
				externalImages: gallery.externalImages || {},
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
								self.modifyPhoto(imageId);
							});

							// "delete"
							menuItems.eq(1).bind('click.menu', function(ev) {
								ev.preventDefault();
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
					self.selectPage(self.UPLOAD_FIND_PAGE, {});
				});

				// prevent clicks on caption links
				preview.find('.WikiaPhotoGalleryPreviewItemCaption').find('a').click(function(ev) {
					ev.preventDefault();
				});

				// clicks on "Add caption" and "Link" - prevent default
				preview
					.find('.WikiaPhotoGalleryPreviewItemCaption')
					.add( preview.find('.WikiaPhotoGalleryPreviewItemLink') )
					.click( function(ev) {
						ev.preventDefault();
					} );

				// scale external images in gallery preview
				self.log('lazy loading preview images');

				var images = preview.find('.WikiaPhotoGalleryPreviewItem').find('img[data-src]');

				// get dimensions in which image should fit
				var thumb = images.eq(0).parent();
				var thumbWidth = thumb.width();
				var thumbHeight = thumb.height();

				var params = self.editor.gallery.params;
				var crop = (params.orientation && params.orientation !== 'none') || (params.crop && params.crop === 'true');

				images.each(function() {
					WikiaPhotoGalleryView.loadAndResizeImage($(this), thumbWidth, thumbHeight, function(image) {
						image.css({
							'margin-left': (thumbWidth - parseInt(image.css('width'))) >> 1,
							'margin-top': (thumbHeight - parseInt(image.css('height'))) >> 1
						});
					}, crop);
				});

				// setup images drag&drop
				var gallery = preview.find('.WikiaPhotoGalleryPreview');

				gallery.sortable({
					containment: '.WikiaPhotoGalleryPreview',
					delay: 100,
					forcePlaceholderSize: true,
					items: '.WikiaPhotoGalleryPreviewDraggable',
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

						// useless D&D
						if (oldId == newId) {
							return;
						}

						// switch #oldId and #newId images
						var images = self.editor.gallery.images;
						var temp = $.extend(true, images[oldId], {});

						//self.log(images);

						images.splice(oldId, 1);
						images.splice(newId, 0, temp);

						//self.log(images);

						// render preview
						if ( self.isSlider()) {
							self.renderSliderPreview();

						} else if ( self.isSlideshow() ) {
							self.renderSlideshowPreview();

						} else {
							self.renderGalleryPreview();
						}

					}
				});
				gallery.disableSelection();
			});
		},

		// setup gallery preview page
		setupGalleryPreviewPage: function(params) {
			var self = this;

	 		// resize preview area (RT #55203 / RT #59134)
			var resizePreview = function() {
				var preview = $('#WikiaPhotoGalleryEditorPreview');
				preview.height(parseInt(self.editor.height - preview.position().top - $('#WikiaPhotoGalleryEditorCheckboxes').height() - 20));
			};

			// setup option tabs
			this.setupTabs($('#WikiaPhotoGalleryOptionsTabs'), function(index) {
				resizePreview();
			});

			// setup gallery width slider
			var values = {
				min: 50,
				max: 310,
				ratio: 2,
				"default": 185
			};

			this.setupSlider($('#WikiaPhotoGallerySliderGallery'), 'widths', values, function(slider, value) {
				// regenerate gallery preview with updated width
				self.renderGalleryPreview();
			});

			// setup dropdowns
			this.setupDropdown($('#WikiaPhotoGalleryEditorGalleryColumns'), 'columns', self.renderGalleryPreview);
			this.setupDropdown($('#WikiaPhotoGalleryEditorGalleryPosition'), 'position', self.renderGalleryPreview);
			this.setupDropdown($('#WikiaPhotoGalleryEditorGalleryImageSpacing'), 'spacing', self.renderGalleryPreview);

			this.setupDropdown($('#WikiaPhotoGalleryEditorGalleryCaptionPosition'), 'captionposition', self.renderGalleryPreview);
			this.setupDropdown($('#WikiaPhotoGalleryEditorGalleryCaptionAlignment'), 'captionalign', self.renderGalleryPreview);
			this.setupDropdown($('#WikiaPhotoGalleryEditorGalleryCaptionSize'), 'captionsize', self.renderGalleryPreview);
			this.setupDropdown($('#WikiaPhotoGalleryEditorGalleryBorderSize'), 'bordersize', self.renderGalleryPreview);

			// setup color pickers
			this.setupColorPicker($('#WikiaPhotoGalleryEditorGalleryBorderColor'), 'bordercolor', self.renderGalleryPreview);
			this.setupColorPicker($('#WikiaPhotoGalleryEditorGalleryCaptionColor'), 'captiontextcolor', self.renderGalleryPreview);

			//setup image option widgets
			this.setupImageOption($('#WikiaPhotoGalleryOrientation'), 'orientation', self.renderGalleryPreview);

			// "Add an Image" button
			$('#WikiaPhotoGalleryAddImage').unbind('.addimage').bind('click.addimage', function(ev) {
				var button = $(this);

				ev.preventDefault();

				self.track({
					label: 'button-add-photo'
				});

				self.selectPage(self.UPLOAD_FIND_PAGE, {});
			});

	 		// resize preview area (RT #55203 / RT #59134)
			setTimeout(resizePreview, 50);

			// render preview
			this.renderGalleryPreview();
		},

		// render gallery preview
		renderGalleryPreview: function() {
			this.renderPreview('#WikiaPhotoGalleryEditorPreview', 'renderGalleryPreview', 'gallery');
		},

		// setup slideshow preview page
		setupSlideshowPreviewPage: function(params) {
			var self = this;

			// setup slideshow width slider
			var values = {
				min: 200,
				max: 500,
				ratio: 2,
				"default": 300
			};

			this.setupSlider($('#WikiaPhotoGallerySliderSlideshow'), 'widths', values, function(slider, value) {
				// regenerate slideshow preview with updated width
				self.renderSlideshowPreview();
			});

			// "crop" / "recentuploads" checkboxes (update preview on change)
			this.setupCheckbox($('#WikiaPhotoGallerySlideshowCrop'), 'crop', self.renderSlideshowPreview);
			this.setupCheckbox($('#WikiaPhotoGallerySlideshowRecentUploads'), 'showrecentuploads', self.renderSlideshowPreview);

			// "position" dropdown
			this.setupDropdown($('#WikiaPhotoGalleryEditorSlideshowAlign'), 'position');

			// "Add an Image" button
			$('#WikiaPhotoGallerySlideshowAddImage').unbind('.addimage').bind('click.addimage', function(ev) {
				var button = $(this);

				ev.preventDefault();

				self.track({
					label: 'button-add-photo'
				});

				self.selectPage(self.UPLOAD_FIND_PAGE, {});
			});

			this.updateAddAPhotoButton();

			// resize preview area (RT #55203)
			var preview = $('#WikiaPhotoGallerySlideshowEditorPreview');
			preview.height(parseInt(this.editor.height - $('#WikiaPhotoGallerySlideshowEditorCheckboxes').height() - 275));

			// render preview
			this.renderSlideshowPreview();
		},

		// setup slideshow preview page
		setupSliderPreviewPage: function(params) {
			var self = this;

			//setup image option widgets
			this.setupImageOption($('#WikiaPhotoGallerySliderType'), 'orientation', function(){});

			// "Add an Image" button
			$('#WikiaPhotoGallerySliderAddImage').unbind('.addimage').bind('click.addimage', function(ev) {
				var button = $(this);

				self.track({
					label: 'slider-tool-button-add-photo'
				});

				ev.preventDefault();

				self.selectPage(self.UPLOAD_FIND_PAGE, {});
			});

			this.updateAddAPhotoButton();

			// resize preview area (RT #55203)
			var preview = $('#WikiaPhotoGallerySliderEditorPreview');
			preview.height(parseInt(this.editor.height - $('#WikiaPhotoGallerySliderEditorCheckboxes').height() - 275));

			// render preview
			this.renderSliderPreview();
		},

		// render slider preview
		renderSliderPreview: function() {
			this.renderPreview('#WikiaPhotoGallerySliderEditorPreview', 'renderSliderPreview', 'slider');
		},
		// updates style of "Add a photo" (using showrecentuploads parameter)
		updateAddAPhotoButton: function() {
			var button = $('#WikiaPhotoGallerySlideshowAddImage');
			var params = this.editor.gallery.params;

			if (params.showrecentuploads === 'true') {
				button.attr('disabled', true).addClass('secondary');
			} else {
				button.attr('disabled', false).removeClass('secondary');
			}
		},

		// render slideshow preview
		renderSlideshowPreview: function() {
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
			buttons.eq(0).attr('href', pageUrl + (pageUrl.indexOf('?') != -1 ? '&' : '?') + 'action=edit');

			// "View the current article"
			buttons.eq(1).attr('href', pageUrl);

			// generate wikitext
			wikitext.val(this.editor.gallery.wikitext);
		},

		// modify selected photo
		modifyPhoto: function(photoId) {

			//TODO: use externalImages
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
				width: 400,
				onOk: function() {
					self.log('removing photo #' + photoId);

					self.editor.gallery.images.splice(photoId, 1);

					// render preview
					if (self.isSlideshow()) {
						self.renderSlideshowPreview();
					} else if (self.isSlider()){
						self.renderSliderPreview();
					} else {
						self.renderGalleryPreview();
					}
				},
				okMsg: messages['ok'],
				cancelMsg: messages['cancel']
			});
		},

		// setup tabbed section
		setupTabs: function(tabsWrapper, switchCallback) {
			var self = this;
			var tabs = tabsWrapper.find('.tabs,.wikia-tabs').find('a');
			var tabsContent = tabsWrapper.find('.WikiaPhotoGalleryOptionsTab');

			var selectTab = function(index, dontCallback) {
				// highlight selected tab
				tabs.parent().
					removeClass('selected').
					eq(index).addClass('selected');

				// show selected tab content
				tabsContent.
					hide().
					eq(index).show();

				if (typeof switchCallback == 'function' && !dontCallback) {
					switchCallback(index);
				}
			};

			// select first tab
			selectTab(0, true /* don't run callback now */);

			// setup click handlers
			tabs.unbind('.tabs').bind('click.tabs', function(ev) {
				ev.preventDefault();

				var index = $(this).index(tabs);
				var label = (index === 0 ? 'tab-layout' : (index === -1 ? 'tab-borders' : false));
				if (label !== false) {
					self.track({
						label: label
					});
				}
				selectTab(index);
			});
		},

		// adds click handler on given checkbox
		setupCheckbox: function(checkbox, paramName, callback) {
			var self = this;
			var params = this.editor.gallery.params;

			// set initial value
			checkbox.attr('checked', params[paramName] == 'true');

			// event setup
			checkbox.unbind('.checkbox').bind('change.checkbox', function(ev) {
				if ($(this).attr('checked')) {
					params[paramName] = 'true';
				}
				else {
					delete params[paramName];
				}

				if (paramName === 'showrecentuploads') {
					self.track({
						label: 'create-automatic'
					});
				}

				if (typeof callback == 'function') {
					callback.call(self);
				}
			});
		},

		// adds click handler on given dropdown menu (select)
		setupDropdown: function(dropdown, paramName, callback) {
			var self = this;
			var params = this.editor.gallery.params;

			// set initial value
			if (typeof params[paramName] != 'undefined' && params[paramName] != 'undefined') {
				dropdown.val(params[paramName]);
			}

			// event setup
			dropdown.unbind('.dropdown').bind('change.dropdown', function(ev) {
				var value = $(this).val();

				// update value
				params[paramName] = value;

				// If the `paramName` starts with "caption" or "border", add a dash for readability.
				self.track({
					label: 'dropdown-' + paramName.replace('caption', 'caption-').replace('border', 'border-')
				});

				if (typeof callback == 'function') {
					callback.call(self, value);
				}
			});
		},

		/**
		 * setup given image option widget
		 *
		 * @author Lox
		 */
		setupImageOption: function(widget, paramName, callback) {

			function resetStatus() {
				widget.find('li').each(function(index){
					var elm = $(this);
					var elmWidth = parseInt(widget.attr('rel'), 10);
					elm.css('background-position', (-elmWidth * ((2 * index) + 1)) + 'px 0');
				});
			}

			function selectOption(elm) {
				resetStatus();

				elm = $(elm);
				var curBkgPosition = elm.css('background-position');

				//Internet Explorer doesn't handle JS access to background-position as a single value
				if(!curBkgPosition)
					curBkgPosition = elm.css('backgroundPositionX') + ' ' + elm.css('backgroundPositionY')

				var curBkgPosition = parseInt(curBkgPosition.split(' ')[0], 10);
				var optionWidth = parseInt(widget.attr('rel'), 10);

				elm.css('background-position', (curBkgPosition + optionWidth) + 'px 0');
				$('#' + widget.attr('id') + '_option_label').html(elm.attr('title'));
			}

			var self = this;
			var params = this.editor.gallery.params;

			// set initial value
			if (typeof params[paramName] != 'undefined') {
				selectOption(widget.find('#' + widget.attr('id') + '_' + params[paramName]))
			}
			else{
				selectOption(widget.children().first());
			}

			// event setup

			widget.undelegate('li', 'click.imageOption').delegate('li', 'click.imageOption', function(ev) {
				var elm = $(this);
				var value = elm.attr('rel');

				self.track({
					label: 'orientation-' + value
				});

				//run callback and assignment only if new value is different (no n-click)
				if(value != params[paramName]) {
					selectOption(elm);
					// update value
					params[paramName] = value;

					if (typeof callback == 'function') {
						callback.call(self, value);
					}
				}
			});
		},

		// setup given slider
		setupSlider: function(sliderWrapper, paramName, values, onChangeCallback) {
			var params = this.editor.gallery.params;

			var sliderInput = this.sliderInput = sliderWrapper.find('input');
			var slider = sliderWrapper.find('.slider');

			// set slider width
			slider.css('width', Math.round((values.max - values.min) / values.ratio));

			// set slider initial value
			var initialValue = parseInt(params[paramName]) || values['default'];
			sliderInput.val(initialValue);

			// @see http://docs.jquery.com/UI/API/1.8/Slider
			slider.slider({
				animate: true,
				min: values.min,
				max: values.max,
				value: initialValue,

				// fired during sliding
				slide: function(ev, ui) {
					var value = ui.value;

					sliderInput.val(value);
				},

				// fired when sliding is done
				stop: function(ev, ui) {
					var value = ui.value;

					// update parameter value
					params[paramName] = value;

					if (typeof onChangeCallback == 'function') {
						onChangeCallback(slider, value);
					}
				}
			});

			// changes made in field should be shown on slider
			sliderInput.unbind('.slider').bind('keyup.slider blur.slider', function(ev) {
				var value = parseInt($(this).val());

				// correct value when user leaves the field
				if (ev.type == 'blur' && isNaN(value)) {
					value = sliderValues.min;
					$(this).val(value);
				}

				// update the slider
				if (value > 0) {
					slider.slider('value', value);
					params[paramName] = value;
				}

				// value is updated - run callback
				if (ev.type == 'blur') {
					if (typeof onChangeCallback == 'function') {
						onChangeCallback(slider, value);
					}
				}
			});
		},

		// setup given color picker
		setupColorPicker: function(colorPicker, paramName, callback) {
			var self = this;
			var params = this.editor.gallery.params;

			function hex(x) {
				return ("0" + parseInt(x).toString(16)).slice(-2);
			}

			function rgb2hex(rgb) {
				components = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

				if(components) {
					return "#" + hex(components[1]) + hex(components[2]) + hex(components[3]);
				}
				//not an rgb color, probably an hex value has been passed, return it
				else
					return rgb;
			}

			/**
			 * Fetches the border color for the CSS class to use as a background color
			 * using a simple statistical algorithm (at least 1 element with the class attached must exist in the DOM
			 * unfortunately using the same method used in getClassBackgroundColor proved to be unconsistend and not reliable
			 * for internal browser quirks with computed border properties
			 *
			 * @author Lox
			 * @param string cssClass the class selector, e.g. '.className'
			 */
			function getClassBorderColor(className) {
				var cleanName = className.substr(1);
				var tmpId = 'dummy_' + cleanName;
				var tmpElem = $('<div id="' + tmpId + '">').addClass(cleanName).appendTo(document.body).hide();
				var bkgColors = {};

				var colors = [];

				colors.push(tmpElem.css('border-top-color'));
				colors.push(tmpElem.css('border-right-color'));
				colors.push(tmpElem.css('border-bottom-color'));
				colors.push(tmpElem.css('border-left-color'));

				jQuery.each(colors, function(index, value){
					if(value != '') bkgColors[value] = (typeof bkgColors[value] != 'undefined') ? bkgColors[value] + 1 : 1;
				});

				var maxCount = 0;
				var bkgColor = 'rgb(0,0,0)';

				for(color in  bkgColors) {
					if(bkgColors[color] > maxCount) {
						bkgColor = color;
						maxCount = bkgColors[color];
					}
				}

				tmpElem.remove();
				return rgb2hex(bkgColor);
			}

			function getClassBackgroundColor(className) {
				var cleanName = className.substr(1);
				var tmpId = 'dummy_' + cleanName;
				var tmpElem = $('<div id="' + tmpId + '">').addClass(cleanName).appendTo(document.body).hide();
				var color = tmpElem.css('background-color');
				tmpElem.remove();
				return color;
			}

			var colorPickerPopup = $('#' + colorPicker.attr('id') + '_popup');

			if(colorPickerPopup.data('moved') !== true) {
				//avoid z-index problems due to IE7 bad handling of stacks
				colorPickerPopup.appendTo(colorPicker.closest('.WikiaPhotoGalleryEditorPageInner'));
				colorPickerPopup.data('moved', true);
			}


			//prevent showing popups not closed before dismissing the editor
			colorPickerPopup.hide();

			var colorPickerTrigger = colorPicker.find('#' + colorPicker.attr('id') + '_trigger');
			var colorInput = colorPickerPopup.find('input');

			// set initial color for picker
			var title = colorPickerTrigger.attr('title');
			var color = '#000000';

			if (typeof params[paramName] != 'undefined') {
				if(params[paramName].indexOf('#') == 0 || (params[paramName] != 'accent' && params[paramName] != 'color1')) {
					color =  params[paramName];
					title = params[paramName];
				}
				else {
					var className = '.' + params[paramName];
					color = getClassBorderColor(className);
					title = className;
				}
			}
			else if(typeof title != 'undefined' && title != ''){//if there is default enforced by PHP
				if(title.indexOf('--') > 0) {
					var tokens = title.split('--');

					switch(tokens[1]) {
						case 'border':
							color = getClassBorderColor('.' + tokens[0]);
							break;
						case 'background':
						default:
							color = getClassBackgroundColor('.' + tokens[0]);
					}

					color = rgb2hex(color);
					title = '.' + tokens[0];
				}
				//the thing is already set up in the HTML markup for other cases
			}

			if(color == 'transparent') {
				colorPickerTrigger.addClass('transparent-color');
			}
			else {
				colorPickerTrigger.removeClass('transparent-color');
			}

			colorPickerTrigger.attr('title', title);
			colorPickerTrigger.css('background-color', color);
			colorInput.val(title);

			var colorBoxes = colorPickerPopup.find('ul').find('span');

			// get hex codes of colors in the picker
			colorBoxes.each(function(index) {
				var colorBox = $(this);
				var value = null;
				var title = colorBox.attr('title');
				//handle CSS classes
				if(title.indexOf('.') == 0){
					value = title.substr(1);

					switch(colorBox.attr('rel')) {
						case 'border':
							color = getClassBorderColor(title);
							break;
						case 'background':
						default:
							color = getClassBackgroundColor(title);
					}

					colorBox.css('background-color', color);
				}
				else if(title == 'transparent') {
					value = title;
				}
				//handle rgb colors
				else {
					value = rgb2hex(colorBox.css('background-color'));
				}



				colorBox.attr('value', value);
			});

			// update picker and color parameter value when clicked
			colorBoxes.unbind('.colorpicker').bind('click.colorpicker', {caller: this}, function(event) {
				var value = null,
					param = null,
					node = $(this),
					title = node.attr('title');

				if(typeof title != 'undefined' && title.indexOf('.') == 0) {
					colorPickerTrigger.removeClass('transparent-color');
					value = rgb2hex(node.css('background-color'));
					param = title.substr(1);
				} else {
					param = value = rgb2hex(node.attr('value'));

					if(param == 'transparent') {
						colorPickerTrigger.addClass('transparent-color');
					}
					else {
						colorPickerTrigger.removeClass('transparent-color');
					}
				}

				// update parameter value and picker
				params[paramName] = param;
				colorPickerTrigger.css('background-color', value);
				colorPickerTrigger.attr('title', title);
				colorInput.val(title);

				$(document.body).unbind('.colorPicker');
				colorPickerPopup.hide();

				if (typeof callback == 'function') {
					callback.call(event.data.caller, value);
				}
			});

			// open color picker popup
			colorPicker.unbind('.colorpicker').bind('click.colorpicker', function(event) {
				//prevents event bubbling to avoid triggering click.colorPicker on body, see further
				event.stopPropagation();

				var position = $(this).position();

				//hide other opened pickers
				$('.WikiaPhotoGalleryColorPickerPopUp').hide();

				if (paramName == 'captiontextcolor') {
					self.track({
						label: 'color-caption'
					});
				} else if (paramName == 'bordercolor') {
					self.track({
						label: 'color-border'
					});
				}

				colorPickerPopup.css({
					'left': parseInt(position.left) + 30,
					'top': parseInt(position['top']) + 5
				});

				colorPickerPopup.show();

				//make the popup disappear if the user clicks outside
				$(document.body).unbind('.colorPicker').bind('click.colorPicker', function(event){
					if(!$(event.target).hasClass('WikiaPhotoGalleryColorPickerPopUp') && $(event.target).closest('.WikiaPhotoGalleryColorPickerPopUp').length == 0) {
						$(document.body).unbind('.colorPicker');
						$('.WikiaPhotoGalleryColorPickerPopUp').hide();
					}
				});
			});

			// close color picker popup when "Ok" is clicked
			colorPickerPopup.find('button').unbind('.colorpicker').bind('click.colorpicker', {caller: this}, function(event) {
				var inputValue = jQuery.trim(colorInput.val());

				var value = null;
				var param = null
				if(inputValue.indexOf('.') == 0) {
					colorPickerTrigger.removeClass('transparent-color');
					var color = null;

					if(inputValue == '.accent')
						color = getClassBorderColor(inputValue);
					else
						color = getClassBackgroundColor(inputValue);

					value = color;
					param = inputValue.substr(1);
				}
				else {
					param = value = rgb2hex(inputValue);

					if(param == 'transparent') {
						colorPickerTrigger.addClass('transparent-color');
					}
					else {
						colorPickerTrigger.removeClass('transparent-color');
					}
				}

				// update parameter value and picker
				params[paramName] = param;
				colorPickerTrigger.css('background-color', value);
				colorPickerTrigger.attr('title', inputValue);

				$(document.body).unbind('.colorPicker');
				colorPickerPopup.hide();

				if (typeof callback == 'function') {
					callback.call(event.data.caller, value);
				}
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
					width: 400,
					callback: function() {
						// setup clicks
						var buttons = $('#WikiaPhotoGalleryShowSaveQuitDialog').find('.modalToolbar').children();

						// save & quit
						buttons.eq(0).click(function() {
							self.track({
								label: 'exit-button-save'
							});

							$('#WikiaPhotoGalleryShowSaveQuitDialog').closeModal();

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
							self.track({
								label: 'exit-button-discard-changes'
							});

							$('#WikiaPhotoGalleryShowSaveQuitDialog').closeModal();
							$('#WikiaPhotoGalleryEditor').hideModal();
						});

						// cancel
						buttons.eq(2).click(function() {
							self.track({
								label: 'exit-button-cancel'
							});

							$('#WikiaPhotoGalleryShowSaveQuitDialog').closeModal();
						});
					},
					onClose: function() {
						self.track({
							action: Wikia.Tracker.ACTIONS.CLOSE
						});
					}
				}
			);
		},

		// fetch and show gallery editor -- this is an entry point
		showEditor: function(params) {
			$().log(params, "showEdit params");
			var self = WikiaPhotoGallery;

			// check lock to catch double-clicks on toolbar button
			if (self.lockEditor) {
				self.log('lock detected - please wait for dialog to load');
				return;
			}

			self.lockEditor = true;

			// make params always be an object
			params = params || {};

			// get width of article to be used for editor
			var width = parseInt($('#article').width());
			width = Math.min($(window).width() - 75, width);
			width = Math.max(670, width);
			width = Math.min(1300, width);

			// get full height available (RT #55203)
			var height = parseInt($(window).height() - 125);

			if (skin == 'oasis') {
				height -= 150;
				width = 740;
			}

			height = Math.max(460, height);

			self.log('showEditor() - ' + width + 'x' + height + 'px');
			self.log(params);

			self.editor.width = width;
			self.editor.height = height;

			//forcing creation of a new instance to display default settings and let the slider do its' work after cancelling previous dialog
			//done here since the dialog closes in many different ways and some of them use animation fx
			$('#WikiaPhotoGalleryEditor').remove();

			//BugId:51767 - WikiaPhotoGallery editor cannot be opened more than
			//8 times in a single page load on IE 9
			if (self.modalAjaxData) {
				self.log('Using cached data for modal');
				self.processModal(self.modalAjaxData, height, params);
			} else {
				self.log('Loading required data for modal');
				// load CSS for editor popup, wikia-tabs, AIM upload lib and jQuery UI library (if not loaded yet) via loader function
				$.when(
					$.getResources([
						wgExtensionsPath + '/wikia/WikiaPhotoGallery/css/WikiaPhotoGallery.editor.css',
						stylepath + '/common/wikia_ui/tabs.css'
					]),

					// jQuery UI (autocomplete with CSS and slider plugin) and AIM plugin
					mw.loader.using(['jquery.ui.autocomplete', 'jquery.ui.slider', 'wikia.aim']),

					// fetch dialog content
					this.ajax('getEditorDialog', {title: wgPageName})
				).then(function(getResourcesData, mwLoaderUseData, ajaxData){
					// "parse" data from promise of AJAX request
					self.modalAjaxData = ajaxData[0];
					self.processModal(self.modalAjaxData, height, params);
				});
			}
		},

		processModal: function(data, height, params) {
			var self = WikiaPhotoGallery;

			// store messages
			// TODO: use JSMessages - $.getMessages
			self.editor.msg = data.msg;

			// store default values
			self.editor.defaultParamValues = data.defaultParamValues;

			// render editor popup
			$.showModal('', data.html, {
				callbackBefore: function() {
					// change height of the editor popup before it's shown (RT #55203)
					$('#WikiaPhotoGalleryEditorPagesWrapper').height(height);
				},
				callback: function() {
					// remove loading indicator
					$('#WikiaPhotoGalleryEditorLoader').remove();

					// mark editor dialog title node
					if (skin == 'oasis') {
						$('#WikiaPhotoGalleryEditor').children('h1').attr('id', 'WikiaPhotoGalleryEditorTitle');
					}
					else {
						$('#WikiaPhotoGalleryEditor').children('.modalTitle').
							append('<span id="WikiaPhotoGalleryEditorTitle"></span>');
					}

					self.setupEditor(params);
				},
				onClose: function(type) {
					// prevent close event triggered by ESCAPE key
					if (type.keypress) {
						return false;
					}

					self.track({
						action: Wikia.Tracker.ACTIONS.CLOSE
					});

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
				persistent: false, // don't remove popup when user clicks X
				width: self.editor.width
			});
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
				id: id
			});
		},

		JSONtoWikiTextInner: function(data) {
			HTML = '';
			if (typeof data.params.showrecentuploads === 'undefined' || data.params.showrecentuploads !== 'true') {
				// add images
				for (img in data.images) {
					var imageData = data.images[img];

					// skip images "generated" by showrecentuploads
					if (imageData.recentlyUploaded) {
						continue;
					}

									// skip if empty or corrupted data
									if ( typeof imageData.name == 'undefined' ) {
										continue;
									}

					HTML += imageData.name;
					if (imageData.caption != '') {
						HTML += '|' + imageData.caption;
					}
					if (imageData.link != '') {
						HTML += '|link=' + imageData.link;
					}
					if ((this.isSlideshow() || this.isSlider()) && imageData.linktext != '') {
						HTML += '|linktext=' + imageData.linktext;
					}
					HTML += '\n';
				}
			}
			return HTML;
		},

		// create wikitext from JSON data
		JSONtoWikiText: function(data) {
			var HTML = '<gallery';
			var isSlideshow = this.isSlideshow();

			// add type="slideshow" tag attribute
			if (isSlideshow) {
				data.params['type'] = 'slideshow';
			} else if (this.isSlider()) {
				data.params['type'] = 'slider';
			}

			// handle <gallery> tag attributes
			$.each(data.params, function(key, value) {
				WikiaPhotoGallery.log([key, value]);

				// filter out default values
				switch(key) {
					// slideshow has by default 300px, gallery - 185px
					case 'widths':
						if (isSlideshow && value == 300) {
							return;
						}
						if (!isSlideshow && value == 185) {
							return;
						}
						break;

					// slideshow is by default aligned right, gallery - left (RT #68263)
					case 'position':
						if (isSlideshow && value == 'right') {
							return;
						}
						if (!isSlideshow && value == 'left') {
							return;
						}
						break;
	                                //skip when default (BugId:15294)
					case 'captionalign':
						if (value == 'left') {
							return;
						}
						break;
				}

				if (value != '') {
					HTML += ' ' + key + '="' + value + '"';
				}
			});

			HTML += '>\n';
			HTML += this.JSONtoWikiTextInner(data);
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
				var control = RTE.getInstance().textarea.$;
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
		},

		track: (function() {
			var config = {
					action: Wikia.Tracker.ACTIONS.CLICK,
					trackingMethod: 'analytics'
				},
				slice = [].slice;

			return function() {
				var	type = WikiaPhotoGallery.editor.gallery.type;

				config.category = ( type == 3 ? 'slider' : type == 2 ? 'slideshow' : 'gallery' ) + '-tool';

				Wikia.trackEditorComponent.apply( null, [ config ].concat( slice.call( arguments ) ) );
			};
		})()
	};

	// Exports
	window.WikiaPhotoGallery = WikiaPhotoGallery;
})( this, jQuery );
