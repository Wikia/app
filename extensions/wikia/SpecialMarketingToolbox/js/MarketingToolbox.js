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
						var verticalId = $(elem).data('vertical-id');
						this.models[langId][verticalId] = new DatepickerModel(langId, verticalId);
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
			this.saveLangId(this.langId);
			$('.marketingToolbox input').removeAttr('disabled');
			$('.section input').removeClass('secondary');
			$('.placeholder-option').remove();
			this.destroyDatepicker();
			if (this.vertical) {
				this.initDatepicker();
			}
		}, this));

		this.verticalInputs.click($.proxy(function(e) {
			var target = $(e.target);
			this.vertical = target.data('vertical-id');
			this.verticalInputs.addClass('secondary');
			target.removeClass('secondary');
			this.saveVertical(this.vertical);

			this.destroyDatepicker();
			this.initDatepicker();

		}, this));
	},
	destroyDatepicker: function() {
		this.datepickerContainer.datepicker('destroy').text($.msg('marketing-toolbox-tooltip-calendar-placeholder'));
	},
	goToEditHub: function(date) {
		if (window.wgEditHubUrl) {
			(new Wikia.Querystring(window.wgEditHubUrl))
				.setVal('date', date / 1000)
				.setVal('region', $('#marketingToolboxRegionSelect').val())
				.setVal('vertical', $('.vertical input:not(.secondary)').val())
				.goTo();
		}
	},
	initDatepicker: function() {
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
					dateFormat: '@',
					beforeShowDay: $.proxy(this.datePickerBeforeShowDay, this),
					onChangeMonthYear: $.proxy(function(year, month){
						this.getModel().collectData(year, month);
					}, this),
					onSelect: $.proxy(this.goToEditHub, this)
				});
			}
		}, this));
	},
	saveUserProperties: function(data) {
		$.nirvana.sendRequest({
			controller: 'WikiaUserPropertiesController',
			method: 'performPropertyOperation',
			data: data,
			type: 'post',
			format: 'json'
		});
	},
	saveLangId: function(id) {
		this.saveUserProperties({
			handlerName: 'MarketingToolboxUserPropertiesHandler',
			methodName: 'saveMarketingToolboxRegion',
			callParams: {
				'marketing-toolbox-region': id
			}
		});
	},
	saveVertical: function(name) {
		this.saveUserProperties({
			handlerName: 'MarketingToolboxUserPropertiesHandler',
			methodName: 'saveMarketingToolboxVertical',
			callParams: {
				'marketing-toolbox-vertical': name
			}
		});
	}
};

var MarketingToolboxInstance = new MarketingToolbox();
$(function () {
	MarketingToolboxInstance.init();
});
