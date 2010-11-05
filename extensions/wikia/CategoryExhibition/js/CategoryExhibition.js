var CategoryExhibition = {

	init: function() {

		$('#WikiaArticle').delegate('.category-gallery-item', 'click', CategoryExhibition.trackClick);

		$('#mw-images').delegate('a.video-thumbnail', 'click', CategoryExhibition.mediaThumbnailClick);
		$('#mw-pages').delegate('.wikia-paginator a.paginator-page', 'click', CategoryExhibition.articlesPaginatorClick);
		$('#mw-subcategories').delegate('.wikia-paginator a.paginator-page', 'click', CategoryExhibition.subcategoriesPaginatorClick);
		$('#mw-images').delegate('.wikia-paginator a.paginator-page', 'click', CategoryExhibition.mediaPaginatorClick);
		$('#mw-blogs').delegate('.wikia-paginator a.paginator-page', 'click', CategoryExhibition.blogsPaginatorClick);

		// tracking

		$('#category-exhibition-form-current').trackClick('categoryExhibition/filter/open');
		$('#category-exhibition-form-alphabetical').trackClick('categoryExhibition/filter/alphabetical');
		$('#category-exhibition-form-recentedits').trackClick('categoryExhibition/filter/recentlyEdited');
		$('#category-exhibition-form-mostvisited').trackClick('categoryExhibition/filter/mostVisited');
		$('#category-exhibition-form-new').trackClick('categoryExhibition/layout/switch2new');
		$('#category-exhibition-form-old').trackClick('categoryExhibition/layout/switch2old');

		CategoryExhibition.redrawFormButtons();
	},

	redrawFormButtons : function(){
		$('#category-exhibition-display-old').css('background', 'none');
		$('#category-exhibition-display-old').html('<div id="cat-exh-old-one"></div><div id="cat-exh-old-two"></div><div id="cat-exh-old-three"></div><div id="cat-exh-old-four"></div><div id="cat-exh-old-five"></div>');
		$('#category-exhibition-display-new').css('background', 'none');
		$('#category-exhibition-display-new').html('<div id="cat-exh-new-one"></div><div id="cat-exh-new-two"></div><div id="cat-exh-new-three"></div><div id="cat-exh-new-four"></div>');
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
		return CategoryExhibition.paginatorClick($('#mw-pages'), 'axGetArticlesPage', $(this), 'article');
	},

	mediaPaginatorClick : function(e) {
		return CategoryExhibition.paginatorClick($('#mw-images'), 'axGetMediaPage', $(this), 'media');
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
		return CategoryExhibition.paginatorClick($('#mw-subcategories'), 'axGetSubcategoriesPage', $(this), 'subcategory');
	},

	blogsPaginatorClick : function(e) {
		return CategoryExhibition.paginatorClick($('#mw-blogs'), 'axGetBlogsPage', $(this), 'blogs');
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

	paginatorClick : function(pageSection, axMethod, clickedObj, name ){

		// tracking;
		if ( clickedObj.hasClass('paginator-next') ){
			CategoryExhibition.track(name + '/pagination/next');
		} else if ( clickedObj.hasClass('paginator-prev') ) {
			CategoryExhibition.track(name + '/pagination/prev');
		} else {
			CategoryExhibition.track(name + '/pagination/' + clickedObj.attr('data-page'));
		}
		
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
	},

	track: function(fakeUrl) {
		$.tracker.byStr('categoryExhibition/' + fakeUrl);
	},

	trackClick: function(ev) {

		var node = $(ev.target);
		var itemSection = '';
		var itemType = '';
		var itemIndex = '';
		
		// perform detection of which element has been clicked

		if ( node.hasParent('#mw-pages') ){
			itemSection = 'page';
		} else if ( node.hasParent('#mw-images') ){
			itemSection = 'media';
		} else if ( node.hasParent('#mw-blogs') ){
			itemSection = 'blogs';
		} else if ( node.hasParent('#mw-subcategories') ){
			itemSection = 'subcategories';
		}
		
		itemIndex = $(this).index() + 1;

		if ( $(this).has('div.category-gallery-placeholder').length ){
			itemType = 'placeholder';
		} else if ( $(this).has('span.quote').length ) {
			itemType = 'text';
		} else {
			itemType = 'image';
		}
		
		if ( itemType != '' && itemSection != '' && itemIndex != '' ){
			CategoryExhibition.track(itemSection + '/' + itemType + '/' + itemIndex);
		}
	  }
};

//on content ready
wgAfterContentAndJS.push(CategoryExhibition.init);