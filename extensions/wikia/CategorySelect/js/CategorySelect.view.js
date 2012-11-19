(function( window, $ ) {
	var action = window.wgAction,
		wgCategorySelect = window.wgCategorySelect;

	// This file is included on every page, but should only run on view or purge.
	if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
		return;
	}

	$(function() {
		var $wrapper = $( '#CategorySelect' ),
			$categories = $wrapper.find( '.categories' );

		// Lazy loads required resources and initializes $.fn.categorySelect on wrapper
		function lazyLoadResources() {
			var dfd = new $.Deferred();

			$.when(
				mw.loader.use( 'jquery.ui.autocomplete' ),
				$.getResources([
					wgResourceBasePath + '/extensions/wikia/CategorySelect/js/CategorySelect.js',
					wgResourceBasePath + '/resources/wikia/libraries/mustache/mustache.js'
				])
			).done(function() {
				$wrapper.categorySelect({
					categoryInsertMethod: 'append',
					data: wgCategorySelect.categories
				});

				dfd.resolve();
			});

			return dfd.promise();
		}

		// Set up category adding

	});
})( this, jQuery );