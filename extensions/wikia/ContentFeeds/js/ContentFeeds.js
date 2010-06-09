(function( $ ) {
	$.extend( {
		jTwitterSearch: function( phrase, numPosts, callback ) {
			var info = {};
			var url = "http://search.twitter.com/search.json?q=" + phrase + "&rpp=" + numPosts + "&callback=?";

			$.getJSON( url, function( data ) {
				if( $.isFunction( callback ) ) {
					callback.call( this, data.results );
				}
			});
		}
	});
})( jQuery );

(function ( $) { 
	$.fn.extend( {
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
				returning.pus(this.replace(regexp,"<a href=\"http://twitter.com/$1\" target=\"_blank\">@$1</a>"));
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
})( jQuery );

var ContentFeeds = {};

ContentFeeds.getTweets = function( tagId, phrase, limit ) {
	$.jTwitterSearch(phrase, limit, function(posts) {
		$('#'+tagId+'').text('');
		for(var i = 0; i < posts.length; i++) {
			var post = posts[i];
			var user = '<a href="http://twitter.com/'+post.from_user+'">'+post.from_user+'</a>';
			var text = $([post.text]).jTwitterLinkUrl().jTwitterLinkUser().jTwitterLinkHash()[0];
			
			$('#'+tagId+'').append('<li>'+user+':&nbsp;'+text+'</li>');
		}
	});
};
