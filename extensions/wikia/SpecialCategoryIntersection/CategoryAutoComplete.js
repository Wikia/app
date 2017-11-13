CategoryAutoComplete = {
	FORM_ID: "CategoryAutoComplete",
	NS_CATEGORY: 14, // TODO: is there a more programmatic way to get this?
	searchForm: false,
	searchFields: false,
	ads: false,

	init : function() {
		CategoryAutoComplete.searchForm = $('#'+CategoryAutoComplete.FORM_ID);
		CategoryAutoComplete.searchFields = CategoryAutoComplete.searchForm.find('input[placeholder]');

		// RT #141437 - hide TOP_RIGHT_BOXAD when showing search suggestions
		CategoryAutoComplete.ads = $("[id$='TOP_RIGHT_BOXAD']");

		CategoryAutoComplete.searchFields.bind({
			'suggestShow': CategoryAutoComplete.hideAds,
			'suggestHide': CategoryAutoComplete.showAds
		});

		// load autosuggest code on first focus
		CategoryAutoComplete.searchFields.one('focus', CategoryAutoComplete.initSuggest);
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
			CategoryAutoComplete.searchFields.each(function(){
				$(this).autocomplete({
					serviceUrl: wgScriptPath + "/api.php" + '?action=opensearch',
					appendTo: $(this).parent('.autoCompleteWrapper'),
					deferRequestBy: 250,
					maxHeight: 1000,
					queryParamName: 'search',
					selectedClass: 'selected',
					width: '270px',
					namespace: CategoryAutoComplete.NS_CATEGORY,
					fnPreprocessResults: function(response){
						response.query = response[0];
						response.suggestions = response[1];
						response.data = response[1];
						return response;
					}
				});
			});
		});
	}
};

$(function() {
	CategoryAutoComplete.init();
});
