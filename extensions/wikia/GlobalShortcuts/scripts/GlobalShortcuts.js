/**
 * Module keeps list of shortcut keys and provides interface to add new ones or find existing ones.
 * It also initiates bind between key combination and function that handles it
 */
define('GlobalShortcuts', ['Mousetrap', 'mw', 'PageActions'], function (Mousetrap, mw, PageActions) {
	'use strict';

	var all = {},
		wgWikiaShortcutKeys = mw.config.get('wgWikiaShortcutKeys');

	function initShortcut(actionId, key) {
		console.log('Installing shortcut "' + key + '" for ' + actionId);
		Mousetrap.bind(key,function () {
			console.log('Triggered shortcut "' + key + '" for ' + actionId);
			PageActions.find(actionId).execute();
		});
	}

	function add(actionId, key) {
		if (!PageActions.find(actionId)) {
			throw new Error('Unknown action: ' + actionId);
		}
		var current = (actionId in all) ? all[actionId] : [];
		if (current.indexOf(key) === -1) {
			current.push(key);
			all[actionId] = current;
			initShortcut(actionId,key);
		}
	}

	function find(actionId) {
		return (actionId in all) ? all[actionId] : [];
	}

	function init() {
		// Add shortcuts provided by backend
		Object.keys(wgWikiaShortcutKeys).forEach(function (id) {
			wgWikiaShortcutKeys[id].forEach(function (key) {
				add(id, key);
			});
		});
	}

	init();

	return {
		all: all,
		add: add,
		find: find
	};
});
