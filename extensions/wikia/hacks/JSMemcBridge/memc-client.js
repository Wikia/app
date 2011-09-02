$.extend({
	memcached: {
		connect: function() {
			io.transports = [ 'websocket', 'flashsocket', 'htmlfile', 'xhr-polling', 'jsonp-polling' ];

			return socket = io.connect(window.JSMemcBridgeUrl, {
				'force new connection' : true,
				'try multiple transports': true,
				'connect timeout': false
			});
		},

		get: function(key, callback) {
			var socket = this.connect();

			socket.on('connect', function() {
				socket.send('HELLO');
				socket.emit('GET', { key: key, dbname: window.wgDBname });
				socket.on('message', function(msg) {
					callback.apply(callback, [ $.parseJSON(msg) ]);
				});
			});
		},

		set: function(key, value, ttl) {
			var socket = this.connect();
			ttl = (typeof ttl != 'undefined') ? ttl : 0;

			socket.on('connect', function() {
				socket.send('HELLO');
				socket.emit('SET', { key: key, value: value, ttl: ttl, dbname: window.wgDBname });
			});
		},

		watch: function(key, callback) {
			var socket = this.connect();

			socket.on('connect', function() {
				socket.send('HELLO');
				socket.emit('WATCH', { key: key, dbname: window.wgDBname });
				socket.on('message', function(msg) {
					callback.apply(callback, [ $.parseJSON(msg) ]);
				});
			});
		}
	}
});
