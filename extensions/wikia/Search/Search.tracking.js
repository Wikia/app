//result links click tracking
var SearchClickTracking = {
	init: function() {
		$(function() {
			$('.mw-search-result-title').bind('click', function(event) {
				if( typeof $.tracker == 'undefined' ) {
					return true;
				}
				else {
					event.preventDefault();
					var element = $(this);
					var callback = function() {
						$().log('Result click tracked, redirecting ..');
						window.location.href = element.attr('href');
					};
					$.tracker.byStr('search/result/click/pos/'+element.attr('data-pos'));
					$.internalTrack('search_click', {
						'pos': element.attr('data-pos'),
						'sterm': element.attr('data-sterm'),
						'stype': element.attr('data-stype'),
						'rver': element.attr('data-rver'),
						'pageid': element.attr('data-pageid'),
						'pagens': element.attr('data-pagens'),
						'title': element.attr('data-title')
					}, callback, callback );
				}
			});
		});
	}
};
