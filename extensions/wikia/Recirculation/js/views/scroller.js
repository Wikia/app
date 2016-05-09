/*global define*/
define('ext.wikia.recirculation.views.scroller', [
	'jquery',
	'wikia.window',
	'wikia.log',
	'ext.wikia.recirculation.tracker',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.views.incontent'
], function ($, w, log, tracker, utils, incontent) {

	var logGroup = 'ext.wikia.recirculation.views.scroller';

	function render(data) {
		var deferred = $.Deferred(),
			section = incontent().findSuitableSection();

		if (!section) {
			return deferred.reject('Recirculation scroller widget not shown - Not enough sections in article');
		}

		utils.renderTemplate('scroller.mustache', data).then(function($html) {
			section.before($html);

			var scroller = $html.find('.items-container').perfectScrollbar({
					suppressScrollY: true
				}),
				scrollAmount = $html.find('.item').outerWidth(true) * 3;

			$html.find('.scroller-arrow').click(function() {
				var direction = $(this).data('direction'),
					currentScrollLeft = scroller.scrollLeft()
					scroll;

				if (direction === 'prev') {
					scroll = currentScrollLeft - scrollAmount;
				} else {
					scroll = currentScrollLeft + scrollAmount;
				}

				scroller.animate({
					scrollLeft: scroll
				});
				scroller.perfectScrollbar('update');
			});


			deferred.resolve($html);
		});

		return deferred.promise();
	}

	function setupTracking(experimentName) {
		return function($html) {
			tracker.trackVerboseImpression(experimentName, 'scroller');

			$html.on('mousedown', 'a', function() {
				tracker.trackVerboseClick(experimentName, utils.buildLabel(this, 'scroller'));
			});
		}
	}

	return function() {

		return {
			render: render,
			setupTracking: setupTracking
		}
	}
});
