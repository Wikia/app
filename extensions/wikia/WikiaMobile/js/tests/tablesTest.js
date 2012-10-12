/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/wikia/modules/querystring.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/scroll.wikiamobile.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/loader.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/media.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/modal.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/sections.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/layout.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/track.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/events.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/tables.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Test tables module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	window.WikiaTracker = {
		ACTIONS: {}
	};

	window.Features = {};

	window.wgStyleVersion = 1234567890;

	var pageWidth = 1000;

	define.mock('layout', {
		getPageWidth: function(){
			return pageWidth;
		}
	});

	function fire(event, element){
		var evt = document.createEvent("HTMLEvents");
		evt.initEvent(event, true, true); // event type,bubbling,cancelable
		return !element.dispatchEvent(evt);
	}

	async.it('should be defined', function(done){

		document.body.innerHTML = '<div id="mw-content-text"></div>';

		require(['tables'], function(tables){
			expect(tables).toBeDefined();
			expect(typeof tables.process).toBe('function');

			done();
		});
	});

	async.it('should wrap/unwrap table', function(done){
		document.body.innerHTML = '<div id="mw-content-text"><table style="width:2000px"><tr><td></td></tr></table><table><tr><td></td></tr></table></div>';

		var tab = document.getElementsByTagName('table');

		require(['tables'], function(tables){
			tables.process(tab);

			var table = document.getElementsByTagName('table')[0];

			expect(table.parentElement.id).not.toBe("mw-content-text");
			expect(table.parentElement.className).toBe('bigTable');

			pageWidth = 3000;

			fire('viewportsize', window);

			var table = document.getElementsByTagName('table')[0];

			expect(table.parentElement.id).toBe("mw-content-text");
			expect(table.parentElement.className).not.toBe('bigTable');

			done();
		});
	});

	async.it('should add wkScroll to bitTable', function(done){
		document.body.innerHTML = '<div id="mw-content-text"><table style="width:2000px"><tr><td></td></tr></table><table><tr><td></td></tr></table></div>';

		var tab = document.getElementsByTagName('table');

		require(['tables', 'events'], function(tables, ev){
			tables.process(tab);

			var table = document.getElementsByTagName('table')[0];

			fire(ev.touch, table.parentElement);

			expect(table.parentElement.className).toMatch('active');
			expect(table.parentElement.wkScroll).toBe(true);

			done();
		});
	});
});