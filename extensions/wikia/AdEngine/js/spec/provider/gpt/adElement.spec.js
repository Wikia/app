/*global describe, it, beforeEach, expect, modules, spyOn, document*/
describe('ext.wikia.adEngine.provider.gpt.adElement', function () {
	'use strict';

	function noop() { return; }

	var AdElement,
		adSizes = [
			[300, 250],
			[300, 600]
		],
		mocks = {
			adSizeConverter: {
				convert: function () {
					return adSizes;
				}
			},
			adSizeFilter: {
				filter: function (slotName, sizes) {
					return sizes;
				}
			},
			log: noop
		},
		slot,
		slotTargeting;

	beforeEach(function () {
		AdElement = modules['ext.wikia.adEngine.provider.gpt.adElement'](
			document,
			mocks.log,
			mocks.adSizeConverter,
			mocks.adSizeFilter
		);
		slot = {
			setTargeting: noop
		};
		slotTargeting = {
			foo: 12,
			bar: 34,
			baz: 56
		};
	});

	it('New instance created with given id and dom object', function () {
		var element = new AdElement('TOP_RIGHT_BOXAD', '/ELEMENT_SLOTPATH', slotTargeting);

		expect(element.getId()).toEqual('wikia_gpt/ELEMENT_SLOTPATH');
		expect(element.getSlotPath()).toEqual('/ELEMENT_SLOTPATH');
		expect(element.getNode().id).toEqual('wikia_gpt/ELEMENT_SLOTPATH');
	});

	it('Set sizes and add as json to attribute', function () {
		slotTargeting.size = '300x250,300x600';

		var element = new AdElement('TOP_RIGHT_BOXAD', '/ELEMENT_SLOTPATH', slotTargeting);

		expect(element.getSizes()).toEqual(adSizes);
		expect(element.getNode().getAttribute('data-gpt-slot-sizes')).toEqual('[[300,250],[300,600]]');
	});

	it('Set page level params as json on attribute', function () {
		var element = new AdElement('TOP_RIGHT_BOXAD', '/ELEMENT_SLOTPATH', slotTargeting);

		element.setPageLevelParams({
			pageParam1: 'value1',
			pageParam2: 'value2'
		});

		expect(element.getNode().getAttribute('data-gpt-page-params')).toEqual('{"pageParam1":"value1","pageParam2":"value2"}');
	});

	it('Set slot level params on slot object and add as json to attribute', function () {
		var element = new AdElement('TOP_RIGHT_BOXAD', '/ELEMENT_SLOTPATH', slotTargeting);
		spyOn(slot, 'setTargeting');

		element.configureSlot(slot);

		expect(slot.setTargeting.calls.count()).toEqual(3);
		expect(element.getNode().getAttribute('data-gpt-slot-params')).toEqual('{"foo":12,"bar":34,"baz":56}');
	});

	it('Add response event details as json to attribute', function () {
		var element = new AdElement('TOP_RIGHT_BOXAD', '/ELEMENT_SLOTPATH', slotTargeting);

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
