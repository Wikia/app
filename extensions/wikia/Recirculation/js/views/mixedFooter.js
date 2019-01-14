define('ext.wikia.recirculation.views.mixedFooter', [
	'jquery',
	'wikia.window',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.plista'
], function ($, w, tracker, utils, plista) {
	'use strict';

	var $mixedContentFooter = $('#mixed-content-footer'),
		templatePaths = {
			article: 'client/Recirculation_article.mustache',
			sponsoredContent: 'client/Recirculation_sponsoredContent.mustache'
		};

	function render(data) {
		var newsAndStoriesList = data.nsItems,
			wikiArticlesList = data.wikiItems,
			templateList = [templatePaths.article, templatePaths.sponsoredContent],
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
				injectTemplates(templates, newsAndStoriesList, wikiArticlesList, data.sponsoredItem);
				setupTracking();
			});
	}

	function injectTemplates(templates, newsAndStoriesList, wikiArticlesList, sponsoredItem) {
		var $newsAndStoriesHook = $('.mcf-card-ns-placeholder'),
			$wikiArticleHook = $('.mcf-card-wiki-placeholder'),
			$sponsoredContentHook = $('.mcf-card-sponsored-content');

		if (sponsoredItem) {
			$sponsoredContentHook.replaceWith(
				utils.renderTemplate(
					templates[templatePaths.sponsoredContent],
					$.extend(
						true,
						{},
						sponsoredItem,
						{
							shortTitle: sponsoredItem.title.substring(0, 80) + '...',
							attributionLabel: sponsoredItem.attributionLabel || 'Sponsored by',
							trackingLabels: 'footer,sponsored-item'
						}
					)
				)
			);
		}

		$.each($newsAndStoriesHook, function (index) {
			var $this = $(this),
				template = templates[templatePaths.article],
				newsAndStoriesItem = newsAndStoriesList[index];

			if (newsAndStoriesItem) {
				newsAndStoriesItem.shortTitle = newsAndStoriesItem.title;
				newsAndStoriesItem.trackingLabels = $this.data('tracking') + ',' + 'ns,footer';
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

				wikiArticle.trackingLabels = $this.data('tracking') + ',wiki-article,footer';
				wikiArticle.classes = $this[0].className.replace('mcf-card-wiki-placeholder', '');
				wikiArticle.liType = 'wiki';

				$this.replaceWith(utils.renderTemplate(template, wikiArticle));
			}
		});
	}

	function setupTracking() {
		tracker.trackImpression('footer');

		$mixedContentFooter.on('click', '[data-tracking]', function () {
			var $this = $(this),
				labels = $this.data('tracking').split(','),
				href = $this.attr('href');

			labels.forEach(function (label) {
				tracker.trackClick(label);
			});
			tracker.trackSelect(href);
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
