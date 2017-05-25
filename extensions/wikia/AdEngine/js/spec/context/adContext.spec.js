/*global afterEach, beforeEach, describe, it, expect, modules, spyOn*/
describe('ext.wikia.adEngine.adContext', function () {
	'use strict';

	function noop() {}

	function falseResponse() {
		return false;
	}

	var mocks = {
		abTest: noop,
		cookies: {
			get: falseResponse
		},
		doc: noop,
		geo: {
			isProperGeo: falseResponse
		},
		instantGlobals: noop,
		sampler: {
			sample: falseResponse
		},
		w: noop,
		Querystring: function () {
			return {
				getVal: falseResponse
			};
		}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.adContext'](
			mocks.abTest,
			mocks.cookies,
			mocks.doc,
			mocks.geo,
			mocks.instantGlobals,
			mocks.sampler,
			mocks.w,
			mocks.Querystring
		);
	}

	it('Should disable PageFair recovery if there is no correct geo', function () {
		var context = {
			opt: {
				pageFairRecovery: true
			}
		};

		spyOn(mocks.geo, 'isProperGeo');
		mocks.geo.isProperGeo.and.returnValue(false);

		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeFalsy();
	});

	it('Should enable PageFair recovery if there is proper geo', function () {
		var context = {
			opts: {
				pageFairRecovery: true
			}
		};
		spyOn(mocks.geo, 'isProperGeo');
		mocks.geo.isProperGeo.and.returnValue(true);

		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeTruthy();
	});

	it('Should disable PageFair recovery if there is proper geo but is disabled by backend (wgVariable)', function () {
		var context = {
			opts: {
				pageFairRecovery: false
			}
		};
		spyOn(mocks.geo, 'isProperGeo');
		mocks.geo.isProperGeo.and.returnValue(true);

		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeFalsy();
	});

	it('Should disable PageFair recovery if there is no proper geo but its enabled by backend (wgVariable)', function () {
		var context = {
			opts: {
				pageFairRecovery: true
			}
		};
		spyOn(mocks.geo, 'isProperGeo');
		mocks.geo.isProperGeo.and.returnValue(false);

		getModule().setContext(context);

		expect(context.opts.pageFairRecovery).toBeFalsy();
	});

});
