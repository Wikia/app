/**
 * We AB test for wikia search (both within and all wikias) in Oasis with Google custom search result.
 * window.wgGoogleSearchTest: a global variable set true in Optimizely for 50% of users who visit ja wikia.
 * window.wgGoogleSearchParam: Search ID set in Optimizely.
 */
$(function () {
	'use strict';
	if (!window.wgGoogleSearchTest) {
		return;
	}

    var $wikiaSite = $('.WikiaSiteWrapper'),
        searchId = window.wgGoogleSearchParam;

	//The html class is defined in Oasis_Index.php. Better check if it exists.
	if ($wikiaSite.length === 0) {
		return;
	}

	$wikiaSite.before('<gcse:search></gcse:search>');
	$.loadGoogleSearchAPI(searchId);

	$('#searchForm').submit( function (evt) {
		var contentLang = window.wgContentLanguage || 'en',
			searchQuery = $('#searchInput').val(),
			$googleInput = $('.gsc-input'),
			$googleButton = $('.gsc-search-button'),
			$selectElement = $('#searchSelect'),
			$selectedOption = $selectElement.find('option:selected'),
			currentUrlPath = window.location.pathname,
			fakeSearchParam = '&qInter=' + encodeURIComponent(searchQuery);

		//We run Google search only for inter search (INT-289)
		if ($selectedOption.val() === 'local') {
			return;
		}
		evt.preventDefault();

		//Manually trigger page view
		currentUrlPath += '?q=' + encodeURIComponent(searchQuery) + fakeSearchParam;
		window.guaTrackPageview(currentUrlPath);

		//Invoke google search
		$googleInput.val(searchQuery);
		$googleButton.trigger('click');
	});
});
