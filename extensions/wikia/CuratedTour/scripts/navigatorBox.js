define('ext.wikia.curatedTour.navigatorBox',
	[
		'jquery',
		'mw',
		'wikia.loader',
		'wikia.mustache',
		'ext.wikia.curatedTour.tourNavigator',
		'ext.wikia.curatedTour.tourManager'
	],
	function($, mw, loader, mustache, TourNavigator, TourManager) {
		"use strict";

		var	resources;

		function init() {
			resources = null;
			if (resources === null) {
				$.when(loader({
					type: loader.MULTI,
					resources: {
						messages: 'CuratedTourNavigatorBox',
						mustache: '/extensions/wikia/CuratedTour/templates/navigatorBox.mustache,/extensions/wikia/CuratedTour/templates/navigatorBoxItem.mustache',
						styles: '/extensions/wikia/CuratedTour/styles/navigatorBox.scss'
					}
				})).done(function (res) {
					setupNavigatorBox(res);
				});
			} else {
				setupNavigatorBox(resources);
			}
		}

		function setupNavigatorBox(res) {
			if (resources === null) {
				resources = res;
			}

			loader.processStyle(res.styles);
			mw.messages.set(res.messages);

			TourManager.getPlan(renderNavigatorBox);
		}

		function renderNavigatorBox(currentTour) {
			var templateData = {
				title: mw.message('curated-tour-navigator-box-title').escaped(),
				currentTour: currentTour,
				nextStepText: mw.message('curated-tour-navigator-box-next').escaped()
			}

			if (TourNavigator.getCurrentStep() !== 1) {
				templateData.previousStepText = mw.message('curated-tour-navigator-box-previous').escaped();
			}

			$.when($('body').append(mustache.to_html(
				resources.mustache[0],
				templateData,
				{
					navigatorBoxItem: resources.mustache[1]
				}
			))).done(bindEventsToNavigatorBox);
		}

		function bindEventsToNavigatorBox() {
			$('.ct-navigator-box-controls-next').on('click', TourNavigator.goToNextStep);
			$('.ct-navigator-box-controls-previous').on('click', TourNavigator.goToPreviousStep);
		}

		return {
			init: init
		}
	}
)

