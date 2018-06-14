module.exports = function (source) {
	if (this.cacheable) {
		this.cacheable();
	}

	var value = (typeof source === 'string') ? JSON.parse(source) : source,
		transform = this.query.transform;

	if (typeof transform === 'function') {
		value = this.query.transform(value);
	}

	value = JSON.stringify(value)
		.replace(/\u2028/g, '\\u2028')
		.replace(/\u2029/g, '\\u2029');

	return value;
}
