require(['wikia.window', 'jquery', 'wikia.tracker'],
	function (window, $, tracker) {
		'use strict';

		var track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.IMPRESSION,
			category: 'contribution-appreciation',
			trackingMethod: 'analytics'
		});

		$(function () {
			$('.appreciation-button').bind('click', function (e) {
				e.preventDefault();
				track({
					action: tracker.ACTIONS.CLICK,
					label: 'appreciation-send'
				});
				$.post(
					'/wikia.php?controller=ContributionAppreciation&method=appreciate',
					$.extend($(this).data(), {token: mw.user.tokens.get('editToken')})
				).done(function () {
					//TODO: handle sending
					track({
						label: 'appreciation-feedback'
					});
				}).error(function () {
					//TODO: handle errors
					track({
						label: 'appreciation-failed'
					});
				});
			});
		});
	});
