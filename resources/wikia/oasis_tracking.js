/* tracking for oasis skin */
$(function(){

	var tracker = window.WikiaTracker || {trackEvent:function(){/* null function */}},
		track = function(category, action, label) {
			WikiaTracker.trackEvent(
				'trackingevent', 
				{
					ga_category: category,
					ga_action: action,
					ga_label: label
				}, 
				'ga');
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
			track(category, clickAction, 'wikia-logo');
		} else if(el.parent().hasClass('start-a-wiki')) {
			track(category, clickAction, 'start-a-wiki');
		} else if(el.closest('.topNav').length > 0) {
			track(category, clickAction, 'hub-item');
		} else if(el.data('id') == 'mytalk') {
			if(el.hasClass('message-wall-item')) {
				track(category, clickAction, 'user-menu-message-wall');
			} else {
				track(category, clickAction, 'user-menu-talk');
			}
		} else if(el.attr('accesskey') == '.') {
			track(category, clickAction, 'user-menu-profile');
		} else if(el.closest('.notifications-for-wiki').length > 0) {
			if($(el.closest('.notifications-for-wiki')).data('wiki-id') == window.wgCityId) {
				track(category, clickAction, 'notification-item-local');
			} else {
				track(category, clickAction, 'notification-item-cross-wiki');
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
			track(category, clickAction, 'wordmark');
		} else if(el.data('canonical')) {
			var canonical = el.data('canonical');
			switch(canonical) {
				case 'wikiactivity':
					track(category, clickAction, 'on-the-wiki-activity');
					break;
				case 'random':
					track(category, clickAction, 'on-the-wiki-random');
					break;
				case 'newfiles':
					track(category, clickAction, 'on-the-wiki-new-photos');
					break;
				case 'chat':
					track(category, clickAction, 'on-the-wiki-chat');
					break;
				case 'forum':
					track(category, clickAction, 'on-the-wiki-forum');
					break;
				case 'videos':
					track(category, clickAction, 'on-the-wiki-videos');
					break;
				default:
					break;
			}
		} else if(el.closest('.WikiNav').length > 0) {
			track(category, clickAction, 'custom');
		}
	});
	
	$('#WikiaPageHeader').on('click', 'a', function(e) {
		var el = $(e.target);
		
		if(el.length === 0) {
			return true;
		}
		
		var category = 'article';
		
		if((el.data('id') || el.parent().data('id')) == 'edit') {
			track(category, clickAction, 'edit');
		} else if((el.data('id') || el.parent().data('id')) == 'comment') {
			if(el.hasClass('talk') || el.parent().hasClass('talk')) {
				track(category, clickAction, 'talk');
			} else {
				track(category, clickAction, 'comment');
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
			track(category, clickAction, 'section-edit');
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
				track(category, clickAction, 'video');
			} else {
				track(category, clickAction, 'image');
			}
		} else if(el.closest('.RelatedPagesModule').length > 0) {
			track(category, clickAction, 'related-pages');
		} else if(el.closest('.category-gallery').length > 0) {
			track('category', clickAction, 'category-gallery');
		}
	});
	
	$('#WikiaArticleCategories').on('click', 'a', function(e) {
		track('article', clickAction, 'category-name');
	});
	
	$('#WikiaRail').on('click', '.WikiaActivityModule a, .LatestPhotosModule a, .ChatModule button', function(e) {
		var el = $(e.target);
		
		if(el.length === 0) {
			return true;
		}
		
		if(el.closest('.edited-by').length > 0) {
			track('recent-wiki-activity', clickAction, 'activity-username');
		} else if(el.closest('.WikiaActivityModule').length > 0) {
			track('recent-wiki-activity', clickAction, 'activity-title');
		} else if(el.hasClass('thumbimage')) {
			track('photos-module', clickAction, 'photos-module-thumbnail');
		} else if(el.closest('.chat-join').length > 0) {
			track('chat-module', clickAction, 'chat-join');
		}
	});
	
	$('#WikiaSearch').on('click', '.autocomplete', function(e) {
		track('search', clickAction, 'search-suggest');
	}).on('submit', '', function(e) {
		track('search', clickAction, 'search-enter');
	});
	
	if($('body.editor').length > 0) {
		// edit page view event
		track('edit', viewAction, 'edit-page');
		$('#wpSave').on('click', '', function(e) {
			track('edit', clickAction, 'publish');
		});
	}

	$('#RelatedForumDiscussion').on('click', '.forum-thread-title, .forum-new-post, .forum-see-more a', function(e) {
		var el = $(e.target);
		
		if(el.length === 0) {
			return true;
		}
		
		var category = 'thread-module';
		
		if(el.hasClass('forum-thread-title')) {
			track(category, WikiaTracking.ACTIONS.CLICK, 'title');
		} else if(el.hasClass('forum-new-post')) {
			track(category, WikiaTracking.ACTIONS.CLICK, 'start-discussion');
		} else if(el.closest('forum-see-more').length > 0) {
			track(category, WikiaTracking.ACTIONS.CLICK, 'see-more');
		}
	});
	
});