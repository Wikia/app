/*global describe, it, runs, waitsFor, expect, require, document*/
ddescribe("Toast module", function () {
	'use strict';

	var body = getBody(),
		window = {
			document: {
				body: body,
				getElementById: function(id){
					return body.querySelector('#' + id);
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

	it('should show/hide itself', function(){

		var msg = 'This is a test message',
			doc = window.document;

		toast.show(msg);

		expect(doc.body.className).toMatch(' hasToast');
		expect(doc.getElementById('wkTst').innerHTML).toBe(msg);

		toast.show(msg, {
			error: true
		});

		expect(doc.getElementById('wkTst').className).toMatch('err');

		toast.hide();

		expect(doc.getElementById('wkTst').className).toBe('hide clsIco');
	});

});