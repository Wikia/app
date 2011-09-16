/*****************************************************************************
 ******** LOCAL STORAGE WITH EXPIRATIONS (cookie simulation)   ***************
 ******** NOTE: the simulation is not a true cookie. Unlike    ***************
 ******** real cookies, the simulation requires an expiration. ***************
 *****************************************************************************/

$.storageWithExp = new $.store();
$.storageWithExp.get = function(key) {
	var value = this.driver.get( key );
	if (!value) {
		return;
	}
	var cookie = this.driver.encodes ? value : this.unserialize( value );
	value = null; 
	var d = new Date();
	if (cookie.expires >= d.getTime()) {
		value = cookie.value;
	}
	else {
		this.del(key);
	}
	return value;
};

// Set cookie. Expires logic borrowed from a jquery plugin. 
// NOTE: expires is either a date object, or a number of *milli*seconds until the cookie expires 
$.storageWithExp.set = function(key, value, expires) {
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
	var cookie = { value: value, expires: d.getTime() };
	this.driver.set( key, this.driver.encodes ? cookie : this.serialize( cookie ) );
};

/*****************************************************************************
 ******** END LOCAL STORAGE WITH EXPIRATIONS *********************************
 *****************************************************************************/

