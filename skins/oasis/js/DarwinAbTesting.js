// ABTEST: DAR_RIGHTRAILPOSITION

var hookRightRailImpression = function (label) {
	require(['sloth'], function(sloth) {
		sloth( {
			on: document.getElementById('WikiaRail'),
			threshold: 100,
			callback: function(element) {
				Wikia.Tracker.track({
					action: Wikia.Tracker.ACTIONS.IMPRESSION,
					category: 'right-rail-abtesting',
					label: label,
					trackingMethod: 'both'
				}, {});
			}
		});
	});
};

$(function () {
	// Determine if we're in experiment DAR_RIGHTRAILPOSITION
	group = window.Wikia.AbTest
		? Wikia.AbTest.getGroup( "DAR_RIGHTRAILPOSITION" )
		: null ;

	switch (group) {
    case "STATIC":
        // don't let right rail to fall down
        $('html').addClass('keep-rail-on-right');
	    hookRightRailImpression('static');
        break;
    default:
        // no changes in behaviour
		hookRightRailImpression('control');
	}
});
