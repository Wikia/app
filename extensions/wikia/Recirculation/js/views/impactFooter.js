/*global define*/
define('ext.wikia.recirculation.views.impactFooter', [
	'jquery',
	'wikia.window',
	'wikia.log',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils'
], function ($, w, log, tracker, utils) {

	var logGroup = 'ext.wikia.recirculation.views.rail',
		imageRatio = 9/16;
		options = {
			template: 'impactFooter.mustache'
		};

	function render(data) {
		var renderData = {};
		renderData.items = organizeItems(data);
		renderData.discussions = data.discussions;

		return utils.renderTemplate(options.template, renderData).then(function($html) {
			$('#WikiaFooter').html($html).find('.discussion-timestamp').timeago();
			adjustFeatureItem($html);

			return $html;
		});
	}

	function adjustFeatureItem($html) {
		var $firstSet, firstSetHeight, firstSetDifference, $secondSet, secondSetHeight, secondSetDifference,
			$feature, featureHeight, move;

		$firstSet = $html.find('.item:eq(1) h4, .item:eq(2) h4');
		firstSetHeight = $firstSet.outerWidth(true) * imageRatio + $firstSet.outerHeight(true);

		$secondSet = $html.find('.item:eq(3) h4, .item:eq(4) h4');
		secondSetHeight = $secondSet.outerWidth(true) * imageRatio + $secondSet.outerHeight(true);

		$feature = $html.find('.item:eq(5)');
		featureHeight = $feature.outerWidth(true) * imageRatio;

		firstSetDifference = (featureHeight - firstSetHeight);
		secondSetDifference = (featureHeight - secondSetHeight);

		move = firstSetDifference > secondSetDifference ? secondSetDifference : firstSetDifference;

		$feature.css('margin-top', -move);
	}

	function organizeItems(data) {
		var items = [];

		items.push(data.fandom.items.shift());
		items = items.concat(data.articles.splice(0, 2));
		items = items.concat(data.fandom.items);
		items = items.concat(data.articles);

		items.forEach(function(item, index) {
			items[index].index = index;
		});

		return items;
	}

	function setupTracking(experimentName) {
		return function($html) {
			tracker.trackVerboseImpression(experimentName, 'impact-footer');

			$html.on('mousedown', 'a', function() {
				tracker.trackVerboseClick(experimentName, utils.buildLabel(this, 'impact-footer'));
			});
		};
	}

	return function(config) {
		$.extend(options, config);

		return {
			render: render,
			setupTracking: setupTracking
		};
	};
});
