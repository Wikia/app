/**
 * Tracking for TemplateDraft extension
 * Module sends tracking record to google analytics and internal analytics
 * for events related to TemplateDraft.
 */
define(
	'ext.wikia.templateDraft.tracking',
	['jquery', 'wikia.tracker'],
	function ($, tracker) {
		'use strict';

		/* Tracking wrapper function */
		var track = tracker.buildTrackingFunction({
			action: tracker.ACTIONS.CLICK,
			category: 'templatedraft',
			trackingMethod: 'analytics'
		});

		/* Initiate click tracking on templatedraft module box */
		function init() {
			$('.templatedraft-module').on('mousedown', trackModuleClicks);
		}

		/**
		 * Send click tracking data on buttons and links
		 */
		function trackModuleClicks(e) {
			var $target = $(e.target);
			if ($target.is('a') || $target.is('button')) {
				track({
					action: tracker.ACTIONS.CLICK_LINK_TEXT,
					label: $target.data('id')
				});
			}
		}

		return {
			init: init
		};
	}

);
