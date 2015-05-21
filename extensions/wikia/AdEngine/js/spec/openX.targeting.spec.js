/*global describe, it, modules, expect, spyOn*/
/*jshint maxlen:200*/
describe('OpenX targeting', function () {
	'use strict';

	var noop = function () {},
		geoMock = {
			getCountryCode: function () { return 'DE'; }
		},
		adContextMock = {
			getContext: function () {
				return {
					targeting: {
						wikiVertical: 'Gaming'
					}
				}
			}
		},
		logMock = noop;

	function getTargeting() {
		return modules['ext.wikia.adEngine.provider.openX.targeting'](adContextMock, geoMock, logMock);
	}

	it('Should return falsy value when slot name is not supported', function () {
		expect(getTargeting().getItem('NOT_SUPPORTED_SLOT')).toBeFalsy();
	});

	it('Should return international item when geo is not US', function () {
		expect(getTargeting().getItem('TOP_LEADERBOARD').auid).toEqual(537212220);
	});

	it('Should return US item when geo is US', function () {
		spyOn(geoMock, 'getCountryCode').and.returnValue('US');

		expect(getTargeting().getItem('TOP_LEADERBOARD').auid).toEqual(537211356);
	});

	it('Should return item based on ad context vertical', function () {
		spyOn(adContextMock, 'getContext').and.returnValue({
			targeting: {
				wikiVertical: 'Entertainment'
			}
		});

		expect(getTargeting().getItem('TOP_LEADERBOARD').auid).toEqual(537201006);
	});

	it('Should return mobile item when skin is wikiamobile', function () {
		spyOn(adContextMock, 'getContext').and.returnValue({
			targeting: {
				skin: 'wikiamobile'
			}
		});

		expect(getTargeting().getItem('MOBILE_TOP_LEADERBOARD').auid).toEqual(537208060);
	});

	it('Should return falsy value for mobile skin when geo is PL', function () {
		spyOn(geoMock, 'getCountryCode').and.returnValue('PL');
		spyOn(adContextMock, 'getContext').and.returnValue({
			targeting: {
				skin: 'mercury'
			}
		});

		expect(getTargeting().getItem('MOBILE_TOP_LEADERBOARD')).toBeFalsy();
	});
});
