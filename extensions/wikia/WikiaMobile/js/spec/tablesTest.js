/*
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/tables.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
window.addEventListener('load', function(){
	'use strict';

	function fire(event, element){
		var evt = document.createEvent("HTMLEvents");
		evt.initEvent(event, true, true); // event type,bubbling,cancelable
		return !element.dispatchEvent(evt);
	}

	window.Features = {};

	window.iScroll = function(){};

	document.body.innerHTML = '<div id="mw-content-text"><table style="width:2000px"><tr><td></td></tr></table><table><tr><td></td></tr></table></div>';

	describe("Tables module", function () {

		var tables = define.getModule(
			{
				touch: 'click'
			},
			{
				track: function(){}
			});

		it('is defined', function(){
			expect(tables).toBeDefined();
			expect(typeof tables.process).toBe('function');
		});

		it('should wrap/unwrap table', function(){
			var tab = document.getElementsByTagName('table');

			tables.process(tab);

			var table = document.getElementsByTagName('table')[0];

			expect(table.parentElement.id).not.toBe("mw-content-text");
			expect(table.parentElement.className).toBe('bigTable');

//			fire('viewportsize', window);
//
//			table = document.getElementsByTagName('table')[0];
//
//			expect(table.parentElement.id).toBe("mw-content-text");
//			expect(table.parentElement.className).not.toBe('bigTable');
		});

		it('should add wkScroll to bitTable', function(){
			document.body.innerHTML = '<div id="mw-content-text"><table style="width:2000px"><tr><td></td></tr></table><table><tr><td></td></tr></table></div>';

			var tab = document.getElementsByTagName('table');

			tables.process(tab);

			var table = document.getElementsByTagName('table')[0];

			fire('click', table.parentElement);

			expect(table.parentElement.className).toMatch('active');
			expect(table.parentElement.wkScroll).toBe(true);

		});
	});
});
