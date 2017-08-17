define('ext.wikia.recirculation.views.mixedFooter', [
	'jquery',
	'wikia.window',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, tracker, utils) {
	'use strict';

	function render(data) {
		var	newsAndStoriesList = data.nsItems.items,
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
		var $nsHook = $('.ns-article'),
			$wikiArticleHook = $('.wiki-article');
		$.each($nsHook, function( index ) {
			var template = templates['client/Recirculation_article.mustache'];


			if (newsAndStoriesList[index].type === 'topic') {
				template = templates['client/Recirculation_topic.mustache'];
			} else if (newsAndStoriesList[index].type === 'storyStream') {
				template = templates['client/Recirculation_storyStream.mustache'];
			}

			$(this).replaceWith(utils.renderTemplate(template, newsAndStoriesList[index]));
		});
		$.each($wikiArticleHook, function( index ) {
			var template = templates['client/Recirculation_article.mustache'];
			wikiArticlesList[index].fandomHeartSvg = utils.fandomHeartSvg;
			$(this).replaceWith(utils.renderTemplate(template, wikiArticlesList[index]));
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

	return function() {
		return {
			render: render
			//setupTracking: setupTracking
		};
	};
});
