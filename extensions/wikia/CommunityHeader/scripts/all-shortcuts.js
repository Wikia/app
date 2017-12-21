require(['jquery', 'GlobalShortcutsSearch'], function ($, GlobalShortcutsSearch) {
	$('.wds-community-header__wiki-buttons .all-shortcuts').click(function (event) {
		var searchModal = new GlobalShortcutsSearch();
		searchModal.open();
		event.preventDefault();
	});
});
