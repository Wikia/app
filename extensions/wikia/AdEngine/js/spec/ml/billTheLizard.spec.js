/*global describe, it, expect, modules*/
// TODO: Remove unused globals
describe('ext.wikia.adEngine.ml.billTheLizard', function () {
	'use strict';

	var mocks = {
		adEngine3: {},
		adContext: {},
		pageLevelParams: {},
		adEngineBridge: {},
		executor: {},
		services: {
			billTheLizard: true
		},
		pageInfoTracker: {},
		zoneParams: {},
		deviceDetect: {},
		instantGlobals: {},
		log: {},
		trackingOptIn: {}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.ml.billTheLizard'](
			mocks.adEngine3,
			mocks.adContext,
			mocks.pageLevelParams,
			mocks.adEngineBridge,
			mocks.executor,
			mocks.services,
			mocks.pageInfoTracker,
			mocks.zoneParams,
			mocks.deviceDetect,
			mocks.instantGlobals,
			mocks.log,
			mocks.trackingOptIn
		);
	}

	describe('bucketizeViewportHeight', function () {
		it('should bucketize', function () {
			var btl = getModule();

			expect(btl.bucketizeViewportHeight(0)).toEqual('400');
			expect(btl.bucketizeViewportHeight(200)).toEqual('400');
			expect(btl.bucketizeViewportHeight(399)).toEqual('400');

			expect(btl.bucketizeViewportHeight(400)).toEqual('500');
			expect(btl.bucketizeViewportHeight(420)).toEqual('500');
			expect(btl.bucketizeViewportHeight(499)).toEqual('500');

			expect(btl.bucketizeViewportHeight(500)).toEqual('600');
			expect(btl.bucketizeViewportHeight(520)).toEqual('600');
			expect(btl.bucketizeViewportHeight(599)).toEqual('600');

			expect(btl.bucketizeViewportHeight(600)).toEqual('700');
			expect(btl.bucketizeViewportHeight(620)).toEqual('700');
			expect(btl.bucketizeViewportHeight(699)).toEqual('700');

			expect(btl.bucketizeViewportHeight(700)).toEqual('800');
			expect(btl.bucketizeViewportHeight(720)).toEqual('800');
			expect(btl.bucketizeViewportHeight(799)).toEqual('800');

			expect(btl.bucketizeViewportHeight(800)).toEqual('900');
			expect(btl.bucketizeViewportHeight(820)).toEqual('900');
			expect(btl.bucketizeViewportHeight(899)).toEqual('900');

			expect(btl.bucketizeViewportHeight(900)).toEqual('1000');
			expect(btl.bucketizeViewportHeight(920)).toEqual('1000');
			expect(btl.bucketizeViewportHeight(999)).toEqual('1000');

			expect(btl.bucketizeViewportHeight(1000)).toEqual('1100');
			expect(btl.bucketizeViewportHeight(3000)).toEqual('1100');
		});

	});
});
