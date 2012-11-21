var MarketingToolbox = function() {};

MarketingToolbox.prototype = {
	tooltipMessages: {},
	isCalendarReady: false,
	models: {},
	vertical: undefined,
	langId: undefined,
	verticalInputs: undefined,
	datepickerContainer: undefined,
	init: function() {
		this.datepickerContainer =  $("#date-picker");
		this.verticalInputs = $('.vertical input');
		this.initModels();

		this.tooltipMessages[window.wgMarketingToolboxConstants.DAY_EDITED_NOT_PUBLISHED] = $.msg('marketing-toolbox-tooltip-in-progress');
		this.tooltipMessages[window.wgMarketingToolboxConstants.DAY_PUBLISHED] = $.msg('marketing-toolbox-tooltip-published');

		$.when(
			// jQuery UI datepicker plugin
			mw.loader.use(['jquery.ui.datepicker'])
		).done($.proxy(function(getResourcesData) {
			this.isCalendarReady = true;
		}, this));

		this.interactionsHandler();
	},
	initModels: function() {
		$('#marketingToolboxRegionSelect option').each($.proxy(function(i, opt){
			var langId = $(opt).val();
			this.models[langId] = {};
			this.verticalInputs.each(
				$.proxy(
					function(i, elem){
						var verticalName = $(elem).val();
						this.models[langId][verticalName] = new DatepickerModel(langId, verticalName);
					},
					this
				)
			);
		}, this));
	},
	getModel: function() {
		return this.models[this.langId][this.vertical];
	},
	datePickerBeforeShowDay: function(date) {
		var tdClassName = '';
		var tooltip = '';
		var dayStatus = this.getModel().getStatus(date);

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
		$('#marketingToolboxRegionSelect').change($.proxy(function(e) {
			this.langId = $(e.target).val();
			$('.marketingToolbox input').removeAttr('disabled');
			$('.section input').removeClass('secondary');
			$('.vertical input').addClass('secondary');
			$('.placeholder-option').remove();
			this.destroyDatepicker();
		}, this));

		this.verticalInputs.click($.proxy(function(e) {
			var target = $(e.target);
			this.vertical = target.val();
			this.verticalInputs.addClass('secondary');
			target.removeClass('secondary');

			this.destroyDatepicker();

			$.when(
				$.proxy(function(){
					var tmpDate = new Date();
					this.getModel().collectData(tmpDate.getFullYear(), tmpDate.getMonth() + 1);
				}, this)()
			).done($.proxy(function() {
				if (this.isCalendarReady) {
					this.datepickerContainer.text('').datepicker({
						showOtherMonths: true,
						selectOtherMonths: true,
						beforeShowDay: $.proxy(this.datePickerBeforeShowDay, this),
						onChangeMonthYear: $.proxy(function(year, month){
							this.getModel().collectData(year, month);
						}, this),
					});
				}
			}, this));

		}, this));
	},
	destroyDatepicker: function() {
		this.datepickerContainer.datepicker('destroy').text($.msg('marketing-toolbox-tooltip-calendar-placeholder'));
	}
};

var MarketingToolboxInstance = new MarketingToolbox();
$(function () {
	MarketingToolboxInstance.init();
});
