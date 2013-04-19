var CollectionsSetup = function() {};

CollectionsSetup.prototype = {
	init: function() {
		// TODO change select when field name is fixed
		var checkboxes = $('#collectionsSetupForm input[name="enabled"]');

		checkboxes.click(this.handleToggleEnabled);
		checkboxes.each($.proxy(function(i, elem){
			this.handleToggleEnabled({target: elem});
		}, this));
	},

	handleToggleEnabled: function(event) {
		var checkbox = $(event.target);
		var switchableElems = checkbox.parents('.collection-module:first').find('input').filter(':not([name="enabled"])');

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
