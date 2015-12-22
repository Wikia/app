/* JavaScript for Special:RecentChanges */
( function( $ ) {

	var checkboxes = [ 'nsassociated', 'nsinvert' ];

	/**
	 * @var select {jQuery}
	 */
	var $select = null;

	var rc = mw.special.recentchanges = {

		handleCollapsible: function(cache) {
			var prefix = 'rce_',
				$collapsibleElements = $('.collapsible');

			function toggleCollapsible($collapsible) {
				$collapsible.toggleClass('collapsed');
				updateCollapsedCache($collapsible);
			}

			function updateCollapsedCache($collapsible) {
				var id = $collapsible.attr('id');

				if (id !== null) {
					if ($collapsible.hasClass('collapsed')) {
						cache.set(prefix + id, 'collapsed', cache.CACHE_LONG);
					} else {
						cache.set(prefix + id, 'expanded', cache.CACHE_LONG);
					}
				}
			}

			$collapsibleElements.each(function () {
				var $this = $(this),
					id = $this.attr('id');

				if (id !== null) {
					var previousState = cache.get(prefix + id);

					if (!!previousState) {
						if (previousState === 'collapsed') {
							$this.addClass('collapsed');
						} else {
							$this.removeClass('collapsed');
						}
					}
				}
			});

			$collapsibleElements.on('click', 'legend', function(e) {
				toggleCollapsible($(e.currentTarget).parent());
			});
		},

		bindTracking: function(tracker) {
			var $trackedElement = $('#recentchanges-on-wikia-box');

			if ($trackedElement.length > 0) {
				$trackedElement.on('mousedown', 'a', function(e) {
					tracker.track({
						action: tracker.ACTIONS.CLICK_LINK_TEXT,
						category: 'recentchanges-on-wikia',
						label: $(e.currentTarget).attr('href'),
						trackingMethod: 'analytics'
					});
				});
			}
		},

		/**
		 * Handler to disable/enable the namespace selector checkboxes when the
		 * special 'all' namespace is selected/unselected respectively.
		 */
		updateCheckboxes: function() {
			// The option element for the 'all' namespace has an empty value
			var isAllNS = ('' === $select.find('option:selected').val() );

			// Iterates over checkboxes and propagate the selected option
			$.each( checkboxes, function( i, id ) {
				$( '#' + id ).prop( 'disabled', isAllNS );
			});
		},

		init: function() {
			// Populate
			$select = $( '#namespace' );

			// Bind to change event, and trigger once to set the initial state of the checkboxes.
			$select.change( rc.updateCheckboxes ).change();

			require(['wikia.cache', 'wikia.tracker'], function (cache, tracker) {
				// Collapse fieldsets
				rc.handleCollapsible(cache);

				// Track clicks on links in the collapsible box
				rc.bindTracking(tracker);
			});
		}
	};

	// Run when document is ready
	$( rc.init );

})( jQuery );
