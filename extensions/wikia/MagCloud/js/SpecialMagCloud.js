var SpecialMagCloud = {};

// setup variables
SpecialMagCloud.preview = {
	cache: {},
	pages: 0,
	currentPage: 0,
	lock: false,
	retries: 0
};

SpecialMagCloud.magazine = {
	hash: '',
	timestamp: 0
};

// setup "Order your articles" list
SpecialMagCloud.setupArticlesList = function(list) {
	MagCloud.log('setting up list of articles');

	list = $(list);

	// setup remove icons
	list.find('.MagCloudArticlesListRemove').each(function(i) {
		var node = $(this);

		// assign IDs for each row
		node.parent().attr('rel', i);

		node.click(function() {
			// get ID of current row
			i = $(this).parent().attr('rel');

			MagCloud.ajax('removeArticle', {index: i}, function(data) {
				MagCloud.log('removed article #' + i + ' from collection');

				// remove row with removed article
				node.parent().remove();

				// regenerate IDs for remove icons
				list.find('li').each(function(i) { $(this).attr('rel', i); });

				// update intro HTML
				$('#MagCloudArticlesIntro').html(data.html);
			});
		});
	});

	// setup sortable UI jQuery plugin
	list.find('ul').sortable({
		containment: '#MagCloudArticlesList',
		delay: 100,
		forcePlaceholderSize: true,
		handle: '.MagCloudArticlesListGrab',
		items: '> li',
		placeholder: 'MagCloudArticlesListPlaceholder',
		revert: 200, // smooth animation

		// events
		stop: function(ev, ui) {

			// get grabbed item
			var item = ui.item;

			// get old index
			var oldIndex =item.attr('rel');

			// remove CSS from grabbed item
			item.css({left: '', top: ''});

			// get new index
			var newIndex = 0;
			list.find('li').each( function(i) {
				if ($(this).attr('rel') == oldIndex) {
					newIndex = i;
				}
			});

			// optimize a bit
			if (newIndex == oldIndex) {
				MagCloud.log('no reorder was made');
				return;
			}

			MagCloud.log('article reorder: #' + oldIndex + ' -> #' + newIndex);

			// send reindex request
			MagCloud.ajax('reorderArticle', {oldIndex: oldIndex, newIndex: newIndex}, function(data) {
				// regenerate IDs for remove icons
				list.find('li').each(function(i) { $(this).attr('rel', i); });
			});
		}
	});
}

// setup color themes editor
SpecialMagCloud.setupColorTheme = function(editor, themes) {
	MagCloud.log('setting up color themes editor');

	// copy provided list of themes
	SpecialMagCloud.themes = themes;

	MagCloud.log(SpecialMagCloud.themes);

	// get theme to be used
	var theme = editor.find('input[checked]').attr('rel');

	SpecialMagCloud.applyColorTheme(theme);

	// setup clicks on inputs
	editor.find('input').click(function() {
		SpecialMagCloud.applyColorTheme( $(this).attr('rel') );
	});
}

// apply selected color theme to cover preview
SpecialMagCloud.applyColorTheme = function(theme) {
	// extra check
	if (typeof SpecialMagCloud.themes[theme] == 'undefined') {
		return;
	}

	MagCloud.log('applying "' + theme + '" theme');

	// get colors from theme
	var colors = SpecialMagCloud.themes[theme];

	// and apply them
	$('#MagCloudCoverPreview').css('backgroundColor', '#'+colors[1]);

	$('#MagCloudCoverPreviewTitle').css({
		'backgroundColor': '#'+colors[2],
		'color': '#'+colors[1]
	});

	$('#MagCloudCoverPreviewBar').css('backgroundColor', '#'+colors[0]);
}

// setup layout editor
SpecialMagCloud.setupLayout = function(editor) {
	MagCloud.log('setting up layout editor');

	// get theme to be used
	var layout = editor.find('input[checked]').attr('rel')

	SpecialMagCloud.applyLayout(layout);

	// setup clicks on inputs
	editor.find('input').click(function() {
		SpecialMagCloud.applyLayout( $(this).attr('rel') );
	});
}

// apply selected layout to cover preview
SpecialMagCloud.applyLayout = function(layout) {
	layout = layout.substring(6);

	MagCloud.log('applying "' + layout + '" layout');

	// set CSS class
	$('#MagCloudCoverPreviewWrapper').attr('class', 'MagCloudCoverPreviewLayout' + layout);
}

// "connect" title/subtitle fields with cover preview
SpecialMagCloud.connectTitleWithPreview = function() {
	$('#MagCloudMagazineTitle').bind('keyup', function() {
		$('#MagCloudCoverPreviewTitle').find('big').text( $('#MagCloudMagazineTitle').attr('value') );
	});

	$('#MagCloudMagazineSubtitle').bind('keyup', function() {
		$('#MagCloudCoverPreviewTitle').find('small').text( $('#MagCloudMagazineSubtitle').attr('value') );
	});
}

