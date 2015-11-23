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
				$legendElements = $('.collapsible').find('legend');

			function toggleCollapsible($target) {
				$target.toggleClass('collapsed');
				updateCollapsedCache($target);
			}

			function updateCollapsedCache($target) {
				var id = $target.attr('id');

				if (id !== null) {
					if ($target.hasClass('collapsed')) {
						cache.del(prefix + id);
					} else {
						cache.set(prefix + id, 'expand', cache.CACHE_LONG);
					}
				}
			}

			$legendElements.each( function () {
				var $this = $(this),
					id = $this.attr('id');

				if (id !== null) {
					if (!!cache.get(prefix + id)) {
						toggleCollapsible($this.parent());
					}
				}
			});

			$legendElements.on('click', function(e) {
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
