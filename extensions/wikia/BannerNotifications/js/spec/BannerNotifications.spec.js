/*global describe, it, expect, BannerNotification*/
describe('Banner Notification', function () {
	'use strict';
	function noop () {}
	mw.config = new mw.Map();

	it('should have a constructor defined', function () {
		expect(typeof BannerNotification).toBe('function');
	});

	it('should be an object with a full API', function () {
		var bn = new BannerNotification();

		expect(typeof bn.setContent).toBe('function');
		expect(typeof bn.setType).toBe('function');
		expect(typeof bn.show).toBe('function');
		expect(typeof bn.showConnectionError).toBe('function');
		expect(typeof bn.hide).toBe('function');
		expect(typeof bn.onClose).toBe('function');
	});

	it('should set a proper content and type from constructor params', function () {
		var bn = new BannerNotification('Error Message', 'error');

		expect(bn.content).toEqual('Error Message');
		expect(bn.type).toEqual('error');
	});

	it('should update content using "setContent" method', function () {
		var bn = new BannerNotification('Error Message', 'error');
		bn.setContent('New Error Message');

		expect(bn.content).toEqual('New Error Message');
	});

	it('should update type using "setType" method', function () {
		var bn = new BannerNotification('Error Message', 'error');
		bn.setType('notify');

		expect(bn.type).toEqual('notify');
	});

	it('should be hidden by default', function () {
		var bn = new BannerNotification('Error Message', 'error');

		expect(bn.hidden).toEqual(true);
	});

	it('should keep a DOM element only when it\'s shown', function () {
		var bn = new BannerNotification('Error Message', 'error');
		expect(bn.$element).toEqual(null);

		bn.show();
		expect(bn.$element).not.toEqual(null);

		bn.hide();
		expect(bn.$element).toEqual(null);
	});

	it('should set onCloseHandler by onClose method', function () {
		var bn = new BannerNotification('Error Message', 'error');
		bn.onClose(noop);

		expect(bn.onCloseHandler).toEqual(noop);
	});

	it('should chain all the methods by returning instance', function () {
		var bn = new BannerNotification('Error Message', 'error');
		bn.setContent('New Content')
			.setType('notify')
			.show()
			.hide()
			.onClose(noop)
			.hide();

		expect(bn instanceof BannerNotification).toEqual(true);
	});
});
