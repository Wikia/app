$(function() {
	// Make timestamps dynamic
	$('time.wall-timeago').timeago();
	
	$('.wall-owner').click(function(){
		if( typeof($.tracker) != 'undefined' ) {
			$.tracker.byStr('wikiactivity/wall');
		} else {
			WET.byStr('/wikiactivity/wall');
		}
	});
});