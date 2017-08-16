define('ext.wikia.recirculation.views.mixedFooter', [
	'jquery',
	'wikia.window',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, tracker, utils) {
	'use strict';


	function render(data) {
		console.log(data)
		var $nsHook = $('.ns-article'),
			$wikiArticleHook = $('.wiki-article'),
			newsAndStoriesList = data.nsItems.items,
			wikiArticlesList = data.wikiItems.items,
			templateList = getTemplateList(newsAndStoriesList),
			templates = {};

		utils.loadTemplates(templateList)
			.then(function (data) {
			templateList.forEach(function (templateName, index) {
				templates[templateName] = data[index];
			})})
			.then(function () {
				$.each($nsHook, function( index, value ) {
					var template = templates['client/Recirculation_article.mustache'];


					if (newsAndStoriesList[index].type === 'topic') {
						template = templates['client/Recirculation_topic.mustache'];
					} else if (newsAndStoriesList[index].type === 'storyStream') {
						template = templates['client/Recirculation_storyStream.mustache'];
					}

					$(this).replaceWith(utils.renderTemplate(template, newsAndStoriesList[index]));
				});
				$.each($wikiArticleHook, function( index, value ) {
					debugger;
					var template = templates['client/Recirculation_article.mustache'];

					$(this).replaceWith(utils.renderTemplate(template, wikiArticlesList[index]));
				});
			});




		// $.each($nsHook, function( index, value ) {
		// 	utils.renderTemplateByName('client/Recirculation_article.mustache', value).then(function (template) {
		// 		value.append(template);
		// 	});
		//
		// });


		// $.each(data.ns, function( index, value ) {
		// 	utils.renderTemplate('client/Recirculation_article.mustache', value).then(function (template) {
		// 		console.log($('.ns-article')[index]);
		// 		$nsHook.eq(index).append(template);
		// 	});
		// });

		// $.each(data.wikiarticles, function( index, value ) {
		// 	utils.renderTemplate('client/Recirculation_article.mustache', value).then(function (template) {
		// 		$wikiArticleHook.eq(index).append(template);
		// 	});
		// });


		data = {
			discussion: '',
			ns: [],
			wikiarticles: []
		};
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
