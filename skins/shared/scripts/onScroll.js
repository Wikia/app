/**
 * Interface for applying handlers to the single scroll event on window
 */
define('wikia.onScroll', ['jquery', 'wikia.window'], function ($, window) {
	'use strict';
	var handlers = [],
		debounceRate = 5;

	/**
	 * Bind handler to the global scroll event
	 * @param {Function} handler
	 */
	function bind(handler) {
		if (typeof handler === 'function') {
			handlers.push(handler);
		}
	}

	/**
	 * Unbind handler from a global scroll event
	 * @param {Function} handler
	 */
	function unbind(handler) {
		var index = handlers.indexOf(handler);
		if (index > -1) {
			handlers.splice(index, 1);
		}
	}

	/**
	 * Event handler for the global scroll event
	 * @param {Event} event
	 */
	function trigger(event) {
		handlers.forEach(function (handler) {
			handler(event);
		});
	}

	/**
	 * Binds global scroll event listener
	 * Handlers are triggered once, at the beginning
	 * of every debounce rate
	 */
	function init() {
		window.addEventListener(
			'scroll',
			$.debounce(debounceRate, true, trigger)
		);
	}

	return {
		bind: bind,
		unbind: unbind,
		init: init
	};
});

require(['wikia.onScroll'], function (onScroll) {
	'use strict';
	onScroll.init();
});
