var exports = exports || {};

define.call(exports, {
	XDomainLoader: my.Class({
		constructor: function(){
			Observe(this);
		},
		
		load: function(url, options){
			this.fire('beforeLoad', {url: url});
			
			options = options || {};
			var that = this;
			
			if(typeof Titanium != 'undefined'){
				Titanium.addEventListener('XDomainLoader:error', function(event){
					that.fire('error', {url: url, error: event});
				});
				
				Titanium.addEventListener('XDomainLoader:success', function(event){
					that.fire('success', {url: url, response: event});
				});
				
				Titanium.fire('XDomainLoader:load', {url: url, options: options});
			}else{
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