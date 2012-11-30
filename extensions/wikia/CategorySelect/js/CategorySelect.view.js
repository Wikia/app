(function( window, $ ) {
	var action = window.wgAction,
		wgCategorySelect = window.wgCategorySelect;

	// This file is included on every page, but should only run on view or purge.
	if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
		return;
	}

	$(function() {
		var categorySelect,
			$wrapper = $( '#WikiaArticleCategories' ),
			$addCategory = $wrapper.find( '.addCategory' ),
			$categories = $wrapper.find( '.categories' ),
			articleId = window.wgArticleId,
			categoryPrefix = wgCategorySelect.defaultNamespace + wgCategorySelect.defaultSeparator,
			namespace = 'categorySelect',
			originalLength = wgCategorySelect.categories.length;

		function initialize( event ) {
			$.when(
				mw.loader.use( 'jquery.ui.autocomplete' ),
				mw.loader.use( 'jquery.ui.sortable' ),
				$.getResources([
					wgResourceBasePath + '/extensions/wikia/CategorySelect/js/CategorySelect.js',
					wgResourceBasePath + '/resources/wikia/libraries/mustache/mustache.js'
				])

			).done(function() {
				$wrapper.categorySelect({
					data: wgCategorySelect.categories,
					sortable: {
						axis: false,
						cursor: 'move',
						tolerance: 'intersect'
					}
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

				categorySelect = $wrapper.data( namespace );
			});
		}

		$wrapper.find( '.cancel' ).on( 'click', function( event ) {
			$wrapper.removeClass( 'modified' ).trigger( 'reset' );
			$categories.find( '.new' ).remove();
		});

		$wrapper.find( '.save' ).on( 'click', function( event ) {
			$.nirvana.sendRequest({
				controller: 'CategorySelectController',
				data: {
					articleId: articleId,
					categories: categorySelect.state.categories
				},
				method: 'save'

			}).done(function( response ) {

				// TODO: don't use alert
				if ( response.error ) {
					alert( response.error );

				} else {
					$wrapper.removeClass( 'modified' );
					$categories.find( '.category' ).removeClass( 'new' );
				}
			});
		});

		// Initialize immediately if addCategory is already in focus
		if ( $addCategory.is( ':focus' ) ) {
			initialize();

		} else {
			$addCategory.one( 'focus', initialize );
		}
	});
})( this, jQuery );