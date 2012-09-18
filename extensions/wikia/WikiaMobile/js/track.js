/**
 * Module for consistent tracking on WikiaMobile
 *
 * @author Jakub "Student" Olek
 *
 */

/* global WikiaTracker define */

define('track', function () {
	'use strict';
	var ACTIONS = WikiaTracker.ACTIONS;

	return {
		event: function (category, action, options) {
			options = options || {};
			var obj = {
				ga_category: 'wikiamobile-' + category,
				ga_action: action
			};

			if (options.label) {
				obj.ga_label = options.label;
			}

			if (options.value !== undefined) {
				obj.ga_value = options.value;
			}

			if (options.href) {
				obj.href = options.href;
			}

			WikiaTracker.trackEvent('trackingevent', obj, 'ga');
		},
		//if anything happens to WikiaTracker it'll be much easier to fix it in one place
		CLICK: ACTIONS.CLICK,
		SWIPE: ACTIONS.SWIPE,
		SUBMIT: ACTIONS.SUBMIT,
		PAGINATE: ACTIONS.PAGINATE,
		IMAGE_LINK: ACTIONS.CLICK_LINK_IMAGE,
		TEXT_LINK: ACTIONS.CLICK_LINK_TEXT
	};
});