/* tracking for oasis skin */
jQuery(function($){
	var $body = $('body'),
		$wikiaArticle = $('#WikiaArticle'),
		$wikiaRail = $('#WikiaRail'),
		$wikiHeader = $('#WikiHeader'),
		rHrefDiff = /&diff=\d+/,
		rHrefHistory = /&action=history/;

	var track = WikiaTracker.buildTrackingFunction({
		action: WikiaTracker.ACTIONS.CLICK,
		trackingMethod: 'ga'
	});

	var trackWithEventData = function(e) {
		track({ browserEvent: e }, e.data);
	};

	/** article **/

	(function() {
		var category = 'article';

		// Not special pages
		if ($body.hasClass('ns-special')) {
			return;
		}

		$('#WikiaPageHeader').on('click', 'a', function(e) {
			var label,
				el = $(e.currentTarget),
				id = el.data('id');

			switch(id) {
				case 'comment': {
					label = el.hasClass('talk') ? 'talk' : 'comment';
					break;
				}
				case 'edit': {
					label = id;
					break;
				}
				case 'delete':
				case 'history':
				case 'move':
				case 'protect': {
					label = 'edit-' + id;
					break;
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

		$wikiaArticle.on('click', 'a', function(e) {
			var label,
				el = $(e.currentTarget);

			if (el.hasClass('video')) {
				label = 'video';
			} else if (el.hasClass('image')) {
				label = 'image';
			} else if (el.hasClass('external')) {
				label = 'link-external';
			} else if (el.hasClass('wikia-photogallery-add')) {
				label = 'add-photo-to-gallery';
			} else if (el.prop('className') == '') {
				label = 'link-internal';
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

	/** contribute **/

	$wikiHeader.find('.buttons .contribute').on('click', 'a', function(e) {
		var label,
			el = $(e.target),
			id = el.data('id');

		switch(id) {
			case 'createpage': {
				label = 'add-a-page';
				break;
			}
			case 'edit': {
				label = 'edit-a-page';
				break;
			}
			case 'upload': {
				label = 'add-a-photo';
				break;
			}
			case 'wikiavideoadd': {
				label = 'add-a-video';
				break;
			}
			case 'wikiactivity': {
				label = 'wiki-activity';
				break;
			}
			case 'wikinavedit': {
				label = 'edit-wiki-navigation';
				break;
			}
		}

		if (label !== undefined) {
			track({
				browserEvent: e,
				category: 'contribute',
				label: label
			});
		}
	});

	/** edit **/

	(function() {
		var category = 'edit';

		// Stop here if not an edit page
		if(!$body.hasClass('editor')) {
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

		$('#EditPageRail').on('click', '.module_insert .cke_button', function(e) {
			var label,
				el = $(e.currentTarget);

			if (el.hasClass('RTEImageButton')) {
				label = 'add-photo';
			} else if (el.hasClass('RTEGalleryButton')) {
				label = 'add-gallery';
			} else if (el.hasClass('RTESlideshowButton')) {
				label = 'add-slideshow';
			} else if (el.hasClass('RTEVideoButton')) {
				label = 'add-video';
			} else if (el.hasClass('RTEPollButton')) {
				label = 'add-poll';
			} else if (el.hasClass('cke_button_table')) {
				label = 'add-table';
			}

			if (label !== undefined) {
				track({
					browserEvent: e,
					category: category,
					label: label
				});
			}
		});
	})();

	/** photos-module **/

	$wikiaRail.find('.LatestPhotosModule').on('click', 'a', function(e) {
		var label,
			el = $(e.target);

		if (el.hasClass('thumbimage')) {
			label = 'photos-module-thumbnail';
		} else if (el.hasClass('upphotos')) {
			label = 'photos-module-add';
		} else if (el.hasClass('more')) {
			label = 'photos-module-more';
		}

		if (label !== undefined) {
			track({
				browserEvent: e,
				category: 'photos-module',
				label: label
			});
		}
	});

	/** recent-changes **/

	if ($body.hasClass('page-Special_RecentChanges')) {
		$wikiaArticle.find('.rc-conntent').on('click', 'a', function(e) {
			var label,
				el = $(e.target),
				href = el.attr('href');

			if (rHrefDiff.test(href)) {
				label = 'diff';
			} else if (rHrefHistory.test(href)) {
				label = 'history';
			} else if (el.hasClass('mw-userlink')) {
				label = 'username';
			} else if (!el.parent().is('span')) {
				label = 'title';
			}

			if (label !== undefined) {
				track({
					browserEvent: e,
					category: 'recent-changes',
					label: label
				});
			}
		});
	}

	/** recent-wiki-activity **/

	$wikiaRail.find('.WikiaActivityModule').on('click', 'a', function(e) {
		var label,
			el = $(e.target);

		if (el.hasClass('more')) {
			label = 'activity-more';
		} else if(el.closest('.edited-by').length > 0) {
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
		var category = 'search',
			$wikiaSearch = $('.WikiaSearch');

		$wikiaSearch.on('click', '.autocomplete', {
			category: category,
			label: 'search-suggest'
		}, trackWithEventData).on('click', '.wikia-button', function(e) {
			// Prevent tracking 'fake' form submission clicks
			if (e.clientX > 0) {
				track({
					category: category,
					label: 'search-button'
				});
			}
		}).on('keypress', function(e) {
			if (e.which === 13) {
				track({
					category: category,
					label: 'search-enter'
				});
			}
		});

		if ($body.hasClass('page-Special_Search')) {
			$wikiaSearch.on('click', '.search-tabs a', function(e) {
				track({
					browserEvent: e,
					category: category,
					label: 'sidebar-' + $(e.currentTarget).prop('className')
				});
			}).on('click', '.Results .result-link', function(e) {
				var el = $(e.currentTarget);

				track({
					browserEvent: e,
					category: category,
					label: 'result-' + (el.hasClass('search_click_match') ? 'push-top' : 'item-' + el.data('pos'))
				});
			}).on('click', '.image', function(e) {
				track({
					browserEvent: e,
					category: category,
					label: 'result-' + ($(e.currentTarget).hasClass('video') ? 'video' : 'photo')
				});
			});
		}
	})();

	/** share **/

	(function() {
		var category = 'share';

		$wikiHeader.on('click', '.share-button', {
			category: category,
			label: 'share-button'
		}, trackWithEventData);

		$wikiHeader.on('click', '.SharingToolbar .email-link', {
			category: category,
			label: 'email'
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
			case 'customize':
			case 'follow':
			case 'history':
			case 'whatlinkshere': {
				label = name;
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

	(function() {
		var category = 'top-nav';

		$('#WikiaHeader').on('click', 'a', function(e) {
			var label,
				el = $(e.target),
				id = el.data('id');

			if (id !== undefined) {
				switch(id) {
					case 'facebook':
					case 'register': {
						label = id;
						break;
					}
					case 'help':
					case 'logout':
					case 'preferences': {
						label = 'user-menu-' + id;
						break;
					}
					case 'mytalk': {
						label = 'user-menu-' + (el.hasClass('message-wall') ? 'message-wall' : 'talk');
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
					category: category,
					label: label
				});
			}
		});

		$('#UserLoginDropdown input[type=submit]').on('click', {
			category: category,
			label: 'login'
		}, trackWithEventData);

		$('#wall-notifications-markasread').on('click', 'span', function(e) {
			var label,
				el = $(e.target),
				id = el.attr('id');

			switch(id) {
				case 'wall-notifications-markasread-this-wiki':
				case 'wall-notifications-markasread-all-wikis': {
					label = id;
					break;
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
	})();

	/** wiki-activity **/

	if ($body.hasClass('page-Special_WikiActivity')) {
		$wikiaArticle.find('.activityfeed').on('click', 'a', function(e) {
			var label, type,
				el = $(e.target),
				parent = el.parent();

			if (el.hasClass('title')) {
				label = 'title';
			} else if (el.hasClass('username') ||
				el.hasClass('real-name') ||
				parent.hasClass('wall-owner') ||
				parent.hasClass('subtle')
			) {
				label = 'username';
			} else if (parent.hasClass('activityfeed-diff')) {
				label = 'diff';
			} else {
				type = el.closest('tr').data('type');

				if (type == 'inserted-image') {
					label = 'thumbnail-photo';
				} else if (type == 'inserted-video') {
					label = 'thumbnail-video';
				}
			}

			if (label !== undefined) {
				track({
					browserEvent: e,
					category: 'wiki-activity',
					label: label
				});
			}
		});
	}

	/** wiki-nav **/

	$wikiHeader.on('click', 'a', function(e) {
		var label,
			el = $(e.target);

		if (el.closest('.wordmark').length > 0) {
			label = 'wordmark';
		} else if (el.closest('.WikiNav').length > 0) {
			var canonical = el.data('canonical');
			if (canonical !== undefined) {
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
			} else if (el.parent().hasClass('nav-item')) {
				label = 'custom-level-1';
			} else if (el.hasClass('subnav-2a')) {
				label = 'custom-level-2';
			} else if (el.hasClass('subnav-3a')) {
				label = 'custom-level-3';
			}
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