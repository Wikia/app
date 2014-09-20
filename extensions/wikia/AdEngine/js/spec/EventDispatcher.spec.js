/*global describe,it,expect,modules,spyOn,beforeEach */
/*jslint nomen: true*/
describe('EventDispatcher', function(){
	'use strict';

	var callbacks;

	beforeEach(function() {
		callbacks = {
			defaultCallback: function(){ return undefined; },
			trueCallback: function() { return true; },
			falseCallback: function() { return false; },
			objectCallback: function() { return {}; },
			stringCallback: function() { return "string"; },
			arrayCallback: function() { return []; }
		};

		spyOn(callbacks, 'defaultCallback');
	});

	it('successfuly binds callback to event', function() {

		var dispatcher = modules['ext.wikia.adEngine.eventDispatcher']();

		dispatcher.bind('event', callbacks.defaultCallback);

		expect(dispatcher._events.event).not.toBeUndefined();
		expect(dispatcher._events.event).toContain(callbacks.defaultCallback);

	});

	it('successfuly unbinds callback to from event', function() {

		var dispatcher = modules['ext.wikia.adEngine.eventDispatcher']();

		dispatcher.bind('event', callbacks.defaultCallback);
		dispatcher.unbind('event', callbacks.defaultCallback);

		expect(dispatcher._events.event).not.toContain(callbacks.defaultCallback);
	});

	it('trigger should return true when callback result undefined', function() {


		var dispatcher = modules['ext.wikia.adEngine.eventDispatcher']();

		dispatcher.bind('event', callbacks.defaultCallback);
		dispatcher.bind('event', callbacks.defaultCallback);

		expect(dispatcher.trigger('event')).toBe(true);

		expect(callbacks.defaultCallback).toHaveBeenCalled();
		expect(callbacks.defaultCallback.calls.length).toEqual(2);
	});

	it('trigger should return true when all callbacks result !== false', function() {

		var dispatcher = modules['ext.wikia.adEngine.eventDispatcher']();

		dispatcher.bind('event', callbacks.stringCallback);
		dispatcher.bind('event', callbacks.trueCallback);
		dispatcher.bind('event', callbacks.arrayCallback);
		dispatcher.bind('event', callbacks.objectCallback);
		dispatcher.bind('event', callbacks.defaultCallback);

		expect(dispatcher.trigger('event')).toBe(true);
	});

	it('trigger should return false when on of callbacks result === false', function() {

		var dispatcher = modules['ext.wikia.adEngine.eventDispatcher']();

		dispatcher.bind('event', callbacks.defaultCallback);
		dispatcher.bind('event', callbacks.falseCallback);
		dispatcher.bind('event', callbacks.defaultCallback);
		dispatcher.bind('event', callbacks.defaultCallback);

		expect(dispatcher.trigger('event')).toBe(false);
		expect(callbacks.defaultCallback).toHaveBeenCalled();
		expect(callbacks.defaultCallback.calls.length).toEqual(1);
	});

	it('bind should do callbacks in lazyBind scenario', function() {

		var dispatcher = modules['ext.wikia.adEngine.eventDispatcher']();

		expect(dispatcher.trigger('event', 'data')).toBe(true);
		expect(dispatcher.trigger('event', 'anotherData')).toBe(true);

		dispatcher.bind('event', callbacks.defaultCallback, true);

		expect(callbacks.defaultCallback).toHaveBeenCalled();
		expect(callbacks.defaultCallback.calls.length).toEqual(2);
		expect(callbacks.defaultCallback).toHaveBeenCalledWith('data');
		expect(callbacks.defaultCallback).toHaveBeenCalledWith('anotherData');
	});


});