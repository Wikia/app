/*global describe, it, runs, waitsFor, expect, require, document*/
xdescribe("AIM", function () {
	'use strict';

	var jquery = {};

	var async = new AsyncSpec(this),
		aim = modules['wikia.aim'](jquery);

	it('should be defined', function() {
		// jQuery "namespace" API
		expect(jquery.AIM).toBeDefined();
		expect(typeof jquery.AIM.submit).toBe('function');

		// AMD API
		expect(aim).toBeDefined();
		expect(typeof aim.submit).toBe('function');
	});

	async.it('onStart() should be called', function(done) {
		var form = document.createElement('form');
		document.body.appendChild(form);

		aim.submit(form, {
			onStart: function() {
				var iFrameName = form.getAttribute('target');

				expect(typeof iFrameName).toBe('string');
				expect($('iframe#' + iFrameName).length).toBe(1);

				done();
			}
		});
	});

	async.it('onComplete() should be called', function(done) {
		var form = document.createElement('form');
		document.body.appendChild(form);

		aim.submit(form, {
			onStart: function() {
				$(form).
					attr('action', 'about:').
					submit();
			},
			onComplete: function(resp) {
				expect(typeof resp).toBe('string');
				done();
			}
		});
	});
});
