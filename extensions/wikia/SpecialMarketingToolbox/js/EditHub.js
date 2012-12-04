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

		$('#marketing-toolbox-clearall').click($.proxy(this.resetForm, this));
	},

	resetForm: function() {
		this.form.find('input:text, input:password, input:file, select, textarea').val('');
		this.form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
	}
}

var EditHub = new EditHub();
$(function () {
	EditHub.init();
});