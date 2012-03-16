var initTracker = function() {
	// global header
	$('#WikiaHeader').click(function(ev) {
		var fakeUrl = 'globalheader/';
		var node = $(ev.target);

		// wikia logo
		if (node.hasParent('.WikiaLogo')) {
			$.tracker.byStr(fakeUrl + 'wikia-logo');
		}
		// start a wiki
		else if (node.is('.wikia-button')) {
			$.tracker.byStr('action/startawiki');
		}
		// global navigation
		else if (node.hasParent('#GlobalNavigation')) {
			fakeUrl += 'globalnav/';

			if (node.hasParent('.subnav')) {
				// hubs
				if (node.next().is('ul')) {
					$.tracker.byStr(fakeUrl + 'hub');
				}
				// "more" link
				else if (!node.parent().next().exists()) {
					$.tracker.byStr(fakeUrl + 'more');
				}
				// wikis
				else {
					$.tracker.byStr(fakeUrl + 'wiki');
					$.tracker.byStr('spotlights/globalheader/' + node.closest('.SPOTLIGHT_GLOBALNAV').attr('id'));
				}
			}
			// top-level links
			else {
				$.tracker.byStr(fakeUrl + 'hub');
			}
		}
		// account navigation
		else if (node.hasParent('#AccountNavigation')) {
			// dropdown links + login + register + logout
			var id = node.attr('data-id');
			if (id) {
				switch(id) {
					case 'login':
					case 'register':
					case 'logout':
						$.tracker.byStr(fakeUrl + id);
						break;

					default:
						fakeUrl += 'usermenu/';
						$.tracker.byStr(fakeUrl + id);
				}
			}
			// facebook connect button
			else if (node.hasParent('#fbconnect')) {
				$.tracker.byStr(fakeUrl + 'facebookconnect');
			}
			// user name with avatar
			else if (node.hasParent('li')) {
				$.tracker.byStr(fakeUrl + 'usermenu/username');
			}
		}
	});

	// wiki header
	$('#WikiHeader').click(function(ev) {
		var fakeUrl = 'wikiheader/';
		var node = $(ev.target);

		// wiki name (wordmark)
		if (node.hasParent('.wordmark')) {
			$.tracker.byStr(fakeUrl + 'wordmark');
		}
		// link in wiki navigation
		else if (node.hasParent('nav')) {
			$.tracker.byStr(fakeUrl + 'wikinav/click');
		}
		// random page / wikiactivity
		else if (node.attr('data-id')) {
			$.tracker.byStr(fakeUrl + node.attr('data-id'));
		}
	});

	// page header
	$('#WikiaPageHeader').click(function(ev) {
		var fakeUrl = 'pageheader/',
			node = $(ev.target);

		// clicks on image inside "edit" link
		if (node.is('img')) {
			node = node.parent();
		}

		if (!node.is('a')) {
			return;
		}

		// tracking of /pageheader part

		// comments
		if (node.hasParent('.commentslikes')) {
			$.tracker.byStr(fakeUrl + 'comments');
		}
		// create page (on main pages)
		else if (node.hasClass('createpage')) {
			$.tracker.byStr('action/createapage/mainpage');
		}
		// "Read more" categories
		else if (node.hasParent('.categories')) {
			$.tracker.byStr(fakeUrl + 'readmore');
		}
		// history dropdown
		else if (node.hasParent('.history')) {
			fakeUrl += 'history/';
			if (node.hasParent('.view-all')) {
				$.tracker.byStr(fakeUrl + 'more');
			}
			else {
				$.tracker.byStr(fakeUrl + 'click');
			}
		}

		// tracking of /action part

		// edit button / dropdown
		else if (node.hasParent('.wikia-menu-button') || node.hasClass('wikia-button')) {
			fakeUrl = 'action/';
			$.tracker.byStr(fakeUrl + node.attr('data-id'));
		}
	});

	// user page header
	$('.UserProfileActionButton').click(function(ev) {
		var fakeUrl = 'action/';
		var node = $(ev.target);

		// clicks on image inside "edit" link
		if (node.is('img')) {
			node = node.parent();
		}

		// create blog post button + edit button + edit dropdown items + comments
		var id = node.attr('data-id');
		if (id) {
			switch(id) {
				case 'createblogpost':
					$.tracker.byStr('action/createblogpost/bloglistingheader');
					break;

				default:
					$.tracker.byStr(fakeUrl + id);
			}
		}
		var parentId = node.parent().attr('data-id');
		if (parentId) {
			switch(parentId) {
				case "talk":
					$.tracker.byStr('profile/talk_tab');
					break;
				case "profile":
					$.tracker.byStr('profile/profile_tab');
					break;
				case "contribs":
					$.tracker.byStr('profile/contribs_tab');
					break;
				case "blog":
					$.tracker.byStr('profile/blog_tab');
					break;
			}
		}
	});

	// categories
	$('#WikiaArticleCategories').click(function(ev) {
		var node = $(ev.target);

		// categories
		if (node.is('a')) {
			// "Add category" button
			if (node.parent().is('#csAddCategorySwitch')) {
				$.tracker.byStr('action/addcategory');
			}
			// links to categories
			else {
				$.tracker.byStr('contentpage/categorylink');
			}
		}
	});

	// toolbar
	$('#WikiaFooter').find('.tools').click(function(ev) {
		var fakeUrl = 'toolbar/';
		var node = $(ev.target);

		if (!node.is('a')) {
			return;
		}

		if (node.hasParent('.mytools')) {
			fakeUrl += 'mytools/';
		}

		// (un)watch + share
		if (node.attr('id')) {
			switch(node.attr('id')) {
				case 'ca-watch':
					$.tracker.byStr(fakeUrl + 'follow');
					break;

				case 'ca-unwatch':
					$.tracker.byStr(fakeUrl + 'unfollow');
					break;

				case 'control_share_feature':
					$.tracker.byStr(fakeUrl + 'share');
					break;
			}
		} else {
			if (node.hasClass('tools-customize')) {
				// Customize clicked
				$.tracker.byStr(fakeUrl + 'customize');
			} else if (node.attr('data-name')) {
				// Every other option clicked
				$.tracker.byStr(fakeUrl + node.attr('data-name'));
			} else if (node.parent().hasClass('mytools')) {
				// "My Tools" menu opened
				$.tracker.byStr(fakeUrl + 'open');
			} else if (node.data('tracking')) {
				$.tracker.byStr(node.data('tracking'));
			}
		}
	});

	// Page count module
	$('.WikiaPagesOnWikiModule').click(function(ev) {
		var node = $(ev.target);
		if(!node.is('a')) {
			return;
		}

		// Create a Page
		if (node.hasClass('wikia-button')) {
			$.tracker.byStr('action/createapage/module');
		}
	});

	// Latest Activity module
	$('.WikiaActivityModule').click(function(ev) {
		var fakeUrl = 'module/latestactivity/';
		var node = $(ev.target);

		if (!node.is('a')) {
			return;
		}
		// See more
		else if (node.hasClass('more')) {
			$.tracker.byStr(fakeUrl + 'more');
		}
		// items
		else if (node.hasParent('em')) {
			$.tracker.byStr(fakeUrl + 'article');
		}
		else if (node.hasParent('details')) {
			$.tracker.byStr(fakeUrl + 'username');
		}
	});

	// User Achievements module
	$('.AchievementsModule').click(function(ev) {
		var fakeUrl = 'module/userachievements/';
		var node = $(ev.target);

		if (!node.is('a')) {
			return;
		}

		// See all
		if (node.hasClass('view-all')) {
			$.tracker.byStr(fakeUrl + 'more');
		}
		// Customize badges
		else if (node.hasClass('more')) {
			$.tracker.byStr(fakeUrl + 'customize');
		}
		// Ranked #x
		else if (node.hasParent('p')) {
			$.tracker.byStr(fakeUrl + 'rank');
		}
	});

	// Followed Pages module
	$('.FollowedPagesModule').click(function(ev) {
		var fakeUrl = 'module/followedpages/';
		var node = $(ev.target);

		if (!node.is('a')) {
			return;
		}

		// See all
		if (node.hasClass('more')) {
			$.tracker.byStr(fakeUrl + 'more');
		}
		// items
		else if (node.hasParent('ul')) {
			var item = node.closest('li');
			var index = parseInt(item.index()) + 1;

			$.tracker.byStr(fakeUrl + index);
		}
	});

	// Hot Spots module
	$('.HotSpotsModule').click(function(ev) {
		var fakeUrl = 'module/hotspots/';
		var node = $(ev.target);

		if (!node.is('a')) {
			return;
		}

		// items
		if (node.hasParent('ul')) {
			var item = node.closest('li');
			var index = parseInt(item.index()) + 1;

			$.tracker.byStr(fakeUrl + index);
		}
	});

	// Community Corner module
	$('.CommunityCornerModule').click(function(ev) {
		var fakeUrl = 'module/communitycorner/';
		var node = $(ev.target);

		if (!node.is('a')) {
			return;
		}

		// "Edit message"
		if (node.hasClass('more')) {
			$.tracker.byStr(fakeUrl + 'edit');
		}
		else {
			$.tracker.byStr(fakeUrl + 'link');
		}
	});

	// Recent Earned Badges module
	$('.WikiaLatestEarnedBadgesModule').click(function(ev) {
		var fakeUrl = 'module/latestbadges/';
		var node = $(ev.target);

		if (!node.is('a')) {
			return;
		}

		// "See more"
		if (node.hasClass('more')) {
			$.tracker.byStr(fakeUrl + 'more');
		}
		else {
			$.tracker.byStr(fakeUrl + 'username');
		}
	});

	// Latest Photos module
	$('.LatestPhotosModule').click(function(ev) {
		var fakeUrl = 'module/latestphotos/';
		var node = $(ev.target);

		// fix for img within link
		if (node.is('img')) {
			node = node.parent();
		}

		if (!node.is('a')) {
			return;
		}

		// "See more"
		if (node.hasClass('more')) {
			$.tracker.byStr(fakeUrl + 'more');
		}
		// arrows
		else if (node.hasClass('previous')) {
			$.tracker.byStr(fakeUrl + 'arrow');
		}
		else if (node.hasClass('next')) {
			$.tracker.byStr(fakeUrl + 'arrow');
		}
		// "Add a photo"
		else if (node.hasClass('wikia-button')) {
			$.tracker.byStr('action/addphoto/photosmodule');
		}
		// photos
		else if (node.parent().is('li')) {
			$.tracker.byStr(fakeUrl + 'photo');
		}
	});

	// Popular Blog Posts module / <bloglist> parser hook
	$('.WikiaBlogListingBox').click(function(ev) {
		var fakeUrl = 'module/latestblogposts/';
		var node = $(ev.target);

		if (!node.is('a')) {
			return;
		}

		// Create blog post
		if (node.hasClass('wikia-button')) {
			fakeUrl = 'action/createblogpost/';

			// only for <bloglist> (within content)
			if (node.hasParent('#WikiaArticle')) {
				$.tracker.byStr(fakeUrl + 'bloglistingtag');
			}
			// right rail module
			else {
				$.tracker.byStr(fakeUrl + 'blogmodule');
			}
		}
		// items
		else if (node.hasParent('li')) {
			// comments button
			if (node.parent().hasClass('commentslikes')) {
				$.tracker.byStr(fakeUrl + 'comments');
			}
			// author
			else if (node.hasParent('details')) {
				$.tracker.byStr(fakeUrl + 'author');
			}
			// blog posts title
			else {
				$.tracker.byStr(fakeUrl + 'title');
			}
		}
	});

	// random wiki
	$('#WikiaRandomWiki').trackClick('randomwiki');

	// Corporate footer
	$('.CorporateFooter').click(function(ev) {
		var fakeUrl = 'corporatefooter/';
		var node = $(ev.target);

		// fix for "About us" link
		if (node.is('span')) {
			node = node.parent();
		}

		if (!node.is('a')) {
			return;
		}

		// http://www.wikia.com/About_Us - about_us
		var name = node.attr('href').match(/[:\/]([^:\/]+)$/).pop().toLowerCase();

		$.tracker.byStr(fakeUrl + name);
	});

	// content links
	$('#WikiaArticle').click(function(ev) {
		var fakeUrl = 'contentpage/';
		var node = $(ev.target);

		// fix for span and img within link
		if (node.is('img') || node.is('span')) {
			node = node.parent();
		}

		if (!node.is('a')) {
			return;
		}

		// do not track links inside RTE editor
		if (node.closest('.cke_editor').length > 0) {
			return;
		}
		// do not track category gallery links - they are tracked elsewhere
		if (node.closest('.category-gallery').length > 0) {
			return;
		}
		// redlinks
		if (node.hasClass('new')) {
			$.tracker.byStr(fakeUrl + 'redlink');
		}
		// section edit
		else if (node.parent().hasClass('editsection')) {
			$.tracker.byStr('action/sectionedit');
		}
		// TOC
		else if (node.hasParent('#toc')) {
			$.tracker.byStr(fakeUrl + 'toclink');
		}
		// reference link ([2])
		else if (node.parent().is('sup')) {
			$.tracker.byStr(fakeUrl + 'reflink');
		}
		// magnify icon (image thumbs)
		else if (node.parent().hasClass('magnify')) {
			$.tracker.byStr(fakeUrl + 'photodetails');
		}
		// photo attributions
		else if (node.parent().hasClass('picture-attribution')) {
			$.tracker.byStr(fakeUrl + 'photoattributon');
		}
		// lightbox
		else if (node.hasClass('image')) {
			$.tracker.byStr(fakeUrl + 'lightbox');
		}
		// image / video placeholder
		else if (node.hasParent('.wikiaPlaceholder')) {
			fakeUrl = 'action/';

			// yes, we need to do matching of ID here
			var placeholderId = node.parent().parent().attr('id');

			if (placeholderId && placeholderId.indexOf('WikiaImagePlaceholder') > -1) {
				// image placeholder
				$.tracker.byStr(fakeUrl + 'addphoto/placeholder');
			}
			else {
				if (node.hasParent('table.gallery')) {
					// add video to gallery
					$.tracker.byStr(fakeUrl + 'addvideo/gallery');
				}
				else {
					// video placeholder
					$.tracker.byStr(fakeUrl + 'addvideo/placeholder');
				}
			}
		}
		// "Add a photo to this gallery"
		else if (node.hasClass('wikia-photogallery-add')) {
			$.tracker.byStr('action/addphoto/gallery');
		}
		// "Add a photo" to slideshow
		else if (node.hasClass('wikia-slideshow-addimage')) {
			$.tracker.byStr('action/addphoto/slideshow');
		}
		// track clicks on the result of the links
		else {
			$.tracker.byStr(fakeUrl + 'contentlink');
		}
	});

	// Related Pages module
	$('.RelatedPagesModule').click(function(ev) {
		var fakeUrl = 'module/relatedpages/';
		var node = $(ev.target);

		if (node.is('img')) {
			node = node.parent();
		}

		if (!node.is('a')) {
			return;
		}

		if (node.hasClass('more')) {
			$.tracker.byStr(fakeUrl + 'link');
		}
		else {
			$.tracker.byStr(fakeUrl + 'image');
		}
	});

	// track clicks on Facebook's "Like" buttons
	if (typeof FB != 'undefined' && typeof FB.Event != 'undefined' /* (BugId: 11701) */) {
		FB.Event.subscribe('edge.create', function(resp) {
			$.tracker.byStr('pageheader/like');
		});

		FB.Event.subscribe('comments.add', function(resp) {
			$.tracker.byStr('pageheader/post');
		});
	}

	if (wgCanonicalSpecialPageName == "Search") {
		$.tracker.byStr('search/searchResults/view');
	}

	// BugId:2435 - track MW editor view
	if (window.wgIsEditPage && (typeof RTE == 'undefined')) {
		$.tracker.byStr('mweditor/init');

		$('#wpSave').bind('click', function(ev) {
			$.tracker.byStr('mweditor/save');
		});
	}

	// store timestamp when user left the page
	$(window).unload(function(ev) {
		if ($.storage) {
			$.storage.set('unloadstamp', (new Date()).getTime() /* UNIX timestamp */);
		}
	});

	var spotlightTrack = function(e, part) {
		var el = $(e.target);
		if(el.is('a') || el.is('img')) {
			$.tracker.byStr('spotlights/' + part + '/' + window.cityShort);
		}
	};

	// spotlights rail
	$('#SPOTLIGHT_RAIL').bind('click', function(e) {
		spotlightTrack(e, 'rail');
	});

	// spotlights footer
	$('#SPOTLIGHT_FOOTER').bind('click', function(e) {
		spotlightTrack(e, 'footer');
	});
};
