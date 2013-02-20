<?php

/**
 * This file contains shared Wikia-specific ResourceLoader modules
 */

return array(
	// AMD library
	'amd' => array(
		'scripts' => 'resources/wikia/libraries/modil/modil.js',
	),

	// shared AMD modules loaded on each page
	'amd.shared' => array(
		'dependencies' => array(
			'wikia.window',
			'wikia.location',
			'wikia.localStorage',
			'wikia.deferred',
			'wikia.ajax',
			'wikia.nirvana',
			'wikia.mw',
			'wikia.loader',
			'wikia.querystring',
			'wikia.cookies',
			'wikia.log',
			'wikia.thumbnailer',
			'wikia.geo',
			'wikia.tracker',
		),
		'position' => 'top', // needs to be loaded before AssetsManager files
	),

	// core AMD modules (see amd.shared module)
	'wikia.window' => array(
		'scripts' => 'resources/wikia/modules/window.js',
		'dependencies' => 'amd',
	),
	'wikia.location' => array(
		'scripts' => 'resources/wikia/modules/location.js',
		'dependencies' => 'amd',
	),
	'wikia.localStorage' => array(
		'scripts' => 'resources/wikia/modules/localStorage.js',
		'dependencies' => 'amd',
	),
	'wikia.deferred' => array(
		'scripts' => 'resources/wikia/modules/deferred.js',
		'dependencies' => array(
			'amd',
			'wikia.window'
		)
	),
	'wikia.ajax' => array(
		'scripts' => 'resources/wikia/modules/ajax.js',
		'dependencies' => 'amd',
	),
	'wikia.nirvana' => array(
		'scripts' => 'resources/wikia/modules/nirvana.js',
		'dependencies' => array(
			'amd',
			'wikia.ajax'
		)
	),
	'wikia.mw' => array(
		'scripts' => 'resources/wikia/modules/mw.js',
		'dependencies' => 'amd',
	),
	'wikia.loader' => array(
		'scripts' => 'resources/wikia/modules/loader.js',
		'dependencies' => array(
			'amd',
			'wikia.window',
			'wikia.mw',
			'wikia.nirvana'
		)
	),
	'wikia.querystring' => array(
		'scripts' => 'resources/wikia/modules/querystring.js',
		'dependencies' => array(
			'amd',
			'wikia.window',
		)
	),
	'wikia.cookies' => array(
		'scripts' => 'resources/wikia/modules/cookies.js',
		'dependencies' => 'amd'
	),
	'wikia.log' => array(
		'scripts' => 'resources/wikia/modules/log.js',
		'dependencies' => array(
			'amd',
			'wikia.querystring',
			'wikia.cookies',
		)
	),
	'wikia.thumbnailer' => array(
		'scripts' => 'resources/wikia/modules/thumbnailer.js',
		'dependencies' => 'amd',
	),
	'wikia.geo' => array(
		'scripts' => 'resources/wikia/modules/geo.js',
		'dependencies' => array(
			'amd',
			'wikia.cookies'
		)
	),
	'wikia.tracker' => array(
		'scripts' => 'resources/wikia/modules/tracker.js',
		'dependencies' => array(
			'amd',
			'wikia.window',
			'wikia.log',
		)
	),

	// AMD modules loaded on demand
	'wikia.aim' => array(
		'scripts' => 'resources/wikia/modules/aim.js',
		'dependencies' => 'amd',
	),

	'wikia.uniqueId' => array(
		'scripts' => 'resources/wikia/modules/uniqueId.js',
		'dependencies' => 'amd',
	),

	'wikia.modernizr' => array(
		'scripts' => 'resources/wikia/modules/modernizr.js',
		'dependencies' => array(
			'amd',
			'modernizr'
		)
	),

	'wikia.mustache' => array(
		'scripts' => 'resources/wikia/libraries/mustache/mustache.js',
		'dependencies' => 'amd'
	),

	// module loaded via $.loadjQuery UI and is a wrapper for MediaWiki jQuery UI modules
	// this used to be static file located in /skins/common/jquery/jquery-ui-1.8.14.custom.js
	'wikia.jquery.ui' => array(
		'scripts' => 'resources/wikia/libraries/jquery-ui/jquery.ui.menu.js',
		'dependencies' => array(
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
		),
		'group' => 'jquery.ui'
	),

	// libraries and jQuery plugins
	'jquery.mustache' => array(
		'scripts' => 'resources/wikia/libraries/mustache/jquery.mustache.js',
		'dependencies' => 'wikia.mustache'
	),

	'jquery.autocomplete' => array(
		'scripts' => 'resources/wikia/libraries/jquery/autocomplete/jquery.autocomplete.js'
	),

	// moved here from AssetsManager by wladek
	'wikia.yui' => array(
		'scripts' => array(
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
		),
		'group' => 'yui',
	),

	// Wikia-specific assets for monobook-based skins
	'wikia.monobook' => array(
		'styles' => array(
			'skins/wikia/shared.css',
			'skins/wikia/css/Monobook.css',
			'resources/wikia/libraries/yui/container/assets/container.css',
			'resources/wikia/libraries/yui/logger/assets/logger.css',
			'resources/wikia/libraries/yui/tabview/assets/tabview.css',
			'extensions/wikia/RelatedPages/RelatedPages.monobook.css',
		)
	),

);
