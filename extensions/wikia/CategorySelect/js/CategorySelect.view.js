(function( window, $ ) {
	var action = window.wgAction,
		wgCategorySelect = window.wgCategorySelect;

	// This file is included on every page, but should only run on view or purge.
	if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
		return;
	}

	$(function() {
		var articleId = window.wgArticleId,
			$wrapper = $( '#WikiaArticleCategories' ),
			$categories = $wrapper.find( '.categories' ),
			categoryPrefix = wgCategorySelect.defaultNamespace + wgCategorySelect.defaultSeparator;

		function initialize( event ) {
			var dfd = new $.Deferred();

			$.when(
				mw.loader.use( 'jquery.ui.autocomplete' ),
				$.getResources([
					wgResourceBasePath + '/extensions/wikia/CategorySelect/js/CategorySelect.js',
					wgResourceBasePath + '/resources/wikia/libraries/mustache/mustache.js'
				])
			).done(function() {
				var options = {
					data: wgCategorySelect.categories
				};

				if ( event ) {
					options.event = event;
				}

				$wrapper.categorySelect( options )
					.on( 'add.categorySelect', function( event, data ) {
						var category = data.template.data.category;

						category.link = mw.util.wikiGetlink( categoryPrefix + category.name );
						data.element.append( Mustache.render( data.template.content, data.template.data ) );

					}).on( 'remove.categorySelect', function( event, data ) {
						data.element.remove();
					});

				dfd.resolve();
			});

			return dfd.promise();
		}

		function saveCategories( event, data ) {

		}

		$wrapper.one( 'focus', '.addCategory', initialize );
	});
})( this, jQuery );