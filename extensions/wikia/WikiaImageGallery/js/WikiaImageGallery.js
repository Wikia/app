var WikiaImageGallery = {
	// editor state
	editor: {
		msg: {},
		stack: {},
	},

	// constants
	UPLOAD_FIND_PAGE: 0,
	CAPTION_LINK_PAGE: 1,
	GALLERY_PREVIEW_PAGE: 2,

	// send AJAX request to ajax dispatcher in MW
	ajax: function(method, params, callback) {
		$.getJSON(wgScript + '?action=ajax&rs=WikiaImageGalleryAjax&method=' + method, params, callback);
	},

	// track events
	track: function(fakeUrl) {
		WET.byStr('WikiaImageGallery' + fakeUrl);
	},

	// console logging
	log: function(msg) {
		$().log(msg, 'WikiaImageGallery');
	},

	// add MW toolbar button
	addToolbarButton: function() {
		if ( (skin == 'monaco') && (typeof mwCustomEditButtons != 'undefined') ) {
			mwCustomEditButtons.push({
				'imageFile': stylepath + '/../extensions/wikia/WikiaImageGallery/images/button_wig.png',
				'speedTip': 'Add gallery',
				'tagOpen': '',
				'tagClose': '',
				'sampleText': '',
				'imageId': 'mw-editbutton-wig',
				'onclick': function() {
					WikiaImageGallery.showEditor();
				}
			});
		}
	},

	// setup selected page (change dialog title, render content)
	selectPage: function(selectedPage) {
		this.log('selecting page #' + selectedPage);

		// hide pages and setup selected one
		var pages = $('#WikiaImageGalleryEditor').find('.WikiaImageGalleryEditorPage');
		pages.hide();

		// dialog title
		var title = '';

		// messages shortcut
		var msg = this.editor.msg;

		// buttons
		var saveButton = $('#WikiaImageGalleryEditorSave');
		var cancelButton = $('#WikiaImageGalleryEditorCancel');

		switch (selectedPage) {
			// Upload/Find page
			case this.UPLOAD_FIND_PAGE:
				title = msg['wig-upload-title'];

				saveButton.hide();
				cancelButton.show();
				break;

			// Caption/Link page
			case this.CAPTION_LINK_PAGE:
				title = msg['wig-pictureoptions-title'];

				saveButton.show().children().text(msg['save'])
				cancelButton.show();
				break;

			// Gallery preview page
			case this.GALLERY_PREVIEW_PAGE:
				title = msg['wig-preview-title'];

				saveButton.show().children().text(msg['save']);
				cancelButton.hide();
				break;
		}

		// show selected page
		pages.eq(selectedPage).show();

		// set editor dialog title
		$('#WikiaImageGalleryEditorTitle').text(title);
	},

	// setup gallery editor content (select proper page, register event handlers)
	setupEditor: function(params) {
		// TODO: choose first page
		var firstPage = this.UPLOAD_FIND_PAGE;

		// setup upload / find page
		$('#WikiaImageGallerySearchForm').submit(this.onImageSearch);

		// setup search results
		this.setupSearchResults();

		// and render this page
		this.selectPage(firstPage);
	},

	// setup search results (pagination, click events)
	setupSearchResults: function() {
		var results = $('#WikiaImageGallerySearchResults').children();
		var paginationLinks = $('#WikiaImageGallerySearchPagination').show().children('a');

		var rows = results.find('tr');
		var count = results.find('td').length;

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
			}

			// show previous rows
			updatePager();
		});

		// next
		paginationLinks.eq(1).bind('click.pagination', function(ev) {
			ev.preventDefault();

			if (page < pages) {
				page++;
			}

			// show previous rows
			updatePager();
		});

		// setup is done - show the results
		results.show();
	},

	// image search event handler
	onImageSearch: function(ev) {
		ev.preventDefault();

		// show loading indicator
		$('#WikiaImageGallerySearchProgress').show();

		var query = $('#WikiaImageGallerySearchQuery').val();

		WikiaImageGallery.ajax('getSearchResult', {query: query}, function(data) {
			// hide loading indicator
			$('#WikiaImageGallerySearchProgress').hide();

			// change search results heading
			$('#WikiaImageGallerySearchHeader').html(data.msg);

			// render results
			if (data.html) {
				$('#WikiaImageGallerySearchResults').html(data.html);
				WikiaImageGallery.setupSearchResults();
			}
			else {
				$('#WikiaImageGallerySearchResults').html('');
			}
		});
	},

	// fetch and show gallery editor
	showEditor: function(params) {
		var editorPopup = $('#WikiaImageGalleryEditor');

		if (!editorPopup.exists()) {
			WikiaImageGallery.ajax('getEditorDialog', {}, function(data) {
				// store messages
				WikiaImageGallery.editor.msg = data.msg;

				// render editor popup
				$.showModal('', data.html, {
					callback: function() {
						// remove loading indicator
						$('#WikiaImageGalleryEditorLoader').remove();

						// add <span> wrapping editor title
						$('#WikiaImageGalleryEditor').children('.modalTitle').
							append('<span id="WikiaImageGalleryEditorTitle"></span>');

						WikiaImageGallery.setupEditor(params);
					},
					id: 'WikiaImageGalleryEditor',
					persistent: true, // don't remove popup when user clicks X
					width: 670,
				});

				// load CSS for editor popup
				importStylesheetURI(wgExtensionsPath + '/wikia/WikiaImageGallery/css/WikiaImageGallery.editor.css');
			});
		}
		else {
			WikiaImageGallery.setupEditor(params);
			editorPopup.showModal();
		}
	}
};

// add toolbar button
WikiaImageGallery.addToolbarButton();
