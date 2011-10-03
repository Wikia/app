/**
 * Observable base class for the my.Class system, originally written for the
 * BenchMonkey OSS project
 * 
 * @author Federico "Lox" Lucignano
 */
var Observable;

(function(){
	/**
	 * @public
	 */
	
	Observable = my.Class({
		/**
		 * @protected
		 */
		_callbacks: {},
		
		/**
		 * @public
		 */
		fire: function (event, data){
			var x,
			callbacks = this._callbacks[event];
			
			if(callbacks instanceof Array){
				data = data || null;
				
				for(x = 0, y = callbacks.length; x < y; x++){
					callbacks[x].call(this, event, data);
				}
			}
		},
		
		addEventListener: function(event, callback){
			this._callbacks[event] = this._callbacks[event] || [];
			this._callbacks[event].push(callback);
		},
		
		removeEventListener: function(event, callback){
			for(var x = 0, y = this._callbacks[event].length; x < y; x++){
				if(this._callbacks[event][x] === callback)
					this._callbacks[event].splice(x, 1);
			}
		}
	});
})();