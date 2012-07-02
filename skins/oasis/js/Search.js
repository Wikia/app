var WikiaSearchApp = {
	searchForm: false,
	searchField: false,

	ads: false,

	track: function(url) {
		$.tracker.byStr('module/search/' + url);
	},

	trackInternal: function(event, params) {
		WikiaTracker.trackEvent(
			event,
			params,
			'internal'
		);
	},

	init : function() {
		this.searchForm = $('#WikiaSearch');
		this.searchFormBottom = $('#search');
		this.searchField = this.searchForm.children('input[placeholder]');

		// RT #141437 - hide HOME_TOP_RIGHT_BOXAD when showing search suggestions
		this.ads = $("[id$='TOP_RIGHT_BOXAD']");

		if(!this.searchForm.hasClass('noautocomplete')) {
			this.searchField.bind({
				'suggestShow': $.proxy(this.hideAds, this),
				'suggestHide': $.proxy(this.showAds, this)
			});

			// load autosuggest code on first focus
			this.searchField.one('focus', $.proxy(this.initSuggest, this));
		}

		// track form submittion
		this.searchForm.submit($.proxy(function(ev) {
			this.track('submit');
		}, this));
		this.searchFormBottom.submit($.proxy(function(ev) {
			this.track('submit');
		}, this));
	},

	hideAds: function() {
		this.ads.each(function() {
			$(this).children().css('margin-left', '-9999px');
		});
	},

	showAds: function() {
		this.ads.each(function() {
			$(this).children().css('margin-left', 'auto');
		});
	},

	// download necessary dependencies (AutoComplete plugin) and initialize search suggest feature for #search_field
	initSuggest: function() {
		$.when(
			//$.getMessages('LinkSuggest'), // FIXME: doesn't seem to be used here
			$.loadJQueryAutocomplete()
		).then($.proxy(function() {
			this.searchField.autocomplete({
				serviceUrl: wgServer + wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
				onSelect: $.proxy(function(value, data) {
					var valueEncoded = encodeURIComponent(value.replace(/ /g, '_'));

					this.track('suggest');
					this.trackInternal('search_start_suggest', {
						'sterm': valueEncoded,
						'rver': 0
					});
					// slashes can't be urlencoded because they break routing
					window.location.href = wgArticlePath.
						replace(/\$1/, valueEncoded).
						replace(encodeURIComponent('/'), '/');
				}, this),
				appendTo: '#WikiaSearch',
				deferRequestBy: 2000,
				minLength: 3,
				maxHeight: 1000,
				selectedClass: 'selected',
				width: '270px',
				skipBadQueries: true // BugId:4625 - always send the request even if previous one returned no suggestions
			});
		}, this));
	}
};

$(function() {
	WikiaSearchApp.init();
});
