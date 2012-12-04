(function( window, $, mw ) {
	var action = window.wgAction,
		wgCategorySelect = window.wgCategorySelect;

	// This file is included on every page, but should only run on view or purge.
	if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
		return;
	}

	$(function() {
		var $wrapper = $( '#WikiaArticleCategories' ),
			$addCategory = $wrapper.find( '.addCategory' ),
			$categories = $wrapper.find( '.categories' ),
			articleId = window.wgArticleId,
			categoryLinkPrefix = wgCategorySelect.defaultNamespace +
				wgCategorySelect.defaultSeparator;

		function initialize( event ) {
			$.when(
				mw.loader.use( 'jquery.ui.autocomplete' ),
				mw.loader.use( 'jquery.ui.sortable' ),
				$.getResources([
					wgResourceBasePath + '/resources/wikia/libraries/mustache/mustache.js',
					wgResourceBasePath + '/extensions/wikia/CategorySelect/js/CategorySelect.js'
				])

			).done(function() {
				$wrapper.categorySelect({
					categories: wgCategorySelect.categories,
					placement: 'right',
					sortable: {
						axis: false,
						cursor: 'move',
						tolerance: 'intersect'
					}

				}).on( 'update.categorySelect', function( event ) {
					$wrapper.toggleClass( 'modified', $categories.find( '.new' ).length > 0 );
				});
			});
		}

		$wrapper.find( '.cancel' ).on( 'click', function( event ) {
			$wrapper.removeClass( 'modified' ).trigger( 'reset' );
		});

		$wrapper.find( '.save' ).on( 'click', function( event ) {
			$.nirvana.sendRequest({
				controller: 'CategorySelectController',
				data: {
					articleId: articleId,
					categories: $wrapper.data( 'categorySelect' ).getData()
				},
				method: 'save'

			}).done(function( response ) {

				// TODO: don't use alert
				if ( response.error ) {
					alert( response.error );

				} else {
					$wrapper.removeClass( 'modified' );

					// Linkify the new categories
					$categories.find( '.new' ).each(function( i ) {
						var $category = $( this ),
							category = $category.data( 'category' ),
							link = mw.util.wikiGetlink( categoryLinkPrefix + category.name ),
							$link = $( '<a>' )
								.addClass( 'name' )
								.attr( 'href', link )
								.text( category.name );

						$category
							.removeClass( 'new' )
							.find( '.name' )
							.replaceWith( $link );
					});
				}
			});
		});

		// Initialize immediately if addCategory has a value or is in focus
		if ( $addCategory.is( ':focus' ) || $addCategory.val() != '' ) {
			initialize();

		} else {
			$addCategory.one( 'focus', initialize );
		}
	});
})( window, window.jQuery, window.mw );
