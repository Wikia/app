var MarketingToolbox = function() {};

MarketingToolbox.prototype = {
	tooltipMessages: {},
	specialDates: {
		'2012-11-20': 1,
		'2012-11-21': 1,
		'2012-11-12': 2
	},
	isCalendarReady: false,
	init: function() {
		this.tooltipMessages[window.wgMarketingToolboxConstants.DAY_EDITED_NOT_PUBLISHED] = $.msg('marketing-toolbox-tooltip-in-progress');
		this.tooltipMessages[window.wgMarketingToolboxConstants.DAY_PUBLISHED] = $.msg('marketing-toolbox-tooltip-published');

		$.when(
			// jQuery UI datepicker plugin
			mw.loader.use(['jquery.ui.datepicker'])
		).then($.proxy(function(getResourcesData) {
			this.isCalendarReady = true;
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
			$('.section input').removeClass('secondary');
			$('.placeholder-option').remove();
		});
		var verticalInputs = $('.vertical input');
		verticalInputs.click($.proxy(function(e) {
			verticalInputs.addClass('secondary');
			$(e.target).removeClass('secondary');
			if (this.isCalendarReady) {
				$("#date-picker").text('').datepicker({
					showOtherMonths: true,
					selectOtherMonths: true,
					beforeShowDay: $.proxy(this.datePickerBeforeShowDay, this)
				});
				this.isCalendarReady = false;
			}
		}, this));
	}
};

var MarketingToolboxInstance = new MarketingToolbox();
$(function () {
	MarketingToolboxInstance.init();
});
