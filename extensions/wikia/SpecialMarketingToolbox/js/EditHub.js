var EditHub = function() {};

EditHub.prototype = {
	form: undefined,

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

		$('#marketing-toolbox-clearall').click($.proxy(function(){
			if (confirm($.msg('marketing-toolbox-edithub-clearall-confirmation')) == true) {
				this.formReset();
			}
		}, this));

		$('.WikiaForm .submits input[type=submit]').click(this.formValidate);
		$('.WikiaForm input[type=text]').keyup(this.formValidateRealTime);
	},

	formReset: function() {
		this.form.find('input:text, input:password, input:file, select, textarea').val('');
		this.form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
	},

	formValidateRealTime: function(e) {
		$().log('formValidateRealTime');
		var closestError = $(this).siblings('.error');
		closestError.text('');
		if ($(this).val() == '') {
			closestError.text(
				$.msg('marketing-toolbox-validator-string-short')
			);
		}
		var validated = true;
		var submitButton = $('.WikiaForm .submits input[type=submit]');
		$('.WikiaForm input[type=text]').each(function() {
			if ($(this).val() == '') {
				validated = false;
			}
		});
		if (validated) {
			submitButton.removeAttr('disabled');
		}
		else {
			submitButton.attr('disabled', true);
		}
	},

	formValidate: function(e) {
		$('.WikiaForm .error').text('');
		$('.WikiaForm input[type=text]').each(function() {
			if ($(this).val() == '') {
				$(this).siblings('.error').text(
					$.msg('marketing-toolbox-validator-string-short')
				);
				e.preventDefault();
			}
		});
	}
}

var EditHub = new EditHub();
$(function () {
	EditHub.init();
});