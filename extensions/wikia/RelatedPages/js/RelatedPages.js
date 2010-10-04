$(function() {
	    RelatedPages.init.call(RelatedPages);
});

RelatedPages = {
	sections: false,

	log: function(msg) {
		$().log(msg, 'RelatedPages');
	},
	report: function(data) {
		if (/macbre/.test(window.wgServer)) {
			data = data || {};
			data.city = window.wgID;
			data.page = window.wgPageName;
			data.sections = this.sections.length;

			$.get('/stats.php', data);
		}
	},
	init: function() {
		var start = (new Date()).getTime();

		this.log('init');

		var content = $('#WikiaArticle');
		var module = $('.RelatedPagesModule');

		// after which section module can be added
		var addAfter = 3;

		// get 2nd level headings
		this.sections = content.find('.mw-headline').parent().filter('h2');

		// remove headings with floating element next to it (starting from fourth)
		var filteredSections = this.sections.slice(addAfter).filter(function() {
			var heading = $(this);
			return heading.width() > 650;
		});

		this.log('found ' + this.sections.length + ' section(s)');
		//this.log(this.sections); this.log(filteredSections); this.log(module);

		// section found - move Related Pages module before it
		if (filteredSections.exists()) {
			var section = filteredSections.first();
			var sectionId = this.sections.index(section) + 1;

			this.log('moving before #' + sectionId + ' section (' + section.children().first().html() + ')');

			module.insertBefore(section);

			this.report({status: 'moved', sectionId: sectionId});
		}
		// sections found, but none without collision
		else if (this.sections.length > addAfter) {
			this.log('collision detected');

			this.report({status: 'collision'});
		}
		// not enough sections found
		else {
			this.log('article is too short');

			this.report({status: 'too_short'});
		}

		var time = (new Date()).getTime() - start;
		this.log('done in ' + time + ' ms');
	}
}