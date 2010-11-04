var CategoryExhibition = {

	init: function() {
		$('#mw-images').delegate('a.video-thumbnail', 'click', CategoryExhibition.mediaThumbnailClick);
		$('#mw-pages').delegate('.wikia-paginator a.paginator-page', 'click', CategoryExhibition.articlesPaginatorClick);
		$('#mw-subcategories').delegate('.wikia-paginator a.paginator-page', 'click', CategoryExhibition.subcategoriesPaginatorClick);
		$('#mw-images').delegate('.wikia-paginator a.paginator-page', 'click', CategoryExhibition.mediaPaginatorClick);
		$('#mw-blogs').delegate('.wikia-paginator a.paginator-page', 'click', CategoryExhibition.blogsPaginatorClick);
	},

	log: function(msg) {
		$().log(msg, 'CategoryExhibition');
	},

	hideThrobber: function(){
		$('#toplists-loading-screen').remove();
	},
	showThrobber: function(elem){
		CategoryExhibition.hideThrobber();
		elem.prepend('<div id="toplists-loading-screen"></div>');
	},

	articlesPaginatorClick : function(e) {
		return CategoryExhibition.paginatorClick($('#mw-pages'), 'axGetArticlesPage', $(this));
	},

	mediaPaginatorClick : function(e) {
		return CategoryExhibition.paginatorClick($('#mw-images'), 'axGetMediaPage', $(this));
	},

	mediaThumbnailClick : function(e) {
		var url = $(this).attr('data-ref');
		var desc = $(this).attr('title');
		// catch doubleclicks on video thumbnails
		if (CategoryExhibition.videoPlayerLock) {
			return false;
		}
		CategoryExhibition.videoPlayerLock = true;
		$.getJSON(
			wgScript + '?action=ajax&rs=CategoryExhibitionAjax&method=axGetVideoPlayer',
			{'title': url},
			function(res) {
				// replace thumbnail with video preview
				if (res.html) {
					$.showModal(res.title, res.html, {
						'id': 'activityfeed-video-player',
						'width': res.width
					});
				}
				CategoryExhibition.videoPlayerLock = false;
			}
		);
		return false;
	},

	subcategoriesPaginatorClick : function(e) {
		return CategoryExhibition.paginatorClick($('#mw-subcategories'), 'axGetSubcategoriesPage', $(this));
	},

	blogsPaginatorClick : function(e) {
		return CategoryExhibition.paginatorClick($('#mw-blogs'), 'axGetBlogsPage', $(this));
	},

	getUrlVars: function(e){
	    var vars = [], hash;
	    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	    for(var i = 0; i < hashes.length; i++)
	    {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	    }
	    return vars;
	},

	paginatorClick : function(pageSection, axMethod, clickedObj ){
		CategoryExhibition.log('begin: paginatorClick');
		CategoryExhibition.showThrobber(pageSection.find('div.category-gallery-holder'));
		var UrlVars = CategoryExhibition.getUrlVars();
		var data = {
			action: 'ajax',
			articleId: wgArticleId,
			method: axMethod,
			rs: 'CategoryExhibitionAjax',
			page: clickedObj.attr('data-page'),
			sort: UrlVars['sort'],
			display: UrlVars['display']
		};

		if ( scroll )
		$.get(wgScript, data,
		function(axData){
			var goBack = clickedObj.attr('data-back');
			var room1 = pageSection.find('div.category-gallery-room1');
			var room2 = pageSection.find('div.category-gallery-room2');
			pageSection.find('div.category-gallery-paginator').html(axData.paginator);
			CategoryExhibition.hideThrobber();

			if ( typeof goBack !== "undefined" && goBack ){
				room2.html(room1.html());
				room1.css( 'margin-left', ( -1 * room1.width() ) );
				room1.html(axData.page)
				room1.animate( { 'margin-left' : 0 }, 500);
				room1.queue(function () {
					room2.html('');
					$.dequeue( this );
				});

			} else {
				room2.html(axData.page);
				room1.animate( { 'margin-left' : (-1 * room1.width() ) }, 500);
				room1.queue(function () {
					room1.html(axData.page);
					room1.css( 'margin-left', 0 );
					room2.html('');
					$.dequeue( this );
				});
			}
		});

		return false;
	}
};

//on content ready
wgAfterContentAndJS.push(CategoryExhibition.init);