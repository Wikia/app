/**
 * Very primitive hashmap class that allows using objects as keys;
 * JSON flattening of the key object is used as a hash code, so only
 * suitable for objects that will be immutable for now.
 *
 * Actual final comparison is done using object identity, but the
 * bucket match is from the JSON, so don't mess around!
 *
 * Used to map parse tree nodes to output nodes for the inspector mode.
 */
function HashMap() {
	this.keyBuckets = {};
	this.valBuckets = {};
}

/**
 * @param {object} keyObj
 * @return {object} original object, or null if no match found.
 */
HashMap.prototype.get = function(keyObj) {
	var key = this.hash(keyObj);
	if (typeof this.keyBuckets[key] !== 'undefined') {
		var keys = this.keyBuckets[key],
			max = keys.length;
		for (var i = 0; i < max; i++) {
			if (keyObj === keys[i]) {
				return this.valBuckets[key][i];
			}
		}
	}
	return null;
};

/**
 * @param {object} keyObj
 * @param {object} val
 */
HashMap.prototype.put = function(keyObj, val) {
	var key = this.hash(keyObj);
	if (typeof this.keyBuckets[key] === 'undefined') {
		this.keyBuckets[key] = [];
		this.valBuckets[key] = [];
	}
	this.keyBuckets[key].push(keyObj);
	this.valBuckets[key].push(val);
};

/**
 * This will do for us for now. :)
 */
HashMap.prototype.hash = function(keyObj) {
	return JSON.stringify(keyObj).substr(0, 40);
};
