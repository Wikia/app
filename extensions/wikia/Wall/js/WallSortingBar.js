(function(window, $) {

Wall.SortingBar = $.createClass(Observable, {
	constructor: function() {
		this.initElements();
		this.sortingOption.on('click', this.proxy(this.trackClick));
		this.sortingSelected.on('click', this.proxy(this.showSortingMenu));
		this.sortingList.on('mouseleave', this.proxy(this.hideSortingMenu));
	},

	initElements: function() {
		this.sortingOption = $('.SortingOption');
		this.sortingSelected = $('.SortingSelected');
		this.sortingList = $('.SortingList');
	},

	hideSortingMenu: function(event) {
		this.sortingList.hide();
	},

	showSortingMenu: function(event) {
		this.sortingList.show();

		var firstItemOffset = this.sortingList.find('li:first').offset().top,
			currentItemOffset = this.sortingList.find('.current').offset().top,
			newOffset = (currentItemOffset - firstItemOffset) * -1;

		this.sortingList.css('top', newOffset);
	},

	track: function(url) {
		if (typeof($.tracker) != 'undefined') {
			$.tracker.byStr(url);
		} else {
			WET.byStr(url);
		}
	},

	trackClick: function(event) {
		var parent = $(event.target).parent();

		if (parent.hasClass('nt')) {
			this.track('wall/sort/newest-thread');
		} else if (parent.hasClass('ot')) {
			this.track('wall/sort/oldest-thread');
		} else if (parent.hasClass('nr')) {
			this.track('wall/sort/newest-reply');
		} else if (parent.hasClass('ma')) {
			this.track('wall/sort/most-active');
		} else if (parent.hasClass('a')) {
			this.track('wall/sort/archive');
		}
	}
});

Wall.settings.classBindings.sortingBar = Wall.SortingBar;

})(window, jQuery);