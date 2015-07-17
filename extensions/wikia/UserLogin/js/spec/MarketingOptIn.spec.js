describe('UserLogin Marketing Opt In', function () {
	'use strict';

	var optIn,
		geo,
		wikiaFormMock;

	beforeEach(function () {
		geo = modules['wikia.geo']();
		spyOn(geo, 'getContinentCode').and.returnValue('');
		spyOn(geo, 'getCountryCode').and.returnValue('');

		wikiaFormMock = {
			inputs: {
				wpMarketingOptIn: $('<input type="checkbox" class="hidden">')
			},
			getInputGroup: function () {
				return $('<div></div>');
			}
		};

		optIn = modules['usersignup.marketingOptIn'](geo);
	});

	it('should throw an exception', function () {
		wikiaFormMock.inputs.wpMarketingOptIn.length = 0;
		expect(function () {
			optIn.init(wikiaFormMock);
		}).toThrow();
	});

	it('should check the box in Europe', function () {
		var checkedAttr;

		geo.getContinentCode.and.returnValue('EU');
		optIn.init(wikiaFormMock);
		checkedAttr = wikiaFormMock.inputs.wpMarketingOptIn.attr('checked');

		expect(checkedAttr).toBe('checked');
	});

	it('should not check the box in Canada', function () {
		var checkedAttr;

		geo.getCountryCode.and.returnValue('CA');
		optIn.init(wikiaFormMock);
		checkedAttr = wikiaFormMock.inputs.wpMarketingOptIn.attr('checked');

		expect(checkedAttr).toBe(undefined);
	});

	it('should not check the box in Japan', function () {
		var checkedAttr;

		geo.getCountryCode.and.returnValue('JP');
		optIn.init(wikiaFormMock);
		checkedAttr = wikiaFormMock.inputs.wpMarketingOptIn.attr('checked');

		expect(checkedAttr).toBe(undefined);
	});

	it('should hide the box in the US', function () {
		var isHidden;

		geo.getCountryCode.and.returnValue('US');
		optIn.init(wikiaFormMock);
		isHidden = wikiaFormMock.inputs.wpMarketingOptIn.hasClass('hidden');

		expect(isHidden)
			.toBe(true);
	});

	it('should not hide the box in Europe', function () {
		var isHidden;

		geo.getContinentCode.and.returnValue('EU');
		optIn.init(wikiaFormMock);
		isHidden = wikiaFormMock.inputs.wpMarketingOptIn.hasClass('hidden');

		expect(isHidden)
			.toBe(false);
	});
});
