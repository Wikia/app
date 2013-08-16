/*!
 * VisualEditor IndexValueStore class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Index-value store
 *
 * @class
 * @constructor
 */
ve.dm.IndexValueStore = function VeDmIndexValueStore() {
	// maps hashes to indexes
	this.hashStore = {};
	// maps indexes to values
	this.valueStore = [];
};

/* Methods */

/**
 * Get the index of a value in the store.
 *
 * If the hash is not found the value is added to the store.
 *
 * @method
 * @param {Object|string|Array} value Value to lookup or store
 * @param {string} [hash] Value hash. Uses ve.getHash( value ) if not provided.
 * @param {boolean} [overwrite=false] Overwrite the value in the store if the hash is already in use
 * @returns {number} The index of the value in the store
 */
ve.dm.IndexValueStore.prototype.index = function ( value, hash, overwrite ) {
	var index;
	if ( typeof hash !== 'string' ) {
		hash = ve.getHash( value );
	}
	index = this.indexOfHash( hash );
	if ( index === null || overwrite ) {
		if ( index === null ) {
			index = this.valueStore.length;
		}
		if ( ve.isArray( value ) ) {
			this.valueStore[index] = ve.copy( value );
		} else if ( typeof value === 'object' ) {
			this.valueStore[index] = ve.cloneObject( value );
		} else {
			this.valueStore[index] = value;
		}
		this.hashStore[hash] = index;
	}
	return index;
};

/**
 * Get the index of a hash in the store.
 *
 * Returns null if the hash is not found.
 *
 * @method
 * @param {Object|string|Array} hash Value hash.
 * @returns {number|null} The index of the value in the store, or undefined if it is not found
 */
ve.dm.IndexValueStore.prototype.indexOfHash = function ( hash ) {
	return hash in this.hashStore ? this.hashStore[hash] : null;
};

/**
 * Get the indexes of values in the store
 *
 * Sames as index but with arrays.
 *
 * @method
 * @param {Object[]} values Values to lookup or store
 * @returns {Array} The indexes of the values in the store
 */
ve.dm.IndexValueStore.prototype.indexes = function ( values ) {
	var i, length, indexes = [];
	for ( i = 0, length = values.length; i < length; i++ ) {
		indexes.push( this.index( values[i] ) );
	}
	return indexes;
};

/**
 * Get the value at a particular index
 *
 * @method
 * @param {number} index Index to lookup
 * @returns {Object|undefined} Value at this index, or undefined if out of bounds
 */
ve.dm.IndexValueStore.prototype.value = function ( index ) {
	return this.valueStore[index];
};

/**
 * Get the values at a set of indexes
 *
 * Same as value but with arrays.
 *
 * @method
 * @param {number[]} index Index to lookup
 * @returns {Array} Values at these indexes, or undefined if out of bounds
 */
ve.dm.IndexValueStore.prototype.values = function ( indexes ) {
	var i, length, values = [];
	for ( i = 0, length = indexes.length; i < length; i++ ) {
		values.push( this.value( indexes[i] ) );
	}
	return values;
};

/**
 * Clone a store.
 *
 * The returned clone is shallow: the valueStore array and the hashStore array are cloned, but
 * the values inside them are copied by reference. These values are supposed to be immutable,
 * though.
 *
 * @returns {ve.dm.IndexValueStore} New store with the same contents as this one
 */
ve.dm.IndexValueStore.prototype.clone = function () {
	var key, clone = new this.constructor();
	clone.valueStore = this.valueStore.slice();
	for ( key in this.hashStore ) {
		clone.hashStore[key] = this.hashStore[key];
	}
	return clone;
};

/**
 * Merge another store into this store.
 *
 * Objects that are in other but not in this are added to this, possibly with a different index.
 * Objects present in both stores may have different indexes in each store. An object is returned
 * mapping each index in other to the corresponding index in this.
 *
 * Objects added to the store are added by reference, not cloned like in .index()
 *
 * @param {ve.dm.IndexValueStore} other Store to merge into this one
 * @returns {Object} Object in which the keys are indexes in other and the values are the corresponding keys in this
 */
ve.dm.IndexValueStore.prototype.merge = function ( other ) {
	var key, index, mapping = {};
	for ( key in other.hashStore ) {
		if ( !( key in this.hashStore ) ) {
			index = this.valueStore.push( other.valueStore[other.hashStore[key]] ) - 1;
			this.hashStore[key] = index;
		}
		mapping[other.hashStore[key]] = this.hashStore[key];
	}
	return mapping;
};
