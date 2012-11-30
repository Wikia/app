var AchievementsThing = {
	init: function() {
		AchievementsThing.page = 0;
		AchievementsThing.user = $(".AchievementsModule, .WikiaLatestEarnedBadgesModule").find(".data").attr("data-user");
		AchievementsThing.badgesCount = ~~$(".AchievementsModule, .WikiaLatestEarnedBadgesModule").find(".data").attr("data-badges-count");
		AchievementsThing.badgesPerPage = ~~$(".AchievementsModule, .WikiaLatestEarnedBadgesModule").find(".data").attr("data-badges-per-page");
		AchievementsThing.pageCount = Math.floor(AchievementsThing.badgesCount/AchievementsThing.badgesPerPage);
		AchievementsThing.badgesUl = $(".AchievementsModule, .WikiaLatestEarnedBadgesModule").find(".badges-icons");
		AchievementsThing.next = $(".AchievementsModule, .WikiaLatestEarnedBadgesModule").find(".badges-next");
		AchievementsThing.prev = $(".AchievementsModule, .WikiaLatestEarnedBadgesModule").find(".badges-prev");

		if(AchievementsThing.next && AchievementsThing.prev){
			AchievementsThing.next.click(AchievementsThing.loadBadges);
			AchievementsThing.prev.click(AchievementsThing.loadBadges);
		}

		//Show badge description when hovering over the badge
		AchievementsThing.showBadgesDescription();

		//Track sponsored badges
		AchievementsThing.trackSponsoredBadges();
	},

	showBadgesDescription: function(){
		$('.AchievementsModule, .WikiaLatestEarnedBadgesModule').find('.badges li > img, .badges .sponsored-link').add("#LeaderboardTable .badge-icon").each(function(){
			var badge = $(this);
			var html = badge.prevAll(".profile-hover").clone().wrap('<div>').parent().html();
			badge.popover({
				content: html,
				placement: 'left'
			});
		});
	},

	trackSponsoredBadges: function(){
		$('.AchievementsModule, .WikiaLatestEarnedBadgesModule').find('.sponsored-link img').each(function(){
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

	loadBadges: function(event){
		AchievementsThing.badgesUl.startThrobbing();

		var element = this;
		AchievementsThing.page = (element.getAttribute('class') == 'badges-prev') ? AchievementsThing.page - 1 : AchievementsThing.page + 1;

		$.nirvana.sendRequest({
			controller: 'AchievementsController',
			method: 'Badges',
			format: 'html',
			type: 'GET',
			data: {
				user: AchievementsThing.user,
				page: AchievementsThing.page
			},
			callback: function(html){
				AchievementsThing.badgesUl.html(html);
				AchievementsThing.showBadgesDescription();
				AchievementsThing.trackSponsoredBadges();

				if(Math.floor(AchievementsThing.page >= AchievementsThing.pageCount)){
					AchievementsThing.next.hide();
				} else if (AchievementsThing.page <= 0){
					AchievementsThing.prev.hide();
				} else {
					AchievementsThing.next.show();
					AchievementsThing.prev.show();
				}

				AchievementsThing.badgesUl.stopThrobbing();
			}
		});
	}
};

$(function() {
		AchievementsThing.init();
});

