/*global describe, it, runs, waitsFor, expect, require, document*/
describe("Toast module", function () {
	'use strict';

	var body = getBody(),
		window = {
			document: {
				body: body,
				getElementById: function(id){
					body.querySelector('#' + id);
				}
			}
		};

	var toast = modules.toast(window);

	it('should be defined', function(){
		expect(toast).toBeDefined();
		expect(typeof toast.show).toBe('function');
		expect(typeof toast.hide).toBe('function');
	});

	it('should throw exception', function(){
		expect(function(){
			toast.show();
		}).toThrow();

		expect(function(){
			toast.show('');
		}).toThrow();
	});

	it('should show/hide toast', function(){

		var msg = 'This is a test message';

		toast.show(msg);

		expect(window.document.body.className).toMatch(' hasToast');
		expect(window.document.getElementById('wkTst').innerHTML).toBe(msg);

		toast.show(msg, {
			error: true
		});

		expect(window.document.getElementById('wkTst').className).toMatch('err');

		toast.hide();

		expect(window.document.getElementById('wkTst').className).toBe('hide clsIco');
	});

});