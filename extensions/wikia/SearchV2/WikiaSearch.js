jQuery(document).ready(function(){
	jQuery('form#powersearch input[name=title]').val('Special:WikiaSearch');
});

//result links click tracking
jQuery(document).ready(function() {
	$('.ResultLink').bind('click', function() {
		if( typeof $.tracker == 'undefined' ) {
			return true;
		}
		else {
			var element = $(this);
			$.tracker.byStr('search/result/click/pos/'+element.attr('data-pos'));

			var eventName = (typeof element.attr('data-event') == 'undefined') ? 'search_click' : element.attr('data-event');
			$.internalTrack(eventName, {
				'pos': element.attr('data-pos'),
				'gpos': element.attr('data-gpos'),
				'sterm': element.attr('data-sterm'),
				'stype': element.attr('data-stype'),
				'rver': element.attr('data-rver'),
				'pageid': element.attr('data-pageid'),
				'pagens': element.attr('data-pagens'),
				'title': element.attr('data-title')
			});
		}
	});
});