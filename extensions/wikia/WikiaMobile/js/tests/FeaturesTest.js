/*
 @test-framework Jasmine
 @test-require-asset /extensions/wikia/WikiaMobile/js/features.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Test features module", function () {
	'use strict';

	it('should be defined', function(){
		expect(Features).toBeDefined();
		expect(Features.addTest).toBeDefined();
		expect(typeof Features.addTest).toBe('function');
	});

	it('should normalize name', function(){
		Features.addTest('WeIrDNAme', function(){
			return true;
		})

		expect(Features.WeIrDNAme).not.toBeDefined();

		expect(Features.weirdname).toBeDefined();
		expect(Features.weirdname).toBe(true);
	});

	it('should run test smoothly', function(){
		Features.addTest('test', function(){
			return true;
		});

		expect(Features.test).toBeDefined();
		expect(Features.test).toBe(true);
		expect(document.documentElement.className).toMatch(' test');

		Features.addTest('test2', function(){
			return false;
		});

		expect(Features.test2).toBeDefined();
		expect(Features.test2).toBe(false);
		expect(document.documentElement.className).toMatch(' no-test2');
	});

});