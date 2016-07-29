/**
 * Karma configuration
 *
 * Used to run Wikia's JS Integration tests
 *
 * created by Jakub Olek <jakubolek@wikia-inc.com>
 */

var base = require('./karma.base.conf.js');

module.exports = function (config) {
	'use strict';

	base(config);

	config.set({
		files: [
			'tests/lib/jasmine/helpers.js',

			'resources/jquery/jquery-1.8.2.js',
			'resources/wikia/libraries/define.mock.js',

			// JSMessages
			'resources/mediawiki/mediawiki.js',
			'extensions/wikia/JSMessages/js/JSMessages.js',

			// Chat Tests
			'extensions/wikia/Chat2/js/spec/integration/views.mocks.js',
			'extensions/wikia/Chat2/js/views/views.js',
			'extensions/wikia/Chat2/js/spec/integration/ChatController.spec.js',

			// WikiaMobile
			'extensions/wikia/WikiaMobile/js/autocomplete.js',
			'extensions/wikia/WikiaMobile/js/events.js',
			'extensions/wikia/WikiaMobile/js/features.js',
			'extensions/wikia/WikiaMobile/js/lazyload.js',
			'extensions/wikia/WikiaMobile/js/mediagallery.js',
			'extensions/wikia/WikiaMobile/js/media.js',
			'extensions/wikia/WikiaMobile/js/modal.js',
			'extensions/wikia/WikiaMobile/js/pager.js',
			'extensions/wikia/WikiaMobile/js/popover.js',
			'extensions/wikia/WikiaMobile/js/sections.js',
			'extensions/wikia/WikiaMobile/js/share.js',
			'extensions/wikia/WikiaMobile/js/tables.js',
			'extensions/wikia/WikiaMobile/js/throbber.js',
			'extensions/wikia/WikiaMobile/js/toast.js',
			'extensions/wikia/WikiaMobile/js/track.js',
			'extensions/wikia/WikiaMobile/js/toc.js',
			'extensions/wikia/WikiaMobile/js/topbar.js',
			'extensions/wikia/WikiaMobile/js/features.js',

			// loading specs for WikiaMobile
			'extensions/wikia/WikiaMobile/js/spec/integration/*.spec.js',

			// core modules
			'resources/wikia/libraries/mustache/mustache.js',
			'resources/wikia/libraries/mustache/jquery.mustache.js',
			'resources/wikia/modules/aim.js',
			'resources/wikia/modules/cache.js',
			'resources/wikia/modules/cookies.js',
			'resources/wikia/modules/geo.js',
			'resources/wikia/modules/history.js',
			'resources/wikia/modules/lazyqueue.js',
			'resources/wikia/modules/facebookLocale.js',
			'resources/wikia/modules/loader.js',
			'resources/wikia/modules/nirvana.js',
			'resources/wikia/modules/nodeFinder.js',
			'resources/wikia/modules/querystring.js',
			'resources/wikia/modules/scrollToLink.js',
			'resources/wikia/modules/stringhelper.js',
			'resources/wikia/modules/thumbnailer.js',
			'resources/wikia/modules/uniqueId.js',
			'resources/wikia/modules/window.js',

			// loading specs for core modules
			'resources/wikia/modules/spec/integration/*.spec.js',

			// SpecialPromote
			'extensions/wikia/SpecialPromote/js/spec/integration/SpecialPromote.mocks.js',
			'extensions/wikia/SpecialPromote/js/SpecialPromote.js',
			'extensions/wikia/SpecialPromote/js/spec/integration/SpecialPromote.spec.js',

			// Lightbox
			'extensions/wikia/Lightbox/scripts/Lightbox.js',
			'extensions/wikia/Lightbox/scripts/spec/integration/lightbox.spec.js'
		]
	});
};
