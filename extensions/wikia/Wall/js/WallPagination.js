(function($) {

Wall.Pagination = $.createClass(Observable, {
	constructor: function(page, model) {
		Wall.Pagination.superclass.constructor.apply(this, arguments);

		this.page = page;
		this.model = model;

		this.$wall = $('#Wall');
		this.$page = this.$wall.find('.comments, .ThreadList');

		this.$wall.on('click', '.Pagination a', this.proxy(this.switchPage));

		this.model.pageController = this.$wall.find('.Pagination').attr('data-controller') || this.model.pageController; 
		this.model.bind('pageLoaded', this.proxy(this.onPageLoaded));
	},

	switchPage: function(e) {
		var page = $(e.target).closest('li').attr('data-page');

		this.$page.animate({ opacity: 0.5 }, 'slow');
		this.model.loadPage(this.page, page);

		e.preventDefault();
	},

	onPageLoaded: function(page, pagination) {
		this.scrollUp();
		
		this.$page.html(page.html()).animate({ opacity: 1 }, 'slow');
		this.$wall.find('.Pagination').html(pagination.html());
		this.fire('afterPageLoaded');			
	},

	scrollUp: function() {
		var destination = this.$wall.offset().top - 15;

		// MSIE needs document and no animation (too slow)
		if ($.browser.msie) {
			$(document).scrollTop(destination);

		// Webkit needs body, Gecko needs html
		// Checking for :animated prevents duplicate animations in Gecko
		} else {
			$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination }, 500);
		}		
	}
});

// Set as default class binding for Pagination
Wall.settings.classBindings.pagination = Wall.Pagination;

})(jQuery);