/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.template.modalOasisHandler', function () {
	'use strict';

	function noop() {
		return;
	}

	var mocks = {
		wikiaUiFactory: {
			init: function () {
				return mocks.promiseMock;
			}
		},
		promiseMock: {
			then: function (cb) {
				return cb(mocks.wikiaUiModalMock);
			}
		},
		wikiaUiModalMock: {
			createComponent: function (config, cb) {
				cb(mocks.modalMock);
			}
		},
		modalMock: {
			$content: {},
			$element: {},
			$close: {
				hide: noop,
				show: noop
			},
			show: noop
		}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.template.modalOasisHandler'](
			mocks.wikiaUiFactory
		);
	}

	beforeEach(function () {
		mocks.params = {
			adContainer: {},
			modalVisible: true,
			closeButtonDelay: 0
		};
	});

	it('Creates Wikia UI modal', function () {
		spyOn(mocks.wikiaUiModalMock, 'createComponent');
		getModule().prototype.create(mocks.params);

		expect(mocks.wikiaUiModalMock.createComponent.calls.count()).toEqual(1);
	});

});
