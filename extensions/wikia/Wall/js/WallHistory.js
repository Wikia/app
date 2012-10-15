$(document).ready(function() {
	var wallHistory = new WallHistory();
});

var WallHistory = $.createClass(Wall, {
	constructor: function() {
		var sortingBar = new Wall.settings.classBindings.sortingBar();
		$('#WallHistory .message-restore, #WallThreadHistory .message-restore' ).click(this.proxy(this.confirmAction));
		var timeout = null;
		$('#WallHistory tr').hover(
			function(){
				var self = this;
				timeout = setTimeout(function() {
					$(self).find('.threadHistory').css('visibility', 'visible');
				}, 500);
			},
			function(){
				$('.threadHistory').css('visibility', 'hidden');
				clearTimeout(timeout);
			}
		);
	},
	afterRestore: function(data) {
		window.location.reload();
	}
});