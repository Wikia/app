/*
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/layout.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
//currently layout does not have anything testable
xdescribe("Layout module", function () {
	'use strict';

	window.Features = {};
	window.wgStyleVersion = 123;

	var layout = define.getModule(
		{
			init: function(){},
			addEventListener: function(){}
		},
		{
			init: function(){}
		},
		undefined,
		undefined,
		function(){}
	);

	window.require = function(){};

	it('is defined', function(done){
		document.body.innerHTML = '<div id="wkPage"><div id="mw-content-text"></div></div>';

		expect(layout).toBeDefined();
	});
});
