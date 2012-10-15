if(!window.blogInitialized) {
	window.blogInitialized = true;

	var BlogPaginator = {
		isFree: true,
		init: function() {
			BlogPaginator.n = $('.wk_blogs_pager .wikia-paginator');
			BlogPaginator.n.live('click', function(evt) {
				evt.preventDefault();
				if(BlogPaginator.isFree) {
					BlogPaginator.isFree = false;
					var el = $(evt.target);
					if(el.is('span')) {
						el = el.parent();
					}
					if(el.is('a') && !el.hasClass('active')) {
						BlogPaginator.changePage(parseInt(el.data('page')) - 1);
					}
				}
			});
		},
		// modified legacy code
		changePage: function(offset) {
			var wkBlogLoader = $(".wk_blogs_pager .wikia-paginator ul");
			wkBlogLoader.append("<li><img src=\"" + stylepath + "/common/skins/common/images/ajax.gif\"></li>");
			var params = "&rsargs[0]=" + wgArticleId + "&rsargs[1]=" + wgNamespaceNumber + "&rsargs[2]=" + offset + "&rsargs[3]=oasis";
			var baseurl = wgScript + "?action=ajax&rs=BlogTemplateClass::axShowCurrentPage" + params;
			$().log(wgScript + "?action=ajax&rs=BlogTemplateClass::axShowCurrentPage" + params);
			$.get( wgScript + "?action=ajax&rs=BlogTemplateClass::axShowCurrentPage" + params,
				function(data) {
					if(data) {
						$(".wk_blogs_pager").remove();
						$(".WikiaBlogListing").empty().append(data);
						$('html, body').animate({scrollTop: $('body').offset().top}, 400);
					}
					wkBlogLoader.html("");
					BlogPaginator.isFree = true;
				}
			);
		}
	};

	var blogPaginatorHandle = false;
	var initializeBlogPaginator = function() {
		if(blogPaginatorHandle) {
			clearInterval(blogPaginatorHandle);
		}
		var attempt = 30;
		blogPaginatorHandle = setInterval(function() {
			attempt--;
			if(attempt < 0) {
				clearInterval(blogPaginatorHandle);
			}
			if(typeof jQuery != 'undefined') {
				clearInterval(blogPaginatorHandle);
				BlogPaginator.init();
			}
		}, 500);
	};

	initializeBlogPaginator();
}