/*global describe, it, runs, waitsFor, expect, require, document*/
describe("AIM", function () {
	'use strict';

	var async = new AsyncSpec(this),
		aim = modules['wikia.aim'](window.jQuery);

	it('should be defined', function() {
		// jQuery "namespace" API
		expect(window.jQuery.AIM).toBeDefined();
		expect(typeof window.jQuery.AIM.submit).toBe('function');

		// AMD API
		expect(aim).toBeDefined();
		expect(typeof aim.submit).toBe('function');
	});

	async.it('onStart() should be called', function(done) {
		var form = document.createElement('form'),
			body = getBody();

		body.appendChild(form);

		aim.submit(form, {
			onStart: function() {
				var iFrameName = form.getAttribute('target');

				expect(iFrameName).toContain('aim');
				expect($('iframe#' + iFrameName).length).toBe(1);

				done();
			}
		});
	});

	async.it('onComplete() should be called', function(done) {
		var form = document.createElement('form');
		getBody().appendChild(form);

		aim.submit(form, {
			onStart: function() {
				form.setAttribute('action', '');
				form.submit();
			},
			onComplete: function(resp) {
				expect(resp).toBeDefined();
				expect(typeof resp).toBe('string');
				done();
			}
		});
	});
});