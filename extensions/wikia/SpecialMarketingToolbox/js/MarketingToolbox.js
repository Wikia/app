var MarketingToolbox = function() {};

// TODO mocked data
var specialDates = {
	'2012-11-20': 1,
	'2012-11-21': 1,
	'2012-11-12': 2
};

MarketingToolbox.prototype = {
	tooltipMessages: {},
	init: function() {
		var self = this;

		self.tooltipMessages[window.wgMarketingToolboxConstants.DAY_EDITED_NOT_PUBLISHED] = $.msg('marketing-toolbox-tooltip-in-progress');
		self.tooltipMessages[window.wgMarketingToolboxConstants.DAY_PUBLISHED] = $.msg('marketing-toolbox-tooltip-published');

		$.when(
			// jQuery UI datepicker plugin
			mw.loader.use(['jquery.ui.datepicker'])
		).then(function(getResourcesData) {
			$("#date-picker").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				beforeShowDay: function (date) {
					var tdClassName = '',
						tooltip = '',
						theday = $.datepicker.formatDate('yy-mm-dd', date);

					if (theday in specialDates) {
						if (specialDates[theday] == window.wgMarketingToolboxConstants.DAY_EDITED_NOT_PUBLISHED) {
							tdClassName = 'inProg';
						} else if (specialDates[theday] == window.wgMarketingToolboxConstants.DAY_PUBLISHED) {
							tdClassName = 'published';
						}
						tooltip = self.tooltipMessages[specialDates[theday]];
					}

					return [true, tdClassName, tooltip];
				}
			});
		});
	}
};

var MarketingToolboxInstance = new MarketingToolbox();
$(function () {
	MarketingToolboxInstance.init();
});
