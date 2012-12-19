(function( window, $, mw ) {
	var action = window.wgAction,
		wgCategorySelect = window.wgCategorySelect;

	// This file is included on every page, but should only run on view or purge.
	if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
		return;
	}

	$(function() {
		var $wrapper = $( '#WikiaArticleCategories' ),
			$addCategory = $wrapper.find( '.add' ),
			$categories = $wrapper.find( '.categories' ),
			$input = $wrapper.find( '.input' ),
			$newCategories = $wrapper.find( '.newCategories' ),
			articleId = window.wgArticleId,
			categoryLinkPrefix = wgCategorySelect.defaultNamespace +
				wgCategorySelect.defaultSeparator,
			namespace = 'categorySelect';

		function add( event ) {
			$addCategory.addClass( 'hide' );
			$input.removeClass( 'hide' ).focus();
		}

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
					//selectors: {
					//	sortable: '.newCategories'
					//},
					sortable: {
						axis: false,
						forcePlaceholderSize: true,
						revert: 200
					}

				}).on( 'add.' + namespace, function( event, cs, data ) {
					$categories.append( data.element );

				}).on( 'update.' + namespace, function( event ) {
					$wrapper.toggleClass( 'modified', $categories.find( '.new' ).length > 0 );
				});
			});
		}

		$wrapper.find( '.cancel' ).on( 'click.' + namespace, function( event ) {
			$newCategories.empty();
			$wrapper.removeClass( 'modified' ).trigger( 'reset' );
		});

		$wrapper.find( '.save' ).on( 'click.' + namespace, function( event ) {
			var $saveButton = $( this ).attr( 'disabled', true );

			$.nirvana.sendRequest({
				controller: 'CategorySelectController',
				data: {
					articleId: articleId,
					categories: $wrapper.data( 'categorySelect' ).getData()
				},
				method: 'save'

			}).done(function( response ) {
				$saveButton.removeAttr( 'disabled' );

				// TODO: don't use alert
				if ( response.error ) {
					alert( response.error );

				} else {
					$wrapper.removeClass( 'modified' );

					// Linkify the new categories
					$newCategories.find( '.category' ).each(function( i ) {
						var $category = $( this ).detach(),
							category = $category.data( 'category' ),
							$link = $( '<a>' );

						// Make sure first character in name is uppercased
						category.name = category.name.charAt( 0 ).toUpperCase() + category.name.slice( 1 );

						$link
							.addClass( 'name' )
							.attr( 'href', mw.util.wikiGetlink( categoryLinkPrefix + category.name ) )
							.text( category.name );

						$category
							.removeClass( 'new' )
							.find( '.name' )
							.replaceWith( $link )

						$categories.append( $category );
					});
				}
			});
		});

		$input.one( 'focus.' + namespace, initialize );
	});

})( window, window.jQuery, window.mw );