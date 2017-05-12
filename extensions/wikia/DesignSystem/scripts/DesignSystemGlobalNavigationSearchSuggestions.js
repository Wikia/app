$(function () {
	'use strict';

	var $searchInput = $('#searchInput'),
		$searchButton = $('.wds-global-navigation__search-submit'),
		$searchInputWrapper = $('#searchInputWrapper'),
		searchSuggestionsUrl = $searchInput.data('suggestions-url'),
		searchSuggestContainerClass = '.wds-global-navigation__search-suggestions',
		initialized = false;

	function initSuggestions() {
		if (initialized == false) {
			var uid = new Date().getTime();
			var mainContainerId = "AutocompleteContainer_" + uid;
			$searchInputWrapper.append(
				'<div id="' + mainContainerId +
				'" class="wds-dropdown__content wds-global-navigation__search-suggestions">' +
				'</div>');

			initialized = true;
			window.Wikia.Tracker.track({
				action: Wikia.Tracker.ACTIONS.CLICK,
				category: 'search',
				trackingMethod: 'analytics',
				label: 'search-bar-click'
			});
		}

		mw.loader.using('jquery.ui.autocomplete').then(function () {
			var autocompleteReEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')',
														   '[', ']', '{', '}', '\\'].join('|\\')
												  + ')', 'g');
			var beginTyping = false;
			var showedSuggestion = false;

			$searchButton
				.click(function () {
					// Track when a user clicks the search button
					window.Wikia.Tracker.track({
						action: Wikia.Tracker.ACTIONS.CLICK,
						category: 'search',
						trackingMethod: 'analytics',
						label: 'search-button-click'
					});
				});

			$searchInput
				.keyup(function () {
					// Track when user begins to type
					if (beginTyping == false) {
						beginTyping = true;
						window.Wikia.Tracker.track({
							action: Wikia.Tracker.ACTIONS.ENABLE,
							category: 'search',
							trackingMethod: 'analytics',
							label: 'search-button-enable'
						});
					}
				})
				.autocomplete({
					source: function (request, response) {
						$.ajax({
							url: searchSuggestionsUrl,
							dataType: "json",
							data: {
								query: request.term
							},
							success: function (data) {
								response(data.suggestions);
							}
						});
					},
				  	position: { my: "left bottom", at: "left top", of: searchSuggestContainerClass, collision: "flip" },
					open: function(event, ui) {
						// Track when the search suggest dropdown appears
						if (showedSuggestion == false) {
							showedSuggestion = true;
							window.Wikia.Tracker.track({
														   action: Wikia.Tracker.ACTIONS.ENABLE,
														   category: 'search',
														   trackingMethod: 'analytics',
														   label: 'search-suggest-enable'
													   });
						}

						$searchInputWrapper.addClass('wds-is-active');
					},
					close: function(event, ui) {
						$searchInputWrapper.removeClass('wds-is-active');
					},
					focus: function (event, ui) {
						console.log(ui);
						$searchInput.val(ui.item.label);
						return false;
					},
					select: function (event, ui) {
						var valueEncoded = encodeURIComponent(
							ui.item.label.replace(/ /g, '_'));
						// slashes can't be urlencoded because they break routing
						var location = window.wgArticlePath.replace(/\$1/,
																	valueEncoded).replace(
							encodeURIComponent('/'), '/');

						// Track when the user selects a suggestion
						window.Wikia.Tracker.track({
							action: Wikia.Tracker.ACTIONS.CLICK,
							category: 'search',
							trackingMethod: 'analytics',
							label: 'search-suggest-click'
						});

						window.Wikia.Tracker.track({
							eventName: 'search_start_suggest',
							sterm: valueEncoded,
							rver: 0,
							trackingMethod: 'internal'
						});

						// Respect modifier keys to allow opening in a new window
						// (BugId:29401)
						if (event.button === 1 || event.metaKey || event.ctrlKey) {
							window.open(location);

							// Prevents hiding the container
							return false;
						} else {
							window.Wikia.Tracker.track({
							   action: Wikia.Tracker.ACTIONS.CLICK,
							   category: 'navigation',
							   trackingMethod: 'analytics',
							   label: $searchInput.data(
								   'suggestions-tracking-label')
						   });

							window.location.href = location;
						}
						return false;
					},
					minLength: 3,
					appendTo: searchSuggestContainerClass
				})
				.data("autocomplete")._renderItem = function (ul, item) {
					var uid = new Date().getTime();
					ul.attr('id', 'Autocomplete_' + uid);
					ul.addClass('wds-list wds-has-ellipsis wds-is-linked');
					var currentValue = $searchInput.val();
					var pattern = '(' + currentValue.replace(autocompleteReEscape, '\\$1') + ')';
					return $("<li></li>")
						.data("item.autocomplete", item)
						.append(
							'<a class="wds-global-navigation__dropdown-link">' + item.label.replace(
								new RegExp(pattern, 'gi'),
								'<strong>$1<\/strong>') + '</a>')
						.appendTo(ul);
				};
		});
	}

	if (searchSuggestionsUrl) {
		$searchInput.one('focus', initSuggestions);

		if ($searchInput.is(':focus')) {
			initSuggestions();
		}
	}
});
