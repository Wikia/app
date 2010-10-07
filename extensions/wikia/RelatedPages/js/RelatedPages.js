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
		var module = $('.RelatedPagesModule');

		// move the module after (at least) 3rd <h2> section
		var addAfter = 3;

		// get 2nd level headings
		var sections = content.find('.mw-headline').parent().filter('h2');

		// remove headings with floating element next to it (starting from fourth)
		var filteredSections = sections.slice(addAfter).filter(function() {
			var heading = $(this);
			return heading.width() > 650;
		});

		this.log('found ' + sections.length + ' section(s)');

		// section found - move Related Pages module before it
		if (filteredSections.exists()) {
			var section = filteredSections.first();
			var sectionId = sections.index(section) + 1;

			this.log('moving before #' + sectionId + ' section (' + section.children().first().html() + ')');

			module.insertBefore(section);
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