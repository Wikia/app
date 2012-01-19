$(document).ready(function() {
	var wallHistory = new WallHistory();
});

var WallHistory = $.createClass(Wall, {
	constructor: function() {
		$('#WallHistory .message-restore, #WallThreadHistory .message-restore' ).click(this.proxy(this.confirmAction));
	},
	afterRestore: function(data) {
		window.location.reload();
	}
});