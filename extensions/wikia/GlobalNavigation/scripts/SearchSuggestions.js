$(function() {
	'use strict';

	var SearchSuggestions = (function() {
		function WikiaSearchApp(id) {
			this.id = id;
			this.searchForm = $(id);

			this.searchField = $('#searchInput');
			this.searchSelect = $('#searchSelect');

			if ( !this.searchForm.hasClass('noautocomplete') ) {
				this.searchField.bind({
					'suggestShow': window.transparentOut.show,
					'suggestHide': window.transparentOut.hide
				});

				// load autosuggest code on first focus
				this.searchField.one('focus', $.proxy(this.initSuggest, this));

				if (this.searchField.is(':focus')) {
					this.initSuggest();
				}
			}
		}

		WikiaSearchApp.prototype.track = Wikia.Tracker.buildTrackingFunction({
			trackingMethod: 'internal'
		});

		function getPositionRightValue() {
			var width = 0;

			width = parseInt($('.search-container').css('padding-left'), 10) +
				$('.account-navigation-container').width() +
				$('.notifications-container').width();

			return '-' + width + 'px';
		}

		// download necessary dependencies (AutoComplete plugin) and initialize search suggest feature for #search_field
		WikiaSearchApp.prototype.initSuggest = function() {
			var autocompleteReEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')',
				'[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
				mw.loader.using('jquery.autocomplete').then($.proxy(function() {
					this.searchField.autocomplete({
						serviceUrl: window.wgServer + window.wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
						onSelect: $.proxy(function(value, data, event) {
							var valueEncoded = encodeURIComponent(value.replace(/ /g, '_')),
							// slashes can't be urlencoded because they break routing
								location = window.wgArticlePath.
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
						appendTo: '.global-nav-search-input-wrapper',
						deferRequestBy: 200,
						disabled: (this.searchSelect.val() === 'global') ? true : false,
						minLength: 3,
						maxHeight: 1000,
						selectedClass: 'selected',
						width: '100%',
						positionRight: getPositionRightValue(),
						// Add span around every autocomplete result
						fnFormatResult: function(value, data, currentValue) {
							var pattern = '(' + currentValue.replace(autocompleteReEscape, '\\$1') + ')';
							return '<span>' +
								value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') +
								'</span>';
						},
						// BugId:4625 - always send the request even if previous one returned no suggestions
						skipBadQueries: true
					});

			}, this));
		};

		return WikiaSearchApp;
	})();

	new SearchSuggestions('#searchForm');
});
