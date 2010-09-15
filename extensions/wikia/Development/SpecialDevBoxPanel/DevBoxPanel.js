$(function() {
	DevBoxPanel.init();
});

var DevBoxPanel = {
	init: function() {
		$(".tabs").find("li").click(function() { DevBoxPanel.switchTab($(this)) });
	},

	switchTab: function( elem ) {
		$(".tabs").find("li").removeClass("selected");
		$(elem).addClass("selected");
		
		$(".tab-pane").css("display", "none");
		$('#' + $(elem).attr("pane")).css("display", "block");
	},
};
