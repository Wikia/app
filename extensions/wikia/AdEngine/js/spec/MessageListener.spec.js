/*global describe, it, expect, modules, spyOn*/
describe('Module ext.wikia.adEngine.messageListener', function () {
	'use strict';

	function noop() {}

	var mocks = {
		gptIframe: { id: 'gpt_iframe' },
		otherIframe: { id: 'other_iframe' },
		log: noop,
		window: { addEventListener: noop },
		callback: noop,
		callback2: noop,
		callback3: noop,
		callback4: noop
	};

	function checkAddEventListenerCall() {
		expect(mocks.window.addEventListener).toHaveBeenCalled();

		expect(function () {
			return mocks.window.addEventListener.calls[0].args[1];
		}).not.toThrow();

		expect(mocks.window.addEventListener.calls[0].args[0]).toBe('message');
		expect(typeof mocks.window.addEventListener.calls[0].args[1]).toBe('function');
	}

	function callEventListener(data) {
		var callback = mocks.window.addEventListener.calls[0].args[1];

		callback({ data: data });
	}

	it('reacts to register then event', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = modules['ext.wikia.adEngine.messageListener'](mocks.log, mocks.window);
		messageListener.init();
		messageListener.register({ source: mocks.gptIframe.id, dataKey: 'status' }, mocks.callback);

		checkAddEventListenerCall();
		callEventListener({AdEngine: {status: 'success', source: mocks.gptIframe.id }});

		expect(mocks.callback).toHaveBeenCalledWith({status: 'success', source: mocks.gptIframe.id });
	});

	it('matches the event details (does not fire the callback for non-matching register)', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = modules['ext.wikia.adEngine.messageListener'](mocks.log, mocks.window);
		messageListener.init();
		messageListener.register({source: mocks.gptIframe.id, dataKey: 'status'}, mocks.callback);

		checkAddEventListenerCall();

		callEventListener('some random message');
		callEventListener({some: 'object'});
		callEventListener({AdEngine: {aaa: 'bbb'}}, mocks.gptIframe);
		callEventListener({AdEngine: 'ccc'}, mocks.gptIframe);
		callEventListener('ccc', mocks.gptIframe);
		callEventListener({AdEngine: {status: 'success'}}, mocks.otherIframe);
		expect(mocks.callback.calls.length).toBe(0);
	});

	it('allows to register multiple callbacks', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');
		spyOn(mocks, 'callback2');
		spyOn(mocks, 'callback3');
		spyOn(mocks, 'callback4');

		messageListener = modules['ext.wikia.adEngine.messageListener'](mocks.log, mocks.window);
		messageListener.init();
		messageListener.register({source: mocks.gptIframe.id, dataKey: 'status'}, mocks.callback);
		messageListener.register({source: mocks.otherIframe.id, dataKey: 'info'}, mocks.callback4);
		messageListener.register({source: mocks.otherIframe.id, dataKey: 'status'}, mocks.callback3);
		messageListener.register({source: mocks.gptIframe.id, dataKey: 'info'}, mocks.callback2);

		checkAddEventListenerCall();
		callEventListener({AdEngine: {status: 'success', source: mocks.gptIframe.id }});
		callEventListener({AdEngine: {info: 'something', source: mocks.gptIframe.id}});
		callEventListener({AdEngine: {status: 'something', source: mocks.otherIframe.id}});
		callEventListener({AdEngine: {info: 'something', source: mocks.otherIframe.id}});

		expect(mocks.callback).toHaveBeenCalledWith({status: 'success', source: mocks.gptIframe.id });
		expect(mocks.callback2).toHaveBeenCalledWith({info: 'something', source: mocks.gptIframe.id});
		expect(mocks.callback3).toHaveBeenCalledWith({status: 'something', source: mocks.otherIframe.id});
		expect(mocks.callback4).toHaveBeenCalledWith({info: 'something', source: mocks.otherIframe.id});
	});

	it('calls the callback only once', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = modules['ext.wikia.adEngine.messageListener'](mocks.log, mocks.window);
		messageListener.init();
		messageListener.register({source: mocks.gptIframe.id, dataKey: 'status'}, mocks.callback);

		checkAddEventListenerCall();
		callEventListener({AdEngine: {status: 'success', source: mocks.gptIframe.id }});
		callEventListener({AdEngine: {status: 'success', source: mocks.gptIframe.id}});
		expect(mocks.callback).toHaveBeenCalledWith({status: 'success', source: mocks.gptIframe.id });
		expect(mocks.callback.calls.length).toBe(1);
	});

	/**
	 * Register after the event stuff now (comment to be removed)
	 */
	it('reacts to event then register', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = modules['ext.wikia.adEngine.messageListener'](mocks.log, mocks.window);
		messageListener.init();

		checkAddEventListenerCall();
		callEventListener({AdEngine: {status: 'success', source: mocks.gptIframe.id }});
		messageListener.register({source: mocks.gptIframe.id, dataKey: 'status'}, mocks.callback);

		expect(mocks.callback).toHaveBeenCalledWith({status: 'success', source: mocks.gptIframe.id });
	});

	it('reacts to event then register then event (only calls once)', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = modules['ext.wikia.adEngine.messageListener'](mocks.log, mocks.window);
		messageListener.init();

		checkAddEventListenerCall();
		callEventListener({AdEngine: {status: 'success', source: mocks.gptIframe.id }}, mocks.gptIframe);
		messageListener.register({source: mocks.gptIframe.id, dataKey: 'status'}, mocks.callback);
		callEventListener({AdEngine: {status: 'success', source: mocks.gptIframe.id }}, mocks.gptIframe);

		expect(mocks.callback).toHaveBeenCalledWith({status: 'success', source: mocks.gptIframe.id });
		expect(mocks.callback.calls.length).toBe(1);
	});

	it('reacts to event, event then register then event (only calls once)', function () {
		var messageListener;

		spyOn(mocks.window, 'addEventListener');
		spyOn(mocks, 'callback');

		messageListener = modules['ext.wikia.adEngine.messageListener'](mocks.log, mocks.window);
		messageListener.init();

		checkAddEventListenerCall();
		callEventListener({AdEngine: {status: 'success', source: mocks.gptIframe.id }});
		callEventListener({AdEngine: {status: 'success', source: mocks.gptIframe.id }});
		messageListener.register({source: mocks.gptIframe.id, dataKey: 'status'}, mocks.callback);
		callEventListener({AdEngine: {status: 'success', source: mocks.gptIframe.id }});

		expect(mocks.callback).toHaveBeenCalledWith({status: 'success', source: mocks.gptIframe.id });
		expect(mocks.callback.calls.length).toBe(1);
	});
});
