$(function() {
	AchievementsThing.init();
		$().log('init', 'AchievementsModule');
});

var AchievementsThing = {
	init: function() {
		$(".AchievementsModule, .WikiaLatestEarnedBadgesModule").find(".view-all").click(AchievementsThing.seeAllClick);

		//Show badge description when hovering over the badge
		$('.AchievementsModule, .WikiaLatestEarnedBadgesModule').find('.badges li > img, .badges .sponsored-link').hover(function() {
			var badge = $(this);
			var hover = badge.prevAll(".profile-hover");
			var badgeWidth = 0;

			if(badge.is('a'))
				badgeWidth = badge.find('img').width();
			else
				badgeWidth = badge.width();

			var hoverPosition = {
				top : -hover.outerHeight() - parseInt(hover.css('margin-bottom')),
				right: (badge.hasClass('badge-small')) ? badge.parent().width() - badgeWidth : 0
			};

			hover
				.css(hoverPosition)
				.show();

			AchievementsThing.trackSponsored(hover.attr('data-hovertrackurl'));
			
			//Why this has been commented out?
			//self.track('userprofile/hover');
			
		}, function() {
			$(this).prevAll(".profile-hover").hide();
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
			$(".AchievementsModule").find(".view-all").text(wgAchievementsMoreButton[0]);
		}
		else {
			$(".AchievementsModule").find(".view-all").text(wgAchievementsMoreButton[1]);

			$('.AchievementsModule, .WikiaLatestEarnedBadgesModule').find('.sponsored-link img.badges-more').each(function(){
				AchievementsThing.trackSponsored($(this).parent().attr('data-badgetrackurl'));
			});
		}

		$(".AchievementsModule .badges-more").toggle();
	}

};
