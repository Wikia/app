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
					$.tracker.byStr('search/result/click/pos/'+element.attr('data-pos'));

					var eventName = (typeof element.attr('data-event') == 'undefined') ? 'search_click' : element.attr('data-event');
					WikiaTracker.trackEvent(
						eventName,
						{
							'pos': element.attr('data-pos'),
							'sterm': element.attr('data-sterm'),
							'stype': element.attr('data-stype'),
							'rver': element.attr('data-rver'),
							'pageid': element.attr('data-pageid'),
							'pagens': element.attr('data-pagens'),
							'title': element.attr('data-title')
							'href': element.attr('href')
						},
						'internal'
					);
				}
			});
		});
	}
};
