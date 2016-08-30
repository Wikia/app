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

	function openModal(link, title) {
		// Track impression
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'embeddable-discussions-share-modal-loaded',
		});

		uiFactory.init(['modal']).then(function (uiModal) {
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
			  hasUpvoted = event.currentTarget.getAttribute('data-hasUpvoted') === '1',
			  $svg = $($(event.currentTarget).children()[0]),
			  verb = hasUpvoted ? 'DELETE' : 'POST';

			if (!mw.user.anonymous()) {
				if (hasUpvoted) {
					$svg.attr('class', 'embeddable-discussions-upvote-icon');
					event.currentTarget.setAttribute('data-hasUpvoted', '0');
				}
				else {
					$svg.attr('class', 'embeddable-discussions-upvote-icon-active');
					event.currentTarget.setAttribute('data-hasUpvoted', '1');
				}

				$.ajax({
					type: verb,
					url: upvoteUrl,
					xhrFields: {
						withCredentials: true
					},
				});
			}

			event.preventDefault();
		});

		$('.share').click(function (event) {
			openModal(event.currentTarget.getAttribute('data-link'), event.currentTarget.getAttribute('data-title'));
			event.preventDefault();
		});
	});
});
