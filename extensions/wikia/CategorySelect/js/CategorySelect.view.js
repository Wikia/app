(function( window, $, mw ) {
	var action = window.wgAction,
		wgCategorySelect = window.wgCategorySelect;

	// This file is included on every page, but should only run on view or purge.
	if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
		return;
	}

	$(function() {
		var $wrapper = $( '#WikiaArticleCategories' )
			$add = $wrapper.find( '.add' ),
			$cancel = $wrapper.find( '.cancel' ),
			$categories = $wrapper.find( '.categories' ),
			$container = $wrapper.find( '.container' ),
			$input = $wrapper.find( '.input' ),
			$last = $wrapper.find( '.last' ),
			$save = $wrapper.find( '.save' ),
			articleId = window.wgArticleId,
			categoryLinkPrefix = wgCategorySelect.defaultNamespace +
				wgCategorySelect.defaultSeparator,
			loaded = false,
			namespace = 'categorySelect';

		// User can't edit, no need to bind anything
		if ( !$wrapper.hasClass( 'userCanEdit' ) ) {
			return;
		}

		$add.on( 'click.' + namespace, function() {
			$wrapper.addClass( 'editMode' );
			$input.focus();

			if ( !loaded ) {
				loaded = true;

				$.when(
					$.nirvana.sendRequest({
						controller: 'CategorySelectController',
						data: {
							articleId: articleId,
						},
						method: 'getArticleCategories'
					}),
					mw.loader.use( 'jquery.ui.autocomplete' ),
					mw.loader.use( 'jquery.ui.sortable' ),
					$.getResources([
						wgResourceBasePath + '/resources/wikia/libraries/mustache/mustache.js',
						wgResourceBasePath + '/extensions/wikia/CategorySelect/js/CategorySelect.js'
					])

				).done(function( response ) {
					$wrapper.categorySelect({
						categories: response[ 0 ].categories,
						placement: 'right',
						popover: {
							hint: true
						},
						sortable: {
							axis: false,
							forcePlaceholderSize: true,
							items: '.new',
							revert: 200
						}

					}).on( 'add.' + namespace, function( event, cs, data ) {
						$last.before( data.element );

					}).on( 'update.' + namespace, function() {
						var modified = $categories.find( '.new' ).length > 0;

						$wrapper.toggleClass( 'modified', modified );
						$save.prop( 'disabled', !modified );
					});
				});
			}
		});

		$cancel.on( 'click.' + namespace, function( event ) {
			$categories.find( '.new' ).remove();
			$wrapper.removeClass( 'editMode' ).trigger( 'reset' );
		});

		$save.on( 'click.' + namespace, function( event ) {
			var $saveButton = $( this ).attr( 'disabled', true );

			$container.startThrobbing();

			$.nirvana.sendRequest({
				controller: 'CategorySelectController',
				data: {
					articleId: articleId,
					categories: $wrapper.data( 'categorySelect' ).getData( '.new' )
				},
				method: 'save'

			}).done(function( response ) {
				$container.stopThrobbing();
				$saveButton.removeAttr( 'disabled' );

				// TODO: don't use alert
				if ( response.error ) {
					alert( response.error );

				} else {
					$wrapper.removeClass( 'editMode' );

					// Update the saved categories
					$categories.find( '.new' ).each(function() {
						var $category = $( this ),
							category = $category.data( 'category' ),
							current = response.categories[ $category.index() ],
							$link;

						// Category has been removed
						if ( !current || current.name !== category.name ) {
							$category.remove();

						// Linkify the category
						} else {
							$link = $( '<a>' )
								.addClass( 'name' )
								.attr( 'href', mw.util.wikiGetlink( categoryLinkPrefix + category.name ) )
								.text( category.name );

							$category
								.removeClass( 'new' )
								.find( '.name' )
								.replaceWith( $link );
						}
					});
				}
			});
		});
	});

})( window, window.jQuery, window.mw );