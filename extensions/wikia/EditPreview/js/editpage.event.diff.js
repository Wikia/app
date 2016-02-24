define('editpage.event.diff', ['editpage.event.helper', 'wikia.window', 'jquery'], function (helper, win, $){
	'use strict';

	// handle "Show changes" button
	function onDiff(ev, editor) {
		ev.preventDefault();
		// move the focus to the selected items to prevent iPad from showing the VK and resizing the viewport
		$(ev.target).focus();
		renderChanges();
		if (editor) {
			editor.track('diff');
		}
	}

	// render "show diff" modal
	function renderChanges() {
		require([ 'wikia.ui.factory' ], function (uiFactory){
			uiFactory.init([ 'modal' ]).then(function (uiModal) {
				var previewModalConfig = {
					vars: {
						id: 'EditPageDialog',
						title: $.htmlentities($.msg('editpagelayout-pageControls-changes')),
						content: '<div class="ArticlePreview modalContent"><div class="ArticlePreviewInner">' +
							'</div></div>',
						size: 'large'
					}
				};
				uiModal.createComponent(previewModalConfig, function (previewModal) {
					previewModal.deactivate();

					previewModal.$content.on('click', function (event) {
						var target = $(event.target);
						target.closest('a').not('[href^="#"]').attr('target', '_blank');
					});

					$.when(
						helper.getContent()
					).done(function (content, mode){
						prepareDiffContent(previewModal, content);
						previewModal.show();
					});
				});
			});
		});
	}

	/**
	 * Prepare content with difference between last saved and currently edited code
	 *
	 * @param previewModal modal box instance
	 * @param content current edited content
	 */
	function prepareDiffContent(previewModal, content) {
		var section = $.getUrlVar('section') || 0,
			categories = helper.getCategories(),
			extraData = {
				content: content,
				section: parseInt(section, 10)
			};

		if (categories.length) {
			extraData.categories = categories.val();
		}

		$.when(
			// get wikitext diff
			helper.ajax('diff' , extraData),

			// load CSS for diff
			win.mw.loader.using('mediawiki.action.history.diff')
		).done(function (ajaxData) {
			var data = ajaxData[ 0 ],
				html = '<h1 class="pagetitle">' + win.wgEditedTitle + '</h1>' + data.html;
			previewModal.$content.find('.ArticlePreview .ArticlePreviewInner').html(html);
			previewModal.activate();
		});
	}

	return {
		onDiff: onDiff
	};
});
