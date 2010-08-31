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
			$.tracker.byStr(fakeUrl + 'startawiki');
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
			else {
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
		var fakeUrl = 'pageheader/';
		var node = $(ev.target);

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

		// edit button dropdown
		else if (node.hasParent('.wikia-menu-button')) {
			var fakeUrl = 'action/';
			$.tracker.byStr(fakeUrl + node.attr('data-id'));
		}
		// create a page (on main page)
		else if (node.parent().hasClass('tally')) {
			var fakeUrl = 'action/';
			$.tracker.byStr(fakeUrl + 'createapage');
		}
	});

	// user page header
	$('#WikiaUserPagesHeader').click(function(ev) {
		var fakeUrl = 'action/';
		var node = $(ev.target);

		// clicks on image inside "edit" link
		if (node.is('img')) {
			node = node.parent();
		}

		// create blog post button + edit button + edit dropdown items + comments
		if (node.attr('data-id')) {
			$.tracker.byStr(fakeUrl + node.attr('data-id'));
		}
	});

	// categories
	$('#WikiaArticleCategories').click(function(ev) {
		var node = $(ev.target);

		// categories
		if (node.is('a')) {
			// "Add category" button
			if (node.parent().is('#csAddCategorySwitch')) {
				$.tracker.byStr(fakeUrl + 'addcategory');
			}
			// links to categories
			else {
				$.tracker.byStr('contentpage/categorylink');
			}
		}
	});

	// toolbar
	$('#WikiaFooter').find('.share').click(function(ev) {
		var fakeUrl = 'toolbar/';
		var node = $(ev.target);

		if (!node.is('a')) {
			return;
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
		}
		// my tools
		else if (node.hasParent('.mytools')) {
			fakeUrl += 'mytools/';

			// menu links
			if (node.hasParent('#my-tools-menu')) {
				// "Edit My Tools"
				if (node.hasClass('my-tools-edit')) {
					$.tracker.byStr(fakeUrl + 'edit');
				}
				else {
					$.tracker.byStr(fakeUrl + 'link');
				}
			}
			// "My Tools" link
			else {
				$.tracker.byStr(fakeUrl + 'open');
			}
		}
	});

	// Latest Activity module
	$('.WikiaActivityModule').click(function(ev) {
		var fakeUrl = 'module/latestactivity/';
		var node = $(ev.target);

		if (!node.is('a')) {
			return;
		}

		// Create a Page
		if (node.hasClass('wikia-button')) {
			$.tracker.byStr(fakeUrl + 'createpage');
		}
		// See more
		else if (node.hasClass('more')) {
			$.tracker.byStr(fakeUrl + 'more');
		}
		// items
		else if (node.hasParent('li')) {
			var item = node.closest('li');
			var index = parseInt(item.index()) + 1;

			$.tracker.byStr(fakeUrl + index);
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

	// random wiki
	$('#WikiaRandomWiki').trackClick('randomwiki');

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

		// redlinks
		if (node.hasClass('new')) {
			$.tracker.byStr(fakeUrl + 'redlink');
		}
		// section edit
		else if (node.hasClass('editsection')) {
			$.tracker.byStr(fakeUrl + 'sectionedit');
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
			// yes, we need to do matching of ID here
			var placeholderId = node.parent().parent().attr('id');

			if (placeholderId.indexOf('WikiaImagePlaceholder') > -1) {
				// image placeholder
				$.tracker.byStr(fakeUrl + 'addphoto');
			}
			else {
				if (node.hasParent('table.gallery')) {
					// add video to gallery
					$.tracker.byStr(fakeUrl + 'addtovideogallery');
				}
				else {
					// video placeholder
					$.tracker.byStr(fakeUrl + 'addvideo');
				}
			}
		}
		// track clicks on the result of the links
		else {
			$.tracker.byStr(fakeUrl + 'contentlink');
		}
	});
}