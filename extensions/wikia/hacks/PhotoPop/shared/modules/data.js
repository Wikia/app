var exports = exports || {};

define.call(exports, function(){
	var Storage = my.Class({
		constructor: function(){
			Observe(this);
			
			var that = this;
			
			if(Wikia.Platform.is('app')){
				Titanium.App.addEventListener('Storage:stored', function(event){
					that.fire('set', {key: event.key, value: event.value});
					that.fire({name: 'set', key: event.key}, {key: event.key, value: event.value});
				});
				
				Titanium.App.addEventListener('Storage:fetched', function(event){
					that.fire('get', {key: event.key, value: JSON.parse(event.value)});
					that.fire({name: 'get', key: event.key}, {key: event.key, value: event.value});
				});
			}
		},
		
		set: function(key, value){
			if(Wikia.Platform.is('app'))
				Titanium.App.fireEvent('Storage:set', {key: key, value: JSON.stringify(value)});
			else{
				store.set(key, value);
				this.fire('set', {key: key, value: value});
				this.fire({name: 'set', key: key}, {key: key, value: value});
			}
		},
		
		get: function(key){
			if(Wikia.Platform.is('app'))
				Titanium.App.fireEvent('Storage:get', {key: key});
			else{
				var value = store.get(key);
				
				this.fire('get', {key: key, value: value});
				this.fire({name: 'get', key: key}, {key: key, value: value});
			}
		},
		
		getEvent: function(eventName, key){
			return eventName + ':' + key;
		}
	}),
	XDomainLoader = my.Class({
		_onReadCache: null,
		_id: null,
		
		constructor: function(){
			Observe(this);
			
			var that = this;
			
			if(Wikia.Platform.is('app')){
				that._id = (Math.random() * Math.random()).toString();
				
				Titanium.App.addEventListener('XDomainLoader:readCache:' + that._id, function(event){
					Wikia.log('data: read data from cache for ' + event.url + ' - ' + event.data);
					
					var needsRequest = true;
					
					//Android will pass undefined, iOS null, YAY for consistency!
					if(typeof event.data != 'undefined' && event.data !== null){
						try{
							var data = JSON.parse(event.data);
							needsRequest = false;
						}catch(err){
							needsRequest = true;
						}
					}
					
					if(needsRequest)
						that._sendRequest(event.url, event.options);
					else
						that.fire('success', {url: event.url, response: data});
				});
			}
		},
		
		_sendRequest: function(url, options){
			var that = this;
			options = options || {};
			
			Wikia.log('data: sending request to ' + url);
			
			reqwest({
				url: url + ((url.indexOf('?') >= 0) ? '&' : '?') + 'callback=?',
				type: 'jsonp',
				method: options.method || 'get',
				error: function(err){
					that.fire('error', {url: url, error: err});
				},
				success: function(data){
					if(Wikia.Platform.is('app'))
						Titanium.App.fireEvent('XDomainLoader:success', {url: url, response: data, options: options, id: that._id});
					
					that.fire('success', {url: url, response: data});
				}
			});
		},
		
		load: function(url, options){
			Wikia.log('data: loading ' + url);
			this.fire('beforeLoad', {url: url, options: options});
			
			if(Wikia.Platform.is('app'))
				Titanium.App.fireEvent('XDomainLoader:load', {url: url, options: options, id: this._id});
			else
				this._sendRequest(url, options);
		}
	});
	
	return {
		XDomainLoader: XDomainLoader,
		storage: new Storage()
	}
});