// save settings of magazine cover
SpecialMagCloud.saveCoverDesign = function(ev) {
	ev.preventDefault();

	MagCloud.log('saving cover design');

	var settings = {
		magazineTitle: $('#MagCloudMagazineTitle').attr('value'),
		magazineSubtitle: $('#MagCloudMagazineSubtitle').attr('value'),

		coverTheme: $('#MagCloudCoverEditorTheme').find('input[checked]').attr('rel'),
		coverLayout: $('#MagCloudCoverEditorLayout').find('input[checked]').attr('rel').substring(6),

		image: ($('#MagCloudCoverEditorImageSmall').attr('checked') ? $('#MagCloudCoverEditorImageName').attr('value') : '')
	};

	var href = $(this).attr('href');

	MagCloud.ajax('saveCover', settings, function() {
		// after successful save of cover proceed to magazine preview / review list
		document.location = href;
	});
}

// performs magazine save on preview
SpecialMagCloud.saveCollection = function() {
	var node = $(this);

	if (window.wgUserName != null) {
		// logged-in: send AJAX request
		SpecialMagCloud.doSaveCollection();
	}
	else {
		// anon: show AjaxLogin form

		// call this function after successful login
		window.wgAjaxLoginOnSuccess = SpecialMagCloud.doSaveCollection;

		// call AjaxLogin
		openLogin($.getEvent());
	}
}

// send AJAX request to save magazine and update the button
SpecialMagCloud.doSaveCollection = function() {
	$('#MagCloudSaveMagazine').css('visibility', 'hidden');
	MagCloud.ajax('saveCollection', {}, function(data) {
		var node = $('#MagCloudSaveMagazine')
		node.before('<span id="MagCloudSaveMagazine">' + data.shortMsg + '</span>');
		node.remove();
	});
}

// get src of image provided (to be used by cover preview)
SpecialMagCloud.renderImageForCover = function(imageName, width) {
	if (imageName == '') {
		return;
	}

	MagCloud.ajax('renderImage', {image: imageName,	width: width}, function(data) {
		// update image used on cover
		$('#MagCloudCoverPreviewImage').html(data.img).css('marginTop', parseInt(data.height/2) * -1 + 'px');
	});
}

// generate PDF and preview of first two pages
SpecialMagCloud.renderPdf = function(hash, timestamp, node) {
	// store collection data
	SpecialMagCloud.magazine.hash = hash;
	SpecialMagCloud.magazine.timestamp = timestamp;

	// render PDF and preview for first two pages
	MagCloud.ajax('renderPdf', {hash: hash, timestamp: timestamp}, function(data) {
		MagCloud.log(data);
		MagCloud.track('/pdfGenerated/pages/' + data.pages);

		// update message
		node.html(data.msg);

		// remove status popup
		if ($('#SpecialMagCloudStatusPopup').hasClass('SpecialMagCloudPreviewStatusPopup')) {
			$('#SpecialMagCloudStatusMask').hide();
			$('#SpecialMagCloudStatusPopup').hide();
		}

		// current page / total pages
		SpecialMagCloud.preview.currentPage = 1;
		SpecialMagCloud.preview.pages = data.pages;

		// update previews
		var previews = $('#SpecialMagCloudPreviews').find('div');

		SpecialMagCloud.updatePagePreview(0, 1, function(img) {
			previews.eq(0).html('<img src="' + img + '" />');
		});

		SpecialMagCloud.updatePagePreview(0, 2, function(img) {
			previews.eq(1).html('<img src="' + img + '" />');
		});

		// handle clicks on pages to go prev/next
		previews.eq(0).click(SpecialMagCloud.prevPagePreview);
		previews.eq(1).click(SpecialMagCloud.nextPagePreview);

		$('#SpecialMagCloudPreviewPrev').click(SpecialMagCloud.prevPagePreview);
		$('#SpecialMagCloudPreviewNext').click(SpecialMagCloud.nextPagePreview);

		// show "Publish your magazine" button
		$('#SpecialMagCloudButtons a').eq(1).css('visibility', 'visible');

		// debug
		MagCloud.log(SpecialMagCloud);

		if (data.pages > 100) {
			// reopen status popup
			if ($('#SpecialMagCloudStatusPopup').hasClass('SpecialMagCloudPreviewStatusPopup')) {
				$('#SpecialMagCloudPublishStatus').css('background', 'none');
				$('#SpecialMagCloudPublishStatus').text('Your magazine is longer than 100 pages. Please go back and review your collection.');
				$('#SpecialMagCloudStatusMask').show();
				$('#SpecialMagCloudStatusPopup').show();
			}

			// hide "Publish your magazine" button
			$('#SpecialMagCloudButtons a').eq(1).css('visibility', 'hidden');
		}
	});
}

