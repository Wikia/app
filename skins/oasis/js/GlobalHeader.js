$(function(){
	require(['wikia.uifactory'], function(uiFactory) {
		uiFactory.init('drawer').then(function(elem){
			$('body').append(elem.render({type:"default", vars: {side: 'left'}}));
			require(['wikia.uifactory.drawer'], function(drawer){
				var leftDrawer = drawer.init('left');
				$('.WikiaLogo').click(function(){
					leftDrawer.open();
					return false;
				});
			})
		})
	});

})