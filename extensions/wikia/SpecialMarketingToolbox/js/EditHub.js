var EditHub = function() {};

EditHub.prototype = {
	form: undefined,
	validatedInputs: undefined,
	urlInput: undefined,
	submitButton: undefined,
	wmuDeffered: undefined,

	init: function () {
		$('.MarketingToolboxMain .wmu-show').click($.proxy(this.wmuInit, this));

		this.form = $('#marketing-toolbox-form');
		this.validatedInputs = $('.WikiaForm .required');
		this.submitButton = $('.WikiaForm .submits input[type=submit]');
		this.urlInput = $('.WikiaForm input[type=text]:not(.required)');

		$('#marketing-toolbox-clearall').click($.proxy(function(){
			if (confirm($.msg('marketing-toolbox-edithub-clearall-confirmation')) == true) {
				this.formReset();
			}
		}, this));

		this.formValidate();
		this.validatedInputs.keyup($.proxy(this.formValidateRealTime, this));
		this.urlInput.keyup($.proxy(this.urlValidate, this));
	},

	wmuInit: function(event) {
		event.preventDefault();
		var $input = $(this).prev();
		if (!this.wmuDeffered) {
			this.wmuDeffered = mw.loader.use(
				'ext.wikia.WMU'
			).then(function() {
					WMU_skipDetails = true;
					WMU_show();
				});
		} else if (this.wmuDeffered.state() === 'resolved') {
			WMU_show();
		} else {
			return false;
		}
		$(window).bind('WMU_addFromSpecialPage', $.proxy(function(event, wmuData) {
			this.addImage(wmuData);
		}, this));
	},

	addImage: function(wmuData) {
		$.nirvana.sendRequest({
			controller: 'MarketingToolbox',
			method: 'getImageDetails',
			type: 'get',
			data: {
				'fileHandler': wmuData.imageTitle
			},
			callback: function(response) {
				var tempImg = new Image();
				tempImg.src = response.fileUrl;
				$('.MarketingToolboxMain').append(tempImg);
			}
		});
	},

	isUrl: function(url) {
		var reg = new RegExp(/((ftp|https?):\/\/)?(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{2}$/);
		return (reg.test(url));
	},

	urlValidate: function(e) {
		var closestError = $(e.target).siblings('.error');
		closestError.text('');
		if(this.isUrl($(e.target).val())) {

		}
		else {
			closestError.text(
				$.msg('marketing-toolbox-validator-wrong-url')
			);
		}
	},

	formReset: function() {
		this.form.find('input:text, input:password, input:file, select, textarea').val('');
		this.form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
	},

	formValidateRealTime: function(e) {
		var closestError = $(e.target).siblings('.error');
		closestError.text('');
		if ($(e.target).val() == '') {
			closestError.text(
				$.msg('marketing-toolbox-validator-string-short')
			);
		}
		var validated = true;
		this.validatedInputs.each(function() {
			if ($(this).val() == '') {
				validated = false;
			}
		});
		if (validated) {
			this.submitButton.removeAttr('disabled');
		}
		else {
			this.submitButton.attr('disabled', true);
		}
	},

	formValidate: function(e) {
		this.validatedInputs.each($.proxy(function(i, element) {
			if ($(element).val() == '') {
				this.submitButton.attr('disabled', true);
			}
		}, this));
	}
}

var EditHub = new EditHub();
$(function () {
	EditHub.init();
});