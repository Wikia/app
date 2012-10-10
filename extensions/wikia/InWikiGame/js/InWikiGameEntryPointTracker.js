var InWikiGameEntryPointTracker = {
	ENTRY_POINT_STORAGE_KEY: 'IN_WIKI_GAME_ENTRY_POINT',
	init: function() {
		$('.InWikIGameRailModule a').click(this.onEntryPointClick);
		$('.WikiNav .subnav-2a').click(this.onEntryPointClick);
	},
	onEntryPointClick: function(event) {
		var target = event.target;
		$().log(target);
		//$.storage.set(InWikiGameEntryPointTracker.ENTRY_POINT_STORAGE_KEY, target);
	}
}

$(function () {
	InWikiGameEntryPointTracker.init();
});