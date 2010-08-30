$(function() {
	WikiaSearch.init();
});

WikiaSearch = {
	searchForm: false,
	searchField: false,
	adBoxAfter: false,

	track: function(url) {
		$.tracker.byStr('module/search/' + url);
	},

	init : function() {
		WikiaSearch.searchForm = $('#WikiaSearch');
		WikiaSearch.searchField = WikiaSearch.searchForm.children('[placeholder]');

		WikiaSearch.initTooltip();

		// load autosuggest code on first focus
		WikiaSearch.searchField.one('focus',WikiaSearch.initSuggest);

		// track form submittion
		WikiaSearch.searchForm.submit(function(ev) {
			WikiaSearch.track('submit');
		});

		// get boxad following search box
		WikiaSearch.adBoxAfter = WikiaSearch.searchForm.next('.wikia-ad');
	},

	// download necessary dependencies (AutoComplete plugin) and initialize search suggest feature for #search_field
	initSuggest: function () {
		$.getScript(stylepath + '/common/jquery/jquery.autocomplete.js', function() {
			WikiaSearch.searchField.autocomplete({
				serviceUrl: wgServer + wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
				onSelect: function(v, d) {
					WikiaSearch.track('suggest');
					window.location.href = wgArticlePath.replace(/\$1/, v.replace(/ /g, '_'));
				},
				appendTo: '#WikiaSearch',
				deferRequestBy: 1000,
				maxHeight: 1000,
				selectedClass: 'selected',
				width: '270px'
			});

			// hide TOP_BOXAD ad when suggestions are shown
			WikiaSearch.searchField.
				bind('suggestShow', function() {
					//WikiaSearch.adBoxAfter.css('visibility', 'hidden');
				}).
				bind('suggestHide', function() {
					//WikiaSearch.adBoxAfter.css('visibility', 'visible');
				});
		});
	},

	// add support for placeholder attribute in browsers different than webkit
	initTooltip: function() {
		if (jQuery.browser.webkit) {
			return;
		}

		var tooltip = WikiaSearch.searchField.attr('placeholder');

		// remove tooltip if user just hits search button
		WikiaSearch.searchForm.bind('submit', function(ev) {
			if (WikiaSearch.searchField.val() == tooltip) {
				WikiaSearch.searchField.val('').removeClass('tooltip');
			}
		});

		WikiaSearch.searchField.
			bind('focus', function(ev) {
				// clear search field
				if (WikiaSearch.searchField.val() == tooltip) {
					WikiaSearch.searchField.val('').removeClass('tooltip');
				}
			}).
			bind('blur', function(ev) {
				// show tooltip if field is empty when leaving
				if (WikiaSearch.searchField.val() == '') {
					WikiaSearch.searchField.val(tooltip).addClass('tooltip');
				}
			});

		// initial value
		if (WikiaSearch.searchField.val() == '') {
			WikiaSearch.searchField.val(tooltip).addClass('tooltip');
		}
	}
};