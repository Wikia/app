var MarketingToolbox = function() {};

MarketingToolbox.prototype = {
	tooltipMessages: {},
	specialDates: {
		'2012-11-20': 1,
		'2012-11-21': 1,
		'2012-11-12': 2
	},
	init: function() {
		this.tooltipMessages[window.wgMarketingToolboxConstants.DAY_EDITED_NOT_PUBLISHED] = $.msg('marketing-toolbox-tooltip-in-progress');
		this.tooltipMessages[window.wgMarketingToolboxConstants.DAY_PUBLISHED] = $.msg('marketing-toolbox-tooltip-published');

		$.when(
			// jQuery UI datepicker plugin
			mw.loader.use(['jquery.ui.datepicker'])
		).then($.proxy(function(getResourcesData) {
			$("#date-picker").datepicker({
				showOtherMonths: true,
				selectOtherMonths: true,
				beforeShowDay: $.proxy(this.datePickerBeforeShowDay, this)
			});
		}, this));

		this.interactionsHandler();
	},
	datePickerBeforeShowDay: function(date) {
		var tdClassName = '',
			tooltip = '',
			theday = $.datepicker.formatDate('yy-mm-dd', date);

		if (theday in this.specialDates) {
			if (this.specialDates[theday] == window.wgMarketingToolboxConstants.DAY_EDITED_NOT_PUBLISHED) {
				tdClassName = 'inProg';
			} else if (this.specialDates[theday] == window.wgMarketingToolboxConstants.DAY_PUBLISHED) {
				tdClassName = 'published';
			}
			tooltip = this.tooltipMessages[this.specialDates[theday]];
		}

		return [true, tdClassName, tooltip];
	},
	interactionsHandler: function() {
		$('#marketingToolboxRegionSelect').change(function() {
			$('.marketingToolbox input').removeAttr('disabled');
		});
		var verticalInputs = $('.vertical input');
		verticalInputs.click(function() {
			verticalInputs.addClass('secondary');
			$(this).removeClass('secondary');
		});
	}
};

var MarketingToolboxInstance = new MarketingToolbox();
$(function () {
	MarketingToolboxInstance.init();
});
