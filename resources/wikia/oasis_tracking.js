/* tracking for oasis skin */
$(function(){

	var tracker = window.WikiaTracker || {trackEvent:function(){/* null function */}},
		track = function(category, action, label, event) {
			WikiaTracker.trackEvent(
				'trackingevent',
				{
					ga_category: category,
					ga_action: action,
					ga_label: label
				},
				'ga',
				event
			);
		},
		clickAction = WikiaTracker.ACTIONS.CLICK,
		viewAction = WikiaTracker.ACTIONS.VIEW;

	$('#WikiaHeader').on('click', 'a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var category = 'top-nav';

		if(el.hasClass('logo')) {
			track(category, clickAction, 'wikia-logo', e);
		} else if(el.parent().hasClass('start-a-wiki')) {
			track(category, clickAction, 'start-a-wiki');
		} else if(el.closest('.topNav').length > 0) {
			track(category, clickAction, 'hub-item', e);
		} else if(el.data('id') == 'mytalk') {
			if(el.hasClass('message-wall-item')) {
				track(category, clickAction, 'user-menu-message-wall', e);
			} else {
				track(category, clickAction, 'user-menu-talk', e);
			}
		} else if(el.attr('accesskey') == '.') {
			track(category, clickAction, 'user-menu-profile', e);
		} else if(el.closest('.notifications-for-wiki').length > 0) {
			if($(el.closest('.notifications-for-wiki')).data('wiki-id') == window.wgCityId) {
				track(category, clickAction, 'notification-item-local', e);
			} else {
				track(category, clickAction, 'notification-item-cross-wiki', e);
			}
		}
	});

	$('#WikiHeader').on('click', 'a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var category = 'wiki-nav';

		if(el.closest('.wordmark').length > 0) {
			track(category, clickAction, 'wordmark', e);
		} else if(el.data('canonical')) {
			var canonical = el.data('canonical');
			switch(canonical) {
				case 'wikiactivity':
					track(category, clickAction, 'on-the-wiki-activity', e);
					break;
				case 'random':
					track(category, clickAction, 'on-the-wiki-random', e);
					break;
				case 'newfiles':
					track(category, clickAction, 'on-the-wiki-new-photos', e);
					break;
				case 'chat':
					track(category, clickAction, 'on-the-wiki-chat', e);
					break;
				case 'forum':
					track(category, clickAction, 'on-the-wiki-forum', e);
					break;
				case 'videos':
					track(category, clickAction, 'on-the-wiki-videos', e);
					break;
				default:
					break;
			}
		} else if(el.closest('.WikiNav').length > 0) {
			track(category, clickAction, 'custom', e);
		}
	});

	$('#WikiaPageHeader').on('click', 'a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var category = 'article';

		if((el.data('id') || el.parent().data('id')) == 'edit') {
			track(category, clickAction, 'edit', e);
		} else if((el.data('id') || el.parent().data('id')) == 'comment') {
			if(el.hasClass('talk') || el.parent().hasClass('talk')) {
				track(category, clickAction, 'talk', e);
			} else {
				track(category, clickAction, 'comment', e);
			}
		}
	});

	$('#WikiaArticle .editsection').on('click', 'a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var category = 'article';

		if(el.closest('.editsection').length > 0) {
			track(category, clickAction, 'section-edit', e);
		}
	});

	$('#WikiaArticle').on('click', 'a.image, .RelatedPagesModule a, .category-gallery a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var category = 'article';

		if(el.parent().hasClass('image')) {
			if(el.parent().hasClass('video')) {
				track(category, clickAction, 'video', e);
			} else {
				track(category, clickAction, 'image', e);
			}
		} else if(el.closest('.RelatedPagesModule').length > 0) {
			track(category, clickAction, 'related-pages', e);
		} else if(el.closest('.category-gallery').length > 0) {
			track('category', clickAction, 'category-gallery', e);
		}
	});

	$('#WikiaArticleCategories').on('click', 'a', function(e) {
		track('article', clickAction, 'category-name', e);
	});

	$('#WikiaRail').on('click', '.WikiaActivityModule a, .LatestPhotosModule a, .ChatModule button', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		if(el.closest('.edited-by').length > 0) {
			track('recent-wiki-activity', clickAction, 'activity-username', e);
		} else if(el.closest('.WikiaActivityModule').length > 0) {
			track('recent-wiki-activity', clickAction, 'activity-title', e);
		} else if(el.hasClass('thumbimage')) {
			track('photos-module', clickAction, 'photos-module-thumbnail', e);
		} else if(el.closest('.chat-join').length > 0) {
			track('chat-module', clickAction, 'chat-join', e);
		}
	});

	$('#WikiaSearch').on('click', '.autocomplete', function(e) {
		track('search', clickAction, 'search-suggest', e);
	}).on('submit', '', function(e) {
		track('search', clickAction, 'search-enter', e);
	});

	if($('body.editor').length > 0) {
		// edit page view event
		track('edit', viewAction, 'edit-page');
		$('#wpSave').on('click', '', function(e) {
			track('edit', clickAction, 'publish', e);
		});
	}

	$('#RelatedForumDiscussion').on('click', '.forum-thread-title, .forum-new-post, .forum-see-more a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var category = 'thread-module';

		if(el.hasClass('forum-thread-title')) {
			track(category, clickAction, 'title', e);
		} else if(el.hasClass('forum-new-post')) {
			track(category, clickAction, 'start-discussion', e);
		} else if(el.closest('.forum-see-more').length > 0) {
			track(category, clickAction, 'see-more', e);
		}
	});

});