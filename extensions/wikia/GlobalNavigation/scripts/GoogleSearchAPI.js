/**
 * We AB test for wikia search (both within and all wikias) in Oasis with Google custom search result.
 * window.wgGoogleSearchTest: a global variable set true in Optimizely for 50% of users who visit ja wikia.
 * window.wgGoogleSearchParam: Search ID set in Optimizely.
 */
$(function () {
	'use strict';
	if ( window.wgGoogleSearchTest ) {
		var searchId = window.wgGoogleSearchParam;
		$.loadGoogleSearchAPI(searchId);

		$('#searchForm').submit( function (evt) {
			var contentLang = window.wgContentLanguage || 'en',
				searchQuery = $('#searchInput').val(),
				$googleInput = $('.gsc-input'),
				$googleButton = $('.gsc-search-button'),
				$selectElement = $('#searchSelect'),
				$selectedOption = $selectElement.find('option:selected');

			evt.preventDefault();

			//get info of local or global and modify query scope
			if ($selectedOption.val() === 'local') {
				searchQuery += ' site:' + window.location.hostname;
			} else {
				if ( contentLang === 'en') {
					searchQuery += ' site:*.wikia.com';
				} else {
					searchQuery += ' site:' + contentLang + '.*.wikia.com';
				}
			}

			//Invoke google search
			$googleInput.val(searchQuery);
			$googleButton.trigger('click');
		});
	}
});
