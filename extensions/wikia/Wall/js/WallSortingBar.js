/* global require */
require(['jquery', 'wikia.window'], function ($, context) {
	'use strict';

	context.Wall.SortingBar = $.createClass(context.Observable, {
		constructor: function () {
			this.initElements();
			this.sortingSelected.on('click', this.proxy(this.showSortingMenu));
			this.sortingList.on('mouseleave', this.proxy(this.hideSortingMenu));
		},

		initElements: function () {
			this.sortingOption = $('.SortingOption');
			this.sortingSelected = $('.SortingSelected');
			this.sortingList = $('.SortingList');
		},

		hideSortingMenu: function () {
			this.sortingList.hide();
		},

		showSortingMenu: function () {
			this.sortingList.show();

			var firstItemOffset = this.sortingList.find('li:first').offset().top,
				currentItemOffset = this.sortingList.find('.current').offset().top,
				newOffset = (currentItemOffset - firstItemOffset) * -1;

			this.sortingList.css('top', newOffset);
		}
	});

	context.Wall.settings.classBindings.sortingBar = context.Wall.SortingBar;

});
