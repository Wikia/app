/*global jwplayer:true */

(function(jwplayer){
	var template = function(player, config, div) {
		player.onReady( function setup(evt) {		
			if (player.config.width >= 330) {
				var container = $(div);
				container.addClass('jwplayer-infobox');
				var background = $('<div class="jwplayer-infobox-background"></div>');
				var contentClasses = '';
				if (player.config.width < 660) {
					contentClasses += ' small';
				}
				var content = $('<div class="jwplayer-infobox-content'+contentClasses+'"></div>');
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
			}
		});
		this.resize = function(width, height) {};
	};		

	$.getResources([ $.getSassCommonURL('/extensions/wikia/JWPlayer/plugins/css/infobox.scss') ], function() { 
		jwplayer().registerPlugin('infobox', template);
	});
})(jwplayer);
