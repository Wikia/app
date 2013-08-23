describe("Phalanx", function () {
	'use strict';

	var TOKEN = "asdfghjkl",
		REGEXP = 'foo',
		BLOCKID = 123,
		async = new AsyncSpec(this),
		nirvanaMock = {},
		phalanx = modules.phalanx(jQuery, nirvanaMock);

	it('registers AMD module', function() {
		expect(typeof phalanx).toBe('object');
		expect(typeof phalanx.init).toBe('function');
		expect(typeof phalanx.validate).toBe('function');
		expect(typeof phalanx.unblock).toBe('function');
	});

	function mockNirvanaValidate(resp) {
		return {
			postJson: function(controllerName, method, params, callback) {
				// token and regexp is correctly passed
				expect(params.regexp).toBe(REGEXP);
				expect(params.token).toBe(TOKEN);

				callback(resp);
			}
		};
	}

	async.it('RegExp is validated', function(done) {
		var nirvanaMock = mockNirvanaValidate({valid: 1}),
			phalanx = modules.phalanx(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.validate(REGEXP).then(function(resp) {
			expect(resp).toBe(true);
			done();
		});
	});

	async.it('RegExp is not validated', function(done) {
		var nirvanaMock = mockNirvanaValidate({valid: 0}),
			phalanx = modules.phalanx(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.validate(REGEXP).then(function(resp) {
			expect(resp).toBe(false);
			done();
		});
	});

	async.it('empty RegExp is not validated', function(done) {
		var nirvanaMock = {},
			phalanx = modules.phalanx(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.validate('').then(function(resp) {
			expect(resp).toBe(false);
			done();
		});
	});

	function mockNirvanaUnblock(resp) {
		return {
			postJson: function(controllerName, method, params, callback) {
				// token and block ID is correctly passed
				expect(params.blockId).toBe(BLOCKID);
				expect(params.token).toBe(TOKEN);

				callback(resp);
			}
		};
	}

	async.it('block is deleted', function(done) {
		var regexp = "foo",
			nirvanaMock = mockNirvanaUnblock({success: true}),
			phalanx = modules.phalanx(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.unblock(BLOCKID).then(function(resp) {
			expect(resp).toBe(true);
			done();
		});
	});

	async.it('block deletion failed', function(done) {
		var regexp = "foo",
			nirvanaMock = mockNirvanaUnblock({success: false}),
			phalanx = modules.phalanx(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.unblock(BLOCKID).fail(function() {
			done();
		});
	});
});
