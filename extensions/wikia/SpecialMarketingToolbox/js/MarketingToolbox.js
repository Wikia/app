var MarketingToolbox = function() {};
var DatepickerModel = function(vertical) {
	this.vertical = vertical;
};

DatepickerModel.prototype = {
	MONTH_COLLECT_RADIUS: 2,
	specialDates: {},
	colectedMonths: {},
	vertical: undefined,

	getStatus: function (day) {
		var fullDay = $.datepicker.formatDate('yy-mm-dd', day);

		if (fullDay in this.specialDates) {
			return this.specialDates[fullDay];
		}
	},
	collectData: function (year, month) {
		var
			beginTimestamp,
			endTimestamp,
			maxDate,
			datesLength,
			dates = this.getMonthsToCollect(year, month);
		datesLength = dates.length;

		if (datesLength == 0) {
			return true;
		}

		maxDate = new Date(Math.max.apply(null,dates));
		maxDate.setMonth(maxDate.getMonth() + 1)
		endTimestamp = maxDate.getTime() / 1000;
		beginTimestamp = new Date(Math.min.apply(null,dates)).getTime() / 1000;


		this.sendRequest(beginTimestamp, endTimestamp);

		for (var i = 0; i < datesLength; i++) {
			this.setCollected(dates[i].getFullYear(), dates[i].getMonth() + 1);
		}
	},
	sendRequest: function(beginTimestamp, endTimestamp) {
		$.nirvana.sendRequest({
			controller: 'MarketingToolbox',
			method: 'getCalendarData',
			type: 'post',
			data: {
				'vertical': this.vertical,
				'beginTimestamp': beginTimestamp,
				'endTimestamp': endTimestamp
			},
			callback: $.proxy( function(response) {
				$.extend(this.specialDates, response['calendarData']);
			}, this)
		});
	},
	setCollected: function(theYear, theMonth) {
		this.colectedMonths[this.getMonthKey(theYear, theMonth)] = true;
	},
	isCollected: function(theYear, theMonth) {
		if (this.getMonthKey(theYear, theMonth) in this.colectedMonths) {
			return true;
		}
		return false;
	},
	getMonthsToCollect: function(theYear, theMonth) {
		var out = [],
			tmpDate =  new Date(theYear, theMonth - 1);

		for (var i = - this.MONTH_COLLECT_RADIUS; i <= this.MONTH_COLLECT_RADIUS; i++) {
			tmpDate.setMonth(theMonth - 1 + i);
			if (!this.isCollected(tmpDate.getFullYear(), tmpDate.getMonth() + 1)) {
				out.push(new Date(tmpDate.getFullYear(), tmpDate.getMonth(), 1, 0, 0, 0, 0));
			}
		}
		return out;
	},
	getMonthKey: function(theYear, theMonth) {
		return theYear + '-' + theMonth;
	}
}

MarketingToolbox.prototype = {
	tooltipMessages: {},
	isCalendarReady: false,
	model: new DatepickerModel('test-vertical'),
	init: function() {
		this.tooltipMessages[window.wgMarketingToolboxConstants.DAY_EDITED_NOT_PUBLISHED] = $.msg('marketing-toolbox-tooltip-in-progress');
		this.tooltipMessages[window.wgMarketingToolboxConstants.DAY_PUBLISHED] = $.msg('marketing-toolbox-tooltip-published');

		$.when(
			// jQuery UI datepicker plugin
			mw.loader.use(['jquery.ui.datepicker']),
			// get calendar data
			$.proxy(function(){
				var tmpDate = new Date();
				this.model.collectData(tmpDate.getFullYear(), tmpDate.getMonth() + 1)
			}, this)()
		).done($.proxy(function(getResourcesData) {
			this.isCalendarReady = true;
		}, this));

		this.interactionsHandler();
	},
	datePickerBeforeShowDay: function(date) {
		var tdClassName = '',
			tooltip = '',
			dayStatus = this.model.getStatus(date);

		if (dayStatus) {
			if (dayStatus == window.wgMarketingToolboxConstants.DAY_EDITED_NOT_PUBLISHED) {
				tdClassName = 'inProg';
			} else if (dayStatus == window.wgMarketingToolboxConstants.DAY_PUBLISHED) {
				tdClassName = 'published';
			}
			tooltip = this.tooltipMessages[dayStatus];
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
					beforeShowDay: $.proxy(this.datePickerBeforeShowDay, this),
					onChangeMonthYear: $.proxy(function(year, month){
						this.model.collectData(year, month);
					}, this),
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
