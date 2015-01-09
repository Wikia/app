describe('UserLogin Marketing Opt In', function () {
	'use strict';

	var optIn,
		geoMock = {
			getCountryCode: $.noop,
			getContinentCode: $.noop
		},
		wikiaFormMock = {
			inputs: {
				wpMarketingOptIn: {
					length: 1
				}
			}
		};

	it ('should throw an exception', function () {
		wikiaFormMock.inputs.wpMarketingOptIn.length = 0;
		optIn = modules['usersignup.marketingOptIn'](geoMock);
		expect(optIn.init(wikiaFormMock)).toThrow();
	});

	it ('should check the box in the England', function () {

	});

	it ('should not check the box in Canada', function () {

	});

	it ('should hide the box in the US', function () {

	});

	it ('should not hide the box in England', function () {

	});


});