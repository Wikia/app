//result links click tracking
$(function() {
	$('.mw-search-result-title').bind('click', function() {
		var element = $(this);
		$.internalTrack('search_click', {
			'pos': element.attr('data-pos'),
			'sterm': element.attr('data-sterm'),
			'stype': element.attr('data-stype'),
			'rver': element.attr('data-rver')
		});
	});
});
