var EditHub = function() {};

var vet_back,vet_close; //hack for VET, please remove this line after VET refactoring

EditHub.prototype = {
	form: undefined,
	validatedInputs: undefined,
	urlInput: undefined,
	submitButton: undefined,
	wmuDeffered: undefined,

	init: function () {
		$('.MarketingToolboxMain .wmu-show').click($.proxy(this.wmuInit, this));
		$('.MarketingToolboxMain .vet-show').click($.proxy(this.vetInit, this));

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

	vetInit: function(event) {
		var vet_back,vet_close;
		$.when(
			$.loadYUI(),
			$.getScript(wgResourceBasePath + '/resources/wikia/libraries/mustache/jquery.mustache.js'),
			$.getResources($.getSassCommonURL('/extensions/wikia/VideoEmbedTool/css/VET.scss')),
			$.getScript(wgExtensionsPath + '/wikia/WikiaStyleGuide/js/Dropdown.js'),
			$.getResources($.getSassCommonURL('/extensions/wikia/WikiaStyleGuide/css/Dropdown.scss')),
			$.getScript(wgExtensionsPath + '/wikia/VideoEmbedTool/js/VET.js')
		).then(function() {
			VET_show();
			$(window).bind('VET_addFromSpecialPage', $.proxy(function(event, vetData) {
				$().log(vetData);
			}, this));
		});
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
		var reg = new RegExp(window.wgMarketingToolboxUrlRegex);
		return (reg.test(url));
	},

	urlValidate: function(e) {
		var closestError = $(e.target).siblings('.error');
		closestError.text('');
		if ($(e.target).val() == '') {
			this.submitButton.removeAttr('disabled');
		}
		else if(this.isUrl($(e.target).val())) {
			this.submitButton.removeAttr('disabled');
		}
		else {
			closestError.text(
				$.msg('marketing-toolbox-validator-wrong-url')
			);
			this.submitButton.attr('disabled', true);
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