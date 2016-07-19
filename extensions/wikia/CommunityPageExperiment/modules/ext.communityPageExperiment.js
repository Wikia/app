require([
	'jquery',
	'wikia.window',
	'wikia.cache',
	'wikia.tracker'
], function ($, win, cache, tracker) {
	'use strict';

	var track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK_LINK_TEXT,
			category: 'community-page',
			trackingMethod: 'analytics'
		});

	function handleSignupButton(event) {
		if (event.which !== 1 || event.shiftKey || event.altKey || event.metaKey || event.ctrlKey) {
			return;
		}

		event.preventDefault();
		event.stopPropagation();

		track({
			action: tracker.ACTIONS.CLICK_LINK_BUTTON,
			label: 'signup-button'
		});

		// Hack to always use the new auth modal
		win.wgEnableNewAuthModal = true;

		win.wikiaAuthModal.load({
			forceLogin: true,
			url: event.currentTarget.href,
			origin: 'community-page',
			onAuthSuccess: function () {
				cache.set('communityPageSignedUp', true, cache.CACHE_LONG);
				win.location.reload();
			}
		});
	}

	function communityPageClickTrackingHandler(event) {
		var $element, label;

		// Track only primary mouse button click
		if (event.type === 'mousedown' && event.which !== 1) {
			return;
		}

		$element = $(event.target);

		label = getLabelByDataTrackingLabel($element);

		if (label !== false) {
			track({
				label: label
			});
		}
	}

	function getLabelByDataTrackingLabel($element) {
		return $element.data('tracking-label') || false;
	}

	$(function () {
		$('#CommunityPageHeader').find('.signup-button').click(handleSignupButton);

		$('#CommunityPageAdminMessage, #CommunityPageContent')
			.on('mousedown touchstart', communityPageClickTrackingHandler);
	});
});
