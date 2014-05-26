define('wikia.intMap.createMap.utils', ['jquery', 'wikia.mustache'], function($, mustache) {
	'use strict';

	/**
	 * @desc bind events to a modal
	 * @param {object} modal - modal component
	 * @param {object} events - object containing array of handlers for each event type
	 */

	function bindEvents(modal, events) {
		Object.keys(events).forEach(function(event) {
			events[event].forEach(function(handler) {
				modal.bind(event, handler);
			});
		});
	}

	/**
	 * @desc render template and add it to the container
	 * @param {string} template - mustache template
	 * @param {object} templateData - mustache template variables
	 * @param {object} $container - jQuery selector
	 */

	function render(template, templateData, $container) {
		$container.html(mustache.render(template, templateData));
	}

	/**
	 * @desc configure buttons (set visibility + attach events)
	 * @param {object} modal - modal component
	 * @param {object} buttons - object with button ids as keys and event names as values
	 */

	function setButtons(modal, buttons) {
		// reset buttons visibility
		modal.$buttons.addClass('hidden');

		Object.keys(buttons).forEach(function(key) {
			modal.$buttons
				.filter(key)
				.data('event', buttons[key])
				.removeClass('hidden');
		});
	}

	return {
		bindEvents: bindEvents,
		render: render,
		setButtons: setButtons
	}
});
