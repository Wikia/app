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
		$interlang = $('.WikiaArticleInterlang'),
		rHrefDiff = /&diff=\d+/,
		rHrefHistory = /&action=history/,
		track,
		trackWithEventData,
		trackEditorComponent;

	track = Wikia.Tracker.buildTrackingFunction({
		action: Wikia.Tracker.ACTIONS.CLICK,
		trackingMethod: 'analytics'
	});

	trackWithEventData = function (event) {
		if (window.veTrack && event.data.label === 'section-edit') {
			veTrack({
				action: ($('#ca-ve-edit').exists() ? 've-section-edit' : 'other-section-edit') + '-click'
			});
		}

		// Primary mouse button only
		if (event.type === 'mousedown' && event.which !== 1) {
			return;
		}

		track({
			browserEvent: event
		}, event.data);
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

		$wikiaArticle.on('mousedown', 'a', function (event) {
			var label,
				el = $(event.currentTarget);

			// Primary mouse button only
			if (event.which !== 1) {
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
					browserEvent: event,
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
			alliance.on('mousedown', 'a', function (event) {
				suffix = '-click';
				if ($(this).attr('href').indexOf('http://www.wikia.com/Alliance') !== -1) {
					suffix = '-logo-click';
				}
				label = $(event.delegateTarget).attr('data-label');

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


	/** recent-changes **/

	if ($body.hasClass('page-Special_RecentChanges')) {
		// We need to bind to #WikiaArticle because users use scripts which reload the content
		// see: http://dev.wikia.com/wiki/MediaWiki:AjaxRC/code.js
		$wikiaArticle.on('mousedown', 'a', function (event) {
			var $el = $(event.target),
				label = $el.attr('data-action'),
				href = $el.attr('href');

			// Primary mouse button only
			if (event.which !== 1) {
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
					browserEvent: event,
					category: 'recent-changes',
					label: label
				});
			}
		});
	}

	/** diff page **/
	$wikiaArticle.find('.diff-header').on('mousedown', 'a', function (e) {
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
			$exactWikiMatchModule = $('.exact-wiki-match'),
			$fandomStoriesModule = $('.fandom-stories'),
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
		}, trackWithEventData).on('mousedown', '.wikia-button', function (event) {
			// Prevent tracking 'fake' form submission clicks
			if (event.which === 1 && event.clientX > 0) {
				var label = !suggestionShowed ? 'search-button' : 'search-after-suggest-button';
				track({
					category: category,
					label: label
				});
			}
		}).on('keypress', '[name=search]', function (event) {
			if (event.which === 13 && $(this).is(':focus')) {
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
		}, function (event) {
			suggestionShowed = true;
			trackWithEventData(event);
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
			$wikiaSearch.on('mousedown', '.search-tabs a', function (event) {
				track({
					browserEvent: event,
					category: category,
					label: 'sidebar-' + $(event.currentTarget).prop('className')
				});
			}).on('mousedown', '.Results .result-link', function (event) {
				var el = $(event.currentTarget),
					label = 'result-' +
						(el.data('event') === 'search_click_match' ? 'push-top' : 'item-' +
							el.data('pos'));
				track({
					browserEvent: event,
					category: category,
					label: label
				});
			}).on('mousedown', '.Results .wiki-thumb-tracking', function (event) {
				var el = $(event.currentTarget),
					label = 'result-item-' +
						el.data('pos') +
						'-image' +
						(el.data('event') === 'search_click_wiki-no-thumb' ? '-placeholder' : '');
				track({
					browserEvent: event,
					category: category,
					label: label
				});
			}).on('mousedown', '.thumb-tracking', function (event) {
				var el = $(event.currentTarget),
					label = 'result-item-' +
						'image-' +
						(el.data('event') === 'search_click_match' ? 'push-top' : el.data('pos'));
				track({
					browserEvent: event,
					category: category,
					label: label
				});
			}).on('mousedown', '.image', function (event) {
				var $currentTarget = $(event.currentTarget),
					label = 'result-' +
						($currentTarget.hasClass('video') ? 'video' : 'photo') +
						(($currentTarget.parents('.video-addon-results').length > 0) ? '-video-addon' : '');
				track({
					browserEvent: event,
					category: category,
					label: label
				});
			}).on('mousedown', '.video-addon-seach-video', function (event) {
				track({
					browserEvent: event,
					category: category,
					label: 'video-addon-results-header'
				});
			});
		}

		if ($exactWikiMatchModule.length) {
			track({
				action: Wikia.Tracker.ACTIONS.IMPRESSION,
				category: category,
				label: 'exact-wiki-match'
			});

			$exactWikiMatchModule.on('mousedown', 'a', function (event) {
				var el = $(event.currentTarget);
				track({
					browserEvent: event,
					category: category,
					label: 'exact-wiki-match-' + el.data('event')
				});
			});
		}

		if ($fandomStoriesModule.length) {
			track({
				action: Wikia.Tracker.ACTIONS.IMPRESSION,
				category: category,
				label: 'fandom-stories'
			});

			$fandomStoriesModule.on('mousedown', '.fandom-story-link', function (event) {
				track({
					browserEvent: event,
					category: category,
					label: 'fandom-story-link-' + $(event.currentTarget).data('pos')
				});
			}).on('mousedown', '.fandom-story-image', function (event) {
				track({
					browserEvent: event,
					category: category,
					label: 'fandom-story-image-' + $(event.currentTarget).data('pos')
				});
			});
		}

		if ($topModule.length) {
			track({
				action: Wikia.Tracker.ACTIONS.IMPRESSION,
				category: category,
				label: 'top-wiki-articles'
			});

			$topModule.on('mousedown', '.top-wiki-article-link', function (event) {
				track({
					browserEvent: event,
					category: category,
					label: 'top-wiki-article-link-' + $(event.currentTarget).data('pos')
				});
			}).on('mousedown', '.top-wiki-article-image', function (event) {
				track({
					browserEvent: event,
					category: category,
					label: 'top-wiki-article-image-' + $(event.currentTarget).data('pos')
				});
			});
		}

		if ($categoryModule.length) {
			$categoryModule.on('mousedown', '.category-articles-thumb a', function (event) {
				var el = $(event.currentTarget);
				track({
					browserEvent: event,
					category: category,
					label: 'category-module-thumb-' + el.data('pos')
				});
			}).on('mousedown', '.category-articles-text a', function (event) {
				var el = $(event.currentTarget);
				track({
					browserEvent: event,
					category: category,
					label: 'category-module-title-' + el.data('pos')
				});
			});
		}
	})();

	/** thread-module **/

	$('#RelatedForumDiscussion').on('mousedown', 'a', function (event) {
		var label,
			el = $(event.target);

		// Primary mouse button only
		if (event.which !== 1) {
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
				browserEvent: event,
				category: 'thread-module',
				label: label
			});
		}
	});

	/** toolbar **/

	$('#WikiaBarWrapper').on('mousedown', '.toolbar a', function (event) {
		var label,
			el = $(event.target),
			name = el.data('name');

		// Primary mouse button only
		if (event.which !== 1) {
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
				browserEvent: event,
				category: 'toolbar',
				label: label
			});
		}
	});

	/** top-nav **/

	(function () {
		var category = 'top-nav';

		$('#wall-notifications-markasread').on('mousedown', 'span', function (event) {
			var label,
				el = $(event.target),
				id = el.attr('id');

			// Primary mouse button only
			if (event.which !== 1) {
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
					browserEvent: event,
					category: category,
					label: label
				});
			}
		});
	})();

	/** wiki-activity **/

	if ($body.hasClass('page-Special_WikiActivity')) {
		$wikiaArticle.find('.activityfeed').on('mousedown', 'a', function (event) {
			var label, type,
				el = $(event.target),
				parent = el.parent();

			// Primary mouse button only
			if (event.which !== 1) {
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
					browserEvent: event,
					category: 'wiki-activity',
					label: label
				});
			}
		});
	}

	/** interwiki links **/
	$interlang.on('click', 'a', function () {
		var data = $(this).data('tracking');
		track({
			category: 'interwiki-links',
			label: data
		});
	});

	function initRailTracking() {
		/** chat-module **/

		$wikiaRail.find('.chat-module').on('mousedown', '.start-a-chat-button', {
			category: 'chat-module',
			label: 'chat-join'
		}, trackWithEventData);

		/** related-threads-module **/
		$wikiaRail.find('#ForumRelatedThreadsModule').on('mousedown', 'a', function (event) {
			var label = event.target.getAttribute('data-tracking');

			// Primary mouse button only
			if (event.which !== 1) {
				return;
			}

			if (label) {
				track({
					browserEvent: event,
					category: 'related-threads-module',
					label: label
				});
			}
		});

		/** forum-activity-module **/
		$wikiaRail.find('#ForumActivityModule').on('mousedown', 'a', function (event) {
			var label = event.target.getAttribute('data-tracking');

			// Primary mouse button only
			if (event.which !== 1) {
				return;
			}

			if (label) {
				track({
					browserEvent: event,
					category: 'forum-activity-module',
					label: label
				});
			}
		});

		/** recent-wiki-activity-module **/
		$wikiaRail.find('#wikia-recent-activity .page-title-link, #wikia-recent-activity .edit-info-user').on('mousedown', function (event) {
			var label = event.target.getAttribute('data-tracking');

			// Primary mouse button only
			if (event.which !== 1) {
				return;
			}

			if (label) {
				track({
					browserEvent: event,
					category: 'recent-wiki-activity-module',
					label: label
				});
			}
		});
	}

	// Exports
	Wikia.trackEditorComponent = trackEditorComponent;
	Wikia.initRailTracking = initRailTracking;
});
