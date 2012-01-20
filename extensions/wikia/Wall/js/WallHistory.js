$(document).ready(function() {
	var wallHistory = new WallHistory();
});

var WallHistory = $.createClass(Wall, {
	constructor: function() {
		$('#WallHistory .message-restore, #WallThreadHistory .message-restore' ).click(this.proxy(this.confirmAction));
		$('#WallHistory tr').hover(
			function(){
				$(this).find('.threadHistory').css('visibility', 'visible').fadeIn("slow");
			},
			function(){
				$(this).find('.threadHistory').fadeOut("slow").css('visibility', 'hidden');
			}
		);
	},
	afterRestore: function(data) {
		window.location.reload();
	}
});