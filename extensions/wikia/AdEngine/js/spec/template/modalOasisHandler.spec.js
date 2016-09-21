/*global describe, it, expect, modules, spyOn, beforeEach*/
describe('ext.wikia.adEngine.template.modalOasisHandler', function () {
	'use strict';

	function noop() {
		return;
	}

	var mocks = {
		$: function () {
			return {
				addClass: noop,
				text: noop
			};
		},
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
				show: noop,
				parent: function () {
					return {
						prepend: noop
					};
				}
			},
			show: noop
		}
	};

	function getModule() {
		return modules['ext.wikia.adEngine.template.modalOasisHandler'](
			mocks.$,
			mocks.wikiaUiFactory
		).prototype;
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
		getModule().create(
			mocks.params.adContainer,
			mocks.params.modalVisible,
			mocks.params.closeButtonDelay
		);

		expect(mocks.wikiaUiModalMock.createComponent.calls.count()).toEqual(1);
		expect(mocks.modalMock.show.calls.count()).toEqual(1);
	});

	it('Modal called for async ad - not displayed at first', function () {
		spyOn(mocks.modalMock, 'show');

		mocks.params.modalVisible = false;
		var module = getModule();
		module.create(
			mocks.params.adContainer,
			mocks.params.modalVisible,
			mocks.params.closeButtonDelay
		);

		expect(mocks.modalMock.show.calls.count()).toEqual(0);

		module.show();

		expect(mocks.modalMock.show.calls.count()).toEqual(1);
	});

	it('Close button hidden when delay set', function () {
		spyOn(mocks.modalMock.$close, 'hide');

		mocks.params.closeButtonDelay = 5;
		var module = getModule();
		module.create(
			mocks.params.adContainer,
			mocks.params.modalVisible,
			mocks.params.closeButtonDelay
		);

		expect(mocks.modalMock.$close.hide.calls.count()).toEqual(1);
	});

});
