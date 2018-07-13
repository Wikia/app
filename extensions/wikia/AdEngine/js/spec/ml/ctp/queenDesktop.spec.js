/* global describe, it, modules, expect */

describe('ext.wikia.adEngine.ml.ctp.queenDesktop', function () {
	'use strict';
	var context = {};

	var mocks = {
		adContext: {
			get: function (key) {
				if (context.hasOwnProperty(key)) {
					return context[key];
				}
				return false;
			}
		},
		source: {
			coefficients: [1],
			intercept: 0
		},
		modelFactory: {
			create: function (model) {
				return model;
			}
		},
		linearModel: {
			create: function () { }
		}
	};
	var modulePath = 'ext.wikia.adEngine.ml.ctp.queenDesktop';
	var model = modules[modulePath](mocks.adContext, mocks.source, mocks.modelFactory, mocks.linearModel);

	it('should have name set to "queendesktop"', function () {
		expect(model.name).toEqual('queendesktop');
	});

	describe('enabled', function () {
		beforeEach(function () {
			context = {
				'targeting.hasFeaturedVideo': true,
				'rabbits.queenDesktop': true,
				'rabbits.isQueenDesktopForced': false,
				'targeting.skin': 'oasis'
			};
		});

		it('should return false if there is no featured video', function () {
			context['targeting.hasFeaturedVideo'] = false;
			expect(model.enabled()).toEqual(false);
		});

		it('should return false if queen is not enabled', function () {
			context['rabbits.queenDesktop'] = false;
			expect(model.enabled()).toEqual(false);
		});

		it('should return false if skin is not oasis', function () {
			context['targeting.skin'] = 'mercury';
			expect(model.enabled()).toEqual(false);
		});

		it('should return true if there is fv, queen is enabled and skin is oasis', function () {
			expect(model.enabled()).toEqual(true);
		});
	});
});
