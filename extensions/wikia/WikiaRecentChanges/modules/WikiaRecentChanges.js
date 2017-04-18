require(['jquery', 'wikia.window'], function($, context) {
	$(function() {
		this.$table = $('.mw-recentchanges-table');
		var $dropdowns = [];
		this.$table.find('.WikiaDropdown').each(function () {
			$dropdowns.push(new context.Wikia.MultiSelectDropdown($(this)));
		});
	});
});
