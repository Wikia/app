/*
 @test-framework Jasmine
 \@test-require-asset resources/wikia/libraries/define.mock.js
 @test-require-asset resources/jquery/jquery-1.8.2.js
 @test-require-asset extensions/wikia/PhalanxII/js/modules/phalanx.js
 */

describe("Phalanx", function () {
	'use strict';

	var async = new AsyncSpec(this),
		TOKEN = "asdfghjkl",
		nirvanaMock = function() {},
		phalanx = define.getModule(jQuery, nirvanaMock);

	it('registers AMD module', function() {
		expect(typeof phalanx).toBe('object');
		expect(typeof phalanx.init).toBe('function');
		expect(typeof phalanx.validate).toBe('function');
		expect(typeof phalanx.unblock).toBe('function');
	});

	async.it('RegExp is validated', function(done) {
		var regexp = "foo",
			nirvanaMock = {
				postJson: function(controllerName, method, params, callback) {
					// token and regexp is correctly passed
					expect(params.regexp).toBe(regexp);
					expect(params.token).toBe(TOKEN);

					callback({valid: 1});
				}
			},
			phalanx = define.getModule(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.validate(regexp).then(function(resp) {
			expect(resp).toBe(true);
			done();
		});
	});
});
