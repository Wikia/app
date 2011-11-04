(function(jwplayer){
	$.getResources([ $.getSassCommonURL('/extensions//wikia/JWPlayer/plugins/css/infobox.scss') ], function() { 
		jwplayer().registerPlugin('infobox', template);
	});

	var template = function(player, config, div) {
		function setup(evt) {			
			var container = $(div);
			container.addClass('jwplayer-infobox');
			var background = $('<div class="jwplayer-infobox-background"></div>');
			var content = $('<div class="jwplayer-infobox-content"></div>');
			container.append(background).append(content);
			content.html(config.title);

			// bind player play control to clicks on div
			container.click(function() {
				player.play();
			});
			
			// bind div display to controlbar display
			player.getPlugin('controlbar').onShow(function(args) {
				container.fadeIn(200);
			});
			player.getPlugin('controlbar').onHide(function(args) {
				container.fadeOut(200);
			});

		};
		player.onReady(setup);
		this.resize = function(width, height) {};
	};		
})(jwplayer);