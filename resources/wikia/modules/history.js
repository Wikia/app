/*
 * @define wikia.history
 * module used to handle history state
 *
 * @author Bartosz 'V.' Bentkowski
 */

define('wikia.history', ['wikia.window'], function(win) {
	'use strict';

	/**
	 * @desc Check if current platform has support for given history function or nor
	 * @param {String} name of the function
	 * @return {Bool} returns true if current platform supports given function
	 */
	function hasHistoryFunction (name) {
		return win.history && name in win.history;
	}

	/**
	 * @desc Push into history (if possible) and return proper state
	 * @param {Object} state
	 * @param {String} title
	 * @param {String} url
	 * @return {Boolean} return true if pushState is available on current platform
	 */
	function pushState (state, title, url) {
		if (hasHistoryFunction('pushState')) {
			state = state || {};
			title = title || win.document.title;
			url = url || win.location;

			win.history.pushState(state, title, url);
			return true;
		}
		return false;
	}


	/**
	 * @desc Replaces history (if possible)
	 * @param {Object} state
	 * @param {String} title
	 * @param {String} url
	 * @return {Boolean} return true if replaceState is available on current platform
	 */
	function replaceState (state, title, url) {
		if (hasHistoryFunction('replaceState')) {
			state = state || {};
			title = title || win.document.title;
			url = url || win.location;

			win.history.replaceState(state, title, url);
			return true;
		}
		return false;
	}

	// return interface
	return {
		pushState: pushState,
		replaceState: replaceState
	};
});
