var MarketingToolbox = function() {};

// TODO mocked data
var specialDates = {
	'2012-11-20': 1,
	'2012-11-12': 2
};

// TODO
var tooltipMessages = {};
tooltipMessages[window.wgMarketingToolboxConstants.DAY_EDITED_NOT_PUBLISHED] = 'In progress / Not published';
tooltipMessages[window.wgMarketingToolboxConstants.DAY_PUBLISHED] = 'Saved / Published';


MarketingToolbox.prototype = {
	init: function() {
		$.when(
			// jQuery UI datepicker plugin
			mw.loader.use(['jquery.ui.datepicker'])
		).then(function(getResourcesData) {
			$("#date-picker").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				beforeShowDay: function (date) {
					var tdClassName, tooltip;
					var theday = date.getFullYear() + '-' +
						(date.getMonth()+1) + '-' +
						date.getDate();

					if (theday in specialDates) {
						if (specialDates[theday] == window.wgMarketingToolboxConstants.DAY_EDITED_NOT_PUBLISHED) {
							tdClassName = 'inProg';
						} else if (specialDates[theday] == window.wgMarketingToolboxConstants.DAY_PUBLISHED) {
							tdClassName = 'published';
						}
						tooltip = tooltipMessages[specialDates[theday]];
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
