$(function() {
	AchievementsLeaderboard.init();
});

AchievementsLeaderboard = {
	init: function() {
		//Set correct initial state of page intro (visible or hidden)

		//TODO: check cookie
		if ($.cookies.get("ShowSpecialLeaderboardIntro") == "no") {
			$("#about-achievements")
				.children(".hide, div").hide().end()
				.children(".open").show();
		}
		
		//Enable hiding/showing page intro
		$("#about-achievements").children("span").click(function() {
			var text = $("#about-achievements").children("div");
			if ($(this).hasClass("open")) {
				text.slideDown();
				$.cookies.set("ShowSpecialLeaderboardIntro", "yes");
			} else if ($(this).hasClass("hide")) {
				text.slideUp();
				$.cookies.set("ShowSpecialLeaderboardIntro", "no");
			}
			$("#about-achievements").children("span").toggle();
		});
	}
}