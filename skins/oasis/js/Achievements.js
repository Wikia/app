$(function() {
	AchievementsThing.init();
		$().log('init');
});

var AchievementsThing = {
	init: function() {
		$(".AchievementsModule").find(".view-all").click(AchievementsThing.seeAllClick);

		//Show badge description when hovering over the badge
		$('.badges img').hover(function() {
			$(this).css('position', 'absolute');
			var badge = $(this);
			var hover = badge.prevAll(".profile-hover");
			var hoverPosition = {
				left : -hover.outerWidth() + badge.width() + badge.position().left,
				top : -hover.outerHeight() + badge.position().top
			};

			badge.prev().css("right", badge.width());
			self.timer = setTimeout(function() {
				badge.prevAll(".profile-hover")
					.css("left", hoverPosition.left)
					.css("top", hoverPosition.top)
					.show();
				//self.track('userprofile/hover');
			}, self.delay);
		}, function() {
			$(this).css('position', 'static');
			clearTimeout(self.timer);
			$(this).prevAll(".profile-hover").hide();
		});


	},

	seeAllClick: function(event) {
		if ($(".AchievementsModule .badges-more").is(':visible')) {
			$(".AchievementsModule").find(".view-all").text(wgAchievementsMoreButton[0]);
		}
		else {
			$(".AchievementsModule").find(".view-all").text(wgAchievementsMoreButton[1]);
		}
		$(".AchievementsModule .badges-more").toggle();
	}

};