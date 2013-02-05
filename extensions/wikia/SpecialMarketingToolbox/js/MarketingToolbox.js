var MarketingToolbox = function() {};

MarketingToolbox.prototype = {
	tooltipMessages: {},
	isCalendarReady: false,
	models: {},
	verticalId: undefined,
	langCode: undefined,
	verticalInputs: undefined,
	datepickerContainer: undefined,
	regionSelect: undefined,
	init: function() {
		this.datepickerContainer =  $("#date-picker");
		this.regionSelect = $('#marketingToolboxRegionSelect');
		this.verticalInputs = $('.vertical input');
		this.initModels();

		this.tooltipMessages[window.wgMarketingToolboxConstants.EDITED_NOT_PUBLISHED] = $.msg('marketing-toolbox-tooltip-in-progress');
		this.tooltipMessages[window.wgMarketingToolboxConstants.PUBLISHED] = $.msg('marketing-toolbox-tooltip-published');

		this.interactionsHandler();

		this.langCode = this.regionSelect.val();
		var selectedVertical = this.verticalInputs.filter(':not(.secondary)');
		if (selectedVertical.length) {
			this.verticalId = selectedVertical.data('vertical-id');
		}

		$.when(
			// jQuery UI datepicker plugin
			mw.loader.use(['jquery.ui.datepicker'])
		).done($.proxy(function(getResourcesData) {
			this.isCalendarReady = true;

			if (this.langCode && this.verticalId) {
				this.initDatepicker();
			}
		}, this));

	},
	initModels: function() {
		$('#marketingToolboxRegionSelect option').each($.proxy(function(i, opt){
			var langCode = $(opt).val();
			this.models[langCode] = {};
			this.verticalInputs.each(
				$.proxy(
					function(i, elem){
						var verticalId = $(elem).data('vertical-id');
						this.models[langCode][verticalId] = new DatepickerModel(langCode, verticalId);
					},
					this
				)
			);
		}, this));
	},
	getModel: function() {
		return this.models[this.langCode][this.verticalId];
	},
	datePickerBeforeShowDay: function(date) {
		var tdClassName = '';
		var tooltip = '';
		var dayStatus = this.getModel().getStatus(date);

		if (dayStatus) {
			if (dayStatus == window.wgMarketingToolboxConstants.NOT_PUBLISHED) {
				tdClassName = 'inProg';
			} else if (dayStatus == window.wgMarketingToolboxConstants.PUBLISHED) {
				tdClassName = 'published';
			}
			tooltip = this.tooltipMessages[dayStatus];
		}

		return [true, tdClassName, tooltip];
	},
	interactionsHandler: function() {
		this.regionSelect.change($.proxy(function(e) {
			this.langCode = $(e.target).val();
			this.savelangCode(this.langCode);
			$('.marketingToolbox input').removeAttr('disabled');
			$('.section input').removeClass('secondary');
			$('.placeholder-option').remove();
			this.destroyDatepicker();
			if (this.verticalId) {
				this.initDatepicker();
			}
		}, this));

		this.verticalInputs.click($.proxy(function(e) {
			var target = $(e.target);
			this.verticalId = target.data('vertical-id');
			this.verticalInputs.addClass('secondary');
			target.removeClass('secondary');
			this.saveVertical(this.verticalId);

			this.destroyDatepicker();
			this.initDatepicker();

		}, this));
	},
	destroyDatepicker: function() {
		this.datepickerContainer.datepicker('destroy').text($.msg('marketing-toolbox-tooltip-calendar-placeholder'));
	},
	goToEditHub: function(date) {
		if (window.wgEditHubUrl) {
			var tmpDate = new Date();
			tmpDate.setTime(date);
			Wikia.Querystring(window.wgEditHubUrl)
				.setVal({
					date: tmpDate.getTime() / 1000 - tmpDate.getTimezoneOffset() * 60,
					region: $('#marketingToolboxRegionSelect').val(),
					verticalId: $('.vertical input:not(.secondary)').data('vertical-id'),
					sectionId: $('.section input:not(.secondary)').data('section-id')
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
	savelangCode: function(id) {
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
