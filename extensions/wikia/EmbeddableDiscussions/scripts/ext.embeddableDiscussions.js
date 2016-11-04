require([
	'jquery',
	'wikia.tracker',
	'wikia.ui.factory',
	'wikia.mustache',
	'wikia.window',
	'wikia.throbber',
	'embeddablediscussions.templates.mustache',
	'EmbeddableDiscussionsSharing'
], function ($, tracker, uiFactory, mustache, window, throbber, templates, sharing) {
	'use strict';

	var track = tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		category: 'embeddable-discussions',
		trackingMethod: 'analytics'
	});

	function getBaseUrl() {
		if (mw.config.get('wgDevelEnvironment')) {
			return 'https://services.wikia-dev.com/discussion';
		}

		return 'https://services.wikia.com/discussion';
	}

	function openModal(link, title) {
		// Track impression
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'embeddable-discussions-share-modal-loaded',
		});

		uiFactory.init(['modal']).then(function (uiModal) {
			var modalConfig = {
				vars: {
					classes: ['embeddable-discussions-share-modal'],
					content: '',
					id: 'EmbeddableDiscussionsShareModal',
					size: 'small',
				}
			};

			uiModal.createComponent(modalConfig, function (modal) {
				modal.$content
					.html(mustache.render(templates.ShareModal, {
						heading: $.msg('embeddable-discussions-share-heading'),
						icons: sharing.getData(mw.config.get('wgUserLanguage'), link, title),
						close: $.msg('embeddable-discussions-cancel-button'),
					}));

				modal.show();

				$('.embeddable-discussions-sharemodal-cancel-button').on('click', function(event) {
					modal.trigger('close', event);
					event.preventDefault();
				});
			});
		});
	}

	function processData(threads, upvoteUrl) {
		var ret = [],
			i,
			thread,
			userData,
			date,
			content;

		for (i in threads) {
			thread = threads[i];
			userData = thread._embedded.userData[0];
			date = new Date(thread.creationDate.epochSecond * 1000);
			content = thread.rawContent;

			if (shouldUseTruncationHack()) {
				content = truncate(content, 148);
			}

			ret.push({
				author: thread.createdBy.name,
				authorAvatar: thread.createdBy.avatarUrl,
				commentCount: thread.postCount,
				content: content,
				createdAt: $.timeago(date),
				timestamp: date.toLocaleString([mw.config.get('wgContentLanguage')]),
				forumName: $.msg( 'embeddable-discussions-forum-name', thread.forumName),
				id: thread.id,
				isDeleted: thread.isDeleted ? 'is-deleted' : '',
				isReported: thread.isReported ? 'is-reported' : '',
				firstPostId: thread.firstPostId,
				index: i,
				link: '/d/p/' + thread.id,
				shareUrl: 'http://' + window.location.hostname + '/d/p/' + thread.id,
				upvoteUrl: upvoteUrl + thread.firstPostId,
				title: thread.title,
				upvoteCount: thread.upvoteCount,
				hasUpvoted: userData.hasUpvoted,
			});
		}

		return ret;
	}

	function performRequest($elem) {
		var requestUrl = getBaseUrl() + $elem.attr('data-requestUrl'),
			requestData = JSON.parse($elem.attr('data-requestData')),
			columnsDetailsClass;

		// Inject proper class for 2 columns display
		if (requestData.columns === 2) {
			if ($elem.closest('.main-page-tag-rcs').length) {
				// When the tag is inside the main page right column
				columnsDetailsClass = 'embeddable-discussions-post-detail-right-column';
			} else {
				columnsDetailsClass = 'embeddable-discussions-post-detail-columns';
			}
		}

		$.ajax({
			type: 'GET',
			url: requestUrl,
			xhrFields: {
				withCredentials: true
			},
		}).done(function (data) {
			var threads = processData(data._embedded.threads, requestData.upvoteRequestUrl);

			$elem.html(mustache.render(templates.DiscussionThreads, {
				threads: threads,
				columnsDetailsClass: columnsDetailsClass,
				replyText: $.msg('embeddable-discussions-reply'),
				shareText: $.msg('embeddable-discussions-share'),
				showAll: $.msg('embeddable-discussions-show-all'),
				upvoteText: $.msg('embeddable-discussions-upvote'),
				zeroText: $.msg('embeddable-discussions-zero'),
				zeroTextDetail: $.msg('embeddable-discussions-zero-detail'),
			}));
		}).fail(function () {
			throbber.hide($elem);
			$elem.html($.msg('embeddable-discussions-error-loading'));
		});
	}

	function loadData() {
		var $threads = $('.embeddable-discussions-threads');
		throbber.show($threads);

		$.each($threads, function() {
			performRequest($(this));
		});
	}

	/**
	 * Truncates text to maxLength characters
	 * @param {String} text
	 * @param {Number} maxLength
	 * @returns {string}
	 */
	function truncate(text, maxLength) {
		var ellipsisCharacter = '\u2026',
			truncatedString,
			lastWhiteSpacePos;

		if (text.length <= maxLength) {
			return text;
		}

		truncatedString = text.substr(0, maxLength);
		lastWhiteSpacePos = truncatedString.search(/\s[^\s]*$/);

		if (lastWhiteSpacePos === maxLength || lastWhiteSpacePos < 0) {
			return truncatedString + ellipsisCharacter;
		}

		return truncatedString.substr(0, lastWhiteSpacePos) + ellipsisCharacter;
	}

	/**
	 * @desc Provides information about whether it is need to use truncation hack as a cover for
	 * the line-clamp css property. Method returns true only in Firefox and in IE, because in othe
	 * browsers 'line-clamp' css property works.
	 *
	 * @returns {Boolean}
	 */
	function shouldUseTruncationHack() {
		return (/Firefox|Trident|Edge/).test(navigator.userAgent);
	}

	$(function () {
		// Track impression
		track({
			action: tracker.ACTIONS.IMPRESSION,
			label: 'embeddable-discussions-loaded',
		});

		$('.embeddable-discussions-module').on('click', '.upvote', function(event) {
			var upvoteUrl = getBaseUrl() + event.currentTarget.getAttribute('href'),
				hasUpvoted = event.currentTarget.getAttribute('data-hasUpvoted') === '1',
				$svg = $($(event.currentTarget).children()[0]),
				verb = hasUpvoted ? 'DELETE' : 'POST';

			if (!mw.user.anonymous()) {
				if (hasUpvoted) {
					$svg.attr('class', 'embeddable-discussions-upvote-icon');
					event.currentTarget.setAttribute('data-hasUpvoted', '0');
				}
				else {
					$svg.attr('class', 'embeddable-discussions-upvote-icon-active');
					event.currentTarget.setAttribute('data-hasUpvoted', '1');
				}

				$.ajax({
					type: verb,
					url: upvoteUrl,
					xhrFields: {
						withCredentials: true
					},
				});
			}

			event.preventDefault();
		});

		$('.embeddable-discussions-module').on('click', '.share', function(event) {
			openModal(event.currentTarget.getAttribute('data-link'), event.currentTarget.getAttribute('data-title'));
			event.preventDefault();
		});

		// Hook to load after VE edit completes (no page reload)
		mw.hook('postEdit').add(function () {
			loadData();
		});

		// Hook for loading data on page load
		mw.hook('wikipage.content').add(function () {
			loadData();
		});
	});
});
