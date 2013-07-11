$(function() {
	var WikiaRailNode = $('#WikiaRail'),
		WikiaFoooterNode = $('#WikiaFooter'),
		WikiaSpotlightsModuleNode = $('#WikiaSpotlightsModule');

	if(WikiaRailNode.exists() && WikiaFoooterNode.exists() && WikiaSpotlightsModuleNode.exists()) {
		if(WikiaFoooterNode.offset().top - (WikiaRailNode.offset().top + WikiaRailNode.height()) > 1200) {
			WikiaSpotlightsModuleNode.show();
		}
	}
});