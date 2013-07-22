var AchievementsThing = {
	init: function() {
		AchievementsThing.page = 0;
		AchievementsThing.windowObj = $(window);
		AchievementsThing.module = $(".AchievementsModule, .WikiaLatestEarnedBadgesModule");

		var data = AchievementsThing.module.find(".data");

		AchievementsThing.user = data.attr("data-user");
		AchievementsThing.badgesCount = ~~data.attr("data-badges-count");
		AchievementsThing.badgesPerPage = ~~data.attr("data-badges-per-page");
		AchievementsThing.pageCount = Math.floor(AchievementsThing.badgesCount/AchievementsThing.badgesPerPage);
		AchievementsThing.badgesUl = AchievementsThing.module.find(".badges-icons");
		AchievementsThing.next = AchievementsThing.module.find(".badges-next");
		AchievementsThing.prev = AchievementsThing.module.find(".badges-prev");
		AchievementsThing.badgeDescWidth = 400; // this width is based on bootstrap popover max-width from popover.scss

		if(AchievementsThing.next && AchievementsThing.prev){
			AchievementsThing.next.click(AchievementsThing.loadBadges);
			AchievementsThing.prev.click(AchievementsThing.loadBadges);
		}

		//Show badge description when hovering over the badge
		AchievementsThing.showBadgesDescription();

		//Track sponsored badges
		AchievementsThing.trackSponsoredBadges();

		//TODO: var wgIsResponsiveLayoutEnabled may be changed after
		// code review for https://github.com/Wikia/app/pull/1140
		if ( window.wgIsResponsiveLayoutEnabled ) {
			AchievementsThing.addResizeEvent();
		}
	},

	addResizeEvent: function() {
		AchievementsThing.windowObj.on( 'resize', this.resizeBadgesDescription );
	},

	prepareBadgesDescription: function(badge) {
		var placement = 'left';
		var html = badge.prevAll(".profile-hover").clone().wrap('<div>').parent().html();

		if ( badge.offset().left + badge.width() - AchievementsThing.badgeDescWidth < 0 ) {
			placement = 'right';
		}

		badge.popover({
			content: html,
			placement: placement
		});
	},

	resizeBadgesDescription: function() {
		AchievementsThing.module.find('.badges li > img').each(function(){
			var badge = $(this);
			badge.popover('destroy');
			AchievementsThing.prepareBadgesDescription(badge);
		});
	},

	showBadgesDescription: function(){
		AchievementsThing.module.find('.badges li > img, .badges .sponsored-link').add("#LeaderboardTable .badge-icon").each(function(){
			var badge = $(this);
			AchievementsThing.prepareBadgesDescription(badge);
		});
	},

	trackSponsoredBadges: function(){
		AchievementsThing.module.find('.sponsored-link img').each(function(){
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
			controller: 'Achievements',
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

