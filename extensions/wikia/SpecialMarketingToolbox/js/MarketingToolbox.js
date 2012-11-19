var MarketingToolbox = function() {};

MarketingToolbox.prototype = {
	init: function() {
		$.when(
			// jQuery UI datepicker plugin
			mw.loader.use(['jquery.ui.datepicker'])
		).then(function(getResourcesData) {
			$("#date-picker").datepicker();
		});
	}
};

var MarketingToolboxInstance = new MarketingToolbox();
$(function () {
	MarketingToolboxInstance.init();
});
