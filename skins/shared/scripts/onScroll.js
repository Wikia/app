/**
 * Interface for applying handlers to the single scroll event on window
 */
define('wikia.onScroll', ['wikia.window'], function () {
	'use strict';
	var handlers = [];

	/**
	 * Bind handler to the global scroll event
	 * @param {Function} handler
	 */
	function bind(handler) {
		handlers.push(handler);
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
	 */
	function init() {
		window.addEventListener('scroll', trigger);
	}

	return {
		bind: bind,
		unbind: unbind,
		init: init,
	};
});

require(['wikia.onScroll'], function (onScroll) {
	'use strict';
	onScroll.init();
});
