require(['jquery', 'wikia.tracker'],
	function ($, tracker) {
		'use strict';

		var track = tracker.buildTrackingFunction({
				action: tracker.ACTIONS.IMPRESSION,
				category: 'contribution-appreciation',
				trackingMethod: 'analytics'
			}),
			send = function (data) {
				$.post(
					'/wikia.php?controller=ContributionAppreciation&method=appreciate',
					$.extend(data, {token: mw.user.tokens.get('editToken')})
				).done(function () {
					track({
						label: 'appreciation-done'
					});
				}).error(function () {
					track({
						label: 'appreciation-failed'
					});
				});
			};

		$(function () {
			$('.appreciation-link').bind('click', function (e) {
				var link = $(this);

				e.preventDefault();
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'appreciation-history-send'
				});
				send(link.data());
				link.hide();
				link.parent('.appreciation-history-link').find('.appreciation-feedback').show();
			});

			$('.appreciation-button').bind('click', function (e) {
				var button = $(this);

				e.preventDefault();
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'appreciation-diff-send'
				});
				send(button.data());
				button.attr('disabled', true);
				$('.appreciation-cta').hide();
				$('.appreciation-feedback').show();
			});
		});
	});
