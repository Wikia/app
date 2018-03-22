WikiaSearchApp = (function() {

	function WikiaSearchApp(id) {
		this.id = id;
		this.searchForm = $(id);
		// make autocomplete sticked to right, but only under inputbox (not button on it's right)
		// 4 is border + padding of autocomplete container
		this.positionRight = this.searchForm.innerWidth() - this.searchForm.children('input:first-child').outerWidth() + 4;
		this.searchField = this.searchForm.children('input[placeholder]');

		// RT #141437 - hide TOP_RIGHT_BOXAD when showing search suggestions
		this.ads = $("[id$='TOP_RIGHT_BOXAD']");

		if ( !this.searchForm.hasClass('noautocomplete') ) {
			this.searchField.bind({
				'suggestShow': $.proxy(this.hideAds, this),
				'suggestHide': $.proxy(this.showAds, this)
			});

			// load autosuggest code on first focus
			this.searchField.one('focus', $.proxy(this.initSuggest, this));
		}
	}

	WikiaSearchApp.prototype.track = Wikia.Tracker.buildTrackingFunction({
		trackingMethod: 'internal'
	});

	WikiaSearchApp.prototype.hideAds = function() {
		this.ads.each(function() {
			$(this).children().css('margin-left', '-9999px');
		});
	};

	WikiaSearchApp.prototype.showAds = function() {
		this.ads.each(function() {
			$(this).children().css('margin-left', 'auto');
		});
	};

	// download necessary dependencies (AutoComplete plugin) and initialize search suggest feature for #search_field
	WikiaSearchApp.prototype.initSuggest = function() {
		$.when(
				$.loadJQueryAutocomplete()
			).then($.proxy(function() {
				this.searchField.autocomplete({
					serviceUrl: wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
					onSelect: $.proxy(function(value, data, event) {
						var valueEncoded = encodeURIComponent(value.replace(/ /g, '_')),
						// slashes can't be urlencoded because they break routing
							location = wgArticlePath.
								replace(/\$1/, valueEncoded).
								replace(encodeURIComponent('/'), '/');

						this.track({
							eventName: 'search_start_suggest',
							sterm: valueEncoded,
							rver: 0
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
					appendTo: this.id,
					deferRequestBy: 400,
					minLength: 3,
					maxHeight: 1000,
					selectedClass: 'selected',
					width: '100%',
					positionRight: this.positionRight + 'px',
					skipBadQueries: true // BugId:4625 - always send the request even if previous one returned no suggestions
				});
				if ( window.Wikia.newSearchSuggestions ) {
					window.Wikia.newSearchSuggestions.setAsMainSuggestions('search');
				}
			}, this));
	};

	return WikiaSearchApp;
})();

$(function() {
	new WikiaSearchApp('#WikiaSearch');
	new WikiaSearchApp('#HeaderWikiaSearch');
});
