require(
	['jquery', 'wikia.window'],
	function ($, window) {
		'use strict';

		var $searchInput = $('#searchInput'),
			$searchInputWrapper = $('#searchInputWrapper');

		function initSuggestions() {
			mw.loader.using('jquery.autocomplete').then(function () {
				var autocompleteReEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')',
						'[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');

				$searchInput.autocomplete({
					serviceUrl: window.wgServer + window.wgScript + '?action=ajax&rs=getLinkSuggest&format=json',
					appendTo: '.wds-global-navigation__search-input-wrapper',
					deferRequestBy: 200,
					minLength: 3,
					maxHeight: 1000,
					selectedClass: 'wds-is-active',
					// always send the request even if previous one returned no suggestions
					skipBadQueries: true,
					setPosition: false,
					suggestionWrapperElement: 'li',
					fnContainerMarkup: function (mainContainerId, autocompleteElId) {
						return '<div id="' + mainContainerId + '" class="wds-dropdown__content wds-global-navigation__search-suggestions">' +
								'<ul id="' + autocompleteElId + '" class="wds-list wds-has-ellipsis wds-is-linked"></ul>' +
								'</div>';
					},
					fnFormatResult: function (value, data, currentValue) {
						var pattern = '(' + currentValue.replace(autocompleteReEscape, '\\$1') + ')',
							valueEncoded = encodeURIComponent(value.replace(/ /g, '_')),
							// slashes can't be urlencoded because they break routing
							href = window.wgArticlePath.replace(/\$1/, valueEncoded).replace(encodeURIComponent('/'), '/');

						return '<a href="' + href + '" class="wds-global-navigation__dropdown-link">' +
							value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') +
							'</a>';
					}
				});
			});
		}

		$searchInput.one('focus', function () {
			initSuggestions();

			$searchInput.bind({
				'suggestShow': function () {
					$searchInputWrapper.addClass('wds-is-active');
				},
				'suggestHide': function () {
					$searchInputWrapper.removeClass('wds-is-active');
				}
			});
		});

		if ($searchInput.is(':focus')) {
			initSuggestions();
		}
	}
);
