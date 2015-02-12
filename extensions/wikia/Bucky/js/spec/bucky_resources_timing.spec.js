/*global describe,it,expect,modules*/
/*jshint maxlen: 200*/
describe('BuckyResourcesTiming', function () {
	'use strict';

	function getModule(windowMock) {
		return modules['bucky.resourceTiming'](jQuery, windowMock || window, modules.bucky);
	}

	it('exposes an API', function() {
		var resourcesTiming = getModule();

		expect(typeof resourcesTiming.isSupported).toEqual('function');
		expect(typeof resourcesTiming.isWikiaAsset).toEqual('function');
		expect(typeof resourcesTiming.reportToBucky).toEqual('function');
	});

	it('correctly detects Wikia assets', function() {
		var resourcesTiming = getModule(),
			urls = {
				// Wikia assets
				'http://img4.wikia.nocookie.net/__cb4/nordycka/pl/images/b/bc/Wiki.png': true,
				'http://slot1.images2.wikia.nocookie.net/__am/1418375407/sasses/foo/extensions/wikia/Qualaroo/css/Qualaroo.scss': true,
				'http://nordycka.wikia.com/__load/-/cb%3D1418375407%26debug%3Dfalse%26lang%3Dpl%26only%3Dstyles%26skin%3Doasis/site': true,
				'http://nordycka.wikia.com/wikia.php?controller=WallNotificationsExternal&method=getUpdateCounts&format=json': true,
				'http://nordycka.macbre.wikia-dev.com/__load/-/cb%3D123456%26debug%3Dfalse%26lang%3Dpl%26only%3Dstyles%26skin%3Dvenus/site': true,
				// 3rd party assets
				'http://edge.quantserve.com/quant-wikia.js': false,
				'http://www.google-analytics.com/ga.js': false
			};

		Object.keys(urls).forEach(function(url) {
			expect(resourcesTiming.isWikiaAsset(url)).toEqual(urls[url]);
		});
	});

	it('detects a feature when it\'s present', function() {
		var resourcesTiming = getModule({
			performance: {
				getEntriesByType: function() {}
			}
		});

		expect(resourcesTiming.isSupported()).toEqual(true);
	});

	it('does not detect a feature when it\'s not present', function() {
		var resourcesTiming = getModule({
			performance: {}
		});

		expect(resourcesTiming.isSupported()).toEqual(false);
	});
});
