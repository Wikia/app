<div id=wkAdTopLeader></div><script>window.addEventListener('load', function () {
	if(Wikia.AbTest && ['A', 'B', 'D', 'F'].indexOf(Wikia.AbTest.getGroup("WIKIAMOBILEADSLOTS")) != -1){
			require(['ads'], function (ads) {
				var adWrapper = document.getElementById('wkAdTopLeader');

				ads.setupSlot({
					name: 'MOBILE_TOP_LEADERBOARD',
					size: '320x50',
					wrapper: adWrapper,
					init: function(found){
						if(found) {
							adWrapper.className = 'show';
						}
					}
				});
			});
	}
});</script>
