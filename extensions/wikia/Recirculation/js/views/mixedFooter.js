define('ext.wikia.recirculation.views.mixedFooter', [
	'jquery',
	'wikia.window',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, tracker, utils) {
	'use strict';

	function render(data) {
		var newsAndStoriesList = data.nsItems.items,
			wikiArticlesList = data.wikiItems.items,
			templateList = getTemplateList(newsAndStoriesList),
			templates = {};

		$('.mcf-discussions-placeholder').replaceWith(data.discussions);

		utils.loadTemplates(templateList)
			.then(function (data) {
				templateList.forEach(function (templateName, index) {
					templates[templateName] = data[index];
				});
				injectTemplates(templates, newsAndStoriesList, wikiArticlesList);
			});
	}

	function injectTemplates(templates, newsAndStoriesList, wikiArticlesList) {
		var $newsAndStoriesHook = $('.mcf-card-ns-placeholder'),
			$wikiArticleHook = $('.mcf-card-wiki-placeholder');

		$.each($newsAndStoriesHook, function (index) {
			var template = templates['client/Recirculation_article.mustache'],
				newsAndStoriesItem = newsAndStoriesList[index];

			if (newsAndStoriesItem.type === 'topic') {
				template = templates['client/Recirculation_topic.mustache'];
				newsAndStoriesItem.buttonLabel = $.msg('recirculation-explore');
			} else if (newsAndStoriesItem.type === 'storyStream') {
				template = templates['client/Recirculation_storyStream.mustache'];
				newsAndStoriesItem.buttonLabel = $.msg('recirculation-explore-posts');
			}

			$(this).replaceWith(utils.renderTemplate(template, newsAndStoriesList[index]));
		});

		$.each($wikiArticleHook, function (index) {
			var template = templates['client/Recirculation_article.mustache'],
				wikiArticle = wikiArticlesList[index];

			if (!wikiArticle.thumbnail) {
				wikiArticle.fandomHeartSvg = utils.fandomHeartSvg;
			}

			$(this).replaceWith(utils.renderTemplate(template, wikiArticle));
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

	return function () {
		return {
			render: render
			//TODO setupTracking: setupTracking
		};
	};
});
