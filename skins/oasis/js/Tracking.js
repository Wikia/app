/* global WikiaEditor, veTrack */
/**
 * This file contains most of the tracking calls for the Oasis skin.
 * Some tracking calls live elsewhere due to the complexity of tracking
 * them in this file, but general preference is to have any Oasis related
 * tracking in this file if at all possible.
 */
jQuery(function ($) {
	'use strict';

	var $body = $('body'),
		$wikiaArticle = $('#WikiaArticle'),
		$wikiaRail = $('#WikiaRail'),
		$wikiHeader = $('#WikiHeader'),
		rHrefDiff = /&diff=\d+/,
		rHrefHistory = /&action=history/,
		track,
		trackWithEventData,
		trackEditorComponent;

	track = Wikia.Tracker.buildTrackingFunction({
		action: Wikia.Tracker.ACTIONS.CLICK,
		trackingMethod: 'analytics'
	});

	trackWithEventData = function (e) {
		if (window.veTrack && e.data.label === 'section-edit') {
			veTrack({
				action: ($('#ca-ve-edit').exists() ? 've-section-edit' : 'other-section-edit') + '-click'
			});
		}

		// Primary mouse button only
		if (e.type === 'mousedown' && e.which !== 1) {
			return;
		}

		track({
			browserEvent: e
		}, e.data);
	};

	// For tracking components which are used inside and outside of the editor.
	trackEditorComponent = (function () {
		var slice = Array.prototype.slice;

		return function () {
			var wikiaEditor = window.WikiaEditor && WikiaEditor.getInstance(),
				track = Wikia.Tracker.track;

			// Determine whether or not to track through the editor tracking method:
			// - If an editor is present on the page and is not a MiniEditor, then it must be the main editor.
			// - If an editor is present on the page and is a MiniEditor, make sure it currently has focus.
			// - Otherwise, assume that we are not tracking through the editor.
			if (wikiaEditor && (!wikiaEditor.config.isMiniEditor || wikiaEditor.plugins.MiniEditor.hasFocus)) {
				track = WikiaEditor.track;
			}

			track.apply(track, slice.call(arguments));
		};
	})();

	/** article **/

	(function () {
		var category = 'article';

		// Not special pages
		if ($body.hasClass('ns-special')) {
			return;
		}

		$('#WikiaPageHeader').on('mousedown', 'a', function (e) {
			var label,
				el = $(e.currentTarget),
				id = el.data('id');

			// Primary mouse button only
			if (e.which !== 1) {
				return;
			}

			if (window.veTrack) {
				if (id === 'edit') {
					veTrack({
						action: 'other-edit-click'
					});
				}
				if (id === 've-edit') {
					veTrack({
						action: 've-edit-click'
					});
				}
			}

			switch (id) {
			case 'comment':
				label = el.hasClass('talk') ? 'talk' : 'comment';
				break;
			case 'edit':
				label = id;
				break;
			case 'delete':
			case 'history':
			case 'move':
			case 'protect':
			case 'flags':
				label = 'edit-' + id;
				break;
			}

			if (label !== undefined) {
				track({
					browserEvent: e,
					category: category,
					label: label
				});
			}
		});

		$wikiaArticle.on('mousedown', 'a', function (e) {
			var label,
				el = $(e.currentTarget);

			// Primary mouse button only
			if (e.which !== 1) {
				return;
			}

			if (el.hasClass('video')) {
				label = 'video';
			} else if (el.hasClass('image')) {
				label = 'image';
			} else if (el.parents('.infobox, .wikia-infobox').length > 0) {
				label = 'infobox';
			} else if (el.hasClass('external')) {
				label = 'link-external';
			} else if (el.hasClass('wikia-photogallery-add')) {
				label = 'add-photo-to-gallery';
			} else if (el.prop('className') === '') {
				label = 'link-internal';
			}

			if (label !== undefined) {
				track({
					browserEvent: e,
					category: category,
					label: label
				});
			}
		}).on('mousedown', '.editsection a', {
			category: category,
			label: 'section-edit'
		}, trackWithEventData);

		$('#articleCategories').on('mousedown', 'a', {
			category: category,
			label: 'category-name'
		}, trackWithEventData).on('mousedown', '.add', {
			category: category,
			label: 'add-category'
		}, trackWithEventData);
	})();

	/** category **/

	(function () {
		var category = 'category';

		$wikiaArticle.on('mousedown', '.category-gallery a', {
			category: category,
			label: 'category-gallery'
		}, trackWithEventData);

		$('#mw-pages').on('mousedown', 'a', {
			category: category,
			label: 'category-item'
		}, trackWithEventData);
	})();

	/** Alliance Template **/
	(function () {
		var alliance = $('.alliance-module', $wikiaArticle),
			category = 'Alliance',
			label,
			suffix;
		if (alliance.length) {
			alliance.on('mousedown', 'a', function (e) {
				suffix = '-click';
				if ($(this).attr('href').indexOf('http://www.wikia.com/Alliance') !== -1) {
					suffix = '-logo-click';
				}
				label = $(e.delegateTarget).attr('data-label');

				if (label !== undefined) {
					label += suffix;
					track({
						category: category,
						label: label
					});
				}
			});

			alliance.each(function () {
				suffix = '-impression';
				label = $(this).attr('data-label');

				if (label !== undefined) {
					label += suffix;
					track({
						action: Wikia.Tracker.ACTIONS.IMPRESSION,
						category: category,
						label: label
					});
				}
			});
		}
	})();

	/** contribute **/

	$wikiHeader.find('.buttons .contribute').on('mousedown', 'a', function (e) {
		var label,
			el = $(e.target),
			id = el.data('id');

		// Primary mouse button only
		if (e.which !== 1) {
			return;
		}

		switch (id) {
		case 'createpage':
			label = 'add-a-page';
			break;
		case 'edit':
			label = 'edit-a-page';
			break;
		case 'upload':
			label = 'add-a-photo';
			break;
		case 'wikiavideoadd':
			label = 'add-a-video';
			break;
		case 'wikiactivity':
			label = 'wiki-activity';
			break;
		case 'wikinavedit':
			label = 'edit-wiki-navigation';
			break;
		}

		if (label !== undefined) {
			track({
				browserEvent: e,
				category: 'contribute',
				label: label
			});
		}
	});

	/** recent-changes **/

	if ($body.hasClass('page-Special_RecentChanges')) {
		// We need to bind to #WikiaArticle because users use scripts which reload the content
		// see: http://dev.wikia.com/wiki/MediaWiki:AjaxRC/code.js
		$wikiaArticle.on('mousedown', 'a', function (e) {
			var $el = $(e.target),
				label = $el.attr('data-action'),
				href = $el.attr('href');

			// Primary mouse button only
			if (e.which !== 1) {
				return;
			}

			if (!label) {
				if (rHrefDiff.test(href)) {
					label = 'diff';
				} else if (rHrefHistory.test(href)) {
					label = 'history';
				} else if ($el.hasClass('mw-userlink')) {
					label = 'username';
				} else if (!$el.parent().is('span')) {
					label = 'title';
				}
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

	/** diff page **/
	$wikiaArticle.find('.diff-header').on('mousedown', 'a', function(e) {
		var $el = $(e.target),
			action = $el.attr('data-action');

		if (action) {
			track({
				browserEvent: e,
				category: 'oasis-diff',
				label: action
			});
		}
	});

	/** search **/

	(function () {
		var category = 'search',
			suggestionShowed = false,
			$topModule = $('.top-wiki-articles'),
			$categoryModule = $('.category-articles'),
			$wikiaSearch = $('.search-tracking'),
			$noResults = $('.results-wrapper .no-result');

		if ($body.hasClass('page-Special_Search')) {
			category = 'special-search';
		}
		/**
		 * Search suggestions tracking
		 */
		$wikiaSearch.on('mousedown', '.autocomplete', {
			category: category,
			label: 'search-suggest'
		}, trackWithEventData).on('mousedown', '.wikia-button', function (e) {
			// Prevent tracking 'fake' form submission clicks
			if (e.which === 1 && e.clientX > 0) {
				var label = !suggestionShowed ? 'search-button' : 'search-after-suggest-button';
				track({
					category: category,
					label: label
				});
			}
		}).on('keypress', '[name=search]', function (e) {
			if (e.which === 13 && $(this).is(':focus')) {
				var label = !suggestionShowed ? 'search-enter' : 'search-after-suggest-enter';
				track({
					category: category,
					label: label
				});
			}
		}).on('suggestEnter', {
			category: category,
			label: 'search-suggest-enter'
		}, trackWithEventData).one('suggestShow', {
			action: Wikia.Tracker.ACTIONS.VIEW,
			category: category,
			label: 'search-suggest-show'
		}, function (e) {
			suggestionShowed = true;
			trackWithEventData(e);
		});

		/**
		 * Special:Search tracking
		 */
		if ($body.hasClass('page-Special_Search')) {
			if ($noResults.length) {
				track({
					action: Wikia.Tracker.ACTIONS.VIEW,
					category: category,
					label: 'empty-page'
				});
			}
			$wikiaSearch.on('mousedown', '.search-tabs a', function (e) {
				track({
					browserEvent: e,
					category: category,
					label: 'sidebar-' + $(e.currentTarget).prop('className')
				});
			}).on('mousedown', '.Results .result-link', function (e) {
				var el = $(e.currentTarget),
					label = 'result-' +
					(el.data('event') === 'search_click_match' ? 'push-top' : 'item-' +
						el.data('pos'));
				track({
					browserEvent: e,
					category: category,
					label: label,
				});
			}).on('mousedown', '.Results .wiki-thumb-tracking', function (e) {
				var el = $(e.currentTarget),
					label = 'result-item-' +
					el.data('pos') +
					'-image' +
					(el.data('event') === 'search_click_wiki-no-thumb' ? '-placeholder' : '');
				track({
					browserEvent: e,
					category: category,
					label: label,
				});
			}).on('mousedown', '.thumb-tracking', function (e) {
				var el = $(e.currentTarget),
					label = 'result-item-' +
					'image-' +
					(el.data('event') === 'search_click_match' ? 'push-top' : el.data('pos'));
				track({
					browserEvent: e,
					category: category,
					label: label,
				});
			}).on('mousedown', '.image', function (e) {
				var $currentTarget = $(e.currentTarget),
					label = 'result-' +
					($currentTarget.hasClass('video') ? 'video' : 'photo') +
					(($currentTarget.parents('.video-addon-results').length > 0) ? '-video-addon' : '');
				track({
					browserEvent: e,
					category: category,
					label: label
				});
			}).on('mousedown', '.video-addon-seach-video', function (e) {
				track({
					browserEvent: e,
					category: category,
					label: 'video-addon-results-header'
				});
			});
		}
		if ($topModule.length) {
			$topModule.on('mousedown', '.top-wiki-article-thumbnail a', function (e) {
				var el = $(e.currentTarget);
				track({
					browserEvent: e,
					category: category,
					label: 'top-module-thumb-' + el.data('pos')
				});
			}).on('mousedown', '.top-wiki-article-text a', function (e) {
				var el = $(e.currentTarget);
				track({
					browserEvent: e,
					category: category,
					label: 'top-module-title-' + el.data('pos')
				});
			});
		}
		if ($categoryModule.length) {
			$categoryModule.on('mousedown', '.category-articles-thumb a', function (e) {
				var el = $(e.currentTarget);
				track({
					browserEvent: e,
					category: category,
					label: 'category-module-thumb-' + el.data('pos')
				});
			}).on('mousedown', '.category-articles-text a', function (e) {
				var el = $(e.currentTarget);
				track({
					browserEvent: e,
					category: category,
					label: 'category-module-title-' + el.data('pos')
				});
			});
		}
	})();

	/** thread-module **/

	$('#RelatedForumDiscussion').on('mousedown', 'a', function (e) {
		var label,
			el = $(e.target);

		// Primary mouse button only
		if (e.which !== 1) {
			return;
		}

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

	$('#WikiaBarWrapper').on('mousedown', '.toolbar a', function (e) {
		var label,
			el = $(e.target),
			name = el.data('name');

		// Primary mouse button only
		if (e.which !== 1) {
			return;
		}

		switch (name) {
		case 'customize':
		case 'follow':
		case 'history':
		case 'whatlinkshere':
			label = name;
			break;
		default:
			label = 'custom';
			break;
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

	(function () {
		var category = 'top-nav';

		$('#wall-notifications-markasread').on('mousedown', 'span', function (e) {
			var label,
				el = $(e.target),
				id = el.attr('id');

			// Primary mouse button only
			if (e.which !== 1) {
				return;
			}

			switch (id) {
			case 'wall-notifications-markasread-this-wiki':
			case 'wall-notifications-markasread-all-wikis':
				label = id;
				break;
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
		$wikiaArticle.find('.activityfeed').on('mousedown', 'a', function (e) {
			var label, type,
				el = $(e.target),
				parent = el.parent();

			// Primary mouse button only
			if (e.which !== 1) {
				return;
			}

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

				if (type === 'inserted-image') {
					label = 'thumbnail-photo';
				} else if (type === 'inserted-video') {
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

	$wikiHeader.on('mousedown', 'a', function (e) {
		var label,
			el = $(e.target),
			canonical;

		// Primary mouse button only
		if (e.which !== 1) {
			return;
		}

		if (el.closest('.wordmark').length > 0) {
			label = 'wordmark';
		} else if (el.closest('.WikiNav').length > 0) {
			canonical = el.data('canonical');
			if (canonical !== undefined) {
				switch (canonical) {
				case 'wikiactivity':
					label = 'on-the-wiki-activity';
					break;
				case 'random':
					label = 'on-the-wiki-random';
					break;
				case 'images':
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

	function initRailTracking() {
		/** chat-module **/

		$wikiaRail.find('.ChatModule').on('mousedown', '.chat-join', {
			category: 'chat-module',
			label: 'chat-join'
		}, trackWithEventData);

		/** recent-wiki-activity **/
		$wikiaRail.find('.WikiaActivityModule').on('mousedown', 'a', function (e) {
			var label,
				el = $(e.target);

			// Primary mouse button only
			if (e.which !== 1) {
				return;
			}

			if (el.hasClass('more')) {
				label = 'activity-more';
			} else if (el.closest('.edited-by').length > 0) {
				label = 'activity-username';
			} else if (el.closest('em').length > 0) {
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
	}

	// Exports
	Wikia.trackEditorComponent = trackEditorComponent;
	Wikia.initRailTracking = initRailTracking;
});
