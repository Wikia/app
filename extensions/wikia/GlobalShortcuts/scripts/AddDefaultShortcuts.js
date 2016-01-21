/**
 * A module for adding a set of default shortcut keys that are always available
 */
require(['GlobalShortcuts', 'PageActions'],
	function (GlobalShortcuts, PageActions) {
		'use strict';

		var INITIAL_SHORTCUTS = {
			'general:StartWikia': {
				shortcuts: ['s'],
				actionParams: {
					id: 'general:StartWikia',
					caption: 'Start a new wikia',
					fn: function () {
						$('[data-id=start-wikia]')[0].click();
					},
					category: 'Global'
				}
			},
			'help:Actions': {
				shortcuts: ['.'],
				actionParams: {
					id: 'help:Actions',
					caption: 'Actions list (Actions explorer)',
					fn: function () {
						require(['GlobalShortcutsSearch'], function (GlobalShortcutsSearch) {
							var searchModal = new GlobalShortcutsSearch();
							searchModal.open();
						});
					},
					category: 'Help'
				}
			},
			'help:Keyboard': {
				shortcuts: ['?'],
				actionParams: {
					id: 'help:Keyboard',
					caption: 'Keyboard shortcuts help',
					fn: function () {
						require(['GlobalShortcutsHelp'], function (help) {
							help.open();
						});
					},
					category: 'Help'
				}
			}
		};

		Object.keys(INITIAL_SHORTCUTS).forEach(function (actionId) {
			PageActions.add(INITIAL_SHORTCUTS[actionId].actionParams);
			INITIAL_SHORTCUTS[actionId].shortcuts.forEach(function (key) {
				GlobalShortcuts.add(actionId, key);
			});
		});

	}
);
