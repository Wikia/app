//result links click tracking
$(function() {
	$('.mw-search-result-title').bind('click', function(event) {
		event.preventDefault();

		var callback = function() {
			$().log('Result click tracked, redirecting ..');
			window.location.href = element.attr('href');
		}

		var element = $(this);
		$.tracker.byStr('search/result/click/pos/'+element.attr('data-pos'));
		$.internalTrack('search_click', {
			'pos': element.attr('data-pos'),
			'sterm': element.attr('data-sterm'),
			'stype': element.attr('data-stype'),
			'rver': element.attr('data-rver')
		}, callback, callback );
	});
});
