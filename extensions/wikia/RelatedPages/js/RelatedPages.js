$(function() {
	    RelatedPages.init.call(RelatedPages);
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

		// move the module after (at least) 3rd <h2> section
		var addAfter = 3;

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

			module.insertBefore(sectionMatch);
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
	}
}