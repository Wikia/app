/*global describe, it, modules, expect, spyOn*/
describe('Krux module', function () {
	'use strict';

	var mocks;

	function getModule() {
		return modules['wikia.krux'](
			mocks.window
		);
	}

	mocks = {
		window: {
			localStorage: {
				kxuser: 'testUser'
			}
		}
	};

	it('Expects to get user from localStorage', function () {
		expect(getModule().getUser()).toBe(mocks.window.localStorage.kxuser);
	});

	it('Expects to get limited amount of segments from localStorage', function () {
		var kruxSegmentsLots = ['kxsgmnt1', 'kxsgmnt2', 'kxsgmnt3', 'kxsgmnt4', 'kxsgmnt5',
				'kxsgmnt6', 'kxsgmnt7', 'kxsgmnt8', 'kxsgmnt9', 'kxsgmnt10', 'kxsgmnt11',
				'kxsgmnt12', 'kxsgmnt13', 'kxsgmnt14', 'kxsgmnt15', 'kxsgmnt16', 'kxsgmnt17',
				'kxsgmnt18', 'kxsgmnt19', 'kxsgmnt20', 'kxsgmnt21', 'kxsgmnt22', 'kxsgmnt23',
				'kxsgmnt24', 'kxsgmnt25', 'kxsgmnt26', 'kxsgmnt27', 'kxsgmnt28', 'kxsgmnt29',
				'kxsgmnt30', 'kxsgmnt31', 'kxsgmnt32', 'kxsgmnt33', 'kxsgmnt34', 'kxsgmnt35'
			],
			kruxSegments27 = ['kxsgmnt1', 'kxsgmnt2', 'kxsgmnt3', 'kxsgmnt4', 'kxsgmnt5',
				'kxsgmnt6', 'kxsgmnt7', 'kxsgmnt8', 'kxsgmnt9', 'kxsgmnt10', 'kxsgmnt11',
				'kxsgmnt12', 'kxsgmnt13', 'kxsgmnt14', 'kxsgmnt15', 'kxsgmnt16', 'kxsgmnt17',
				'kxsgmnt18', 'kxsgmnt19', 'kxsgmnt20', 'kxsgmnt21', 'kxsgmnt22', 'kxsgmnt23',
				'kxsgmnt24', 'kxsgmnt25', 'kxsgmnt26', 'kxsgmnt27'
			];

		mocks.window.localStorage.kxsegments = kruxSegmentsLots;
		expect(getModule().getSegments()).toEqual(kruxSegments27);
	});
});
