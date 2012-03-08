var touchImprovements = {

	init: function() {

		//onload scroll to main content
		var globalUls = $('#GlobalNavigation li > ul');

		//global nav fix: first click opens nav,  second redirects to a hub
		$('#GlobalNavigation').delegate('li > a', 'click', function(event) {
			var next = $(this).next();
			if (!next.hasClass('open')) {
				event.preventDefault();
				globalUls.removeClass('open');
				next.addClass('open');
			}
		});

		//user menu fix:
		$('#AccountNavigation').delegate('li > a[accesskey="."]', 'click', function(event) {
			var next = $(this).next('ul.subnav');
			if (next && !next.hasClass('open')) {
				event.preventDefault();
				next.addClass('open');
			}
		});
	}
};

$(touchImprovements.init);