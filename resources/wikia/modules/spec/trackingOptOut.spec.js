describe('Tracking opt-out', function () {
	var mocks = {}, trackingOptOut;

	function mockOptOutUser() {
		mocks.qs.prototype.getVal = function (key) {
			if (key === 'trackingoptout') {
				return 1;
			}

			return null;
		};
	}

	function mockNotOptOutUser() {
		mocks.qs.prototype.getVal = function (key) {
			if (key === 'trackingoptout') {
				return null;
			}

			return 1;
		};
	}

	beforeEach(function () {
		mocks.context = {
			Wikia: {
				TrackingOptOut: {}
			}
		};
		mocks.qs = function () {};

		trackingOptOut = modules['wikia.trackingOptOut'](mocks.qs, mocks.context);
	});

	describe('when user opted out', function () {
		it('treats user as opted out when no explicit tracker given', function () {
			mockOptOutUser();

			var callback = jasmine.createSpy();

			trackingOptOut.ifNotOptedOut(callback);

			expect(callback).not.toHaveBeenCalled();
		});

		it('checks specific tracker when explicit tracker given', function () {
			mockOptOutUser();

			var testTrackerCallback = jasmine.createSpy();
			var otherTrackerCallback = jasmine.createSpy();

			mocks.context.Wikia.TrackingOptOut['test-tracker'] = 1;

			trackingOptOut.ifTrackerNotOptedOut('test-tracker', testTrackerCallback);
			trackingOptOut.ifTrackerNotOptedOut('other-tracker', otherTrackerCallback);

			expect(trackingOptOut.isOptedOut('test-tracker')).toBeTruthy();
			expect(trackingOptOut.isOptedOut('other-tracker')).toBeFalsy();

			expect(testTrackerCallback).not.toHaveBeenCalled();
			expect(otherTrackerCallback).toHaveBeenCalled();
		});
	});

	describe('when user is not opted out', function () {
		it('user is not opted out when no explicit tracker given', function () {
			mockNotOptOutUser();

			var callback = jasmine.createSpy();

			trackingOptOut.ifNotOptedOut(callback);

			expect(callback).toHaveBeenCalled();
		});

		it('user is not opted out for any tracker when explicit tracker given', function () {
			mockNotOptOutUser();

			var testTrackerCallback = jasmine.createSpy();
			var otherTrackerCallback = jasmine.createSpy();

			mocks.context.Wikia.TrackingOptOut['test-tracker'] = 1;

			trackingOptOut.ifTrackerNotOptedOut('test-tracker', testTrackerCallback);
			trackingOptOut.ifTrackerNotOptedOut('other-tracker', otherTrackerCallback);

			expect(trackingOptOut.isOptedOut('test-tracker')).toBeFalsy();
			expect(trackingOptOut.isOptedOut('other-tracker')).toBeFalsy();

			expect(testTrackerCallback).toHaveBeenCalled();
			expect(otherTrackerCallback).toHaveBeenCalled();
		});
	});
});
