/**
 * Module for consistent tracking on WikiaMobile
 *
 * @author Jakub "Student" Olek
 *
 */

/* global define Wikia */

define('track', function () {
	'use strict';
	var ACTIONS = Wikia.Tracker.ACTIONS;

	return {
		event: function (category, action, options, ev) {
			options = options || {};

			if (!window.wgGameGuides) {
				Wikia.Tracker.track({
					action: action,
					browserEvent: ev,
					category: 'wikiamobile-' + category,
					href: options.href,
					label: options.label,
					trackingMethod: 'ga',
					value: options.value
				});
			}
		},
		//if anything happens to Wikia.Tracker it'll be much easier to fix it in one place
		CLICK: ACTIONS.CLICK,
		SWIPE: ACTIONS.SWIPE,
		SUBMIT: ACTIONS.SUBMIT,
		PAGINATE: ACTIONS.PAGINATE,
		IMAGE_LINK: ACTIONS.CLICK_LINK_IMAGE,
		TEXT_LINK: ACTIONS.CLICK_LINK_TEXT
	};
});