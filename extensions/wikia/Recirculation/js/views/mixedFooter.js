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
		$mixedContentFooter = $('#mixed-content-footer');

	function render(data) {
		var newsAndStoriesList = data.nsItems ? data.nsItems.items : [],
			wikiArticlesList = data.wikiItems.items,
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
				injectTemplates(templates, newsAndStoriesList, wikiArticlesList);
				setupTracking();
			})
	}

	function injectTemplates(templates, newsAndStoriesList, wikiArticlesList) {
		var $newsAndStoriesHook = $('.mcf-card-ns-placeholder'),
			$wikiArticleHook = $('.mcf-card-wiki-placeholder');

		$.each($newsAndStoriesHook, function (index) {
			var $this = $(this),
				template = templates['client/Recirculation_article.mustache'],
				newsAndStoriesItem = newsAndStoriesList[index],
				type;

			if(newsAndStoriesItem) {
				type = newsAndStoriesItem.type;
				newsAndStoriesItem.shortTitle = newsAndStoriesItem.title;
				if (type === 'topic') {
					template = templates['client/Recirculation_topic.mustache'];
					newsAndStoriesItem.buttonLabel = $.msg('recirculation-explore');
				} else if (type === 'storyStream') {
					template = templates['client/Recirculation_storyStream.mustache'];
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
				template = templates['client/Recirculation_article.mustache'],
				wikiArticle = wikiArticlesList[index];
				wikiArticle.shortTitle = wikiArticle.title;

			if(wikiArticle) {
				if (!wikiArticle.thumbnail) {
					wikiArticle.fandomHeartSvg = utils.fandomHeartSvg;
				}

				if (wikiArticle.title.length > 90) {
					wikiArticle.shortTitle = wikiArticle.title.substring(0, 80) + '...';
				}

				wikiArticle.trackingLabels = $this.data('tracking') + ',wiki-article';
				wikiArticle.classes = $this[0].className.replace('mcf-card-wiki-placeholder', '');
				wikiArticle.liType = 'wiki';
				if (wikiArticle.type === 'video') {
					wikiArticle.video = true;
				}

				$this.replaceWith(utils.renderTemplate(template, wikiArticle));
			}
		});
	}

	function getTemplateList(newsAndStoriesArticles) {
		var templateList = ['client/Recirculation_article.mustache'],
			topicExist = false,
			storyStreamExist = false;

		newsAndStoriesArticles.forEach(function (article) {
			if (article.type === 'topic' && !topicExist) {
				templateList.push('client/Recirculation_topic.mustache');
				topicExist = true;
			} else if (article.type === 'storyStream' && !storyStreamExist) {
				templateList.push('client/Recirculation_storyStream.mustache');
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
