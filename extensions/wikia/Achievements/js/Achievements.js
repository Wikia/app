var Achievements = {
	// track events
	track: function(fakeUrl) {
		window.jQuery.tracker.byStr('Achievements/' + fakeUrl);
	},

	//hover delay (in ms)
	delay: 500,

	init: function() {
		var self = this;

		$('#view-all').click(function() {
			var badgesTotal = $("#badge-list").children().length;
			var badgeHeight = Math.round(badgesTotal/3)*100;			

			$('#view-all').fadeOut('fast');
			$('#view-less').fadeIn('fast');
			$("#profile-sidebar #badges").animate({height: badgeHeight +'px'}, 'slow');

			self.track('userprofile/viewall');
		});

		$('#view-less').click(function() {
			$('#view-less').fadeOut('fast');
			$('#view-all').fadeIn('fast');
			$("#profile-sidebar #badges").animate({height: '200px'}, 'slow');

			self.track('userprofile/viewless');
		});
		
		$('.customize-upload').submit(function() {
			var img = $(this).prev().children().eq(0);
			self.track('customize/savepicture');
			$.AIM.submit(this, {
				onComplete: function(response) {
					var response = $.evalJSON(response);
					if(typeof response.error != 'undefined') {
						alert(response.error);
					} else {
						img.attr('src', response.url + '?' + Math.random(0,1));
					}
				}
			});
		});

		//Show badge description when hovering over the badge	
		$('#badge-list li>img').hover(function() {
			var badge = $(this);
			self.timer = setTimeout(function() {
				badge.prev().show();
				self.track('userprofile/hover');
			}, self.delay);
		}, function() {
			clearTimeout(self.timer);
			$(this).prev().hide();
		});
		
		$('form.customize-upload').find('input').click(function(e) {
			self.track('customize/browse');
		});

		$('#achievements-leaderboard').click(function() {
			self.track('userprofile/leaderboardlink');
		});

		$('#achievements-customize').click(function() {
			self.track('userprofile/customizelink');
		});

		$('#about-achievements').find('a').click(function(e) {
			self.track('leaderboard/yourprofile');
			if (wgUserName == null) {
				var callbackLink = $(e.target).attr('href');
				showComboAjaxForPlaceHolder(false, false, function(){
					AjaxLogin.doSuccess = function() {
						window.location = callbackLink;
					}
				});
				return false;
			}
		});

		//avatars
		$('#leaderboard').find('a').click(function(e) {
			self.track('leaderboard/avatar');
		});

		//user names
		$('#leaderboard-sidebar').find('a').click(function(e) {
			self.track('leaderboard/username');
		});

		$('span.custom-text').find('a').click(function(e) {
			self.track('leaderboard/revert');
		});
	},

	revert: function(o, badge_type, badge_lap) {
		var file = badge_type;
		if (badge_lap != null) {
			file += '-' + badge_lap;
		}

		var img = $(o).parent().prev().prev();

		$.get(window.wgServer+wgScript+'?action=ajax&rs=Ach&method=revert&file='+file, function(response) {
				var response = $.evalJSON(response);
				img.attr('src', response.url);
				alert(response.message);
			});

		return false;
	},

	AchPrepareData: function() {
		this.track('customize/savechanges');
		var messages = {};
		$('.c-message').each(function() {
			messages[this.name] = this.value;
		});
		var json = $.toJSON(messages);
		$('.c-messages').val(json);
		return false;
	}
}

wgAfterContentAndJS.push(
	function() {
	$('document').ready(function(){
		Achievements.init.call(Achievements);
	});
});
