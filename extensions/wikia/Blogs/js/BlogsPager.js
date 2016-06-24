if (!window.blogInitialized) {
	window.blogInitialized = true;

	var BlogPaginator = {
		isFree: true,
		init: function () {
			$('.WikiaBlogListing').on ('click', '.wk_blogs_pager .wikia-paginator a', function (evt) {
				evt.preventDefault();
				if (BlogPaginator.isFree) {
					var $el = $(evt.target);
					if ($el.is('a') && !$el.hasClass('active')) {
						BlogPaginator.isFree = false;
						BlogPaginator.changePage(parseInt($el.data('page')) - 1);
						history.replaceState({}, document.title, $el.attr('href'));
					}
				}
			});
		},
		// modified legacy code
		changePage: function (offset) {
			var wkBlogLoader = $(".wk_blogs_pager .wikia-paginator ul");
			wkBlogLoader.append("<li><img src=\"" + stylepath + "/common/images/ajax.gif\"></li>");
			var params = "&rsargs[0]=" + wgArticleId + "&rsargs[1]=" + wgNamespaceNumber + "&rsargs[2]=" + offset + "&rsargs[3]=oasis";
			var baseurl = wgScript + "?action=ajax&rs=BlogTemplateClass::axShowCurrentPage" + params;
			$().log(baseurl);
			$.get( baseurl,
				function (data) {
					if (data) {
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
	var initializeBlogPaginator = function () {
		if (blogPaginatorHandle) {
			clearInterval(blogPaginatorHandle);
		}
		var attempt = 30;
		blogPaginatorHandle = setInterval(function () {
			attempt--;
			if (attempt < 0) {
				clearInterval(blogPaginatorHandle);
			}
			if (typeof jQuery != 'undefined') {
				clearInterval(blogPaginatorHandle);
				BlogPaginator.init();
			}
		}, 500);
	};

	initializeBlogPaginator();
}
