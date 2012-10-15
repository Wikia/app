/* Navigation by arrow keys */
$(function() {
	$nav = $( ' .mw-book-navigation ' );
	$prev = $nav.find( ' .mw-prev a ' );
	$next = $nav.find( ' .mw-next a ' );
	if ( $prev.length ) {
		$(document).bind('keydown', 'left', function(){
			location.href = $prev[0].href;
		});
	}
	if ( $next.length ) {
		$(document).bind('keydown', 'right', function(){
			 location.href = $next[0].href;
		});
	}
});
