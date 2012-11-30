/*
 @test-framework Jasmine
 @test-require-asset /resources/wikia/libraries/modil/modil.js
 @test-require-asset /resources/jquery/jquery-1.8.2.js
 @test-require-asset /resources/wikia/modules/aim.js
 */

/*global describe, it, runs, waitsFor, expect, require, document*/

describe("AIM", function () {
	'use strict';

	var async = new AsyncSpec(this),
		timerCallback;

	beforeEach(function() {
		timerCallback = jasmine.createSpy('timerCallback');
		jasmine.Clock.useMock();
	});

	async.it('should be defined', function(done) {
		// jQuery "namespace" API
		expect(jQuery.AIM).toBeDefined();
		expect(typeof jQuery.AIM.submit).toBe('function');

		// AMD API
		require(['aim'], function(aim) {
			expect(aim).toBeDefined();
			expect(typeof aim.submit).toBe('function');

			done();
		});

		jasmine.Clock.tick(1);
	});

	async.it('onStart() should be called', function(done) {
		require(['aim'], function(aim) {
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

		jasmine.Clock.tick(1);
	});

	/**
	async.it('onComplete should be called', function(done){
		require(['aim'], function(aim) {
			var form = document.createElement('form');
			document.body.appendChild(form);

			aim.submit(form, {
				onStart: function() {
					$('iframe#' + form.getAttribute('target')).trigger('load');
				},
				onComplete: function(resp) {
					done();
				}
			});
		});

		jasmine.Clock.tick(1);
	});
	**/

});
