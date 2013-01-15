/* tracking for oasis skin */
jQuery(function($){
	var track = WikiaTracker.buildTrackWithDefaults({
		action: WikiaTracker.ACTIONS.CLICK,
		trackingMethod: 'ga'
	});

	$('#WikiaHeader').on('click', 'a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var options = {
			browserEvent: e,
			category: 'top-nav'
		};

		if(el.hasClass('logo')) {
			track(options, {
				label: 'wikia-logo'
			});
		} else if(el.parent().hasClass('start-a-wiki')) {
			track(options, {
				label: 'start-a-wiki'
			});
		} else if(el.closest('.topNav').length > 0) {
			track(options, {
				label: 'hub-item'
			});
		} else if(el.data('id') == 'mytalk') {
			if(el.hasClass('message-wall')) {
				track(options, {
					label: 'user-menu-message-wall'
				});
			} else {
				track(options, {
					label: 'user-menu-talk'
				});
			}
		} else if(el.attr('accesskey') == '.') {
			track(options, {
				label: 'user-menu-profile'
			});
		} else if(el.closest('.notifications-for-wiki').length > 0) {
			if($(el.closest('.notifications-for-wiki')).data('wiki-id') == window.wgCityId) {
				track(options, {
					label: 'notification-item-local'
				});
			} else {
				track(options, {
					label: 'notification-item-cross-wiki'
				});
			}
		}
	});

	$('#WikiHeader').on('click', 'a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var options = {
			browserEvent: e,
			category: 'wiki-nav'
		};

		if(el.closest('.wordmark').length > 0) {
			track(options, {
				label: 'wordmark'
			});
		} else if(el.data('canonical')) {
			var canonical = el.data('canonical');
			switch(canonical) {
				case 'wikiactivity':
					track(options, {
						label: 'on-the-wiki-activity'
					});
					break;
				case 'random':
					track(options, {
						label: 'on-the-wiki-random'
					});
					break;
				case 'newfiles':
					track(options, {
						label: 'on-the-wiki-new-photos'
					});
					break;
				case 'chat':
					track(options, {
						label: 'on-the-wiki-chat'
					});
					break;
				case 'forum':
					track(options, {
						label: 'on-the-wiki-forum'
					});
					break;
				case 'videos':
					track(options, {
						label: 'on-the-wiki-videos'
					});
					break;
				default:
					break;
			}
		} else if(el.closest('.WikiNav').length > 0) {
			track(options, {
				label: 'custom'
			});
		}
	});

	$('#WikiaPageHeader').on('click', 'a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var options = {
			browserEvent: e,
			category: 'article'
		};

		if((el.data('id') || el.parent().data('id')) == 'edit') {
			track(options, {
				label: 'edit'
			});
		} else if((el.data('id') || el.parent().data('id')) == 'comment') {
			if(el.hasClass('talk') || el.parent().hasClass('talk')) {
				track(options, {
					label: 'talk'
				});
			} else {
				track(options, {
					label: 'comment'
				});
			}
		}
	});

	$('#WikiaArticle .editsection').on('click', 'a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		if(el.closest('.editsection').length > 0) {
			track({
				browserEvent: e,
				category: 'article',
				label: 'section-edit'
			});
		}
	});

	$('#WikiaArticle').on('click', 'a.image, .RelatedPagesModule a, .category-gallery a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var options = {
			browserEvent: e,
			category: 'article'
		};

		if(el.parent().hasClass('image')) {
			if(el.parent().hasClass('video')) {
				track(options, {
					label: 'video'
				});
			} else {
				track(options, {
					label: 'image'
				});
			}
		} else if(el.closest('.RelatedPagesModule').length > 0) {
			track(options, {
				label: 'related-pages'
			});
		} else if(el.closest('.category-gallery').length > 0) {
			track(options, {
				label: 'category-gallery'
			});
		}
	});

	$('#WikiaArticleCategories').on('click', 'a', function(e) {
		track({
			category: 'article',
			label: 'category-name'
		});
	});

	$('#WikiaRail').on('click', '.WikiaActivityModule a, .LatestPhotosModule a, .ChatModule button', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		if(el.closest('.edited-by').length > 0) {
			track({
				category: 'recent-wiki-activity',
				label: 'activity-username'
			});
		} else if(el.closest('.WikiaActivityModule').length > 0) {
			track({
				category: 'recent-wiki-activity',
				label: 'activity-title'
			});
		} else if(el.hasClass('thumbimage')) {
			track({
				category: 'photos-module',
				label: 'photos-module-thumbnail'
			});
		} else if(el.closest('.chat-join').length > 0) {
			track({
				category: 'chat-module',
				label: 'chat-join'
			});
		}
	});

	$('#WikiaSearch').on('click', '.autocomplete', function(e) {
		track({
			category: 'search',
			label: 'search-suggest'
		});
	}).on('submit', '', function(e) {
		track({
			category: 'search',
			label: 'search-enter'
		});
	});

	if($('body.editor').length > 0) {
		track({
			action: WikiaTracker.ACTIONS.VIEW,
			category: 'edit',
			label: 'edit-page'
		});

		$('#wpSave').on('click', '', function(e) {
			track({
				category: 'edit',
				label: 'publish'
			});
		});
	}

	$('#RelatedForumDiscussion').on('click', '.forum-thread-title, .forum-new-post, .forum-see-more a', function(e) {
		var el = $(e.target);

		if(el.length === 0) {
			return true;
		}

		var options = {
			browserEvent: e,
			category: 'thread-module'
		};

		if(el.hasClass('forum-thread-title')) {
			track(options, {
				label: 'title'
			});
		} else if(el.hasClass('forum-new-post')) {
			track(options, {
				label: 'start-discussion'
			});
		} else if(el.closest('.forum-see-more').length > 0) {
			track(options, {
				label: 'see-more'
			});
		}
	});
});