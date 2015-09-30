$(function () {
	'use strict';

	var sessionVisitSource = new VisitSource('WikiaSessionSource', window.wgCookieDomain),
		lifetimeVisitSource = new VisitSource('WikiaLifetimeSource', window.wgCookieDomain, false);

	sessionVisitSource.checkAndStore();
	lifetimeVisitSource.checkAndStore();
});
