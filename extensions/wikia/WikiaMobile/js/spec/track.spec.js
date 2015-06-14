/*global describe, it, expect*/
describe('Track module', function () {
	'use strict';

	var tracker = {
			track: function () {

			},
			ACTIONS: {
				CLICK: 'click',
				CLICK_LINK_TEXT: 'click-link-text',
				CLICK_LINK_IMAGE: 'click-link-image',
				PAGINATE: 'paginate',
				SUBMIT: 'submit',
				SWIPE: 'swipe'
			}
		},
		track = modules.track(tracker);

	it('should be defined', function () {
		expect(track).toBeDefined();
		expect(track.event).toBeDefined();
		expect(typeof track.event).toBe('function');
	});

	it('calls tracker', function () {
		spyOn(tracker, 'track');

		track.event('CAT', 'ACT');

		expect(tracker.track).toHaveBeenCalledWith({
			action: 'ACT',
			browserEvent: undefined,
			category: 'wikiamobile-CAT',
			href: undefined,
			label: undefined,
			trackingMethod: 'analytics',
			value: undefined
		});
	});

	it('should have proper action names', function () {
		expect(track.CLICK).toEqual('click');
		expect(track.SWIPE).toEqual('swipe');
		expect(track.SUBMIT).toEqual('submit');
		expect(track.PAGINATE).toEqual('paginate');
		expect(track.IMAGE_LINK).toEqual('click-link-image');
		expect(track.TEXT_LINK).toEqual('click-link-text');
	});
});
