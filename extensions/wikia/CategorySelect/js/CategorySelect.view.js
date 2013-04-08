(function( window, $, mw ) {
	var action = window.wgAction,
		wgCategorySelect = window.wgCategorySelect;

	// This file is included on every page, but should only run on view or purge.
	if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
		return;
	}

	$(function() {
		var articleId = window.wgArticleId,
			loaded = false,
			namespace = 'categorySelectView',
			$wrapper = $( '#WikiaArticleCategories' );

		// User can't edit, no need to bind anything
		if ( !$wrapper.hasClass( 'userCanEdit' ) ) {
			return;
		}

		$wrapper.on( 'click.' + namespace, '.add', function() {
			$wrapper
				.addClass( 'editMode' )
				.find( '.input' )
				.focus();

			if ( !loaded ) {
				loaded = true;

				$.when(
					mw.loader.use( 'jquery.ui.autocomplete' ),
					mw.loader.use( 'jquery.ui.sortable' ),
					$.getResources([
						wgResourceBasePath + '/resources/wikia/libraries/mustache/mustache.js',
						wgResourceBasePath + '/extensions/wikia/CategorySelect/js/CategorySelect.js'
					])

				).done(function( response ) {
					$wrapper.categorySelect({
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

					}).on( 'add', function( event, cs, data ) {
						$wrapper
							.find( '.last' )
							.before( data.element );
					}).on( 'click.' + namespace, '.cancel', function() {
						$wrapper
							.removeClass( 'editMode' )
							.trigger( 'reset' )
							.find( '.category.new' )
							.remove();

					}).on( 'click.' + namespace, '.save', function() {
						var $container = $wrapper.find( '.container' ).startThrobbing(),
							$saveButton = $( this ).attr( 'disabled', true );
						
						$.nirvana.sendRequest({
							controller: 'CategorySelectController',
							data: {
								articleId: articleId,
								categories: $wrapper.data( 'categorySelect' ).getData( '.new' )
							},
							method: 'save'

						}).done(function( response ) {
							$container.stopThrobbing();

							// TODO: don't use alert
							if ( response.error ) {
								alert( response.error );

							} else {
								$wrapper
									.removeClass( 'editMode' )
									.find( '.category' ).remove();

								$wrapper
									.find( '.last' )
									.before( response.html );

								$wrapper
									.find( '.input' )
									.val( '' );
							}
						});

					}).on( 'update', function() {
						var modified = $wrapper.find( '.category.new' ).length > 0;
						
						$wrapper
							.toggleClass( 'modified', modified )
							.find( '.save' )
							.prop( 'disabled', !modified );
					});
				});
			}
		});
	});

})( window, window.jQuery, window.mw );