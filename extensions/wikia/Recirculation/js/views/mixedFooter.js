define('ext.wikia.recirculation.views.mixedFooter', [
	'jquery',
	'wikia.window',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, tracker, utils) {
	'use strict';

	var mockData = {
		title: 'Test title',
		subtitle: 'Marvel Wiki'
	};

	function render(data) {
		data = {
			discussion: '',
			ns: [{title: 'NS title', subtitle: 'Marvel Wiki', type: 'topic'}, {title: 'NS title', subtitle: 'Dupa Wiki', type: 'storyStream'}],
			wikiarticles: [{title: 'WikiArt title', subtitle: 'Marvel Wiki'}, {title: 'WikiArt title', subtitle: 'Dupa Wiki'}],
		};
		var $nsHook = $('.ns-article'),
			$wikiArticleHook = $('.wiki-article'),
			newsAndStoriesList = data.ns,
			templateList = getTemplateList(newsAndStoriesList),
			templates = {};

		utils.loadTemplates(templateList).then(function (data) {
			templateList.forEach(function (templateName, index) {
				templates[templateName] = data[index];
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
