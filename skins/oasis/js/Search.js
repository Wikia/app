$(function() {
	WikiaSearchApp.init();
});

WikiaSearchApp = {
	searchForm: false,
	searchField: false,
	adBoxAfter: false,

	track: function(url) {
		$.tracker.byStr('module/search/' + url);
	},

	init : function() {
		WikiaSearchApp.searchForm = $('#WikiaSearch');
		WikiaSearchApp.searchField = WikiaSearchApp.searchForm.children('input[placeholder]');

		// load autosuggest code on first focus
		WikiaSearchApp.searchField.one('focus', WikiaSearchApp.initSuggest);

		// track form submittion
		WikiaSearchApp.searchForm.submit(function(ev) {
			WikiaSearchApp.track('submit');
		});
	},

	// download necessary dependencies (AutoComplete plugin) and initialize search suggest feature for #search_field
	initSuggest: function () {
		$.loadJQueryAutocomplete(function() {
			WikiaSearchApp.searchField.autocomplete({
				serviceUrl: wgServer + wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
				onSelect: function(v, d) {
					WikiaSearchApp.track('suggest');
					window.location.href = wgArticlePath.replace(/\$1/, v.replace(/ /g, '_'));
				},
				appendTo: '#WikiaSearch',
				deferRequestBy: 1000,
				maxHeight: 1000,
				selectedClass: 'selected',
				width: '270px'
			});

			// hide TOP_BOXAD ad when suggestions are shown
			/*
			WikiaSearchApp.searchField.
				bind('suggestShow', function() {
					//WikiaSearch.adBoxAfter.css('visibility', 'hidden');
				}).
				bind('suggestHide', function() {
					//WikiaSearch.adBoxAfter.css('visibility', 'visible');
				});
			*/
		});
	}
};