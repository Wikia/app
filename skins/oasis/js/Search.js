var WikiaSearchApp = {
	searchForm: false,
	searchField: false,

	ads: false,

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
				onSelect: $.proxy(function(value, data, event) {
					var valueEncoded = encodeURIComponent(value.replace(/ /g, '_')),
						// slashes can't be urlencoded because they break routing
						location = wgArticlePath.
							replace(/\$1/, valueEncoded).
							replace(encodeURIComponent('/'), '/');

					this.trackInternal('search_start_suggest', {
						'sterm': valueEncoded,
						'rver': 0
					});

					// Respect modifier keys to allow opening in a new window (BugId:29401)
					if (event.button === 1 || event.metaKey || event.ctrlKey) {
						window.open(location);

						// Prevents hiding the container
						return false;
					} else {
						window.location.href = location;
					}
				}, this),
				appendTo: '#WikiaSearch',
				deferRequestBy: 400,
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
