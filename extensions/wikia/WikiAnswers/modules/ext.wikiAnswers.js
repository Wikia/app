/* global jQuery, mediaWiki, alert */
;(function ($, mw) {
	'use strict';

	// not a question, leave early
	if (!mw.config.has('wgIsUnansweredQuestion')) {
		return;
	}

	var $saveButton = $("#article_save_button"),
		$textArea = $("#article_textarea"),
		mwApi = new mw.Api();

	$('#answer-box-form').on('submit', function (event) {
		event.preventDefault();

		$saveButton.val($saveButton.val() + mw.message('ellipsis').text());
		$saveButton.attr("disabled", "disabled");

		mwApi.post({
			action: 'edit',
			title: mw.config.get('wgTitle'),
			prependtext: $textArea.val(),
			token: mw.user.tokens.get('editToken')
		}).done(window.location.reload).fail(alert);
	});

	$($textArea.focus);
}(jQuery, mediaWiki));
