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
			$content: {
				append: noop
			},
			$element: {
				width: noop
			},
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

	it('Default case: creates Wikia UI modal which is immediately shown', function () {
		spyOn(mocks.wikiaUiModalMock, 'createComponent').and.callThrough();
		spyOn(mocks.modalMock, 'show');
		getModule().prototype.create(
			mocks.params.adContainer,
			mocks.params.modalVisible,
			mocks.params.closeButtonDelay
		);

		expect(mocks.wikiaUiModalMock.createComponent.calls.count()).toEqual(1);
		expect(mocks.modalMock.show.calls.count()).toEqual(1);
	});

});
