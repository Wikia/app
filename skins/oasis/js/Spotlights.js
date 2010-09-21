$(function() {
	if($('#WikiaRail').exists() && $('#WikiaFooter').exists() && $('#WikiaSpotlightsModule').exists()) {
		if($('#WikiaFooter').offset().top - ($('#WikiaRail').offset().top + $('#WikiaRail').height()) > 1200) {
			$('#WikiaSpotlightsModule').css('display', 'block')
		}
	}
});