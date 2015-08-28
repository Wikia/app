/*global describe, it, expect, modules, beforeEach*/
describe('ext.wikia.adEngine.template.modalHandlerFactory', function () {
	'use strict';

	function noop() {
		return;
	}

	var adContext = {
			targeting: {}
		},
		mocks = {
			adContext: {
				getContext: function () {
					return adContext;
				}
			},
			log: noop,
			mercuryHandler: function () {
				this.id = 'mercury';
			},
			oasisHandler: function () {
				this.id = 'oasis';
			}
		};

	beforeEach(function () {
		adContext.targeting.skin = 'oasis';
	});

	function getModule() {
		return modules['ext.wikia.adEngine.template.modalHandlerFactory'](
			mocks.adContext,
			mocks.log,
			mocks.mercuryHandler,
			mocks.oasisHandler
		);
	}

	it('Should return null for unsupported skin', function () {
		adContext.targeting.skin = 'wikiamobile';

		expect(getModule().create()).toEqual(null);
	});

	it('Should return oasis handler for oasis skin', function () {
		expect(getModule().create().id).toEqual('oasis');
	});

	it('Should return mercury handler for mercury skin', function () {
		adContext.targeting.skin = 'mercury';

		expect(getModule().create().id).toEqual('mercury');
	});
});
