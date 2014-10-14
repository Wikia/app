$( function() {
	var $editor = $('#AbTestEditor');
	var $details = $('#AbTestDetails');
	var $window = $(window);
	var $document = $(document);

	// make sure that details view (on the right side of A/B tests list)
	// get's properly sized
	var doSizing = function() {
		var current = $window.scrollTop();
		if (current < 0) current = 0;
		if (current > $document.height() - $window.height() ) current = $document.height() - $window.height();
		var min_top = $editor.offset().top - current;
		var max_top = $editor.offset().top + $editor.height() - $details.height();
		if (min_top < 10) min_top = 10;
		if (current > max_top ) min_top = max_top - current;
		$details.css('top', min_top);
		var scroll_left = $document.scrollLeft();
		if (scroll_left<0) scroll_left = 0;
		$details.css('left', $editor.offset().left + $editor.width() - scroll_left );
	}

	$window.on('scroll', doSizing);
	$window.resize( doSizing );

	$('td.timeago').timeago();
	$editor.on('click','tr.exp', $.proxy(function(ev) {
		var id = $(ev.target).closest('tr').data()['id'];
		var tr = $(ev.target).closest('tr');
		if( tr.hasClass('selected') ) {
			tr.removeClass('selected');
			$details.hide();
			$editor.css('margin-right', '0');
		} else {
			$('tr.selected', $editor).removeClass('selected');
			tr.addClass('selected');
			var html = $('.details', tr).html();
			$details.html( linkify(html) );
			$details.show();
			$editor.css('margin-right', $details.width() );
			doSizing();
		}
	},this));

})