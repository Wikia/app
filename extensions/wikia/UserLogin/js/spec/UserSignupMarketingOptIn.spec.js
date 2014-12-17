describe('UserLogin Marketing Opt In', function () {
	'use strict';

	var geo,
		optIn,
		wikiaForm;

	beforeEach(function () {
		geo = modules['wikia.geo']();
		optIn = modules['usersignup.marketingOptIn'](geo);
		wikiaForm = {
			inputs: {

			}
		}
	});


});