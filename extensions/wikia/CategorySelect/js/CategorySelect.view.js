(function( window, $ ) {
	var action = window.wgAction,
		wgCategorySelect = window.wgCategorySelect;

	// This file is included on every page, but should only run on view or purge.
	if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
		return;
	}

	$(function() {
		var articleId = window.wgArticleId,
			categoryPrefix = wgCategorySelect.defaultNamespace + wgCategorySelect.defaultSeparator,
			namespace = 'categorySelect',
			originalLength = wgCategorySelect.categories.length,
			$wrapper = $( '#WikiaArticleCategories' ),
			$categories = $wrapper.find( '.categories' );

		function cancel( event ) {
			$wrapper.removeClass( 'modified' ).trigger( 'reset' );
			$categories.find( '.new' ).remove();
		}

		function initialize( event ) {
			$.when(
				mw.loader.use( 'jquery.ui.autocomplete' ),
				$.getResources([
					wgResourceBasePath + '/extensions/wikia/CategorySelect/js/CategorySelect.js',
					wgResourceBasePath + '/resources/wikia/libraries/mustache/mustache.js'
				])

			).done(function() {
				$wrapper.categorySelect({
					data: wgCategorySelect.categories,
					event: event
				})
				.on( 'add.' + namespace, function( event, state, data ) {
					var category = data.template.data.category;

					category.link = mw.util.wikiGetlink( categoryPrefix + category.name );
					data.element.append( Mustache.render( data.template.content, data.template.data ) );

				}).on( 'remove.' + namespace, function( event, state, data ) {
					data.element.remove();

				}).on( 'update.' + namespace, function( event, state ) {
					$wrapper.toggleClass( 'modified', state.length != originalLength );
				});
			});
		}

		function save( event, data ) {

		}

		// Listeners
		$wrapper
			.on( 'click', '.cancel', cancel )
			.on( 'click', '.save', save )
			.one( 'focus', '.addCategory', initialize );
	});
})( this, jQuery );