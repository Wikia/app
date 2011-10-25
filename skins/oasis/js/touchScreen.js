touchImprovements = {
	
	init: function() {
		
		//onload scroll to main content
		var wikiaMainContent = $('#WikiaMainContent').offset(),
		wikiUls = $('#WikiHeader nav > ul > li > ul'),
		globalUls = $('#GlobalNavigation li > ul');
		
		window.scrollTo(0, wikiaMainContent.top);

		//global nav fix: first click opens nav,  second redirects to a hub
		$('#GlobalNavigation').delegate('li > a', 'click', function(event) {
			var next = $(this).next();
			if (!next.hasClass('open')) {
				event.preventDefault();
				globalUls.removeClass('open'); 
				next.addClass('open');
			};
		});
		

		//wiki nav fix: first click opens nav, second redirects to a desired page
		$('#WikiHeader').delegate('nav > ul > li > a', 'click', function(event) {
			var subnav = $(this).next('ul');
			if (subnav.length && !subnav.hasClass('open')) {
				event.preventDefault();
				wikiUls.removeClass('open');
				subnav.addClass('open');
			};
		});
		
		//user menu fix:
		$('#AccountNavigation').delegate('li > a[accesskey="."]', 'click', function(event) {
			var next = $(this).next('ul.subnav');
			if (next && !next.hasClass('open')) {
				event.preventDefault();
				next.addClass('open');
			};
		});
	}
};

$(document).ready(function() {
	touchImprovements.init();
});
