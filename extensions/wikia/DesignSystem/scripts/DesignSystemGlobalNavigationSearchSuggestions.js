$(function () {
	require(['search-tracking', 'uuid'], function (searchTracking, uuid) {
		'use strict';
		var $globalNav = $('.wds-global-navigation'),
			$searchDropdown = $globalNav.find('.wds-global-navigation__search'),
			$searchInput = $globalNav.find('.wds-global-navigation__search-input'),
			searchSuggestionsUrl = $searchInput.data('suggestions-url'),
			trackingState = {};

		function initSuggestions() {
			mw.loader.using('jquery.autocomplete').then(function () {
				var autocompleteReEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')',
					'[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');

				$searchInput
					.on({
						suggestShow: function (event) {
							$searchDropdown.addClass('wds-is-active');
						},
						suggestHide: function () {
							$searchDropdown.removeClass('wds-is-active');
						}
					})
					.autocomplete({
						serviceUrl: searchSuggestionsUrl,
						queryParamName: $searchInput.data('suggestions-param-name'),
						appendTo: '.wds-global-navigation__search',
						deferRequestBy: 200,
						minLength: 3,
						maxHeight: 1000,
						onSelect: function (value, data, event) {
							var valueEncoded = encodeURIComponent(value.replace(/ /g, '_')),
								// slashes can't be urlencoded because they break routing
								location = window.wgArticlePath.replace(/\$1/, valueEncoded).replace(encodeURIComponent('/'), '/');

							window.Wikia.Tracker.track({
								eventName: 'search_start_suggest',
								sterm: valueEncoded,
								rver: 0,
								trackingMethod: 'internal'
							});

							// Respect modifier keys to allow opening in a new window (BugId:29401)
							if (event.button === 1 || event.metaKey || event.ctrlKey) {
								window.open(location);

								// Prevents hiding the container
								return false;
							} else {
								window.Wikia.Tracker.track({
									action: Wikia.Tracker.ACTIONS.CLICK,
									category: 'navigation',
									trackingMethod: 'analytics',
									label: $searchInput.data('suggestions-tracking-label')
								});

								window.location.href = location;
							}

							trackSuggestionClick(value);
						},
						selectedClass: 'wds-is-selected',
						// always send the request even if previous one returned no suggestions
						skipBadQueries: true,
						setPosition: false,
						suggestionWrapperElement: 'li',
						fnContainerMarkup: function (mainContainerId, autocompleteElId) {
							return '<div id="' + mainContainerId +
								'" class="wds-dropdown__content wds-global-navigation__search-suggestions">' +
								'<ul id="' + autocompleteElId +
								'" class="wds-list wds-has-ellipsis wds-is-linked"></ul>' +
								'</div>';
						},
						fnFormatResult: function (value, data, currentValue) {
							var pattern = '(' + currentValue.replace(autocompleteReEscape, '\\$1') + ')';

							return '<a class="wds-global-navigation__dropdown-link">' +
								value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') +
								'</a>';
						},
						fnPreprocessResults: function (data) {
							trackSuggestionsImpression(data.ids, data.query);

							return data;
						},
						actionEvent: 'mousedown',
					});
			});
		}

		if (searchSuggestionsUrl) {
			$searchInput.one('focus', initSuggestions);

			if ($searchInput.is(':focus')) {
				initSuggestions();
			}
		}

		function trackSuggestionsImpression(suggestions, query) {
			trackingState = {
				query: query,
				suggestions: suggestions,
				suggestionId: uuid()
			};

			searchTracking.trackSuggestImpression(
				getSearchTrackingPayload(suggestions, query)
			);
		}

		function trackSuggestionClick(suggestion) {
			searchTracking.trackSuggestClicked(
				Object.assign(
					{},
					getSearchTrackingPayload(trackingState.suggestions, trackingState.query),
					{
						positionOfClickedItem: Object.values(trackingState.suggestions).indexOf(suggestion)
					}
				)
			);
		}

		function getSearchTrackingPayload(suggestions, query) {
			return {
				enteredPhrase: query,
				suggestions: Object.keys(suggestions).map(function (articleId) {
					return {
						type: 'article',
						value: articleId,
						id: suggestions[articleId]
					};
				}),
				app: 'mobile-wiki',
				siteId: parseInt(window.wgCityId),
				suggestionId: trackingState.suggestionId,
				pvUniqueId: window.pvUID || 'dev'
			};
		}
	});
});
