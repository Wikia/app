/* moved to optimizely
$(function() {
	$( '#GlobalNavigation' ).addClass( 'vertical-colors' );

	var GlobalSearch = {
		header: $( '#WikiaHeader' ),
		addSearch: function () {
			var li = $('<li>' ),
				form = $('<form>' )
					.addClass( 'search-form' )
					.attr( 'method', 'get' )
					.attr( 'action', window.wgGlobalSearchUrl );

			$('<input>')
				.addClass( 'search-box' )
				.attr( 'type', 'text' )
				.attr( 'accesskey', 'f' )
				.attr( 'autocomplete', 'off' )
				.attr( 'name', 'search' )
				//TODO i18n
				.attr( 'placeholder', 'Search for topics brand and content' )
				.appendTo( form );
			$('<input>' )
				.attr( 'type', 'hidden' )
				.attr( 'name', 'resultsLang')
				.val( window.wgUserLanguage)
				.appendTo( form );
			$('<input>')
				.addClass( 'search-button' )
				.attr( 'type', 'submit' )
				// TODO i18n
				.val( 'Search all Wikia' )
				.appendTo( form );

			li.append( form );
			this.header.find( '.start-a-wiki' ).after( li );
		},
		addCollapsedSearch: function() {
			this.addSearch();
			this.header.find( '.search-form' ).addClass( 'search-collapsed' );
			this.header.find( '.search-button' ).addClass( 'search-icon' );
		},
		addSmallCollapsedSearch: function() {
			this.addSearch();
			this.header.find( '.search-form' ).addClass( 'search-collapsed' );
			// TODO i18n
			this.header.find( '.search-box' ).attr( 'placeholder', 'Search...' ).addClass( 'search-small' );
			this.header.find( '.search-button' ).addClass( 'search-icon' );
		},
		addSmallSearch: function() {
			this.addSearch();
			// TODO i18n
			this.header.find( '.search-box' ).attr( 'placeholder', 'Search...' ).addClass( 'search-small' );
			$('<input>')
				.addClass( 'search-button' )
				.addClass( 'alternative' )
				.attr( 'type', 'submit' )
				// TODO i18n
				.val( 'Search this Wikia' )
				.click(
					function() { $(this ).parents( 'form:first' ).attr( 'action', $( '#WikiaSearch' ).attr( 'action' ) ); }
				)
				.insertAfter( this.header.find( '.search-button' ) );
		}
	};

	$( '#search-v2-form' ).find( '.SearchInput' ).remove();
});
*/
