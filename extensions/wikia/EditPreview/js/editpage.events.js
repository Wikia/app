define('editpage.events', ['editpage.event.preview', 'editpage.event.diff', 'jquery'], function(preview, diff, $){
	'use strict';

	function attachDiff(id, editor) {
		$('#' + id).on('click', function(e){
			diff.onDiff(e, editor);
		});
	}

	function attachDesktopPreview(id,  editor) {
		var $editPage = $('#EditPage'),
			$previewButton = $('#' + id);

		$previewButton.on(
			'click', function(e) { preview.onPreview(e, editor); }
		).popover({
			placement: 'top',
			content: $.htmlentities($.msg('editpagelayout-preview-label-desktop')),
			trigger: 'manual'
		}).on('mouseenter', function() {
			if ($editPage.hasClass('mode-source') && $editPage.hasClass('editpage-sourcewidemode-on')) {
				$(this).popover('show');
			}
		}).on('mouseleave', function() {
			$(this).popover('hide');
		});

		// Wikia change (bugid:5667) - begin
		if ($.browser.msie) {
			$(window).on('keydown', function (e) {
				if (e.altKey && String.fromCharCode(e.keyCode) === $previewButton.attr('accesskey').toUpperCase()) {
					$previewButton.click();
				}
			});
		}
	}

	function attachMobilePreview(id, editor) {
		var $editPage = $('#EditPage');

		$('#' + id).on(
			'click', function(e) { preview.onPreviewMobile(e, editor); }
		).popover({
				placement: 'top',
				content: $.htmlentities($.msg('editpagelayout-preview-label-mobile')),
				trigger: 'manual'
			}).on('mouseenter', function() {
				if ($editPage.hasClass('mode-source') && $editPage.hasClass('editpage-sourcewidemode-on')) {
					$(this).popover('show');
				}
			}).on('mouseleave', function() {
				$(this).popover('hide');
			});
	}

	return {
		attachDiff: attachDiff,
		attachDesktopPreview: attachDesktopPreview,
		attachMobilePreview: attachMobilePreview
	};
});
