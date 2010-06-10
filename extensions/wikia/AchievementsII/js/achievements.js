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

		//Show badge description when hovering over the badge	
		$('#challenges li>img, #badge-list li>img, .recent-badges li>img').hover(function() {
			$(this).css('position', 'absolute');
			var badge = $(this);
			var hover = badge.prevAll(".profile-hover");
			var hoverPosition = {
				left : -hover.outerWidth() + badge.width() + badge.position().left,
				top : -hover.outerHeight() + badge.position().top + 10 
			};

			badge.prev().css("right", badge.width());
			self.timer = setTimeout(function() {
				badge.prevAll(".profile-hover")
					.css("left", hoverPosition.left)
					.css("top", hoverPosition.top)
					.show();
				self.track('userprofile/hover');
			}, self.delay);
		}, function() {
			$(this).css('position', 'static');
			clearTimeout(self.timer);
			$(this).prevAll(".profile-hover").hide();
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
		
		$('input.c-enabled-flags').click(function(e) {
			if($(this).attr('checked'))
				self.track('customize/enabled');
			else
				self.track('customize/disabled');
		});
		
		$('#customize-sidebar form.customize-edit-plus-category button').click(function(e) {
			self.track('customize/createtrack');
		});
	},
	
	submitPicture:function(form){
		var inputs = $(form).find('button, input[type=file]');
		var img = $(form).prev().children().eq(0);
		var handler = form.onsubmit;
		
		Achievements.track('customize/savepicture');
		
		$.AIM.submit(form, {onComplete: function(response){
			$("#body").removeClass("ajax");
			inputs.attr('disabled', '');
			form.onsubmit = handler;
			form.reset();
			
			if(typeof response.error != 'undefined') {
				alert(response.error);
			} else {
				img.attr('src', response.output + '?' + Math.random(0,1));
			}
		}});
		
		//unbind original html element handler to avoid loops
		form.onsubmit = null;
		
		$(form).submit();
		
		$("#body").addClass("ajax");
		
		if(!$.browser.webkit)
			inputs.attr('disabled', 'disabled');
		
		return false;
	},
	
	revert: function(o, badge_type, badge_lap) {
		var inputs = $(o).parent().parent().next().find('button, input[type=file]');
		$("#body").addClass("ajax");
		
		if(!$.browser.webkit)
			inputs.attr('disabled', 'disabled');
		
		if (badge_lap == null && typeof(badge_lap) == "undefined") {
			badge_lap = '';
		}

		var img = $(o).parent().prev().prev();

		$.get(window.wgServer+wgScript+'?action=ajax&rs=AchAjax&method=resetBadge&type_id='+badge_type+'&lap='+badge_lap, function(response) {
			var response = $.evalJSON(response);
			img.attr('src', response.output);
			$("#body").removeClass("ajax");
			inputs.attr('disabled', '');
			alert(response.message);
		});
	},

	AchPrepareData: function(createInTrackEditPlusCategory, sectionId) {
		this.track('customize/savechanges');
		var dataStore = {
			messages: {},
			statusFlags: {},
			sectionId:(typeof(sectionId) == "undefined") ? '' : sectionId
		};
		
		$('.c-message').each(function() {
			dataStore.messages[this.name] = this.value;
		});
		
		$('.c-enabled-flags').each(function() {
			dataStore.statusFlags[this.name] = this.checked;
		});
		
		var json = $.toJSON(dataStore);
		var storeClass = '.c-messages';
		
		if(createInTrackEditPlusCategory == true)
			storeClass = '.c-messages-ec';
		
		$(storeClass).val(json);
		return false;
	}
}

wgAfterContentAndJS.push(
	function() {
	$('document').ready(function(){
		Achievements.init.call(Achievements);
	});
});
