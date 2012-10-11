/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /extensions/wikia/WikiaMobile/js/toast.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Test toast module", function () {
	'use strict';
	var async = new AsyncSpec(this);

	async.it('should be defined', function(done){
		require(['toast'], function(toast){

			expect(toast).toBeDefined();
			expect(typeof toast.show).toBe('function');
			expect(typeof toast.hide).toBe('function');

			done();
		});
	});

	async.it('should throw exception', function(done){
		require(['toast'], function(toast){

			expect(function(){
				toast.show();
			}).toThrow();

			expect(function(){
				toast.show('');
			}).toThrow();

			done();
		});
	});

	async.it('should show/hide toast', function(done){

		var msg = 'This is a test message';

		require(['toast'], function(toast){

			toast.show(msg);

			expect(document.body.className).toMatch(' hasToast');
			expect(document.getElementById('wkTst').innerHTML).toBe(msg);


			toast.show(msg, {
				error: true
			});

			expect(document.getElementById('wkTst').className).toMatch('err');

			toast.hide();

			expect(document.getElementById('wkTst').className).toBe('hide clsIco');

			done();
		});
	});

});