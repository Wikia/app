$(function() {
	    RelatedPages.init.call(RelatedPages);
});

RelatedPages = {
	log: function(msg) {
		$().log(msg, 'RelatedPages');
	},
	init: function() {
		this.log('init');

		var content = $('#WikiaArticle');
		var module = $('.RelatedPagesModule');

		// get 2nd level headings
		var sections = content.find('.mw-headline').parent().filter('h2');

		// remove headings with floating element next to it (starting from fourth)
		var filteredSections = sections.slice(3).filter(function() {
			var heading = $(this);
			return heading.width() > 650;
		});

		this.log(sections);	this.log(filteredSections);	this.log(module);

		if (filteredSections.exists()) {
			var section = filteredSections.first();
			var sectionId = sections.index(section) + 1;

			this.log('moving before #' + sectionId + ' section (' + section.children().first().html() + ')');

			module.insertBefore(section);
		}
		else if (sections.exists()) {
			this.log('collision detected');
		}
		else {
			this.log('article is too short');
		}
	}
}