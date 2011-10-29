var exports = exports || {};

define.call(exports, {
	XDomainLoader: my.Class({
		constructor: function(){
			Observe(this);
		},
		
		load: function(url, options){
			this.fire('beforeLoad', {url: url});
			
			var that = this;
			options = options || {};
			options.method = options.method || 'get';
			url += ((url.indexOf('?') >= 0) ? '&' : '?')
			
			if(typeof Titanium != 'undefined'){
				url += 'format=json';
				
				Titanium.App.addEventListener('XDomainLoader:error', function(event){
					that.fire('error', {url: url, error: event.data});
				});
				
				Titanium.App.addEventListener('XDomainLoader:success', function(event){
					that.fire('success', {url: url, response: JSON.parse(event.data).data});
				});
				
				Titanium.App.fireEvent('XDomainLoader:load', {url: url, options: options});
			}else{
				url += 'callback=?';
				
				reqwest({
					url: url,
					type: 'jsonp',
					method: options.method || 'get',
					error: function(err){
						that.fire('error', {url: url, error: err});
					},
					success: function(data) {
						that.fire('success', {url: url, response: data});
					}
				});
			}
		}
	})
});