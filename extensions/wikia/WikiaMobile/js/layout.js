/* global Features */
/**
 * @requires section, media, cache, wikia.loader, lazyload, jquery, sloth
 *
 * Layout handling of WikiaMobile
 * ie. Sections, Images, Galleries etc.
 */
require(['sections', 'media', require.optional('wikia.cache'), 'wikia.loader', 'lazyload', 'jquery', 'sloth'], function(sections, media, cache, loader, lazyload, $, sloth) {
	'use strict';

	//init sections
	sections.init(Features.gameguides);

	var d = document,
		images = d.getElementsByClassName('media'),
		selector = 'table:not(.toc):not(.infobox)',
		tables = d.querySelectorAll(selector),
		tablesProcessedSections = [],
		tablesModule,
		tablesKey = 'wideTables',
		ttl = 604800, //7days
		assets,
		process = function(res){
			!assets && cache && cache.setVersioned(tablesKey, res, ttl);

			if(res) {
				var scripts = res.scripts,
					l = scripts.length,
					i = 0;

				loader.processStyle(res.styles);

				for(; i < l; i++ ){
					loader.processScript(scripts[i]);
				}
			}

			require([require.optional('tables')], function(t){
				t && t.process($(selector).not('.artSec table, table table'));

				//make it available for sections on open so tables can be processed as well
				tablesModule = t;
			});
		};

	$(document).on('sections:open', function(event, section){
		var index = ~~section.attr('data-index');

		if(tablesModule && !tablesProcessedSections[index]){
			//without fake I get DOM Exception 12
			tablesModule.process(section.find(selector).not('table table,fake'));

			tablesProcessedSections[index] = true;
		}

		sloth();
	});

	//tables
	if(tables && tables.length > 0){
		assets = cache && cache.getVersioned(tablesKey);

		if(Features.gameguides || assets){
			//if gameguides or we already have all our asses
			process(assets);
		}else{
			//when we need to load assets
			loader({
				type: loader.MULTI,
				resources: {
					scripts: 'wikiamobile_tables_js' + (Features.overflow ? '' : ',wikiamobile_scroll_js'),
					styles: '/extensions/wikia/WikiaMobile/css/tables.scss',
					ttl: ttl
				}
			}).done(process);
		}
	}

	//init media
	media.init(images);

	sloth({
		on: document.getElementsByClassName('lazy'),
		threshold: 300,
		callback: lazyload
	});
});
