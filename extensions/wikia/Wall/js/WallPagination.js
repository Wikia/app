var WallPagination = $.createClass(Observable, {
	page: null,
	pagination: null,
	username: null,
	constructor: function(username, model) {
		WallPagination.superclass.constructor.apply(this,arguments);
		this.username = username;
		this.model = model;
		this.wall = $('#Wall');
		this.page = this.wall.find('.comments');
		this.pagination = this.wall.find('.Pagination');
		this.pagination.on('click', 'a', this.proxy(this.switchPage));
		this.model.bind('pageLoaded', this.proxy(this.onPageLoaded));
	},

	switchPage: function(e) {
		var page = $(e.target).closest('li').attr('data-page');

		this.page.animate({ opacity: 0.5 }, 'slow');
		this.model.loadPage(this.username, page);

		e.preventDefault();
	},

	onPageLoaded: function(page, pagination) {
		this.scrollUp();
		this.page.html(page.html()).animate({ opacity: 1 }, 'slow');
		this.pagination.html(pagination.html());
		this.fire('afterPageLoaded');			
	},

	scrollUp: function() {
		var destination = this.wall.offset().top - 15;

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