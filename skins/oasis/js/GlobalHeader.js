$(function(){
	require(['wikia.uifactory'], function(uiFactory) {
		uiFactory.init('drawer').then(function(elem){
			$('#WikiaHeader').append(elem.render({type:"default", vars: {side: 'left', content: 'test content'}}));
			require(['wikia.uifactory.drawer'], function(drawer){
				var leftDrawer = drawer.init('left');
				$('#BrowseEntry').click(function(){
					if (leftDrawer.isOpen()) {
						leftDrawer.close();
					} else {
						leftDrawer.open();
					}

					return false;
				});
			})
		})
	});

})