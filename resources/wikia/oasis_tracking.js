/* tracking for oasis skin */
jQuery(function($){
	var $wikiaArticle = $('#WikiaArticle');
	var $wikiaRail = $('#WikiaRail');

	var track = WikiaTracker.buildTrackWithDefaults({
		action: WikiaTracker.ACTIONS.CLICK,
		trackingMethod: 'ga'
	});

	var trackWithEventData = function(e) {
		track($.extend({
			browserEvent: e
		}, e.data));
	};

	/** article **/

	(function() {
		var category = 'article';

		$('#WikiaPageHeader').on('click', 'a', function(e) {
			var label,
				el = $(e.target);

			if((el.data('id') || el.parent().data('id')) == 'edit') {
				label = 'edit';
			} else if((el.data('id') || el.parent().data('id')) == 'comment') {
				if(el.hasClass('talk') || el.parent().hasClass('talk')) {
					label = 'talk';
				} else {
					label = 'comment';
				}
			}

			if (label !== undefined) {
				track({
					browserEvent: e,
					category: category,
					label: label
				});
			}
		});

		$wikiaArticle.on('click', 'a.image', function(e) {
			var label,
				el = $(e.target);

			if (el.closest('.video').length > 0) {
				label = 'video';
			} else {
				label = 'image';
			}

			if (label !== undefined) {
				track({
					browserEvent: e,
					category: category,
					label: label
				});
			}
		}).on('click', '.RelatedPagesModule a', {
			category: category,
			label: 'related-pages'
		}, trackWithEventData).on('click', '.editsection a', {
			category: category,
			label: 'section-edit'
		});

		$('#WikiaArticleCategories').on('click', 'a', {
			category: category,
			label: 'category-name'
		}, trackWithEventData);
	})();

	/** category **/

	(function() {
		var category = 'category';

		$wikiaArticle.on('click', '.category-gallery a', {
			category: category,
			label: 'category-gallery'
		}, trackWithEventData);

		$('#mw-pages').on('click', 'a', {
			category: category,
			label: 'category-item'
		}, trackWithEventData);
	})();

	/** chat-module **/

	$wikiaRail.find('.ChatModule').on('click', '.chat-join', {
		category: 'chat-module',
		label: 'chat-join'
	}, trackWithEventData);

	/** edit **/

	(function() {
		var category = 'edit';

		// Stop here if not an edit page
		if(!$('body.editor').length) {
			return;
		}

		track({
			action: WikiaTracker.ACTIONS.VIEW,
			category: category,
			label: 'edit-page'
		});

		$('#wpSave').on('click', {
			category: category,
			label: 'publish'
		}, trackWithEventData);
	})();

	/** photos-module **/

	$wikiaRail.find('.LatestPhotosModule')on('click', 'a', function(e) {
		var label,
			el = $(e.target);

		if(el.hasClass('thumbimage')) {
			label = 'photos-module-thumbnail';
		} else if(el.hasClass('upphotos')) {
			label ='photos-module-add';
		}

		if (label !== undefined) {
			track({
				browserEvent: e,
				category: 'photos-module',
				label: label
			});
		}
	});

	/** recent-wiki-activity **/

	$wikiaRail.find('.WikiaActivityModule').on('click', 'a', function(e) {
		var label,
			el = $(e.target);

		if(el.closest('.edited-by').length > 0) {
			label = 'activity-username';
		} else if(el.closest('em').length > 0) {
			label = 'activity-title';
		}

		if (label !== undefined) {
			track({
				browserEvent: e,
				category: 'recent-wiki-activity',
				label: label
			});
		}
	});

	/** search **/

	(function() {
		var category = 'search';

		$('#WikiaSearch').on('click', '.autocomplete', {
			category: category,
			label: 'search-suggest'
		}, trackWithEventData).on('click', '.wikia-button', {
			category: category,
			label: 'search-button'
		}, trackWithEventData).on('submit', {
			category: category,
			label: 'search-enter'
		}, trackWithEventData);
	})();

	/** thread-module **/

	$('#RelatedForumDiscussion').on('click', 'a', function(e) {
		var label,
			el = $(e.target);

		if (el.hasClass('forum-thread-title')) {
			label = 'title';
		} else if (el.hasClass('forum-new-post')) {
			label = 'start-discussion';
		} else if (el.parent().hasClass('forum-see-more')) {
			label = 'see-more';
		}

		if (label !== undefined) {
			track({
				browserEvent: e,
				category: 'thread-module',
				label: label
			});
		}
	});

	/** toolbar **/

	$('#WikiaBarWrapper').on('click', '.toolbar a', function(e) {
		var label,
			el = $(e.target),
			name = el.data('name');

		switch(name) {
			case 'follow':
			case 'history': {
				label = name;
				break;
			}
			case 'whatlinkshere': {
				label = 'what-links-here';
				break;
			}
			default: {
				label = 'custom';
				break;
			}
		}

		if (label !== undefined) {
			track({
				browserEvent: e,
				category: 'toolbar',
				label: label
			});
		}
	});

	/** top-nav **/

	$('#WikiaHeader').on('click', 'a', function(e) {
		var label,
			el = $(e.target),
			id = el.data('id');

		if (id !== undefined) {
			switch(id) {
				case 'login': {
					label = 'login';
					break;
				}
				case 'mytalk': {
					label = 'user-menu' + el.hasClass('message-wall') ? 'message-wall' : 'talk';
					break;
				}
				case 'register': {
					label = 'signup';
					break;
				}
			}
		} else if(el.hasClass('logo')) {
			label = 'wikia-logo';
		} else if(el.parent().hasClass('start-a-wiki')) {
			label = 'start-a-wiki';
		} else if(el.closest('.topNav').length > 0) {
			label = 'hub-item';
		} else if(el.attr('accesskey') == '.') {
			label = 'user-menu-profile';
		} else if(el.closest('.notifications-for-wiki').length > 0) {
			if($(el.closest('.notifications-for-wiki')).data('wiki-id') == window.wgCityId) {
				label = 'notification-item-local';
			} else {
				label = 'notification-item-cross-wiki';
			}
		}

		if (label !== undefined) {
			track({
				browserEvent: e,
				category: 'top-nav',
				label: label
			});
		}
	});

	/** wiki-nav **/

	$('#WikiHeader').on('click', 'a', function(e) {
		var label,
			el = $(e.target);

		if(el.closest('.wordmark').length > 0) {
			label = 'wordmark';
		} else if(el.data('canonical')) {
			var canonical = el.data('canonical');
			switch(canonical) {
				case 'wikiactivity':
					label = 'on-the-wiki-activity';
					break;
				case 'random':
					label = 'on-the-wiki-random';
					break;
				case 'newfiles':
					label = 'on-the-wiki-new-photos';
					break;
				case 'chat':
					label = 'on-the-wiki-chat';
					break;
				case 'forum':
					label = 'on-the-wiki-forum';
					break;
				case 'videos':
					label = 'on-the-wiki-videos';
					break;
			}
		} else if(el.closest('.WikiNav').length > 0) {
			label = 'custom';
		}

		if (label !== undefined) {
			track({
				browserEvent: e,
				category: 'wiki-nav',
				label: label
			});
		}
	});
});