var EditHub = function() {};

EditHub.prototype = {
	form: undefined,
	wmuDeffered: undefined,

	init: function () {
		$('.MarketingToolboxMain .wmu-show').click($.proxy(this.wmuInit, this));

		this.form = $('#marketing-toolbox-form');

		$('#marketing-toolbox-clearall').click($.proxy(function(){
			if (confirm($.msg('marketing-toolbox-edithub-clearall-confirmation')) == true) {
				this.formReset();
			}
		}, this));

		$.validator.addMethod("wikiaUrl", function(value, element) {
			var reg = new RegExp(window.wgMarketingToolboxUrlRegex);
			return this.optional(element) || reg.test(value);
		}, $.validator.messages.url);

		this.form.validate({
			errorElement: 'p'
		});
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

	formReset: function() {
		this.form.find('input:text, input:password, input:file, select, textarea').val('');
		this.form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
	}
}

var EditHub = new EditHub();
$(function () {
	EditHub.init();
});