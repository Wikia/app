require([
	'jquery',
	'wikia.tracker',
	'wikia.ui.factory',
	'wikia.mustache',
	'wikia.window',
	'embeddablediscussions.templates.mustache',
	'EmbeddableDiscussionsSharing'
], function ($, tracker, uiFactory, mustache, window, templates, sharing) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		category: 'embeddable-discussions',
		trackingMethod: 'analytics'
	});

	function getUiModalInstance() {
		return uiFactory.init(['modal']);
	}

	function openModal(link, title) {
		// Track impression
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'embeddable-discussions-share-modal-loaded',
		});

		$.when(
			getUiModalInstance()
		).then(function (uiModal) {
				var modalConfig = {
					vars: {
						classes: ['embeddable-discussions-share-modal'],
						content: '',
						id: 'EmbeddableDiscussionsShareModal',
						size: 'small',
					}
				};

				uiModal.createComponent(modalConfig, function (modal) {
					modal.$content
						.html(mustache.render(templates.ShareModal, {
							heading: $.msg('embeddable-discussions-share-heading'),
							icons: sharing.getData(mw.config.get('wgUserLanguage'), link, title),
						}));

					modal.show();
				});
			});
	}

	$(function () {
		// Track impression
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'embeddable-discussions-loaded',
		});

		$('.upvote').click(function (event) {
			var upvoteUrl = event.currentTarget.getAttribute('data-url'),
				$svg = $($(event.currentTarget).children()[0]);

			$svg.attr('class', 'embeddable-discussions-upvote-icon-active');

			$.ajax({
				type: 'POST',
				url: upvoteUrl,
				xhrFields: {
					withCredentials: true
				},
			}).fail(function () {
				$svg.attr('class', 'embeddable-discussions-upvote-icon');
			});

			event.preventDefault();
		});

		$('.share').click(function (event) {
			openModal(event.currentTarget.getAttribute('data-link'), event.currentTarget.getAttribute('data-title'));
			event.preventDefault();
		});
	});
});
