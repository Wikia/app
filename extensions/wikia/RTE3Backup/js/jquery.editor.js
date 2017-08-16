// get meta data from given node
jQuery.fn.getData = function() {
	var json = this.attr('data-rte-meta');
	if (!json) {
		return {};
	}

	// decode JSON
	json = decodeURIComponent(json);

	var data = JSON.parse(json) || {};
	return data;
};

// set meta data for given node
jQuery.fn.setData = function(key, value) {
	var data = {};

	// prepare data to be stored
	if (typeof key == 'object') {
		data = key;
	}
	else if (typeof key == 'string') {
		data[key] = value;
	}

	// read current data stored in node and merge with data
	data = jQuery().extend(true, this.getData(), data);

	// encode JSON
	var json = JSON.stringify(data);

	this.attr('data-rte-meta', encodeURIComponent(json));

	// return modified data
	return data;
};

// set type of current placeholder
jQuery.fn.setPlaceholderType = function(type) {
	$(this).
		attr('class', 'placeholder placeholder-' + type).
		setData('type', type);
};
