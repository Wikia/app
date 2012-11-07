jQuery(function( $ ) {
	var action = window.wgAction,
		wgCategorySelect = window.wgCategorySelect;

	// This file is included on every page, but should only run on view or purge.
	if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
		return;
	}

	var $wrapper = $( '#WikiaArticleCategories' );

	// Lazy loads required resources and initializes $.fn.categorySelect on wrapper
	function lazyLoadResources() {
		var dfd = new $.Deferred();

		$.when(
			mw.loader.use( 'jquery.ui.autocomplete' ),
			$.getResource( wgResourceBasePath + '/extensions/wikia/CategorySelect/js/CategorySelect.js' )

		).done(function() {
			$wrapper.categorySelect({
				data: wgCategorySelect.categories
			});

			dfd.resolve();
		});

		return dfd.promise();
	}
});