require(['wikia.window', 'jquery'], function (window, $) {
	'use strict';

	var editformSubmitAllowed = false;

	function firstMenuValidator() {
		var $localNavPreview = $('.local-navigation-preview'),
			$tabs = $localNavPreview.find('.wds-tabs');

		return $tabs.width() <= $localNavPreview.width();
	}

	function initPreview() {
		if (window.wgIsWikiNavMessage) {
			$('#wpSave').hide();
			$('#editform').submit(function (ev) {
				if (!editformSubmitAllowed) {
					ev.stopImmediatePropagation();
					return false;
				}
			});
			$('#wpSummary').bind('keypress', function (ev) {
				if (ev.keyCode === 13 /* enter */ && !editformSubmitAllowed) {
					// prevent tracking
					ev.stopImmediatePropagation();
				}
			});

			// preload messages
			$.getMessages('Oasis-navigation-v2').done(function () {
				// setup menu in preview mode
				$(window).bind('EditPageAfterRenderPreview', function (ev, previewNode) {
					// don't style wiki nav like article content
					previewNode.children().removeClass('WikiaArticle');
					var firstMenuValid = firstMenuValidator(),
						menuParseError = !!previewNode.find('nav > ul').attr('data-parse-errors'),
						errorMessages = [];

					if (menuParseError) {
						errorMessages.push($.msg('oasis-navigation-v2-magic-word-validation'));
					}

					if (!firstMenuValid) {
						errorMessages.push($.msg('oasis-navigation-v2-level1-validation'));
					}

					if (errorMessages.length > 0) {
						$('#publish').remove();
						new window.BannerNotification(
							errorMessages.join('</br>'),
							'error',
							$('.modalContent .ArticlePreview')
						).show();

					} else {
						editformSubmitAllowed = true;
					}

					previewNode.find('nav > ul a').click(function () {
						if ($(this).attr('href') === '#') {
							return false;
						}
					});

					previewNode.find('.msg > a').click(function () {
						window.location = this.href;
					});

				});
			});

			// disable submit on editform when preview is closed
			$(window).bind('EditPagePreviewClosed', function () {
				editformSubmitAllowed = false;
			});

			$('#wpPreview').parent().removeClass('secondary');
			// to set the toolbar height in wide mode (so the preview-validator-desc div fits)
			$('#EditPageMain').addClass('editpage-wikianavmode');
		}
	}

	$(function () {
		initPreview();
	});
});