var EditHub = function() {};

EditHub.prototype = {
	init: function () {
		$('.MarketingToolboxMain .wmu-show').click(function() {
			$.loadYUI( function() {
				$.getScript(wgExtensionsPath+'/wikia/WikiaMiniUpload/js/WMU.js', function() {
					WMU_show($.getEvent(), -2);
					mw.loader.load( wgExtensionsPath+'/wikia/WikiaMiniUpload/css/WMU.css', "text/css" );
				});
				$(window).bind('WMU_addFromSpecialPage', function(event, filePageUrl) {
					$().log('file name: ' + filePageUrl);
				});
			});
		});
	}
}

var EditHub = new EditHub();
$(function () {
	EditHub.init();
});