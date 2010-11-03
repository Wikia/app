$(function() {
	    RelatedPages.init.call(RelatedPages);
	    RelatedPages.attachLazyLoaderEvents();
});

RelatedPages = {
	module: false,

	log: function(msg) {
		$().log(msg, 'RelatedPages');
	},
	init: function() {
		this.module = $('.RelatedPagesModule').first();

		// there's no Related Pages module on this page
		if (!this.module.exists()) {
			return;
		}

		//this.log('init');

		var content = $('#WikiaArticle');
		var contentWidth = content.width();

		// move the module after (at least) #x <h2> section (RT #84264)
		var addAfter = parseInt(this.module.attr('data-add-after-section'));

		// module is configured to stay at the bottom of the page
		if (!addAfter) {
			return;
		}

		// get 2nd level headings
		var sections = content.find('.mw-headline').parent().filter('h2');

		//this.log('found ' + sections.length + ' section(s)');

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
			this.module.insertBefore( sectionMatch.prev() /* RT #72977 */);
		}
		// sections found, but none without collision
		else if (sections.length > addAfter) {
			this.log('collision detected');
		}
		// not enough sections found
		else {
			this.log('article is too short (less than ' + addAfter + ' sections)');
		}

		//var time = (new Date()).getTime() - start;
		//this.log('done in ' + time + ' ms');
	},

	scroll_threshold: 300,

	attachLazyLoaderEvents: function() {
		if (RelatedPages.module.exists()) {
			$(window).scroll(RelatedPages.updateScroll);
			RelatedPages.updateScroll(); // check if we are already in the visible area
		}
	},

	updateScroll: function() {
		//RelatedPages.log('updated after scroll');
		var fold = $(window).height() + $(window).scrollTop();
		var topVal = RelatedPages.module.offset().top;

		if(topVal > 0 && topVal < (fold + RelatedPages.scroll_threshold)) {
			RelatedPages.lazyLoadImages();
		}
	},

	lazyLoadImages: function() {
		RelatedPages.log('loading RelatedPages images');
		var images = RelatedPages.module.find('img').filter('[data-src]');
		images.each(function() {
			var image = $(this);
			image.
				attr('src', image.attr('data-src')).
				removeAttr('data-src');
		});
		$(window).unbind('scroll', RelatedPages.updateScroll);
	}
}