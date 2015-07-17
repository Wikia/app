define('editpage.event.preview', ['editpage.event.helper', 'jquery', 'wikia.window'], function(helper, $, window){
	'use strict';



	// handle "Preview" button
	function onPreview(ev, editor) {
		ev.preventDefault();

		renderPreview({}, 'current');
		if (editor) {
			editor.track('preview-desktop');
		}
	}

	// handle "PreviewMobile" button
	function onPreviewMobile(ev, editor) {
		ev.preventDefault();

		renderPreview({}, 'mobile');
		if (editor) {
			editor.track('preview-mobile');
		}
	}

	// render "Preview" modal
	// TODO: it would be nice if there weren't any hardcoded values in here.
	// Any changes to the article page or modal will break here. Also, get rid
	// of any widthType/gridLayout settings when the responsive layout goes out
	// for a global release.
	function renderPreview(extraData, type) {
		var isWebkit = navigator.userAgent.toLowerCase().indexOf(' applewebkit/') > -1,
			isWidePage = !!window.wgEditPageIsWidePage,
			isGridLayout = $('.WikiaGrid').length > 0,
			extraPageWidth = (window.sassParams && window.sassParams.hd) ? 200 : 0,
			scrollbarWidth = helper.getScrollbarWidth();

		require([ 'wikia.fluidlayout' ], function (fluidlayout) {
			var previewPadding = 22, // + 2px for borders
				articleWidth = 660, width = articleWidth + (isGridLayout ? 30 : 0
					), railBreakPoint = fluidlayout.getBreakpointSmall();

			if (isWidePage) {
				// 980 px of content width on main pages / pages without right rail
				width += 320 + (isGridLayout ? 20 : 0);
			}

			if (extraPageWidth) {
				// wide wikis
				width += extraPageWidth;
			}

			if (window.wgOasisResponsive || window.wgOasisBreakpoints) {
				var pageWidth = $('#WikiaPage').width(), widthArticlePadding = fluidlayout.getWidthGutter(), railWidth = fluidlayout.getRightRailWidth() + fluidlayout.getWidthPadding(), minWidth = fluidlayout.getMinArticleWidth();

				// don't go below minimum width
				if (pageWidth <= minWidth) {
					pageWidth = minWidth;
				}

				// subtract rail width only in certain criteria
				width = (isWidePage || pageWidth <= railBreakPoint
					) ? pageWidth : pageWidth - railWidth;

				width -= widthArticlePadding;

				// For Webkit browsers, when the responsive layout kicks in
				// we have to subtract the width of the scrollbar. For more
				// information, read: http://bit.ly/hhJpJg
				// PS: this doesn't work between 1370-1384px because at that point
				// the article page has a scrollbar and the edit page doesn't.
				// Luckily, those screen resolutions are kind of an edge case.
				// PSS: fuck scrollbars.
				// TODO: we should have access to breakpoints and such in JavaScript
				// as variables instead of hardcoded values.
				if (isWebkit && pageWidth >= 1370 || pageWidth <= railBreakPoint) {
					width -= scrollbarWidth;
				}
			}

			// add article preview padding width
			width += previewPadding;

			// add width of scrollbar (BugId:35767)
			width += scrollbarWidth;

			var previewOptions = {
				width: width,
				scrollbarWidth: scrollbarWidth,
				onPublishButton: function () {
					$('#wpSave').click();
				},
				getPreviewContent: function (callback, skin) {
					$.when(
						helper.getContent()
					).done(function(content){
						preparePreviewContent(content, extraData, callback, skin);
					});
				}
			};

			// pass info about dropped rail to preview module
			if (pageWidth <= railBreakPoint && (window.wgOasisResponsive || window.wgOasisBreakpoints)) {
				// if it's a small screen or wide page pass to preview a flag to drop rail
				previewOptions.isRailDropped = true;
			}

			// pass info about if it's a wide page (main page or page without right rail)
			previewOptions.isWidePage = isWidePage;
			previewOptions.currentTypeName = type;

			require(['wikia.preview'], function (preview) {
				preview.renderPreview(previewOptions);
			});
		});
	}

	// internal method, based on the editor content and some extraData, prepare a preview markup for the
	// preview dialog and pass it to the callback
	function preparePreviewContent(content, extraData, callback, skin) {
		var categories = helper.getCategories();

		// add section name when adding new section (BugId:7658)
		if (window.wgEditPageSection === 'new') {
			content = '== ' + getSummary() + ' ==\n\n' + content;
		} else {
			extraData.summary = getSummary();
		}

		extraData.content = content;

		if (window.wgEditPageSection !== null) {
			extraData.section = window.wgEditPageSection;
		}

		if (categories.length) {
			extraData.categories = categories.val();
		}

		helper.ajax('preview', extraData, function (data) {
			callback(data);
		}, skin);
	}

	function getSummary() {
		var summary = $('#wpSummary').val();

		// bugid-93498: IE fakes placeholder functionality by setting a real val
		if (summary === $('#wpSummary').attr('placeholder')) {
			summary = '';
		}

		return summary;

	}

	return {
		onPreview: onPreview,
		onPreviewMobile: onPreviewMobile
	};
});
