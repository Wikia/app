jQuery.fn.extend({
	jTwitterLinkUrl: function() {
		var returning = [];
		var regexp = /((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/gi;
		this.each(function() {
			returning.push(this.replace(regexp,"<a href=\"$1\" target=\"_blank\">$1</a>"));
		});
		return $(returning);
	},
	jTwitterLinkUser: function() {
		var returning = [];
		var regexp = /[\@]+([A-Za-z0-9-_]+)/gi;
		this.each(function() {
			returning.push(this.replace(regexp,"<a href=\"http://twitter.com/$1\" target=\"_blank\">@$1</a>"));
		});
		return $(returning);
	},
	jTwitterLinkHash: function() {
		var returning = [];
		var regexp = /(?:^| )[\#]+([A-Za-z0-9-_]+)/gi;
		this.each(function() {
			returning.push(this.replace(regexp, ' <a href="http://search.twitter.com/search?q=&tag=$1&lang=all" target=\"_blank\">#$1</a>'));
		});
		return $(returning);
	}
});

var ContentFeeds = {
	getTweets: function(tagId, phrase, limit) {
		var url = "http://search.twitter.com/search.json?q=" + phrase + "&rpp=" + limit + "&callback=?";
		$.getJSON(url, function(data) {
			var posts = data.results;
			var html = '';

			for (var i = 0; i < posts.length; i++) {
				var post = posts[i];
				var user = '<a href="http://twitter.com/' + post.from_user + '">' + post.from_user + '</a>';
				var text = $([post.text]).jTwitterLinkUrl().jTwitterLinkUser().jTwitterLinkHash()[0];

				html += '<li>' + user + ':&nbsp;' + text + '</li>';
			}

			$('#' + tagId).html(html);
		});
	},

	getUserTweets: function(tagId, user, limit) {
		var url = "http://api.twitter.com/1/statuses/user_timeline.json?screen_name=" + user + "&count=" + limit + "&callback=?";
		$.getJSON(url, function(posts) {
			var html = '';

			for (var i = 0; i < posts.length; i++) {
				var post = posts[i];
				var user = '<a href="http://twitter.com/' + post.user.screen_name + '">' + post.user.screen_name + '</a>';
				var text = $([post.text]).jTwitterLinkUrl().jTwitterLinkUser().jTwitterLinkHash()[0];

				html += '<li>' + user + ':&nbsp;' + text + '</li>';
			}

			$('#' + tagId).html(html);
		});
	}
};
