define('ext.wikia.curatedTour.editBox',
	[
		'jquery',
		'wikia.loader'
	],
	function($) {

		function init() {
			$.when(loader({
				type: loader.MULTI,
				resources: {
					messages: 'CuratedTourEditBox',
					mustache: '/extensions/wikia/CuratedTour/templates/editBox.mustache',
					styles: '/extensions/wikia/CuratedTour/styles/editBox.scss'
				}
			})).done(function(resources){
				loader.processStyles(resources.styles)
			});
		}

		return {
			init: init
		}
	}
)
