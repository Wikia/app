/* JavaScript for Special:RecentChanges */
( function( $ ) {

	var checkboxes = [ 'nsassociated', 'nsinvert' ];

	/**
	 * @var select {jQuery}
	 */
	var $select = null;

	var rc = mw.special.recentchanges = {

		handleCollapsible: function(cache) {
			var prefix = 'rc_',
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

			require(['wikia.cache'], function (cache) {
				// Collapse fieldsets
				rc.handleCollapsible(cache);
			});
		}
	};

	// Run when document is ready
	$( rc.init );

})( jQuery );
