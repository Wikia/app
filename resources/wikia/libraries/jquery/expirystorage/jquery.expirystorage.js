/**
 * LOCAL STORAGE WITH EXPIRATION (cookie simulation)
 * NOTE: the simulation is not a true cookie. Unlike
 * real cookies, the simulation requires an expiration.
 *
 * Depends on jquery.store.js
 */

$.expiryStorage = new $.store();
$.expiryStorage.get = function(key) {
	var value = this.driver.get( key );
	if (!value) {
		return;
	}
	var data = this.driver.encodes ? value : this.unserialize( value );
	value = null;
	var d = new Date();
	if (data.expires >= d.getTime()) {
		value = data.value;
	}
	else {
		this.del(key);
	}
	return value;
};

// Set cookie. Expires logic borrowed from a jquery plugin.
// NOTE: expires is either a date object, or a number of *milli*seconds until the cookie expires
$.expiryStorage.set = function(key, value, expires) {
	var d;
	if (typeof expires == 'number') {
		d = new Date();
		d.setTime(d.getTime() + (expires));
	}
	else if (typeof expires == 'object' && expires.toUTCString) {
		d = expires;
	}
	else {
		throw 'expires is not in a valid form';
	}
	var data = { value: value, expires: d.getTime() };
	this.driver.set( key, this.driver.encodes ? data : this.serialize( data ) );
};
