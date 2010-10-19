$(function() {
	    RelatedPages.init.call(RelatedPages);
	    RelatedPages.attachLazyLoaderEvents();
});

RelatedPages = {
	log: function(msg) {
		$().log(msg, 'RelatedPages');
	},
	init: function() {
		var start = (new Date()).getTime();

		this.log('init');

		var content = $('#WikiaArticle');
		var contentWidth = content.width();

		var module = $('.RelatedPagesModule');

		// move the module after (at least) 2nd <h2> section
		var addAfter = 2;

		// get 2nd level headings
		var sections = content.find('.mw-headline').parent().filter('h2');

		this.log('found ' + sections.length + ' section(s)');

		// find section without collision
		var sectionMatch = false;

		sections.slice(addAfter).each(function() {
			var node = $(this);
			if (node.width() > contentWidth - 10) {
				sectionMatch = node;
				// stop each loop
				return false;
			}
		});

		// section found - move Related Pages module before it
		if (sectionMatch) {
			var sectionId = sections.index(sectionMatch) + 1;

			this.log('moving before #' + sectionId + ' section (' + sectionMatch.children().first().text() + ')');
			module.insertBefore( sectionMatch.prev() /* RT #72977 */);
		}
		// sections found, but none without collision
		else if (sections.length > addAfter) {
			this.log('collision detected');
		}
		// not enough sections found
		else {
			this.log('article is too short (less than ' + addAfter + ' sections)');
		}

		var time = (new Date()).getTime() - start;
		this.log('done in ' + time + ' ms');
	},
	
	scroll_threshold: 300,
	
	attachLazyLoaderEvents: function() {
		$(window).scroll(RelatedPages.updateScroll);
		RelatedPages.updateScroll(); // check if we are already in the visible area
	},
	
	updateScroll: function() {
		var fold = $(window).height() + $(window).scrollTop();
		var topVal = $('.RelatedPagesModule').offset().top;

		if(topVal > 0 && topVal < (fold + RelatedPages.scroll_threshold)) {
			RelatedPages.lazyLoadImages();
		}
	},
	
	lazyLoadImages: function() {
		var images = $('.RelatedPagesModule').find('img').filter('[data-src]');
		images.each(function() {
			var image = $(this);
			image.
				attr('src', image.attr('data-src')).
				removeAttr('data-src');
		});
		$(window).unbind('scroll', RelatedPages.updateScroll);
	}
}