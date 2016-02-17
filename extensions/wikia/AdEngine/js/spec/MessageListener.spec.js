/*global describe, it, expect, modules, spyOn*/
describe('Module ext.wikia.adEngine.messageListener', function () {
	'use strict';

	function noop() { return; }

	var windowMock = { id: 'window', addEventListener: 'abc' },
		gptMock = { id: 'gpt_iframe', parent: windowMock },

		mocks = {
			adContext: {
				addCallback: noop
			},
			gptIframe: gptMock,
			otherIframe: { id: 'other_iframe', parent: windowMock },
			otherIframeInsideGpt: { id: 'iframe_in_iframe', parent: gptMock },
			log: noop,
			window: windowMock,
			callback: noop,
			callback2: noop,
			callback3: noop,
			callback4: noop,
			callback5: noop,
			callback6: noop
		};

	function checkAddEventListenerCall() {
		expect(mocks.window.addEventListener).toHaveBeenCalled();

		expect(function () {
			return mocks.window.addEventListener.calls.first().args[1];
		}).not.toThrow();

		expect(mocks.window.addEventListener.calls.first().args[0]).toBe('message');
		expect(typeof mocks.window.addEventListener.calls.first().args[1]).toBe('function');
	}

	function callEventListener(data, source) {
		var callback = mocks.window.addEventListener.calls.first().args[1];

		callback({data: data, source: source});
	}

	function getModule() {
		return modules['ext.wikia.adEngine.messageListener'](mocks.adContext, mocks.log, mocks.window);
	}

	it('reacts to register then event', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = getModule();
		messageListener.init();
		messageListener.register({ source: mocks.gptIframe, dataKey: 'status' }, mocks.callback);

		checkAddEventListenerCall();
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.gptIframe);

		expect(mocks.callback).toHaveBeenCalledWith({status: 'success'});
	});

	it('matches the event details (does not fire the callback for non-matching register)', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = getModule();
		messageListener.init();
		messageListener.register({source: mocks.gptIframe, dataKey: 'status'}, mocks.callback);

		checkAddEventListenerCall();

		callEventListener('some random message');
		callEventListener(JSON.stringify('some random message'));
		callEventListener(JSON.stringify({some: 'object'}));
		callEventListener(JSON.stringify({AdEngine: {aaa: 'bbb'}}), mocks.gptIframe);
		callEventListener(JSON.stringify({AdEngine: {aaa: 'bbb'}}), mocks.gptIframe);
		callEventListener(JSON.stringify({AdEngine: 'ccc'}), mocks.gptIframe);
		callEventListener(JSON.stringify('ccc'), mocks.gptIframe);
		callEventListener('ccc', mocks.gptIframe);
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.otherIframe);
		expect(mocks.callback.calls.count()).toBe(0);
	});

	it('matches the event details (test without an expected source)', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = getModule();
		messageListener.init();
		messageListener.register({dataKey: 'slot_TOP_LEADERBOARD'}, mocks.callback);

		checkAddEventListenerCall();

		callEventListener('some random message');
		callEventListener(JSON.stringify('some random message'));
		callEventListener(JSON.stringify({some: 'object'}));
		callEventListener(JSON.stringify({AdEngine: {aaa: 'bbb'}}), mocks.gptIframe);
		callEventListener(JSON.stringify({AdEngine: {'slot_TOP_LEADERBOARD': 'bbb'}}), mocks.otherIframe);
		expect(mocks.callback.calls.count()).toBe(1);
	});

	it('listens for gptIframe but actually receives message from iframe inside GPT', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = getModule();
		messageListener.init();
		messageListener.register({source: mocks.gptIframe, dataKey: 'status'}, mocks.callback);

		checkAddEventListenerCall();
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.otherIframeInsideGpt);
		expect(mocks.callback).toHaveBeenCalledWith({status: 'success'});
		expect(mocks.callback.calls.count()).toBe(1);
	});

	it('allows to register multiple callbacks', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');
		spyOn(mocks, 'callback2');
		spyOn(mocks, 'callback3');
		spyOn(mocks, 'callback4');
		spyOn(mocks, 'callback5');
		spyOn(mocks, 'callback6');

		messageListener = getModule();
		messageListener.init();
		messageListener.register({source: mocks.gptIframe, dataKey: 'status'}, mocks.callback);
		messageListener.register({source: mocks.otherIframe, dataKey: 'info'}, mocks.callback4);
		messageListener.register({source: mocks.otherIframe, dataKey: 'status'}, mocks.callback3);
		messageListener.register({source: mocks.gptIframe, dataKey: 'info'}, mocks.callback2);
		// we listen for GPT iframe, but actually receive postMessage from iframe inside GPT
		messageListener.register({source: mocks.gptIframe, dataKey: 'status'}, mocks.callback5);
		messageListener.register({source: mocks.gptIframe, dataKey: 'info'}, mocks.callback6);

		checkAddEventListenerCall();
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.gptIframe);
		callEventListener(JSON.stringify({AdEngine: {info: 'something'}}), mocks.gptIframe);
		callEventListener(JSON.stringify({AdEngine: {status: 'something'}}), mocks.otherIframe);
		callEventListener(JSON.stringify({AdEngine: {info: 'something'}}), mocks.otherIframe);
		callEventListener(JSON.stringify({AdEngine: {status: 'something'}}), mocks.otherIframeInsideGpt);
		callEventListener(JSON.stringify({AdEngine: {info: 'something'}}), mocks.otherIframeInsideGpt);

		expect(mocks.callback).toHaveBeenCalledWith({status: 'success'});
		expect(mocks.callback2).toHaveBeenCalledWith({info: 'something'});
		expect(mocks.callback3).toHaveBeenCalledWith({status: 'something'});
		expect(mocks.callback4).toHaveBeenCalledWith({info: 'something'});
		expect(mocks.callback5).toHaveBeenCalledWith({status: 'something'});
		expect(mocks.callback6).toHaveBeenCalledWith({info: 'something'});
	});

	it('calls the callback only once', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = getModule();
		messageListener.init();
		messageListener.register({source: mocks.gptIframe, dataKey: 'status'}, mocks.callback);

		checkAddEventListenerCall();
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.otherIframeInsideGpt);
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.gptIframe);
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.gptIframe);
		expect(mocks.callback).toHaveBeenCalledWith({status: 'success'});
		expect(mocks.callback.calls.count()).toBe(1);
	});

	/**
	 * Register after the event stuff now (comment to be removed)
	 */
	it('reacts to event then register', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = getModule();
		messageListener.init();

		checkAddEventListenerCall();
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.gptIframe);
		messageListener.register({source: mocks.gptIframe, dataKey: 'status'}, mocks.callback);

		expect(mocks.callback).toHaveBeenCalledWith({status: 'success'});
	});

	it('reacts to event then register then event (only calls once)', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = getModule();
		messageListener.init();

		checkAddEventListenerCall();
		callEventListener(JSON.stringify({AdEngine: {status: 'success' }}), mocks.gptIframe);
		messageListener.register({source: mocks.gptIframe, dataKey: 'status'}, mocks.callback);
		callEventListener(JSON.stringify({AdEngine: {status: 'success' }}), mocks.gptIframe);

		expect(mocks.callback).toHaveBeenCalledWith({status: 'success' });
		expect(mocks.callback.calls.count()).toBe(1);
	});

	it('reacts to event, event then register then event (only calls once)', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = getModule();
		messageListener.init();

		checkAddEventListenerCall();
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.gptIframe);
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.gptIframe);
		messageListener.register({source: mocks.gptIframe, dataKey: 'status'}, mocks.callback);
		callEventListener(JSON.stringify({AdEngine: {status: 'success'}}), mocks.gptIframe);

		expect(mocks.callback).toHaveBeenCalledWith({status: 'success'});
		expect(mocks.callback.calls.count()).toBe(1);
	});
});
