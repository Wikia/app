
/*
Copyright (c) 2009, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)
*/

var initTracker = function() {

	// - Inez
	if(wgID == 2428) {
		$('#realAd0, #realAd1').click(function(e) {
			if(e.target.innerHTML == 'Close ad') {
				if(wgIsMainpage) {
					$.tracker.byStr('CloseAd/MainPage');
				} else {
					$.tracker.byStr('CloseAd/ArticlePage');
				}
			}
		});
	}

	// Request Wiki
	$('#request_wiki').click(function() {
		$.tracker.byStr('RequestWiki/initiate_click');
	});

	// Related pages
	$('#RelatedPages').click(function(e) {
		if(e.target.nodeName == 'A') { $.tracker.byStr('articleAction/relatedPage'); }
	});

	// Edit links for sections
	// TODO: WTF is this variable?
	var WysyWigDone = false;
	$('#bodyContent').find('span.editsection').click(function(e) {
		if(e.target.nodeName == 'A') { $.tracker.byStr('articleAction/editSection'); }
	});

	if(wgUserName == null) {
		$('#login, #register, #community_login, #community_register').click($.tracker.byId);

		$('#wpLoginattempt, #wpMailmypassword, #wpCreateaccount, #wpAjaxRegister').click(function(e) {
            $.tracker.byStr('loginActions/' + this.id.substring(2).toLowerCase());
		});
	} else {
		$('#userData, #headerMenuUser').click(function(e) {
			if(e.target.nodeName == 'A') {
				var parentId = e.target.parentNode.id;
				$.tracker.byStr('userMenu/' + (parentId == 'header_username' ? 'userPage/' : '') + e.target.innerHTML);
			}
		});
		$('#headerButtonUser').click(function() { $.tracker.byStr('userMenu/more'); });
	}

	// CategoryList
	$('#headerMenuHub').click(function() { $.tracker.byStr('categoryList/more'); });
	$('#headerMenuHub').click(function(e) {
		if(e.target.nodeName == 'A') {
			if(e.target.id == 'goToHub')  {
				$.tracker.byStr('categoryList/moredotdotdot');
			} else if(e.target.id != '') {
				$.tracker.byStr('categoryList/'+ e.target.id.split('-')[1]  + '/' + e.target.innerHTML);
			}
		}
	});

	// Wikia & Wiki logo
	$('#wikia_logo, #wiki_logo').click($.tracker.byId);

	// User Engagement
	$('#ue_msg').click(function(e) {
		if(e.target.nodeName == 'A') {
			$.tracker.byStr('userengagement/msg_click_' + e.target.id);
		}
	});

	// Article content actions
	$('#page_controls, #page_tabs').click(function(e) {
		if(e.target.nodeName == 'A') {
			$.tracker.byStr('articleAction/' + e.target.id.substring(3).replace(/nstab-/, 'view/'));
		}
	});

	// Article footer
	$('#articleFooterActions, #articleFooterActions2, #articleFooterActions3, #articleFooterActions4').click(function(e) {
		var el = e.target;
		if(el.nodeName == 'IMG') { el = el.parentNode; }
		if(el.nodeName == 'A') { $.tracker.byStr('ArticleFooter/' + el.id.split('_')[1]); }
	});

	// Share it icons
	$('#share').click(function(e) {
		if(e.target.nodeName == 'A') {
			$.tracker.byStr('ArticleFooter/share/' + e.target.id.substring(5,e.target.id.length-2));
		}
	});


	// Footer links
	$('#wikia_footer').click(function(e) {
		if(e.target.nodeName == 'A') {
			$.tracker.byStr(((e.target.parentNode.id == 'wikia_corporate_footer') ? 'wikiaFooter/' : 'footer/') + e.target.innerHTML);
		}
	});

	// Widgets
	$('dl.widget').click(function(e) {
		if(e.target.nodeName == 'A') {
			$.tracker.byStr('widget/' + this.className.split(' ')[1] + '/' + e.target.innerHTML);
		}
	});

	// Search
	$('#searchform').submit(function() {
		$.tracker.byStr('search/submit/enter/' +  escape($('#search_field').val().replace(/ /g, '_')));
	});

	// Search button
	$('#search_button').click(function(e) {
		$.tracker.byStr('search/submit/click/' +  escape($('#search_field').val().replace(/ /g, '_')));
	});

	// Spotlights
	$('#spotlight_footer').find('div').each(function(i) {
		var id = parseInt(this.id.substr(this.id.length-1), 10);
		$('#realAd'+id).click(function() {
			$.tracker.byStr('spotlights/footer' + (i+1));
		});
	});

	// Advertiser Widget
	$('#102_content').find('div').each(function(i) {
		var id = this.id.substr(this.id.length-1);
		$('#realAd'+id).click(function() {
			$.tracker.byStr('spotlights/sidebar1');
		});
	});

	// Navigation - sidebar
	$("#navigation a").live("click", function() {
		var tree = [];
		self = $(this);
		while (self.attr("id") != 'navigation') {
			if (self.hasClass('menu-item')) {
				tree.push($.trim(self.children("a").contents()[0].nodeValue));
			}
			self = self.parent();
		}
		tree.reverse();
		str = 'sidebar/' + tree.join("/");
		$.tracker.byStr(str);
	});

	if (wgIsArticle && wgArticleId > 0) {
		$("#bodyContent").find("a").click(function(e) {
			$.tracker.byStr("articleAction/contentLink-all");

			/* regular wiki link */
			/* DON'T PUT IT AT THE END AND MAKE CATCH-ALL, BE BRAVE (-; */
			if ($(this).attr("class") == "" && $(this).attr("title") != "" && !$(this).attr("href").match(/\/index\.php\?title=.*\&action=edit/)) {

				/* catlinks */
				/* nonexistent (red) categories will be traced below as regular red links */
				if ($(this).parents("div").is("div#catlinks")) {
					$.tracker.byStr("articleAction/contentLink/ignore/categories");
					return;
				}

				/* smw factbox */
				if ($(this).parents("div").is("div.smwfact")) {
					$.tracker.byStr("articleAction/contentLink/ignore/smwfactbox");
					return;
				}

				$.tracker.byStr("articleAction/contentLink/blueInternal");
				return;
			}

			/* href="#" or href="javascript:..." */
			if ($(this).attr("href") == "#" || $(this).attr("href").match(/^javascript:/)) {
				$.tracker.byStr("articleAction/contentLink/ignore/javascript");
				return;
			}
			/* href="#anchor" */
			if ($(this).attr("href").match(/^#/)) {
				$.tracker.byStr("articleAction/contentLink/ignore/anchor");
				return;
			}

			/* section edit link (already tracked as editSection) */
			if ($(this).attr("href").match(/\/index\.php\?title=.*\&action=edit\&section=/)) {
				$.tracker.byStr("articleAction/contentLink/ignore/editSection");
				return;
			}
			/* regular red link */
			/* including categories */
			if ($(this).attr("href").match(/\/index\.php\?title=.*&action=edit&redlink=/) /* && $(this).hasClass("new") */ ) {
				$.tracker.byStr("articleAction/contentLink/red");
				return;
			}
			/* other edit link (eg. template "e" shortcut) */
			if ($(this).attr("href").match(/\/index\.php\?title=.*\&action=edit/) /* && $(this).hasClass("new") */ ) {
				$.tracker.byStr("articleAction/contentLink/ignore/edit");
				return;
			}

			/* image */
			if ($(this).hasClass("image")) {
				$.tracker.byStr("articleAction/contentLink/image");
				return;
			}
			/* bottom right of thumbnails... is this reliable? */
			if ($(this).hasClass("internal")) {
				$.tracker.byStr("articleAction/contentLink/imageIcon");
				return;
			}

			/* external */
			if ($(this).hasClass("external") || $(this).hasClass("extiw") /* && $(this).attr("href").match(/^https?:\/\//) */ ) {
				$.tracker.byStr("articleAction/contentLink/blueExternal");
				return;
			}

			$.tracker.byStr("articleAction/contentLink/unknown/" + wgCityId + "-" + wgArticleId + "/" + encodeURIComponent($(this).attr("href")));
		});
	}
};
