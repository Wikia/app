/*global describe, it, expect, modules, spyOn, document*/
describe('ext.wikia.adEngine.provider.gpt.adSizeConverter', function () {
	'use strict';

	function noop() {}

	var AdElement,
		adSizes = [
			[300, 250],
			[300, 600]
		],
		pageLevelParamsMock = {
			pageParam1: 'value1',
			pageParam2: 'value2'
		},
		mocks = {
			adLogicPageParams: {
				getPageLevelParams: function () {
					return pageLevelParamsMock;
				}
			},
			adSizeConverter: {
				convert: function () {
					return adSizes;
				}
			},
			log: noop,
			pubads: {
				setTargeting: noop
			}
		},
		slot;

	beforeEach(function() {
		AdElement = modules['ext.wikia.adEngine.provider.gpt.adElement'](document, mocks.log, mocks.adLogicPageParams, mocks.adSizeConverter);
		slot = {
			setTargeting: noop
		};
	});

	it('New instance created with given id and dom object', function () {
		var element = new AdElement('ELEMENT_ID');

		expect(element.getId()).toEqual('ELEMENT_ID');
		expect(element.getNode().id).toEqual('ELEMENT_ID');
	});

	it('Set page level params on pubads object and add as json to attribute', function () {
		var element = new AdElement('ELEMENT_ID');
		spyOn(mocks.pubads, 'setTargeting');

		element.setPageLevelParams(mocks.pubads);

		expect(mocks.pubads.setTargeting.calls.count()).toEqual(2);
		expect(element.getNode().getAttribute('data-gpt-page-params')).toEqual('{"pageParam1":"value1","pageParam2":"value2"}');
	});

	it('Set sizes and add as json to attribute', function () {
		var element = new AdElement('ELEMENT_ID');

		element.setSizes('TOP_RIGHT_BOXAD', '300x250,300x600');

		expect(element.getSizes()).toEqual(adSizes);
		expect(element.getNode().getAttribute('data-gpt-slot-sizes')).toEqual('[[300,250],[300,600]]');
	});

	it('Set slot level params on slot object and add as json to attribute', function () {
		var element = new AdElement('ELEMENT_ID');
		spyOn(slot, 'setTargeting');

		element.setSlotLevelParams(slot, {
			foo: 12,
			bar: 34,
			baz: 56
		});

		expect(slot.setTargeting.calls.count()).toEqual(3);
		expect(element.getNode().getAttribute('data-gpt-slot-params')).toEqual('{"foo":12,"bar":34,"baz":56}');
	});

	it('Add response event details as json to attribute', function () {
		var element = new AdElement('ELEMENT_ID');

		element.updateDataParams({
			lineItemId: 123,
			creativeId: 456,
			size: [728, 90]
		});

		expect(element.getNode().getAttribute('data-gpt-line-item-id')).toEqual('123');
		expect(element.getNode().getAttribute('data-gpt-creative-id')).toEqual('456');
		expect(element.getNode().getAttribute('data-gpt-creative-size')).toEqual('[728,90]');
	});
});
