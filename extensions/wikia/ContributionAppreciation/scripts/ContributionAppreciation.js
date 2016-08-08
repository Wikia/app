require(['wikia.window', 'jquery', 'wikia.tracker'],
	function (window, $, tracker) {
		'use strict';

		var track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.IMPRESSION,
			category: 'contribution-appreciation',
			trackingMethod: 'analytics'
		});

		var send = function (data) {
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
				e.preventDefault();
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'appreciation-history-send'
				});
				send($(this).data());
				$(this).hide();
				$(this).parent('.appreciation-history-link').find('.appreciation-feedback').show();
			});

			$('.appreciation-button').bind('click', function (e) {
				e.preventDefault();
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'appreciation-diff-send'
				});
				send($(this).data());
				$(this).attr('disabled', true);
				$('.appreciation-cta').hide();
				$('.appreciation-feedback').show();
			});
		});
	});
