describe('Phalanx', function () {
	'use strict';

	var TOKEN = 'asdfghjkl',
		REGEXP = 'foo',
		BLOCKID = 123,
		nirvanaMock = {},
		phalanx = modules.phalanx(jQuery, nirvanaMock);

	/**
	 * @desc mock nirvana object for validate method
	 * @param {Object} resp
	 * @returns {Object}
	 */
	function mockNirvanaValidate(resp) {
		return {
			postJson: function (controllerName, method, params, callback) {
				// token and regexp is correctly passed
				expect(params.regexp).toBe(REGEXP);
				expect(params.token).toBe(TOKEN);

				callback(resp);
			}
		};
	}

	/**
	 * @desc mock nirvana object for unblock method
	 * @param {Object} resp
	 * @returns {Object}
	 */
	function mockNirvanaUnblock(resp) {
		return {
			postJson: function (controllerName, method, params, callback) {
				// token and block ID is correctly passed
				expect(params.blockId).toBe(BLOCKID);
				expect(params.token).toBe(TOKEN);

				callback(resp);
			}
		};
	}

	it('registers AMD module', function () {
		expect(typeof phalanx).toBe('object');
		expect(typeof phalanx.init).toBe('function');
		expect(typeof phalanx.validate).toBe('function');
		expect(typeof phalanx.unblock).toBe('function');
	});

	it('RegExp is validated', function (done) {
		var nirvanaMock = mockNirvanaValidate({valid: 1}),
			phalanx = modules.phalanx(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.validate(REGEXP).then(function (resp) {
			expect(resp).toBe(true);
			done();
		});
	});

	it('RegExp is not validated', function (done) {
		var nirvanaMock = mockNirvanaValidate({valid: 0}),
			phalanx = modules.phalanx(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.validate(REGEXP).then(function (resp) {
			expect(resp).toBe(false);
			done();
		});
	});

	it('empty RegExp is not validated', function (done) {
		var nirvanaMock = {},
			phalanx = modules.phalanx(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.validate('').then(function (resp) {
			expect(resp).toBe(false);
			done();
		});
	});

	it('block is deleted', function (done) {
		var nirvanaMock = mockNirvanaUnblock({success: true}),
			phalanx = modules.phalanx(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.unblock(BLOCKID).then(function (resp) {
			expect(resp).toBe(true);
			done();
		});
	});

	it('block deletion failed', function (done) {
		var nirvanaMock = mockNirvanaUnblock({success: false}),
			phalanx = modules.phalanx(jQuery, nirvanaMock);

		phalanx.init(TOKEN);

		phalanx.unblock(BLOCKID).fail(function () {
			done();
		});
	});
});
