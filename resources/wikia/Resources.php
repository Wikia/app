<?php

/**
 * This file contains shared Wikia-specific ResourceLoader modules
 */

return [
	// AMD library
	'amd' => [
		'scripts' => 'resources/wikia/libraries/modil/modil.js',
	],

	// shared AMD modules loaded on each page
	'amd.shared' => [
		'dependencies' => [
			'wikia.instantGlobals',
			'wikia.cache',
			'wikia.cookies',
			'wikia.document',
			'wikia.geo',
			'wikia.fbLocale',
			'wikia.loader',
			'wikia.localStorage',
			'wikia.location',
			'wikia.log',
			'wikia.mw',
			'wikia.nirvana',
			'wikia.querystring',
			'wikia.history',
			'wikia.throbber',
			'wikia.thumbnailer',
			'wikia.tracker',
			'wikia.window',
			'wikia.abTest',
			'underscore',
		],
		'position' => 'top', // needs to be loaded before AssetsManager files
	],

	// core AMD modules (see amd.shared module],
	'wikia.window' => [
		'scripts' => 'resources/wikia/modules/window.js',
		'dependencies' => 'amd',
	],
	'wikia.cache' => [
		'scripts' => 'resources/wikia/modules/cache.js',
		'dependencies' => [
			'amd',
			'wikia.localStorage',
			'wikia.window',
		],
	],
	'wikia.document' => [
		'scripts' => 'resources/wikia/modules/document.js',
		'dependencies' => [
			'amd',
			'wikia.window',
		],
	],
	'wikia.location' => [
		'scripts' => 'resources/wikia/modules/location.js',
		'dependencies' => [
			'amd',
			'wikia.window',
		],
	],
	'wikia.localStorage' => [
		'scripts' => 'resources/wikia/modules/localStorage.js',
		'dependencies' => [
			'amd',
			'wikia.window',
		],
	],
	'wikia.nirvana' => [
		'scripts' => 'resources/wikia/modules/nirvana.js',
		'dependencies' => [
			'amd'
		],
	],
	'wikia.mw' => [
		'scripts' => 'resources/wikia/modules/mw.js',
		'dependencies' => [
			'amd',
			'wikia.window',
		],
	],
	'wikia.fbLocale' => [
		'scripts' => 'resources/wikia/modules/facebookLocale.js',
		'dependencies' => [
			'wikia.geo',
		],
	],
	'wikia.loader' => [
		'scripts' => 'resources/wikia/modules/loader.js',
		'dependencies' => [
			'amd',
			'wikia.window',
			'wikia.mw',
			'wikia.nirvana',
			'wikia.fbLocale',
		],
	],
	'wikia.querystring' => [
		'scripts' => 'resources/wikia/modules/querystring.js',
		'dependencies' => [
			'amd',
			'wikia.window',
		],
	],
	'wikia.history' => [
		'scripts' => 'resources/wikia/modules/history.js',
		'dependencies' => [
			'amd',
			'wikia.window',
		],
	],
	'wikia.cookies' => [
		'scripts' => 'resources/wikia/modules/cookies.js',
		'dependencies' => [
			'amd',
			'wikia.window',
		]
	],
	'wikia.log' => [
		'scripts' => 'resources/wikia/modules/log.js',
		'dependencies' => [
			'amd',
			'wikia.querystring',
			'wikia.cookies',
		],
	],
	'wikia.abTest' => [
		'scripts' => 'resources/wikia/modules/abTest.js',
		'dependencies' => [
			'amd',
			'wikia.window'
		],
	],
	'wikia.instantGlobals' => [
		'scripts' => 'resources/wikia/modules/instantGlobals.js',
		'dependencies' => [
			'amd',
			'wikia.window'
		],
	],
	'wikia.thumbnailer' => [
		'scripts' => 'resources/wikia/modules/thumbnailer.js',
		'dependencies' => 'amd',
	],
	'wikia.geo' => [
		'scripts' => 'resources/wikia/modules/geo.js',
		'dependencies' => [
			'amd',
			'wikia.cookies',
		],
	],
	'wikia.tracker' => [
		'scripts' => 'resources/wikia/modules/tracker.js',
		'dependencies' => [
			'amd',
			'wikia.window',
			'wikia.log',
			'wikia.tracker.stub',
		],
	],
	'wikia.tracker.stub' => [
		'scripts' => 'resources/wikia/modules/tracker.stub.js',
		'dependencies' => [
			'amd',
			'wikia.window',
		],
	],
	'wikia.throbber' => [
		'scripts' => 'resources/wikia/modules/throbber.js',
		'dependencies' => [
			'amd',
		],
	],
	'underscore' => [
		'scripts' => 'resources/wikia/libraries/underscore/underscore-min.js',
		'dependencies' => [
			'amd',
		],
	],

	// AMD modules loaded on demand
	'wikia.aim' => [
		'scripts' => 'resources/wikia/modules/aim.js',
		'dependencies' => 'amd',
	],

	'wikia.uniqueId' => [
		'scripts' => 'resources/wikia/modules/uniqueId.js',
		'dependencies' => 'amd',
	],

	'wikia.modernizr' => [
		'scripts' => 'resources/wikia/modules/modernizr.js',
		'dependencies' => [
			'amd',
			'modernizr',
		],
	],

	'wikia.mustache' => [
		'scripts' => 'resources/wikia/libraries/mustache/mustache.js',
		'dependencies' => 'amd',
	],

	// libraries and jQuery plugins
	'wikia.underscore' => [
		'scripts' => 'resources/wikia/modules/underscore.js',
		'dependencies' => [
			'amd',
			'wikia.window',
		]
	],

	'wikia.stickyElement' => [
		'scripts' => 'resources/wikia/modules/stickyElement.js',
		'dependencies' => [
			'amd',
			'wikia.window',
			'wikia.document',
			'wikia.underscore',
		]
	],

	// module loaded via $.loadjQuery UI and is a wrapper for MediaWiki jQuery UI modules
	// this used to be static file located in /skins/common/jquery/jquery-ui-1.8.14.custom.js
	'wikia.jquery.ui' => [
		'scripts' => 'resources/wikia/libraries/jquery-ui/jquery.ui.menu.js',
		'dependencies' => [
			'jquery.ui.core',
			'jquery.ui.widget',
			'jquery.ui.mouse',
			'jquery.ui.position',
			'jquery.ui.draggable',
			'jquery.ui.droppable',
			'jquery.ui.sortable',
			'jquery.ui.autocomplete',
			'jquery.ui.slider',
			'jquery.ui.tabs',
			'jquery.ui.datepicker',
		],
		'group' => 'jquery.ui',
	],

	// libraries and jQuery plugins
	'jquery.mustache' => [
		'scripts' => 'resources/wikia/libraries/mustache/jquery.mustache.js',
		'dependencies' => 'wikia.mustache',
	],

	'jquery.autocomplete' => [
		'scripts' => 'resources/wikia/libraries/jquery/autocomplete/jquery.autocomplete.js'
	],

	// moved here from AssetsManager by wladek
	'wikia.yui' => [
		'scripts' => [
			'resources/wikia/libraries/yui/wikia.yui-scope-workaround.js',
			'resources/wikia/libraries/yui/utilities/utilities.js',
			'resources/wikia/libraries/yui/cookie/cookie-beta.js',
			'resources/wikia/libraries/yui/container/container.js',
			'resources/wikia/libraries/yui/autocomplete/autocomplete.js',
			'resources/wikia/libraries/yui/animation/animation-min.js',
			'resources/wikia/libraries/yui/logger/logger.js',
			'resources/wikia/libraries/yui/menu/menu.js',
			'resources/wikia/libraries/yui/tabview/tabview.js',
			'resources/wikia/libraries/yui/slider/slider.js',
			'resources/wikia/libraries/yui/extra/tools-min.js',
			'resources/wikia/libraries/yui/extra/carousel-min.js',
		],
		'group' => 'yui',
	],

	// Wikia-specific assets for monobook-based skins
	'wikia.monobook' => [
		'styles' => [
			'skins/wikia/shared.css',
			'skins/wikia/css/Monobook.css',
			'resources/wikia/libraries/yui/container/assets/container.css',
			'resources/wikia/libraries/yui/logger/assets/logger.css',
			'resources/wikia/libraries/yui/tabview/assets/tabview.css',
			'extensions/wikia/RelatedPages/RelatedPages.monobook.css',
		],
	],

	'wikia.importScript' => [
		'scripts' => [
			'resources/wikia/modules/importScript.js',
			'resources/wikia/modules/importScriptHelper.js'
		]
	],

	'wikia.article.edit' => [
		'scripts' => [
			'resources/wikia/modules/article.edit.js',
		],
		'dependencies' => [
			'wikia.tracker',
		]
	],
];