// update given page preview
SpecialMagCloud.updatePagePreview = function(slotId, page, callback) {

	// try to hit the preview cache
	if (typeof SpecialMagCloud.preview.cache[page] == 'string') {
		MagCloud.log('Page preview: ' + page + '/' + SpecialMagCloud.preview.pages + ' (from cache)');

		callback(SpecialMagCloud.preview.cache[page]);
		return;
	}

	// send AJAX request
	MagCloud.ajax('renderPreviewPage', {
		hash: SpecialMagCloud.magazine.hash,
		timestamp: SpecialMagCloud.magazine.timestamp,
		page: page
	},
	function(data) {
		MagCloud.log(data);

		if (data.error) {
			MagCloud.track("/preview/error");

			// check number of retries
			if (++SpecialMagCloud.preview.retries >= 3) {
				MagCloud.log('number of max. preview retries reached (' + SpecialMagCloud.preview.retries + ')');

				MagCloud.track("/preview/error/maxReached");

				SpecialMagCloud.preview.retries = 0;
				return;
			}

			// error handling -> send request once more after 4 sec
			setTimeout(function() {
				SpecialMagCloud.updatePagePreview(slotId, page, callback);
			}, 4000);
		}
		else {
			// successful request
			MagCloud.log('Page preview: ' + page + '/' + SpecialMagCloud.preview.pages);

			// store page in cache
			SpecialMagCloud.preview.cache[page] = data.img;

			// reset retries counter
			SpecialMagCloud.preview.retries = 0;

			callback(data.img);
		}
	});
}

// show previous page preview
SpecialMagCloud.prevPagePreview = function() {
	// load preview for prev page
	if (SpecialMagCloud.preview.currentPage <= 1) {
		return;
	}

	MagCloud.track("/preview/prev");

	var previews = $('#SpecialMagCloudPreviews').find('div');
	var images = previews.find('img');

	// move left page to right
	images.eq(1).attr('src', images.eq(0).attr('src'));
	images.eq(0).remove();

	// decrease current page
	SpecialMagCloud.preview.currentPage--;

	SpecialMagCloud.updatePagePreview(0, SpecialMagCloud.preview.currentPage, function(img) {
		previews.eq(0).html('<img src="' + img + '" />');
	});
}

// show next page preview
SpecialMagCloud.nextPagePreview = function() {
	// load preview for next page
	if (SpecialMagCloud.preview.currentPage >= SpecialMagCloud.preview.pages - 1) {
		return;
	}

	MagCloud.track("/preview/next");

	var previews = $('#SpecialMagCloudPreviews').find('div');
	var images = previews.find('img');

	// move right page to left
	images.eq(0).attr('src', images.eq(1).attr('src'));
	images.eq(1).remove();

	// increase current page
	SpecialMagCloud.preview.currentPage++;

	SpecialMagCloud.updatePagePreview(1, SpecialMagCloud.preview.currentPage + 1, function(img) {
		previews.eq(1).html('<img src="' + img + '" />');
	});
}

SpecialMagCloud.publish2_data = null;
SpecialMagCloud.publish2_node = null;
SpecialMagCloud.publish2 = function(data) {
	var node = SpecialMagCloud.publish2_node;
	if (data.msg) {
		node.html(data.msg);
	}

	if (data['continue']) {
		SpecialMagCloud.publish2_data["state"] = data.state;
		MagCloud.ajax("publish2", SpecialMagCloud.publish2_data, SpecialMagCloud.publish2);
	} else {
		// hide throbber
		node.css("background", "none");

		if (data.issue) {
			window.location.href = "http://magcloud.com/browse/Issue/" + data.issue;
		}
	}
}

SpecialMagCloud.publish = function(hash, timestamp, token, node) {
	SpecialMagCloud.publish2_data = {hash: hash, timestamp: timestamp, token: token};
	SpecialMagCloud.publish2_node =  node;
	SpecialMagCloud.publish2({state: "initialize", 'continue': true});
	return;

	// send AJAX request to publish PDF
	MagCloud.ajax("publish", {hash: hash, timestamp: timestamp, token: token, breakme: (window.wgMagCloudPublishBreakMe ? 1 : 0)}, function(data) {
		MagCloud.log(data);
		MagCloud.track("/published");

		// hide throbber
		node.css('background', 'none');

		if (typeof data.issue == 'number') {
			node.html(data.msg).css('textAlign', 'center');
			window.location.href = "http://magcloud.com/browse/Issue/" + data.issue;
		} else {
			node.html(data.msg);

			// track MagCloud error codes
			if (typeof data.code != 'undefined') {
				MagCloud.track('/published/error/' + data.code);
			}
		}
	});

	// render PDF (will be served from cache) and setup preview
	SpecialMagCloud.renderPdf(hash, timestamp, $('#SpecialMagCloudPdfProcess'));
}
