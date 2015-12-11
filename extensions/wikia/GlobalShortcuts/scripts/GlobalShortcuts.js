define('GlobalShortcuts', ['Mousetrap', 'mw'], function (Mousetrap, mw) {
	'use strict';

	var shortcuts = {
		recentChanges: 'g r',
		insights: 'g i',
		edit: 'e',
		startWikia: 's',
		search: 'g s',
		search1: '/'
	};
	function Init() {
		// Actions
		Mousetrap.bind(shortcuts.edit, function () {
			console.log('Mousetrap');
			$('#ca-edit')[0].click();
		});
		Mousetrap.bind(shortcuts.startWikia, function () {
			$('[data-id=start-wikia]')[0].click();
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
		Mousetrap.bind(shortcuts.insights, function (e) {
			e.preventDefault();
			window.location.href = mw.config.get('globalshortcuts').insights;
		});
		Mousetrap.bind(shortcuts.recentChanges, function (e) {
			e.preventDefault();
			window.location.href = mw.config.get('globalshortcuts').recentChanges;
		});
	}
	return new Init();
});

require(['jquery', 'GlobalShortcuts'], function ($, gs) {
	'use strict';
	$(gs);
});
