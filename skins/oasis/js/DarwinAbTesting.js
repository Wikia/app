// ABTEST: DAR_RIGHTRAILPOSITION

var checkElementVisibility = function (elem) {
	var top = elem.offsetTop,
		bottom = (top + elem.offsetHeight),
		wTop = ((window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop),
		wBottom = (wTop + window.innerHeight);

	return wBottom >= top && wTop <= bottom;
}

var doTrackImpression = function (label) {
	Wikia.Tracker.track({
		action: Wikia.Tracker.ACTIONS.IMPRESSION,
		category: 'abtest-right-rail',
		label: label,
		trackingMethod: 'both'
	}, {});
}

var hookRightRailImpression = function (label) {
	var elem = document.getElementById('WikiaRail');

	// if element is already being visible, we don't need slothjs
	// and we can count impression right away.
	if ( checkElementVisibility(elem) ) {
		doTrackImpression(label);
	} else {
		require(['sloth'], function(sloth) {
			sloth( {
				on: elem,
				threshold: 0,
				callback: function(element) {
					doTrackImpression(label);
				}
			});
		});
	}
}

$(function(){
	// check if we have responsive layout turned on
	if ( window.wgOasisResponsive ) {
		// Determine if we're in experiment DAR_RIGHTRAILPOSITION
		group = window.Wikia.AbTest
			? Wikia.AbTest.getGroup( "DAR_RIGHTRAILPOSITION" )
			: null ;

		switch (group) {
		case "STATIC":
			// track impression
			hookRightRailImpression('static');
			break;
		case "CONTROL":
			// it's control group, do nothing (just track)
			hookRightRailImpression('control');
			break;
		default:
		    // don't track
		}
	}
});
