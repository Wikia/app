$(function() {
	AchievementsLeaderboard.init();
});

AchievementsLeaderboard = {
	init: function() {
		//Set correct initial state of page intro (visible or hidden)

		//TODO: check cookie
		$("#about-achievements").children(".open").hide();
		
		
	
		//Enable hiding/showing page intro
		$("#about-achievements").children("span").click(function() {
			var text = $("#about-achievements").children("div");
			if ($(this).hasClass("open")) {
				text.slideDown();
			} else if ($(this).hasClass("hide")) {
				text.slideUp();
				$.cookie.set("AchivementsIntro", false);
			}
			$("#about-achievements").children("span").toggle();
		});
	}
}