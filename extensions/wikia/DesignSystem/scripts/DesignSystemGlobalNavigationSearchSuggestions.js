$(function () {
	require(['search-tracking', 'uuid', 'wikia.trackingOptIn'], function (searchTracking, uuid, trackingOptIn) {
		'use strict';
		var searchDropdownSelector = '.wds-global-navigation__search-dropdown',
            $globalNav = $('.wds-global-navigation'),
			$searchDropdown = $globalNav.find(searchDropdownSelector),
			$searchInput = $globalNav.find('.wds-global-navigation__search-input'),
			searchSuggestionsUrl = $searchInput.data('suggestions-url'),
			searchScope = $globalNav.find('.wds-global-navigation__search-scope__value'),
			trackingState = {};

		function initSuggestions() {
			mw.loader.using('jquery.autocomplete').then(function () {
				var autocompleteReEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')',
					'[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');

			$searchInput
				.on({
					suggestShow: function () {
						$searchDropdown.addClass('wds-is-active');
					},
					suggestHide: function () {
						$searchDropdown.removeClass('wds-is-active');
					}
				})
				.autocomplete({
					scope: searchScope,
					serviceUrl: 'https://services.fandom-dev.pl/unified-search/global-search-suggestions?lang=en&namespace=0',
					queryParamName: 'query',
					appendTo: searchDropdownSelector,
					deferRequestBy: 200,
					minLength: 3,
					maxHeight: 1000,
					onSelect: function (value, data, event) {
						var valueEncoded = encodeURIComponent(value.title.replace(/ /g, '_')),
							// slashes can't be urlencoded because they break routing
							location = value.url;

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

							// trackSuggestionClick(value);
						},
						selectedClass: 'wds-is-selected',
						// always send the request even if previous one returned no suggestions
						skipBadQueries: true,
						setPosition: false,
						suggestionWrapperElement: 'li',
						fnContainerMarkup: function (mainContainerId, autocompleteElId) {
							return '<div id="' + mainContainerId +
								'" class="wds-dropdown__content wds-global-navigation__search-suggestions wds-is-not-scrollable">' +
								'<ul id="' + autocompleteElId +
								'" class="wds-list wds-has-ellipsis wds-is-linked"></ul>' +
								'<div class="wds-global-navigation__search-suggestions-wikis"></div>' +
								'</div>';
						},
						fnFormatResult: function (value, data, currentValue) {
							let pattern = '(' + currentValue.replace(autocompleteReEscape, '\\$1') + ')';
							let link = '<a class="wds-global-navigation__dropdown-link">' +
								value.title.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') +
								'</a>';
							if (value.wikiId != window.wgCityId) {
								link += '<span class=wds-global-navigation__search-suggestions-wiki-span>';
								link += 'in ' + value.sitename;
								link += '</span>';
							}
							return link;
						},
						fnPreprocessResults: function (data) {
							var wikisContainer = $(".wds-global-navigation__search-suggestions-wikis");
							wikisContainer.empty();
							data.wikis.slice(0, 3).forEach(wiki => {
								let link = '<a href="' + wiki.url + '">' +
									'<img src="' + wiki.thumbnail + '" class="wds-global-navigation__search-suggestions-wiki-thumbnail" />' +
									'<span class="wds-global-navigation__search-suggestions-wiki-name-span">' + wiki.name + '</span>' +
									'</a>';
								wikisContainer.append('<div class="wds-global-navigation__search-suggestions-wiki-div">' + link + '</div>');
							});
							// trackSuggestionsImpression(data.ids, data.query);
							return data.wikiPages.slice(0, 5);
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

			trackingOptIn.pushToUserConsentQueue(function () {
				window.searchTracking.trackSuggestImpression(
					getSearchTrackingPayload(suggestions, query)
				);
			});
		}

		function trackSuggestionClick(suggestion) {
			window.searchTracking.trackSuggestClicked(
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
				app: 'mw-desktop',
				siteId: parseInt(window.wgCityId),
				suggestionId: trackingState.suggestionId,
				pvUniqueId: window.pvUID || 'dev'
			};
		}
	});
});
