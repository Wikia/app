var crypto = require('crypto');
var memcached = require( 'memcached' );


var mwmemc = function( servers, dbname ) {
	this.servers = servers;
	this.serversCount = servers.length;
	this.dbname = dbname;
	this.connections = {};
}

mwmemc.prototype.buildkey = function() {
	var items = [], item;
	for (var i=0;i<arguments.length;i++) {
		item = arguments[i];
		if (Object.prototype.toString.call(item) == '[object Array]') item = this.buildkey.apply(this,item);
		if (item) items.push(item);
	}
	return items.length ? items.join(':') : '';
}

mwmemc.prototype.key = function() {
	return this.buildkey(this.dbname,Array.prototype.slice.call(arguments));
}

mwmemc.prototype.sharedkey = function() {
	return this.buildkey('wikicities',Array.prototype.slice.call(arguments));
}

mwmemc.prototype.md5 = function( data ) {
	return crypto.createHash('md5').update(data).digest("hex");
}
mwmemc.prototype.hex2dec = function(hex) {
	return parseInt(hex,16);
}
mwmemc.prototype.connection = function( key ) {
/*
	console.dir( 'key = ' + key );
	console.dir( 'md5 = ' + (this.md5(key)) );
	console.dir( 'x2  = ' + (this.md5(key).substr(0,8)) );
	console.dir( 'x3  = ' + (this.hex2dec(this.md5(key).substr(0,8))) );
	console.dir( 'dec = ' + (this.hex2dec(this.md5(key).substr(0,8)) & 0x7FFFFFFF) );
*/
	
	var hv = this.hex2dec(this.md5(key).substr(0,8)) & 0x7FFFFFFF;
	var server = hv % this.serversCount;
//	console.dir( 'server = ' + server );
	if (!this.connections[server]) {
		this.connections[server] = new memcached( this.servers[server] );
	}
	return this.connections[server];
}

mwmemc.prototype.get = function() {
	var key = arguments[0];
	var c = this.connection(key);
//console.log(c);
	return c.get.apply(c,arguments);
}


mwmemc.prototype.set = function() {
	var key = arguments[0];
	var c = this.connection(key);
	return c.set.apply(c,arguments);
}

module.exports = mwmemc;

/*
var m = new mwmemc(["10.8.36.106:11000","10.8.36.107:11000"]);
var cacheKey = 'muppet:SearchedKeywordsController::index';

m.get( cacheKey, function( err, result ) {
	if( err ) console.error( err );

	console.dir( result );
//	memcached.end(); // as we are 100% certain we are not going to use the connection again, we are going to end it
});
*/