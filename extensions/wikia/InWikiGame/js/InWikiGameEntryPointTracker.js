var InWikiGameEntryPointTracker = {
	ENTRY_POINT_STORAGE_KEY: 'IN_WIKI_GAME_ENTRY_POINT',
	init: function() {
		$('.InWikIGameRailModule a').click(this.onEntryPointClick);
		$('.WikiNav .subnav-2a').click(this.onEntryPointClick);
	},
	onEntryPointClick: function(event) {
		var target = $(event.target);
		var localStorageValue = null;

		if( target.hasClass('in-wiki-game-rail-link') ) {
			localStorageValue = 'rail-link';
		} else if( target.attr('href') == '/wiki/Play' ) {
		//TODO: investigate and implement if possible adding custom CSS class in WikiaNav then change the condition above
			localStorageValue = 'nav-link';
		}

		$.storage.set(InWikiGameEntryPointTracker.ENTRY_POINT_STORAGE_KEY, localStorageValue);
	}
}

$(function () {
	InWikiGameEntryPointTracker.init();
});