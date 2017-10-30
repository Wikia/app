if (window.wgStagingEnvironment) {
	(function (document) {
		'use strict';
		var stagingEnvName = window.location.hostname.match(/([^\.]+)\.wikia\.com/);
		if (stagingEnvName) {
			stagingEnvName = stagingEnvName[1];
			var links = document.getElementsByTagName('a'),
				i = 0,
				href,
				hostname;
			for (; i < links.length; i++) {
				href = links[i].href;
				hostname = links[i].hostname;
				if (
					href &&
					hostname &&
					!hostname.endsWith(stagingEnvName + '.wikia.com') &&
					hostname.endsWith('.wikia.com') &&
					hostname !== 'fandom.wikia.com'
				) {
					links[i].hostname = hostname.replace('.wikia.com', '.' + stagingEnvName + '.wikia.com');
				}
			}
		}
	})(document);
}
