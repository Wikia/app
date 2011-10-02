var AchievementsThing = {
	init: function() {
		$(".AchievementsModule, .WikiaLatestEarnedBadgesModule").find(".view-all").click(AchievementsThing.seeAllClick);

		//Show badge description when hovering over the badge
		$('.AchievementsModule, .WikiaLatestEarnedBadgesModule').find('.badges li > img, .badges .sponsored-link').add("#LeaderboardTable .badge-icon").each(function(){
			var badge = $(this);
			var hover = badge.prevAll(".profile-hover");
			badge.wikiaTooltip(hover, {relativeToParent:true, align:'right'});
		});
		
		$('.AchievementsModule, .WikiaLatestEarnedBadgesModule').find('.sponsored-link img:not(.badges-more)').each(function(){
			AchievementsThing.trackSponsored($(this).parent().attr('data-badgetrackurl'));
		});
	},

	trackSponsored: function(url){
		if(typeof url != 'undefined'){
			var cb = Math.floor(Math.random() * 1000000);

			url = url.replace('[timestamp]', cb);

			//$().log("Requesting tracking pixel from " + url, 'Sponsored achievements');
			var i = new Image(1, 1);

			/*i.onload = function(){
				$().log("Tracking pixel granted from " + this.src, 'Sponsored achievements');
			};*/

			i.src = url;
		}
	},

	seeAllClick: function(event) {
		if ($(".AchievementsModule .badges-more").is(':visible')) {
			$(".AchievementsModule").find(".view-all span").text(wgAchievementsMoreButton[0]);
			$(".AchievementsModule").find(".view-all img").show();
		}
		else {
			$(".AchievementsModule").find(".view-all span").text(wgAchievementsMoreButton[1]);
			$(".AchievementsModule").find(".view-all img").hide();

			$('.AchievementsModule, .WikiaLatestEarnedBadgesModule').find('.sponsored-link img.badges-more').each(function(){
				AchievementsThing.trackSponsored($(this).parent().attr('data-badgetrackurl'));
			});
		}

		$(".AchievementsModule .badges-more").toggle();
	}

};

$(function() {
		AchievementsThing.init();
		$().log('init', 'AchievementsModule');
});
