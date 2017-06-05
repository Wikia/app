require(['jquery', 'wikia.window'], function ($, context) {
	'use strict';

	context.Forum.SortingBar = $.createClass(context.Wall.SortingBar, {
		initElements: function() {
			this.sorting = $('#Forum .sorting');
			this.sortingList = this.sorting.find('.menu');
			this.sortingOption = this.sortingList.find('.option');
			this.sortingSelected = this.sorting.find('.selected');
		}
	});

	context.Wall.settings.classBindings.sortingBar = context.Forum.SortingBar;

});
