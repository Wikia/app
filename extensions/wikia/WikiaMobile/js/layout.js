/* global Features */
/**
 * @requires section, media, cache, wikia.loader, lazyload, jquery, sloth
 *
 * Layout handling of WikiaMobile
 * ie. Images, Galleries etc.
 */
(function () {
	'use strict';

	var media = require('media'),
		loader = require('wikia.loader'),
		lazyload = require('lazyload'),
		$ = require('jquery'),
		sloth = require('sloth'),
		cache,
		d = document,
		selector = 'table:not(.toc):not(.infobox):not(.infobox-table)',
		tables = d.querySelectorAll(selector),
		tablesKey = 'wideTables',
		ttl = 604800, //7days
		assets,
		lazyImages,
		process = function (res) {
			if (!assets && cache) {
				cache.setVersioned(tablesKey, res, ttl);
			}

			if (res) {
				loader.processStyle(res.styles);
				loader.processScript(res.scripts);
			}

			require('tables').process($(selector).not('table table, fake'));
		};

	/**
	 * cache module is optional here
	 */
	try {
		cache = require('wikia.cache');
	} catch (exception) {
	}

	//tables
	if (tables && tables.length > 0) {
		assets = cache && cache.getVersioned(tablesKey);

		if (Features.gameguides || assets) {
			//if gameguides or we already have all our asses
			process(assets);
		} else {
			//when we need to load assets
			loader({
				type: loader.MULTI,
				resources: {
					scripts: 'wikiamobile_tables_js',
					styles: '/extensions/wikia/WikiaMobile/css/tables.scss'
				}
			}).done(process);
		}
	}

	//init media
	media.init(d.getElementsByClassName('media'));

	lazyImages = d.getElementsByClassName('lazy');
	lazyload.fixSizes(lazyImages);

	sloth({
		on: lazyImages,
		threshold: 400,
		callback: lazyload
	});
})();
