/* JavaScript for Special:RecentChanges */
( function( $ ) {

	var checkboxes = [ 'nsassociated', 'nsinvert' ];

	/**
	 * @var select {jQuery}
	 */
	var $select = null;

	var rc = mw.special.recentchanges = {

		handleCollapsible: function() {
			var prefix = 'rce_',
				$legendElements = $('.collapsible').find('legend');

			$legendElements.each( function (i) {
				var $this = $(this),
					id = $this.attr('id');

				if (id !== null) {
					if (!!localStorage.getItem(prefix + id)) {
						toggleCollapsible($this);
					}
				}
			});

			$legendElements.on('click', function(e) {
				toggleCollapsible($(e.currentTarget).parent());
			});

			function toggleCollapsible($target) {
				$target.toggleClass('collapsed');
				updateCollapsedCache($target);
			}

			function updateCollapsedCache($target) {
				var id = $target.attr('id');

				if (id !== null) {
					if ($target.hasClass('collapsed')) {
						localStorage.removeItem(prefix + id);
					} else {
						localStorage.getItem(prefix + id); // Chrome bug
						localStorage.setItem(prefix + id, true);
					}
				}
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

			// Collapse fieldsets
			rc.handleCollapsible();
		}
	};

	// Run when document is ready
	$( rc.init );

})( jQuery );
