/**
 * Observable base class for the my.Class system, originally written for the
 * BenchMonkey OSS project
 *
 * @author Federico "Lox" Lucignano
 */
function Observe(obj){
	obj._callbacks = {};
	obj._oneTimeCallbacks = {};

	/**
	 * @public
	 *
	 * @param event
	 * @param data
	 */
	obj.fire = function (event, data){
		event = this.getEventName(event);
		var x, y,
		callbacks = this._callbacks[event];
		if(callbacks instanceof Array){
			data = data || null;

			for(x = 0, y = callbacks.length; x < y; x++){
				callbacks[x].call(this, event, data);
			}
		}

		callbacks = this._oneTimeCallbacks[event];
		if(callbacks instanceof Array){
			data = data || null;

			for(x = 0, y = callbacks.length; x < y; x++){
				callbacks[x].call(this, event, data);
				callbacks.splice(x, 1);
			}
		}
	};

	obj.addEventListener = function(event, callback, options){
		event = this.getEventName(event);
		options = options || {};
		var stack = (options.oneTime) ? '_oneTimeCallbacks' : '_callbacks';

		this[stack][event] = this[stack][event] || [];
		this[stack][event].push(callback);
	};

	obj.removeEventListener = function(event, callback){
		event = this.getEventName(event);
		var x, y;

		if(this._callbacks[event]) {
			for(x = 0, y = this._callbacks[event].length; x < y; x++){
				if(this._callbacks[event][x] === callback) {
					this._callbacks[event].splice(x, 1);
				}
			}
		}

		if(this._oneTimeCallbacks[event]) {
			for(x = 0, y = this._oneTimeCallbacks[event].length; x < y; x++){
				if(this._oneTimeCallbacks[event][x] === callback) {
					this._oneTimeCallbacks[event].splice(x, 1);
				}
			}
		}

	};

	obj.getEventName = function(event){
		if(typeof event == 'object'){
			var key = [],
			value;

			for(var p in event){
				value = event[p];

				if(value && typeof value != 'function' && typeof value != 'object')
					key.push(value);
			}

			event = key.join(':');
		}

		return event;
	};
}