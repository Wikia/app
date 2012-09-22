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
				'internal');
		};
	
	$('#WikiaHeader').on('click', 'a', function(e) {
		var el = $(e.target);
		
		if(el.length === 0) {
			return true;
		}
		
		var category = 'top-nav';
		
		if(el.hasClass('logo')) {
			track(category, WikiaTracker.ACTIONS.CLICK, 'wikia-logo');
		} else if(el.parent().hasClass('start-a-wiki')) {
			track(category, WikiaTracker.ACTIONS.CLICK, 'start-a-wiki');
		} else if(el.closest('.topNav').length > 0) {
			track(category, WikiaTracker.ACTIONS.CLICK, 'hub-item');
		} else if(el.data('id') == 'mytalk') {
			track(category, WikiaTracker.ACTIONS.CLICK, 'user-menu-message-wall');
		} else if(el.attr('accesskey') == '.') {
			track(category, WikiaTracker.ACTIONS.CLICK, 'user-menu-profile');
		} else if(el.closest('.notifications-for-wiki').length > 0) {
			if($(el.closest('.notifications-for-wiki')).data('wiki-id') == window.wgCityId) {
				track(category, WikiaTracker.ACTIONS.CLICK, 'notification-item-local');
			} else {
				track(category, WikiaTracker.ACTIONS.CLICK, 'notification-item-cross-wiki');
			}
		}
	});
	
	$('#WikiHeader.WikiHeaderRestyle').on('click', 'a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}
		
		var category = 'wiki-nav';
		
		if(el.parent().hasClass('wordmark')) {
			track(category, WikiaTracker.ACTIONS.CLICK, 'wordmark');
		} else if(el.data('canonical')) {
			var canonical = el.data('canonical');
			switch(canonical) {
				case 'wikiactivity':
					track(category, WikiaTracker.ACTIONS.CLICK, 'on-the-wiki-activity');
					break;
				case 'random':
					track(category, WikiaTracker.ACTIONS.CLICK, 'on-the-wiki-random');
					break;
				case 'newfiles':
					track(category, WikiaTracker.ACTIONS.CLICK, 'on-the-wiki-new-photos');
					break;
				case 'chat':
					track(category, WikiaTracker.ACTIONS.CLICK, 'on-the-wiki-chat');
					break;
				case 'forum':
					track(category, WikiaTracker.ACTIONS.CLICK, 'on-the-wiki-forum');
					break;
				case 'videos':
					track(category, WikiaTracker.ACTIONS.CLICK, 'on-the-wiki-videos');
					break;
				default:
					break;
			}
		} else if(el.closest('.WikiNav').length > 0) {
			track(category, WikiaTracker.ACTIONS.CLICK, 'custom');
		}
	});
	
	$('#WikiaPageHeader').on('click', 'a', function(e) {
		var el = $(e.target);
		
		if(el.length === 0) {
			return true;
		}
		
		var category = 'article';
		
		if((el.data('id') || el.parent().data('id')) == 'edit') {
			track(category, WikiaTracker.ACTIONS.CLICK, 'edit');
		} else if((el.data('id') || el.parent().data('id')) == 'comment') {
			track(category, WikiaTracker.ACTIONS.CLICK, 'comment');
		}
	});
	
	$('#WikiaArticle .editsection').on('click', 'a', function(e) {
		var el = $(e.target);
		
		if(el.length === 0) {
			return true;
		}
		
		var category = 'article';
		
		if(el.closest('.editsection').length > 0) {
			track(category, WikiaTracker.ACTIONS.CLICK, 'section-edit');
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
				track(category, WikiaTracker.ACTIONS.CLICK, 'video');
			} else {
				track(category, WikiaTracker.ACTIONS.CLICK, 'image');
			}
		} else if(el.closest('.RelatedPagesModule').length > 0) {
			track(category, WikiaTracker.ACTIONS.CLICK, 'related-pages');
		} else if(el.closest('.category-gallery').length > 0) {
			track('category', WikiaTracker.ACTIONS.CLICK, 'category-gallery');
		}
	});
	
	$('#WikiaArticleCategories').on('click', 'a', function(e) {
		track('article', WikiaTracker.ACTIONS.CLICK, 'category-name');
	});
	
	$('#WikiaRail').on('click', '.WikiaActivityModule a, .LatestPhotosModule a, .ChatModule button', function(e) {
		var el = $(e.target);
		
		if(el.length === 0) {
			return true;
		}
		
		if(el.closest('.edited-by').length > 0) {
			track('recent-wiki-activity', WikiaTracker.ACTIONS.CLICK, 'activity-username');
		} else if(el.closest('.WikiaActivityModule').length > 0) {
			track('recent-wiki-activity', WikiaTracker.ACTIONS.CLICK, 'activity-title');
		} else if(el.hasClass('thumbimage')) {
			track('photos-module', WikiaTracker.ACTIONS.CLICK, 'photos-module-thumbnail');
		} else if(el.closest('.chat-join').length > 0) {
			track('chat-module', WikiaTracker.ACTIONS.CLICK, 'chat-join');
		}
	});
	
	if($('body.editor').length > 0) {
		// edit page view event
		track('edit', WikiaTracker.ACTIONS.VIEW, 'edit-page');
		$('#wpSave').on('click', '', function(e) {
			track('edit', WikiaTracker.ACTIONS.CLICK, 'publish');
		});
	}
	
});