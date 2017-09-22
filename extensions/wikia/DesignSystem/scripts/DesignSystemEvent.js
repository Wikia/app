define('ext.wikia.design-system.event', [], function () {
	'use strict';

	function Event(sender) {
		this._sender = sender;
		this._listeners = [];
	}

	Event.prototype = {
		attach: function (listener) {
			this._listeners.push(listener);
		},
		notify: function (args) {
			this._listeners.forEach(function (listener) {
				listener(this._sender, args)
			}.bind(this));
		}
	};

	return Event
});
