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
			hash: false,
			id: 0
		},
		msg: {},
		source: false,
		width: false
	},

	// constants
	UPLOAD_FIND_PAGE: 0,
	UPLOAD_CONFLICT_PAGE: 1,
	CAPTION_LINK_PAGE: 2,
	GALLERY_PREVIEW_PAGE: 3,
	EDIT_CONFLICT_PAGE: 4,

	// send AJAX request to extension's ajax dispatcher in MW
	ajax: function(method, params, callback) {
		$.post(wgScript + '?action=ajax&rs=WikiaPhotoGalleryAjax&method=' + method, params, callback, 'json');
	},

	// track events
	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('photogallery' + fakeUrl);
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

		// dialog title
		var title = '';

		// messages shortcut
		var msg = this.editor.msg;

		// buttons
		var saveButton = $('#WikiaPhotoGalleryEditorSave');
		var cancelButton = $('#WikiaPhotoGalleryEditorCancel');

		// hide gallery options (slider, alignment option) in modal toolbar
		$('#WikiaPhotoGalleryEditorPreviewOptions').hide();

		// hide edit conflict buttons
		$('#WikiaPhotoGalleryEditConflictButtons').hide();

		switch (selectedPage) {
			// Upload/Find page
			case this.UPLOAD_FIND_PAGE:
				title = msg['wikiaPhotoGallery-upload-title'];

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
				title = msg['wikiaPhotoGallery-upload-title'];

				saveButton.hide();
				cancelButton.show();

				this.setupUploadConflictPage(params);
				break;

			// Caption/Link page
			case this.CAPTION_LINK_PAGE:
				title = msg['wikiaPhotoGallery-photooptions-title'];

				saveButton.show().text(msg['wikiaPhotoGallery-photooptions-done']);
				cancelButton.show();

				this.setupCaptionLinkPage(params);
				break;

			// Gallery preview page
			case this.GALLERY_PREVIEW_PAGE:
				title = msg['wikiaPhotoGallery-preview-title'];

				saveButton.show().text(msg['save']);
				cancelButton.hide();

				this.setupPreviewPage(params);
				break;

			// Edit conflict page
			case this.EDIT_CONFLICT_PAGE:
				title = msg['wikiaPhotoGallery-conflict-title'];

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

	// set intro text of currently selected page using message ID provided
	setIntroText: function(msg) {
		$('#WikiaPhotoGalleryEditor').find('.WikiaPhotoGalleryEditorPageIntro').eq(this.editor.currentPage).html(this.editor.msg[msg]);
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

		switch (this.editor.currentPage) {
			case this.UPLOAD_FIND_PAGE:
				break;

			case this.UPLOAD_CONFLICT_PAGE:
				break;

			case this.CAPTION_LINK_PAGE:
				newPage = this.GALLERY_PREVIEW_PAGE;

				var caption = $('#WikiaPhotoGalleryEditorCaption').val();
				var link = $('#WikiaPhotoGalleryLink').val();

				// remove wrapping brackets
				link.replace(/^(\[)+/, '').replace(/(\])+$/, '');

				var data = {
					caption: caption,
					link: link,
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

				// tracking
				this.track('/dialog/options/save');

				if (caption != '') {
					this.track('/dialog/options/caption');
				}

				if (link != '') {
					this.track('/dialog/options/link');
				}
				break;

			case this.GALLERY_PREVIEW_PAGE:
				// update gallery data, generate wikitext and store it in wikitext
				var gallery = this.editor.gallery;

				gallery.params.captionalign = $('#WikiaPhotoGalleryEditorPreviewAlign').val();
				gallery.params.widths = $('#WikiaPhotoGalleryEditorPreviewSlider').slider('value');
				gallery.wikitext = this.JSONtoWikiText(gallery);

				this.track('/dialog/preview/save');

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

						// save the whole page
						$('#wpSave').click();

						var messages = this.editor.msg;
						$.showModal(messages['wikiaPhotoGallery-preview-saving-title'], '<p>' + messages['wikiaPhotoGallery-preview-saving-intro'] + '</p>', {id: 'WikiaConfirm'});

						hideModal = false;
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

	// cancel button handler
	onCancel: function() {
		// variable shortcuts
		var editor = this.editor;
		var params = editor.currentPageParams;

		this.log('onCancel');
		this.log(params);

		var newPage = null;
		var newPageParams = {};

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
		var firstPage = this.UPLOAD_FIND_PAGE;

		// clear internal gallery object
		this.editor.gallery = {
			id: false,
			params:{},
			images:[],
			node: false
		};

		this.log(params);
		// for gallery edits from wysiwyg mode open gallery preview page
		switch (params.from) {
			case 'wysiwyg':
				if (typeof params.gallery == 'object') {
					this.log('editing existing gallery');
					this.log(params.gallery);

					firstPage = this.GALLERY_PREVIEW_PAGE;

					// read gallery data from gallery node and store it in editor
					var data = params.gallery.getData();

					this.editor.gallery = {
						id: data.id,
						images: data.images,
						node: params.gallery,
						params: data.params
					};

					this.track('/init/edit/editpage');
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

					firstPage = this.GALLERY_PREVIEW_PAGE;
					this.editor.gallery = params.gallery;

					this.track('/init/edit/view');
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

		// init editor with list of recently uploaded images
		var searchResults = $('#WikiaPhotoGallerySearchResults');
		searchResults.html('');

		$('#WikiaPhotoGallerySearchHeader').html(this.editor.msg['wikiaPhotoGallery-upload-filestitle-pre']);
		$('#WikiaPhotoGalleryRecentlyUploadedImages').children().clone().appendTo(searchResults);

		// setup image search results
		this.setupSearchResults();

		// setup caption editor toolbar
		this.setupCaptionToolbar();

		// setup MW suggest
		this.setupLinkSuggest();

		// setup width slider
		this.setupSliderAndDropDown();

		// add handlers to buttons
		$('#WikiaPhotoGalleryEditorSave').unbind('.save').bind('click.save', function() {self.onSave.apply(self)});
		$('#WikiaPhotoGalleryEditorCancel').unbind('.cancel').bind('click.cancel', function() {self.onCancel.apply(self)});

		// and render this page
		this.selectPage(firstPage);
	},

	// setup image upload
	setupUpload: function() {
		var self = this;

		// clicks on file field
		$('#WikiaPhotoGalleryImageUpload').
			unbind('.upload').
			bind('click.upload', function() {
				self.track('/dialog/upload/upload/browse');
			});

		// upload form submittion
		$('#WikiaPhotoGalleryImageUploadForm').
			unbind('.upload').
			bind('submit.upload', function(ev) {
				self.track('/dialog/upload/upload/upload');

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

	// setup search results (pagination, click events)
	setupSearchResults: function() {
		var self = this;

		var resultsTrackingType = ($('#WikiaPhotoGalleryResults').attr('type') == 'results') ? 'find' : 'recent';

		var results = $('#WikiaPhotoGallerySearchResults').children();
		var paginationLinks = $('#WikiaPhotoGallerySearchPagination').show().children('a');

		var rows = results.children('tbody').children();
		var count = rows.children('td').length;

		var page = 1;
		var perPage = 8;

		var pages = Math.ceil(count / perPage);

		// show proper rows (based on value of page) and show prev/next links
		var updatePager = function() {
			var fromRow = (page-1) << 1;
			rows.hide().slice(fromRow,fromRow + 2).show();

			if (page > 1) {
				paginationLinks.eq(0).show();
			}
			else {
				paginationLinks.eq(0).hide();
			}

			if (page < pages) {
				paginationLinks.eq(1).show();
			}
			else {
				paginationLinks.eq(1).hide();
			}
		};

		// show first two run
		updatePager();

		// pagination links
		paginationLinks.unbind('.pagination');

		// prev
		paginationLinks.eq(0).bind('click.pagination', function(ev) {
			ev.preventDefault();

			if (page > 1) {
				page--;
				self.track('/dialog/upload/' + resultsTrackingType + '/prev');
			}

			// show previous rows
			updatePager();
		});

		// next
		paginationLinks.eq(1).bind('click.pagination', function(ev) {
			ev.preventDefault();

			if (page < pages) {
				page++;
				self.track('/dialog/upload/' + resultsTrackingType + '/next');
			}

			// show previous rows
			updatePager();
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
	setupLinkSuggest: function() {
		var self = this;
		var fieldId = 'WikiaPhotoGalleryLink';

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
		container.appendTo('#WikiaPhotoGalleryLinkSuggestWrapper');

		// handle ENTER hits (hide suggestion's dropdown)
		$('#WikiaPhotoGalleryLink').keydown(function(ev) {
			if (ev.keyCode == 13) {
				$('#WikiaPhotoGalleryLinkSuggest').css('visibility', 'hidden');
			}
		});

		this.log('MW suggest set up');
	},

	// setup width slider and alignment dropdown
	setupSliderAndDropDown: function() {
		var tooltip = $('#WikiaPhotoGalleryEditorPreviewSliderTooltip').hide();
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

				self.track('/dialog/preview/changeSize');
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

				self.track('/dialog/preview/captionAlignment/' + value);
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

	// setup upload / find page
	setupUploadPage: function(params) {
		// reset fields value
		$('#WikiaPhotoGalleryImageUpload').val('');
		$('#WikiaPhotoGallerySearchQuery').val('');

		// unblock upload and search form
		$('#WikiaPhotoGalleryImageUploadButton').attr('disabled', false);
		$('#WikiaPhotoGallerySearchButton').attr('disabled', false);

		// use different intro text (depending on number of images in currently edited / created gallery)
		var count = this.editor.gallery.images.length;
		var msg = count ? 'intro' : 'intro-first';

		this.setIntroText('wikiaPhotoGallery-upload-' + msg);
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
		var imagePreview = $('#WikiaPhotoGalleryEditorCaptionImagePreview').find('span');

		imagePreview.
			html('').
			addClass('WikiaPhotoGalleryProgress');

		// get thumbnail for selected image
		this.loadThumbnail(params.imageName, imagePreview);

		// set value of caption / link fields
		var caption = '';
		var link = '';

		// used when 'cancel' button pressed
		if (params.caption || params.link) {
			if (params.caption) caption = params.caption;
			if (params.link) link = params.link;
		}
		// editing existing image (and entering via 'modify' - not 'cancel')
		else if (params.imageId != null) {
			var image = this.editor.gallery.images[ params.imageId ];

			caption = image.caption;
			link = image.link;
		}

		$('#WikiaPhotoGalleryEditorCaption').val(caption);
		$('#WikiaPhotoGalleryLink').val(link);

		// handle "change this picture" link
		var self = this;
		$('#WikiaPhotoGalleryEditorCaptionChangeImage').unbind('.change').bind('click.change', function(ev) {
			ev.preventDefault();

			self.track('/dialog/options/changePhoto');

			// show upload page
			var data = (params.imageId != null) ? {imageId: params.imageId} : {};
			if (params.imageName) {
				data.imageName = params.imageName;
			}
			data.caption = $('#WikiaPhotoGalleryEditorCaption').val();
			data.link = $('#WikiaPhotoGalleryLink').val();

			self.selectPage(self.UPLOAD_FIND_PAGE, data);
		});

		// resize fields
		$('#WikiaPhotoGalleryEditorCaptionLinkTable').css('width', parseInt(this.editor.width - 300) + 'px');
	},

	// setup gallery preview page
	setupPreviewPage: function(params) {
		// show slider and alignment dropdown menu
		$('#WikiaPhotoGalleryEditorPreviewOptions').show();

		var params = this.editor.gallery.params;

		// set slider value
		var widths = parseInt(params.widths) || 120 /* default value */;
		$('#WikiaPhotoGalleryEditorPreviewSlider').slider('value', widths);

		// select proper alignment option
		$('#WikiaPhotoGalleryEditorPreviewAlign').val( params.captionalign || 'left' );

		// resize gallery preview (height of intro section can change depending of width of editor)
		setTimeout(function() {
			var preview = $('#WikiaPhotoGalleryEditorPreview');
			var page = preview.parent();
			var intro = page.children('.WikiaPhotoGalleryEditorPageIntro');

			var previewHeight = parseInt(page.height() - intro.outerHeight());
			// prevent height=0 when CSS is not ready yet
			if (previewHeight) {
				preview.css('height', previewHeight + 'px');
			}
		}, 50);

		// render preview
		this.renderGalleryPreview();
	},

	// render gallery preview
	renderGalleryPreview: function() {
		var self = this;
		var gallery = this.editor.gallery;

		// show loading indicator
		var preview = $('#WikiaPhotoGalleryEditorPreview');
		preview.html('').addClass('WikiaPhotoGalleryProgress');

		// send JSON-encoded gallery data to backend to render HTML for it
		var galleryJSON = $.toJSON({
			images: gallery.images,
			params: gallery.params
		});

		this.ajax('renderGalleryPreview', {
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

							self.track('/dialog/preview/photo/modify');
							self.modifyPhoto(imageId);
						});

						// "delete"
						menuItems.eq(1).bind('click.menu', function(ev) {
							ev.preventDefault();

							self.track('/dialog/preview/photo/delete');
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
				self.track('/dialog/preview/addPhoto');

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
					if (node.hasClass('WikiaPhotoGalleryPreviewItemLink')) {
						self.track('/dialog/preview/photo/link');
					}
					else if (node.hasClass('WikiaPhotoGalleryPreviewItemAddCaption')) {
						self.track('/dialog/preview/photo/captionNew');
					}
					else {
						self.track('/dialog/preview/photo/captionEdit');
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

					self.track('/dialog/preview/photo/move');

					// switch #oldId and #newId images
					var images = self.editor.gallery.images;
					var temp = $.extend(true, images[oldId], {});

					self.log(images);

					images.splice(oldId, 1);
					images.splice(newId, 0, temp);

					self.log(images);

					// render preview
					self.renderGalleryPreview();
				}
			});
		});
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
				self.renderGalleryPreview();
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
                        if (showComboAjaxForPlaceHolder('', false)) {
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
			self.ajax('getEditorDialog', {}, function(data) {
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

						// tracking
						var currentPage = self.editor.currentPage;
						var trackerSuffix = '';

						switch(currentPage) {
							case self.UPLOAD_FIND_PAGE:
								trackerSuffix = 'upload';
								break;

							case self.CAPTION_LINK_PAGE:
								trackerSuffix = 'options';
								break;

							case self.GALLERY_PREVIEW_PAGE:
								trackerSuffix = 'preview';
								break;
						}

						if (trackerSuffix) {
							self.track('/dialog/' + trackerSuffix + '/close');
						}

						// prevent close event triggered by ESCAPE key
						if (type.keypress) {
							return false;
						}

						// X has been clicked
						if (type.click) {
							if (currentPage == self.EDIT_CONFLICT_PAGE) {
								// just close the dialog when on edit conflict page
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

	// load thumbnail of image into given HTML node
	loadThumbnail: function(imageName, node) {
		this.ajax('getThumbnail', {imageName: imageName}, function(data) {
			node.
				removeClass('WikiaPhotoGalleryProgress').
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
		for (img in data.images) {
			HTML += data.images[img].name;
			if (data.images[img].caption != '') {
				HTML += '|' + data.images[img].caption;
			}
			if (data.images[img].link != '') {
				HTML += '|link=' + data.images[img].link;
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
