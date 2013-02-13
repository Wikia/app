/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/define.mock.js
 @test-require-asset /resources/jquery/jquery-1.8.2.js
 @test-require-asset /resources/wikia/modules/aim.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/

describe("AIM", function () {
	'use strict';

	var async = new AsyncSpec(this),
		aim = define.getModule(jQuery);

	it('should be defined', function() {
		// jQuery "namespace" API
		expect(jQuery.AIM).toBeDefined();
		expect(typeof jQuery.AIM.submit).toBe('function');

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
