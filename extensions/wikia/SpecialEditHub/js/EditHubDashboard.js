var EditHub = function() {};

EditHub.prototype = {
	tooltipMessages: {},
	isCalendarReady: false,
	models: {},
	datepickerContainer: undefined,
	init: function() {
		this.datepickerContainer =  $("#date-picker");
		this.initModel();

		this.tooltipMessages[window.wgEditHubConstants.EDITED_NOT_PUBLISHED] = $.msg('edit-hub-tooltip-in-progress');
		this.tooltipMessages[window.wgEditHubConstants.PUBLISHED] = $.msg('edit-hub-tooltip-published');

		// jQuery UI datepicker plugin
		mw.loader.using('jquery.ui.datepicker')
			.done($.proxy(function(getResourcesData) {
				this.isCalendarReady = true;
				this.initDatepicker();
			}, this));

	},
	initModel: function() {
		this.model = new DatepickerModel(window.wgCityId);
	},
	getModel: function() {
		return this.model;
	},
	datePickerBeforeShowDay: function(date) {
		var tdClassName = '';
		var tooltip = '';
		var dayStatus = this.getModel().getStatus(date);

		if (dayStatus) {
			if (dayStatus == window.wgEditHubConstants.NOT_PUBLISHED) {
				tdClassName = 'inProg';
			} else if (dayStatus == window.wgEditHubConstants.PUBLISHED) {
				tdClassName = 'published';
			}
			tooltip = this.tooltipMessages[dayStatus];
		}

		return [true, tdClassName, tooltip];
	},
	destroyDatepicker: function() {
		this.datepickerContainer.datepicker('destroy').text($.msg('edit-hub-tooltip-calendar-placeholder'));
	},
	goToEditHub: function(date) {
		if (window.wgEditHubUrl) {
			var tmpDate = new Date();
			tmpDate.setTime(date);
			Wikia.Querystring(window.wgEditHubUrl)
				.setVal({
					date: tmpDate.getTime() / 1000 - tmpDate.getTimezoneOffset() * 60
				})
				.goTo();
		}
	},
	initDatepicker: function() {
		$.when(
			$.proxy(function(){
				var tmpDate = new Date();
				return this.getModel().collectData(tmpDate.getFullYear(), tmpDate.getMonth() + 1);
			}, this)()
		).done($.proxy(function() {
			if (this.isCalendarReady) {
				this.datepickerContainer.text('').datepicker({
					showOtherMonths: true,
					selectOtherMonths: true,
					dateFormat: '@',
					beforeShowDay: $.proxy(this.datePickerBeforeShowDay, this),
					onChangeMonthYear: $.proxy(function(year, month){
						this.getModel().collectData(year, month);
					}, this),
					onSelect: $.proxy(this.goToEditHub, this)
				});
			}
		}, this));
	}
};

var EditHubInstance = new EditHub();
$(function () {
	EditHubInstance.init();
});
