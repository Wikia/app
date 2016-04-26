require([
	'jquery',
	'mw',
	'ext.wikia.spitfires.experiments.tracker',
	'wikia.cache',
	'wikia.loader',
	'wikia.mustache'
], function ($, mw, tracker, cache, loader, mustache) {
	'use strict';

	var experimentName = 'contribution-experiments',
		freshlyRegisteredExperimentId = 5654433460,
		usersWithoutEditExperimentId = 5735670451,
		dismissCookieName = 'contribchallengedismissed';

	function init() {
		if (
			mw.config.get('wgAction') !== 'view' ||
			!window.optimizely ||
			(
				window.optimizely.variationNamesMap[freshlyRegisteredExperimentId] !== 'CHALLENGE-LIST' &&
				window.optimizely.variationNamesMap[usersWithoutEditExperimentId] !== 'CHALLENGE-LIST'
			) ||
			$.cookie(dismissCookieName) ||
			mw.config.get('wgNamespaceNumber') !== 0
		) {
			return;
		}

		$.when(
			getPopularPages(),
			loader({
				type: loader.MULTI,
				resources: {
					mustache: '/extensions/wikia/SpitfiresContributionExperiments/templates/Challenge.mustache',
					styles: '/extensions/wikia/SpitfiresContributionExperiments/styles/challenge.scss'
				}
			})
		).done(addEntryPoint);
	}

	function addEntryPoint(pageTitles, resources) {
		var pages = getRandomPagesData(pageTitles, 2),
			templateData = {
				userName: mw.config.get('wgUserName'),
				blankImgUrl: mw.config.get('wgBlankImgUrl'),
				pages: pages
			};

		if (!pages.length) {
			return;
		}

		loader.processStyle(resources.styles);

		$('#WikiaPageHeader').prepend(
			mustache.render(resources.mustache[0], templateData)
		).on('click', '.spitfires-challenge-experiment .close-button', function (e) {
			e.preventDefault();
			tracker.trackVerboseClick(experimentName, 'dismissed');
			$.cookie(dismissCookieName, 1, {
				expires: 30,
				path: mw.config.get('wgCookiePath'),
				domain: mw.config.get('wgCookieDomain')
			});
			$(this).parent().remove();
		}).on('mousedown touchstart', '.spitfires-challenge-experiment-content a', function () {
			tracker.trackVerboseClick(experimentName, $(this).attr('class'));
		});

		tracker.trackVerboseImpression(experimentName, 'view');
	}

	function getRandomPagesData(pageTitles, numItems) {
		var i, index, title,
			result = [],
			editParams = { action: 'edit' };

		if (!pageTitles.length) {
			return result;
		}

		if (mw.config.get('wgVisualEditorPreferred')) {
			editParams = { veaction: 'edit' };
		}

		if (pageTitles.length < numItems) {
			numItems = pageTitles.length;
		}

		for (i = 0; i < numItems; i++) {
			index = Math.floor(Math.random() * pageTitles.length);
			title = mw.Title.newFromText(pageTitles[index]);
			result[result.length] = {
				pageTitle: title.getPrefixedText(),
				pageUrl: title.getUrl(),
				editUrl: title.getUrl(editParams)
			};
			pageTitles.splice(index, 1);
		}

		return result;
	}

	function getPopularPages() {
		var deferred = $.Deferred(),
			cacheKey = 'contribChallengeExperiment',
			pageTitles = cache.get(cacheKey) || [];

		if (pageTitles.length) {
			deferred.resolve(pageTitles);
			return deferred.promise();
		}

		$.getJSON('/api.php', {
			action: 'query',
			list: 'querypage',
			qppage: 'Popularpages',
			qplimit: 50,
			format: 'json'
		}).done(function (data) {
			var i, results;
			if (
				data.query &&
				data.query.querypage.results &&
				data.query.querypage.results.length
			) {
				results = data.query.querypage.results;
				for (i = 0; i < results.length; i++) {
					if (results[i].ns === 0) {
						pageTitles[pageTitles.length] = results[i].title;
					}
				}
				cache.set(cacheKey, pageTitles, cache.CACHE_STANDARD);
				deferred.resolve(pageTitles);
			} else {
				deferred.reject();
			}
		}).fail(function () {
			deferred.reject();
		});

		return deferred.promise();
	}

	$(init);
});
