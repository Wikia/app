(function(window, $) {

Wall.SortingBar = $.createClass(Observable, {
	constructor: function() {
		this.initElements();
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
	}
});

Wall.settings.classBindings.sortingBar = Wall.SortingBar;

})(window, jQuery);