define('GlobalShortcuts', ['Mousetrap', 'mw'], function (Mousetrap, mw) {
	'use strict';

	var shortcuts = {
		// Actions
		delete: 'd',
		edit: 'e',
		flag: 'f',
		move: 'm',
		startWikia: 's',
		classify: 'k',
		// Global navigation
		discussions: 'g d',
		history: 'g h',
		insights: 'g i',
		recentChanges: 'g r',
		// Local navigation / focus
		help: '?',
		search: 'g s',
		search1: '/'
	};
	function Init() {
		var globalShortcutsConfig = mw.config.get('globalShortcutsConfig');
		// Help
		Mousetrap.bind(shortcuts.help, function () {
			require(['GlobalShortcutsHelp'],function (help) {
				help.open();
			});
		});
		// Actions
		Mousetrap.bind(shortcuts.edit, function () {
			$('#ca-edit')[0].click();
		});
		Mousetrap.bind(shortcuts.flag, function () {
			$('#ca-flags')[0].click();
		});
		Mousetrap.bind(shortcuts.delete, function () {
			$('[accesskey=' + shortcuts.delete + ']')[0].click();
		});
		Mousetrap.bind(shortcuts.move, function () {
			$('[accesskey=' + shortcuts.move + ']')[0].click();
		});
		Mousetrap.bind(shortcuts.startWikia, function () {
			$('[data-id=start-wikia]')[0].click();
		});
		// TODO add conditional shortcuts
		Mousetrap.bind(shortcuts.classify, function () {
			require(['TemplateClassificationModal'], function shortcutOpenTemplateClassification(tc) {
				tc.open();
			});
		});

		// Local navigation / focus
		Mousetrap.bind(shortcuts.search, function (e) {
			e.preventDefault();
			$('#searchInput')[0].focus();
		});
		Mousetrap.bind(shortcuts.search1, function (e) {
			e.preventDefault();
			$('#searchInput')[0].focus();
		});

		// Global navigation
		Mousetrap.bind(shortcuts.discussions, function () {
			window.location.href = mw.config.get('location').origin + '/d';
		});
		Mousetrap.bind(shortcuts.history, function () {
			$('[accesskey=h]')[0].click();
		});
		Mousetrap.bind(shortcuts.insights, function (e) {
			e.preventDefault();
			window.location.href = globalShortcutsConfig.insights;
		});
		Mousetrap.bind(shortcuts.recentChanges, function (e) {
			e.preventDefault();
			window.location.href = globalShortcutsConfig.recentChanges;
		});
	}
	return new Init();
});

require(['jquery', 'GlobalShortcuts'], function ($, gs) {
	'use strict';
	$(gs);
});
