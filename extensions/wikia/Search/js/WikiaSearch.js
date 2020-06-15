(function($, window) {

require(['search-tracking', 'uuid', 'wikia.trackingOptIn'], function(searchTracking, uuid, trackingOptIn) {
	var currentScope = $('#search-v2-scope').val();

	var resultClickTrackerFactory = function (type, idGenerator, filters) {
		return function(clickedElement) {
			var queryparams = new URL(window.location).searchParams;
			var query = queryparams.get('search') || queryparams.get('query');

			var payload = {
				searchPhrase: query || '',
				filters: filters,
				clicked: {
					type: type,
					id: idGenerator(clickedElement),
					title: clickedElement.getAttribute('data-name'),
					position: parseInt(clickedElement.getAttribute('data-pos')),
					thumbnail: !!clickedElement.getAttribute('data-thumbnail'),
				},
				target: 'redirect',
				app: 'mw-desktop',
				siteId: parseInt(window.wgCityId),
				searchId: getUniqueSearchId(),
				pvUniqueId: window.pvUID || 'dev', // on dev there is no pvUID available
			};

			trackingOptIn.pushToUserConsentQueue(function () {
				window.searchTracking.trackSearchClicked(payload);
			});
		}.bind(this);
	};

	var getUniqueSearchId = function() {
		if (!this.searchUID) {
			var queryParams = new URL(window.location).searchParams;

			this.searchUID = queryParams.get('searchUID') || uuid();
		}

		return this.searchUID;
	};

	var WikiaSearch = {
		searchUID: null,

		init: function() {
			$('form#powersearch input[name=title]').val('Special:WikiaSearch');

			var hiddenInputs = $('input.default-tab-value');
			$('section.AdvancedSearch input[type="checkbox"]').change(function() {
				hiddenInputs.remove();
			});

			var advancedDiv = $('#AdvancedSearch'),
				advancedCheckboxes = advancedDiv.find('input[type="checkbox"]');

			var advancedOptions = false;
			if ( window.location.hash && window.location.hash == '#advanced' ) {
				advancedDiv.slideToggle('fast');
				advancedOptions = !advancedOptions;
			}

			$('#advanced-link').on('click', function(e) {
				e.preventDefault();
				advancedDiv.slideToggle('fast', function() {
					advancedOptions = !advancedOptions;
				});
			});

			$('#mw-search-select-all').click(function(){
				if ($(this).attr('checked')) {
					advancedCheckboxes.attr('checked', 'checked');
				} else {
					advancedCheckboxes.attr('checked', false);
				}
			});

			$('.result .result-link:not(.community-result-link)').on('click', function(event) {
				this.trackSearchResultClick(event.target);
			}.bind(this));

			$('.WikiaSearchResultItemSitename a').on('click', function(event) {
				this.trackSearchResultCommunityClick(event.target);
			}.bind(this));

			$('.exact-wiki-match__result a').on('click', function(event) {
				this.trackRightRailResultClick(event.target);
			}.bind(this));

			this.initVideoTabEvents();
			this.trackSearchResultsImpression();
			this.searchScopeEvents();

			$('#search-v2-form').submit( function() {
				if ( advancedOptions && this.action.indexOf( '#advanced' ) < 0 ) {
					this.action += 'advanced';
				}
				if ( !advancedOptions ) {
					this.action = this.action.split('#')[0];
					this.action += '#';
				}
			});
		},
		initVideoTabEvents: function() {
			var videoFilterOptions = $('.search-filter-sort');

			if(!videoFilterOptions.length) {
				return;
			}

			videoFilterOptions.find('.search-filter-sort-overlay').remove();

			var searchForm = $('#search-v2-form'),
				videoRadio = $('#filter-is-video'),
				videoOptions = videoRadio.parent().next(),
				filterInputs = $('input[type="radio"][name="filters[]"]');

			// Show and hide video filter options when radio buttons change.
			filterInputs.on('change', function() {
				if(videoRadio.is(':checked')) {
					videoOptions
						.find('input') // only re-enable inputs, we'll handle the select input separately
						.attr('disabled', false);
				} else {
					videoOptions
						.find('input, select')
						.attr('disabled', true)
						.attr('checked', false);
				}
				// Refresh search results
				searchForm.submit();
			});

			// If the input isn't handled above, do a form submit
			videoFilterOptions.find('input, select').not(filterInputs).on('change', function() {
				// Refresh search results
				searchForm.submit();
			});

		},
		trackSearchResultClick: resultClickTrackerFactory(
			'article',
			function (clickedElement) {
				return clickedElement.getAttribute('data-wiki-id') + '_' + clickedElement.getAttribute('data-page-id');
			},
			{
				searchType: currentScope
			}
		),
		trackSearchResultCommunityClick: resultClickTrackerFactory(
			'community',
			function (clickedElement) {
				return clickedElement.getAttribute('data-wiki-id');
			},
			{
				searchType: currentScope
			}
		),
		trackRightRailResultClick: resultClickTrackerFactory(
			'community',
			function (clickedElement) {
				return clickedElement.getAttribute('data-wiki-id');
			},
			{}
		),
		trackSearchResultsImpression: function() {
			var queryparams = new URL(window.location).searchParams;
			var query = queryparams.get('search') || queryparams.get('query');

			var results = this.getSearchResults();
			var searchUID = getUniqueSearchId();
			this.appendSearchUidToPaginationLinks(searchUID);

			var payload = {
				searchPhrase: query  || '',
				filters: {
					searchType: currentScope
				},
				results: results,
				page: parseInt(queryparams.get('page')) || 1,
				limit: results.length,
				sortOrder: 'default',
				app: 'mw-desktop',
				siteId: parseInt(window.wgCityId),
				searchId: searchUID,
				pvUniqueId: window.pvUID || "dev", // on dev there is no pvUID available
			};

			trackingOptIn.pushToUserConsentQueue(function () {
				window.searchTracking.trackSearchImpression(payload);
			});
		},
		getSearchResults: function() {
			var $results = $('h1 a.result-link[data-page-id]');

			return $results.map(function(index, item) {
				return {
					id: item.getAttribute('data-wiki-id') + '_' + item.getAttribute('data-page-id'),
					title: item.text,
					position: parseInt(item.getAttribute('data-pos')),
					thumbnail: !!item.getAttribute('data-thumbnail'),
				};
			}).toArray();
		},
		appendSearchUidToPaginationLinks: function(searchUID) {
			$('a.paginator-prev, a.paginator-next, a.paginator-page').each(function() {
				var $elem = $(this);
				var originalUrl = $elem.attr('href');
				var modifiedUrl = new URL(originalUrl);

				modifiedUrl.searchParams.append('searchUID', searchUID);
				$elem.attr('href', modifiedUrl);
			});
		},
		searchScopeEvents: function() {
			var searchForm = $('#search-v2-form'),
				scopes = $('.SearchInput .wds-list a');

			scopes.on('click', function(e) {
				var value = $(e.target).attr('data-value');

				searchForm.find('#search-v2-scope').val(value);
				searchForm.submit();
			});
		},
	};


	$(function() {
		WikiaSearch.init();
	});

});

})(jQuery, this);
