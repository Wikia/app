/*global describe, it, expect, modules, beforeEach, spyOn*/
describe('ext.wikia.adEngine.video.playwire', function () {
	'use strict';

	function noop () {}

	var mocks = {
			doc: {
				createElement: function () {
					return {
						setAttribute: function (key, value) {
							this[key] = value;
						}
					};
				}
			},
			log: noop,
			parent: {
				appendChild: noop
			}
		};

	function getModule() {
		return modules['ext.wikia.adEngine.video.playwire'](
			mocks.doc,
			mocks.log
		);
	}

	beforeEach(function () {
		mocks.parent.appendChild = noop;
	});

	it('Get config url', function () {
		var playwire = getModule();

		expect(playwire.getConfigUrl(1, 2))
			.toEqual('//config.playwire.com/1/videos/v2/2/zeus.json');
	});

	it('Get config url', function () {
		var playwire = getModule();

		expect(playwire.getConfigUrl(123, 789))
			.toEqual('//config.playwire.com/123/videos/v2/789/zeus.json');
	});

	it('Inject player with given config url', function () {
		var playwire = getModule();

		spyOn(mocks.parent, 'appendChild');

		playwire.inject('//fake.url', mocks.parent);

		expect(mocks.parent.appendChild.calls.mostRecent().args[0]['data-config']).toEqual('//fake.url');
	});
});
