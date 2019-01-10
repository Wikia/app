define('ext.wikia.recirculation.views.mixedFooter', [
	'jquery',
	'wikia.window',
	'wikia.tracker',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.plista'
], function ($, w, tracker, utils, plista) {
	'use strict';

	var track = tracker.buildTrackingFunction({
			category: 'mixed-content-footer',
			trackingMethod: 'analytics'
		}),
		$mixedContentFooter = $('#mixed-content-footer'),
		templatePaths = {
			article: 'client/Recirculation_article.mustache',
			topic: 'client/Recirculation_topic.mustache',
			storyStream: 'client/Recirculation_storyStream.mustache',
			sponsoredContent: 'client/Recirculation_sponsoredContent.mustache'
		};

	function render(data) {
		var newsAndStoriesList = data.nsItems ? data.nsItems.items : [],
			wikiArticlesList = data.wikiItems,
			templateList = getTemplateList(newsAndStoriesList),
			templates = {},
			$discussions = $(data.discussions);
		$('.mcf-discussions-placeholder').replaceWith($discussions);
		$discussions.find('.discussion-timestamp').timeago();

		return utils.loadTemplates(templateList)
			.then(function (data) {
				templateList.forEach(function (templateName, index) {
					templates[templateName] = data[index];
				});
			})
			.then(plista.prepareData(wikiArticlesList))
			.then(function () {
				injectTemplates(templates, newsAndStoriesList, wikiArticlesList, data.sponsoredContent);
				setupTracking();
			});
	}

	function injectTemplates(templates, newsAndStoriesList, wikiArticlesList, sponsoredContent) {
		var $newsAndStoriesHook = $('.mcf-card-ns-placeholder'),
			$wikiArticleHook = $('.mcf-card-wiki-placeholder'),
			$sponsoredContentHook = $('.mcf-card-sponsored-content');

		if (sponsoredContent) {
			$sponsoredContentHook.replaceWith(
				utils.renderTemplate(
					templates[templatePaths.sponsoredContent],
					$.extend(
						true,
						{},
						sponsoredContent,
						{
							shortTitle: sponsoredContent.title.substring(0, 80) + '...',
							attributionLabel: sponsoredContent.attributionLabel || 'Sponsored by'
						}
					)
				)
			);
		}

		$.each($newsAndStoriesHook, function (index) {
			var $this = $(this),
				template = templates[templatePaths.article],
				newsAndStoriesItem = newsAndStoriesList[index],
				type;

			if (newsAndStoriesItem) {
				type = newsAndStoriesItem.type;
				newsAndStoriesItem.shortTitle = newsAndStoriesItem.title;
				if (type === 'topic') {
					template = templates[templatePaths.topic];
					newsAndStoriesItem.buttonLabel = $.msg('recirculation-explore');
				} else if (type === 'storyStream') {
					template = templates[templatePaths.storyStream];
					newsAndStoriesItem.buttonLabel = $.msg('recirculation-explore-posts');
				} else if (type === 'video') {
					newsAndStoriesItem.video = true;
				}

				newsAndStoriesItem.trackingLabels = $this.data('tracking') + ',' + type;
				newsAndStoriesItem.liType = 'ns';
				newsAndStoriesItem.classes = $this[0].className.replace('mcf-card-ns-placeholder', '');

				$this.replaceWith(utils.renderTemplate(template, newsAndStoriesItem));
			}
		});

		$.each($wikiArticleHook, function (index) {
			var $this = $(this),
				template = templates[templatePaths.article],
				wikiArticle = wikiArticlesList[index];

			if (wikiArticle) {
				if (!wikiArticle.thumbnail) {
					wikiArticle.fandomHeartSvg = utils.fandomHeartSvg;
				}

				if (wikiArticle.title.length > 90) {
					wikiArticle.shortTitle = wikiArticle.title.substring(0, 80) + '...';
				} else {
					wikiArticle.shortTitle = wikiArticle.title;
				}

				wikiArticle.trackingLabels = $this.data('tracking') + ',wiki-article';
				wikiArticle.classes = $this[0].className.replace('mcf-card-wiki-placeholder', '');
				wikiArticle.liType = 'wiki';

				$this.replaceWith(utils.renderTemplate(template, wikiArticle));
			}
		});
	}

	function getTemplateList(newsAndStoriesArticles) {
		var templateList = [templatePaths.article, templatePaths.sponsoredContent],
			topicExist = false,
			storyStreamExist = false;

		newsAndStoriesArticles.forEach(function (article) {
			if (article.type === 'topic' && !topicExist) {
				templateList.push(templatePaths.topic);
				topicExist = true;
			} else if (article.type === 'storyStream' && !storyStreamExist) {
				templateList.push(templatePaths.storyStream);
				storyStreamExist = true;
			}
		});

		return templateList;
	}

	function setupTracking() {
		track({
			action: tracker.ACTIONS.IMPRESSION
		});

		$mixedContentFooter.on('click', '[data-tracking]', function () {
			var labels = $(this).data('tracking').split(',');
			labels.forEach(function (label) {
				track({
					action: tracker.ACTIONS.CLICK,
					label: label
				});
			});
		});
	}

	return function () {
		return {
			render: render,
			nsItemsSelector: '#mixed-content-footer [data-li-type=ns]',
			wikiItemsSelector: '#mixed-content-footer [data-li-type=wiki]'
		};
	};
});
