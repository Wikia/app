var ContentFeeds = {
	linkUrlRegExp: /((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/gi,
	linkUserRegExp: /[\@]+([A-Za-z0-9-_]+)/gi,
	linkHashRegExp: /(?:^| )[\#]+([A-Za-z0-9-_]+)/gi,

	parseText: function(text) {
		return text.
			replace(this.linkUrlRegExp, '<a href="$1" target="_blank">$1</a>').
			replace(this.linkUserRegExp, '<a href="http://twitter.com/$1" target="_blank">@$1</a>').
			replace(this.linkHashRegExp, ' <a href="http://search.twitter.com/search?q=&tag=$1&lang=all" target=\"_blank\">#$1</a>');
	},

	getTweets: function(options) {
		$.getJSON("http://search.twitter.com/search.json?callback=?", {
			q: options.phrase,
			rpp: options.limit
		}, function(data) {
			var posts = data.results;
			var html = '';

			for (var i = 0; i < posts.length; i++) {
				var post = posts[i],
					user = '<a href="http://twitter.com/' + post.from_user + '">' + post.from_user + '</a>',
					text = ContentFeeds.parseText(post.text);

				html += '<li>' + user + ':&nbsp;' + text + '</li>';
			}

			$('#' + options.tagId).html(html);
		});
	},

	getUserTweets: function(options) {
		$.getJSON("http://api.twitter.com/1/statuses/user_timeline.json?callback=?", {
			'screen_name': options.user,
			count: options.limit
		}, function(posts) {
			var html = '';

			for (var i = 0; i < posts.length; i++) {
				var post = posts[i],
					user = '<a href="http://twitter.com/' + post.user.screen_name + '">' + post.user.screen_name + '</a>',
					text = ContentFeeds.parseText(post.text);

				html += '<li>' + user + ':&nbsp;' + text + '</li>';
			}

			$('#' + options.tagId).html(html);
		});
	}
};