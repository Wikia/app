var CollectionsSetup = function() {};

CollectionsSetup.prototype = {
	nav: undefined,
	init: function() {
		var checkboxes = $('#collectionsSetupForm input[name="enabled[]"]');

		checkboxes.click(this.handleToggleEnabled);
		checkboxes.each($.proxy(function(i, elem){
			this.handleToggleEnabled({target: elem});
		}, this));

		this.nav = new CollectionsNavigation('.collection-module');
	},

	handleToggleEnabled: function(event) {
		var checkbox = $(event.target);
		var switchableElems = checkbox.parents('.collection-module:first').find('input').filter(':not([name="enabled[]"])');

		if (checkbox.is(':checked')) {
			switchableElems.removeAttr('disabled');
		} else {
			switchableElems.attr('disabled', 'disbaled');
		}
	}
};

var CollectionsSetupInstance = new CollectionsSetup();
$(function () {
	CollectionsSetupInstance.init();
});
