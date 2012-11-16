var AchievementsThing = {
	init: function() {
		$(".AchievementsModule, .WikiaLatestEarnedBadgesModule").find(".view-all").click(AchievementsThing.seeAllClick);

		//Show badge description when hovering over the badge
		$('.AchievementsModule, .WikiaLatestEarnedBadgesModule').find('.badges li > img, .badges .sponsored-link').add("#LeaderboardTable .badge-icon").each(function(){
			var badge = $(this);
			var html = badge.prevAll(".profile-hover").clone().wrap('<div>').parent().html();
			badge.popover({
				content: html,
				placement: 'left'
			});
		});

		$('.AchievementsModule, .WikiaLatestEarnedBadgesModule').find('.sponsored-link img:not(.badges-more)').each(function(){
			AchievementsThing.trackSponsored($(this).parent().attr('data-badgetrackurl'));
		});
	},

	trackSponsored: function(url){
		if(typeof url != 'undefined'){
			var cb = Math.floor(Math.random() * 1000000);

			url = url.replace('[timestamp]', cb);

			var i = new Image(1, 1);

			i.src = url;
		}
	},

	seeAllClick: function(event) {
		if ($(".AchievementsModule .badges-more").is(':visible')) {
			$(".AchievementsModule").find(".view-all span").text($(this).attr('data-msg-show'));
		}
		else {
			$(".AchievementsModule").find(".view-all span").text($(this).attr('data-msg-hide'));

			$('.AchievementsModule, .WikiaLatestEarnedBadgesModule').find('.sponsored-link img.badges-more').each(function(){
				AchievementsThing.trackSponsored($(this).parent().attr('data-badgetrackurl'));
			});
		}

		$(".AchievementsModule .badges-more").toggle();
	}

};

$(function() {
		AchievementsThing.init();
});
