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
			$wrapper = $( '#articleCategories' );

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
					mw.loader.using( 'jquery.ui.autocomplete' ),
					mw.loader.using( 'jquery.ui.sortable' ),
					$.getResources([
						wgResourceBasePath + '/resources/wikia/libraries/mustache/mustache.js',
						wgResourceBasePath + '/extensions/wikia/CategorySelect/js/CategorySelect.js',
						wgResourceBasePath + '/resources/wikia/modules/uifactory.js',
						wgResourceBasePath + '/resources/wikia/modules/uicomponent.js'
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
						track({
							label: 'cancel-edit'
						});

						$wrapper
							.removeClass( 'editMode' )
							.trigger( 'reset' )
							.find( '.category.new' )
							.remove();

					}).on( 'click.' + namespace, '.save', function() {
						track({
							label: 'submit-save'
						});

						var $container = $wrapper.find( '.container' ).startThrobbing();

						$( this ).attr( 'disabled', true );

						$.nirvana.sendRequest({
							controller: 'CategorySelectController',
							data: {
								articleId: articleId,
								categories: $wrapper.data( 'categorySelect' ).getData( '.new' ),
								token: mw.user.tokens.get('editToken')
							},
							method: 'save'
						}).done(function( response ) {
							$container.stopThrobbing();

							if ( response.error ) {
								throw 'Saving error: ' + response.error;
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
						}).fail(function (response) {
							$container.stopThrobbing();

							throw 'Saving error: ' + response.responseText
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

		/**
		 * Helper method for tracking clicks on buttons like save or cancel
		 */
		var track = Wikia.Tracker.buildTrackingFunction( Wikia.trackEditorComponent, {
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'category-tool',
			trackingMethod: 'analytics'
		})
	});

})( window, window.jQuery, window.mw );
