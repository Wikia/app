require(['jquery', 'GlobalShortcutsSearch', 'wikia.cookies'], function ($, GlobalShortcutsSearch, cookies) {
	$('.wds-community-header__wiki-buttons .wiki-button-all-shortcuts').click(function (event) {
		var searchModal = new GlobalShortcutsSearch();
		searchModal.open();
		event.preventDefault();
	});

	$('.wds-community-header__wiki-buttons .wiki-button-add-video').click(function () {
		cookies.set('special-video:add-video', 1, {
			path: '/',
			expires: 60000
		});
	});
});
