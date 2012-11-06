jQuery(function( $ ) {

var action = window.wgAction,
	wgCategorySelect = window.wgCategorySelect;

// This file is included on every page, but should only run on view or purge.
if ( !wgCategorySelect || ( action != 'view' && action != 'purge' ) ) {
	return;
}

var $wrapper = $( '#WikiaArticleCategories' );

// Lazy load CategorySelect
$wrapper.one( 'click', function( event ) {
	$.getResource( wgResourceBasePath + '/extensions/wikia/CategorySelect/js/CategorySelect.js' ).done(function() {
		// TODO
	});
});

// Popovers for already existing categories
// TODO

});