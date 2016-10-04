/**
 * A module for adding a set of default shortcut keys that are always available
 */
require(['GlobalShortcuts', 'PageActions', 'mw', 'wikia.loader'],
	function (GlobalShortcuts, PageActions, mw, loader) {
		'use strict';

		function init() {
			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						messages: 'GlobalShortcuts'
					}
				})
			).done(function (res) {
					mw.messages.set(res.messages);
					addShortcuts();
				});
		}

		function addShortcuts() {
			var INITIAL_SHORTCUTS = {
				'general:StartWikia': {
					shortcuts: [],
					actionParams: {
						id: 'general:StartWikia',
						caption: mw.message('global-shortcuts-caption-start-a-new-wikia').plain(),
						fn: function () {
							$('[data-id=start-wikia]')[0].click();
						},
						category: mw.message('global-shortcuts-category-global').escaped()
					}
				},
				'help:Actions': {
					shortcuts: ['.'],
					actionParams: {
						id: 'help:Actions',
						caption: mw.message('global-shortcuts-caption-action-list').plain(),
						fn: function () {
							require(['GlobalShortcutsSearch'], function (GlobalShortcutsSearch) {
								var searchModal = new GlobalShortcutsSearch();
								searchModal.open();
							});
						},
						category: mw.message('global-shortcuts-category-help').escaped()
					}
				},
				'help:Keyboard': {
					shortcuts: ['?'],
					actionParams: {
						id: 'help:Keyboard',
						caption: mw.message('global-shortcuts-caption-keyboard-shortcuts-help').plain(),
						fn: function () {
							require(['GlobalShortcutsHelp'], function (help) {
								help.open();
							});
						},
						category: mw.message('global-shortcuts-category-help').escaped()
					}
				},
				'wikia:Search': {
					shortcuts: ['g s', '/'],
					actionParams: {
						id: 'wikia:Search',
						caption: mw.message('global-shortcuts-caption-search-for-a-page').plain(),
						fn: function () {
							$('#searchInput')[0].focus();
						},
						category: mw.message('global-shortcuts-category-current-wikia').escaped()
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

		init();

	}
);
