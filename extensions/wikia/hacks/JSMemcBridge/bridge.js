var crypto = require('crypto');
var mwmemc = require( './memc' );
var mode = process.argv[2];
var checkInterval = 2; // variable check interval (in seconds)
var allowedGETKeys = [];
var allowedSETKeys = []

allowedGETKeys['SearchedKeywords'] = true;
allowedGETKeys['TEST'] = true;
allowedSETKeys['TEST'] = true;

if(mode == 'devbox') {
	var memcached = new mwmemc( ["10.8.44.110:11000","10.8.36.107:11000"], null );
}
else {
	var memcached = new mwmemc( ["127.0.0.1:11211"], null );
}

var io = require('socket.io').listen(8080);

Watcher = function(key, socket) {
	this.key = key;
	this.socket = socket;
	this.varHash = null;
}

Watcher.prototype.check = function() {
	var self = this;
	memcached.get( this.key, function( err, result ) {
		if( err ) {
			console.error( err );
		}
		var hash = crypto.createHash('md5').update(result.toString()).digest("hex");

		if(hash != self.hash) {
			self.socket.send( result );
			self.hash = hash;
		}
	});
}

io.sockets.on('connection', function (socket) {
	socket.on('message', function (msg) {
		socket.on('GET', function(data) {
			if((typeof data != 'undefined') && (typeof data.key != 'undefined')) {
				if(typeof allowedGETKeys[data.key] == 'undefined') {
					socket.send( false );
					return;
				};
				memcached.dbname = data.dbname;
				var cacheKey = memcached.key( data.key );

				console.log('GET: '+cacheKey);
				memcached.get( cacheKey, function( err, result ) {
					if( err ) {
						console.error( err );
					}
					//console.dir( result );
					socket.send( result );
				});
			}
		});

		socket.on('WATCH', function(data) {
			if(typeof allowedGETKeys[data.key] == 'undefined') {
				socket.send( false );
				return;
			};
			memcached.dbname = data.dbname;

			var watcher = new Watcher(memcached.key( data.key ), socket);
			setInterval(function() {
				watcher.check();
			}, (checkInterval*1000));
		});

		socket.on('SET', function(data) {
			if((typeof data != 'undefined') && (typeof data.key != 'undefined') && (typeof data.value != 'undefined')) {
				if(typeof allowedSETKeys[data.key] == 'undefined') {
					socket.send( false );
					return;
				};
				memcached.dbname = data.dbname;
				var cacheKey = memcached.key( data.key );
				var cacheTtl = (typeof data.ttl != 'undefined') ? data.ttl : 0;

				console.log('SET: '+cacheKey+' (TTL='+cacheTtl+')');
				memcached.set( cacheKey, data.value, cacheTtl, function( err, result ) {
					if( err ) {
						console.error( err );
					}
				});
			}
		});

	});

	socket.on('disconnect', function () { 
		console.log('Kansas went bye bye');
	});
})

