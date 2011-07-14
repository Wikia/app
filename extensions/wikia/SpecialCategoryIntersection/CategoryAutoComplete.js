$(function() {
	CategoryAutoComplete.init();
});

CategoryAutoComplete = {
	FORM_ID: "CategoryAutoComplete",
	searchForm: false,
	searchField: false,

	ads: false,

	track: function(url) {
		// Kind of silly to waste tracking requests on this for now (the # of requests is capped).
		//$.tracker.byStr('module/categoryautocomplete/' + url);
	},

	init : function() {
		CategoryAutoComplete.searchForm = $('#'+this.FORM_ID);
		CategoryAutoComplete.searchField = CategoryAutoComplete.searchForm.children('input[placeholder]');

		// RT #141437 - hide HOME_TOP_RIGHT_BOXAD when showing search suggestions
		CategoryAutoComplete.ads = $("[id$='TOP_RIGHT_BOXAD']");

		CategoryAutoComplete.searchField.bind({
			'suggestShow': CategoryAutoComplete.hideAds,
			'suggestHide': CategoryAutoComplete.showAds
		});

		// load autosuggest code on first focus
		CategoryAutoComplete.searchField.one('focus', CategoryAutoComplete.initSuggest);

		// track form submittion
		CategoryAutoComplete.searchForm.submit(function(ev) {
			CategoryAutoComplete.track('submit');
		});
	},

	hideAds: function() {
		CategoryAutoComplete.ads.each(function() {
			$(this).children().css('margin-left', '-9999px');
		});
	},

	showAds: function() {
		CategoryAutoComplete.ads.each(function() {
			$(this).children().css('margin-left', 'auto');
		});
	},

	// download necessary dependencies (AutoComplete plugin) and initialize search suggest feature for #search_field
	initSuggest: function () {
		$.loadJQueryAutocomplete(function() {
			CategoryAutoComplete.searchField.autocomplete({
// TODO: Make this use the category namespace
				serviceUrl: wgServer + wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
				onSelect: function(v, d) {
					CategoryAutoComplete.track('suggest');
					window.location.href = wgArticlePath.replace(/\$1/, encodeURIComponent(v.replace(/ /g, '_')));
				},
				appendTo: '#'+this.FORM_ID,
				deferRequestBy: 250,
				maxHeight: 1000,
				selectedClass: 'selected',
				width: '270px'
			});
		});
	}
};
