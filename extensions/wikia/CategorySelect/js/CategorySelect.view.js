(function( window, $, mw ) {
	var action = window.wgAction,
		wgCategorySelect = window.wgCategorySelect;

	// This file is included on every page, but should only run on view or purge.
	if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
		return;
	}

	$(function() {
		var $wrapper = $( '#WikiaArticleCategories' ),
			$add = $wrapper.find( '.add' ),
			$categories = $wrapper.find( '.categories' ),
			$container = $wrapper.find( '.container' ),
			$input = $wrapper.find( '.input' ),
			articleId = window.wgArticleId,
			categoryLinkPrefix = wgCategorySelect.defaultNamespace +
				wgCategorySelect.defaultSeparator,
			namespace = 'categorySelect';

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
						forcePlaceholderSize: true,
						items: '.new',
						revert: 200
					}

				}).on( 'add.' + namespace, function( event, cs, data ) {
					$add.before( data.element );

				}).on( 'update.' + namespace, function( event ) {
					$wrapper.toggleClass( 'modified', $categories.find( '.new' ).length > 0 );
				});
			});
		}

		$wrapper.find( '.cancel' ).on( 'click.' + namespace, function( event ) {
			$categories.find( '.new' ).remove();
			$wrapper.removeClass( 'modified' ).trigger( 'reset' );
		});

		$wrapper.find( '.save' ).on( 'click.' + namespace, function( event ) {
			var $saveButton = $( this ).attr( 'disabled', true );

			$container.startThrobbing();

			$.nirvana.sendRequest({
				controller: 'CategorySelectController',
				data: {
					articleId: articleId,
					categories: $wrapper.data( 'categorySelect' ).getData()
				},
				method: 'save'

			}).done(function( response ) {
				$container.stopThrobbing();
				$saveButton.removeAttr( 'disabled' );

				// TODO: don't use alert
				if ( response.error ) {
					alert( response.error );

				} else {
					$wrapper.removeClass( 'modified' );

					// Linkify the new categories
					$categories.find( '.new' ).each(function( i ) {
						var $category = $( this ),
							category = $category.data( 'category' ),
							$link = $( '<a>' );

						$link
							.addClass( 'name' )
							.attr( 'href', mw.util.wikiGetlink( categoryLinkPrefix + category.name ) )
							.text( category.name );

						$category
							.removeClass( 'new' )
							.find( '.name' )
							.replaceWith( $link )
					});
				}
			});
		});

		$input.one( 'focus.' + namespace, initialize );
	});

})( window, window.jQuery, window.mw );