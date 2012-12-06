var EditHub = function() {};

EditHub.prototype = {
	form: undefined,
	validatedInputs: undefined,
	submitButton: undefined,

	init: function () {
		$('.MarketingToolboxMain .wmu-show').click(function() {
			$.loadYUI( function() {
				$.getScript(wgExtensionsPath+'/wikia/WikiaMiniUpload/js/WMU.js', function() {
					WMU_show($.getEvent(), -2);
					mw.loader.load( wgExtensionsPath+'/wikia/WikiaMiniUpload/css/WMU.css', "text/css" );
				});
				$(window).bind('WMU_addFromSpecialPage', function(event, fileHandler) {
					$.nirvana.sendRequest({
						controller: 'MarketingToolbox',
						method: 'getImageDetails',
						type: 'get',
						data: {
							'fileHandler': fileHandler
						},
						callback: function(response) {
							var tempImg = new Image();
							tempImg.src = response.fileUrl;
							$('.MarketingToolboxMain').append(tempImg);
						}
					});
				});
			});
		});

		this.form = $('#marketing-toolbox-form');
		this.validatedInputs = $('.WikiaForm .required');
		this.submitButton = $('.WikiaForm .submits input[type=submit]');

		$('#marketing-toolbox-clearall').click($.proxy(function(){
			if (confirm($.msg('marketing-toolbox-edithub-clearall-confirmation')) == true) {
				this.formReset();
			}
		}, this));

		this.formValidate();
		this.validatedInputs.keyup($.proxy(this.formValidateRealTime, this));
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