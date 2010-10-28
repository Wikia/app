var AutomaticWikiAdoption = {
	// track events
	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('AutomaticWikiAdoption/' + fakeUrl);
	},

	init: function() {
		$('#automatic-wiki-adoption-button-adopt').bind('click', function() {AutomaticWikiAdoption.track('adoptButton');});
	}
}

//on content ready
wgAfterContentAndJS.push(AutomaticWikiAdoption.init);