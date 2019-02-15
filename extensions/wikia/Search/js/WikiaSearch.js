(function($, window) {

require(['uuid', 'search-tracking', 'wikia.trackingOptIn'], function(uuid, searchTracking, trackingOptIn) {
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

			$('.result-link').on('click', function(event) {
				this.trackSearchResultClick(event.target);
			}.bind(this));

			this.initVideoTabEvents();
			this.trackSearchResultsImpression();

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
		trackSearchResultClick: function(clickedElement) {
			var queryparams = new URL(window.location).searchParams;
			var query = queryparams.get('search') || queryparams.get('query');

			if (!query) {
				return;
			}

			var payload = {
				searchPhrase: query,
				clicked: {
					type: 'article', // we don't show wikis results right now
					id: parseInt(clickedElement.getAttribute('data-page-id')),
					title: clickedElement.text,
					position: parseInt(clickedElement.getAttribute('data-pos')),
					thumbnail: !!clickedElement.getAttribute('data-thumbnail'),
				},
				target: 'redirect',
				app: 'mw-desktop',
				siteId: parseInt(window.wgCityId),
				searchId: this.getUniqueSearchId(),
				pvUniqueId: window.pvUID || "dev", // on dev there is no pvUID available
			};

			trackingOptIn.pushToUserConsentQueue(function () {
				searchTracking.trackSearchClicked(payload);
			});
		},
		trackSearchResultsImpression: function() {
			var queryparams = new URL(window.location).searchParams;
			var query = queryparams.get('search') || queryparams.get('query');

			if (!query) {
				return;
			}

			var results = this.getSearchResults();
			var searchUID = this.getUniqueSearchId();
			this.appendSearchUidToPaginationLinks(searchUID);

			var payload = {
				searchPhrase: query,
				filters: {},
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
				searchTracking.trackSearchImpression(payload);
			});
		},
		getSearchResults: function() {
			var $results = $('h1 a.result-link[data-page-id]');

			return $results.map(function(index, item) {
				return {
					id: parseInt(item.getAttribute('data-page-id')),
					title: item.text,
					position: parseInt(item.getAttribute('data-pos')),
					thumbnail: !!item.getAttribute('data-thumbnail'),
				}
			}).toArray();
		},
		getUniqueSearchId: function() {
			if (this.searchUID) {
				return this.searchUID;
			}

			var queryParams = new URL(window.location).searchParams;
			var searchUID = queryParams.get('searchUID') || uuid();
			this.searchUID = searchUID;

			return searchUID;
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
	};


	$(function() {
		WikiaSearch.init();
	});

});

})(jQuery, this);
