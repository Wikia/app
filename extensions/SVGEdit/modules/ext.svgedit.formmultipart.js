/**
 * SVGEdit extension
 * @copyright 2010-2011 Brion Vibber <brion@pobox.com>
 */

/**
 * Utility class for building multipart form submission data.
 *
 * @constructor
 */
function FormMultipart(fields) {
	function genRandom(chars) {
		var base = '';
		for (var i = 0; i < chars; i++) {
			base = base + String.fromCharCode(Math.floor(Math.random() * 26) + 65);
		}
		return base;
	}
	this.boundary = genRandom(16);
	this.out = [];

	if (fields) {
		for (var name in fields) {
			if (fields.hasOwnProperty(name)) {
				this.addField(name, fields[name]);
			}
		}
	}
}

FormMultipart.prototype.append = function(str) {
	this.out.push(str);
};

FormMultipart.prototype.addField = function(name, val) {
	this.addPart({
		name: name,
		data: val
	});
};

FormMultipart.prototype.addPart = function(params) {
	this.append('--' + this.boundary);

	var disposition = 'Content-Disposition: ';
	if (params.disposition) {
		disposition += params.disposition;
	} else {
		disposition += 'form-data';
	}
	if (params.name) {
		disposition += '; name="' + encodeURIComponent(params.name) + '"';
	}
	if (params.filename) {
		disposition += '; filename="' + encodeURIComponent(params.filename) + '"';
	}
	this.append(disposition);

	if (params.type) {
		this.append('Content-Type: ' + params.type);
	}
	if (params.encoding) {
		this.append('Content-Transfer-Encoding: ' + params.encoding)
	}

	this.append('');
	if (params.data) {
		this.append(params.data);
	} else {
		this.append('');
	}
};

FormMultipart.prototype.toString = function() {
	var crlf = "\r\n";
	return this.out.join(crlf) + (crlf + "--" + this.boundary + "--" + crlf);
};

FormMultipart.prototype.contentType = function() {
	// note: charset is needed in Safari 5 to workaround a webkit
	// oddity where it otherwise tries to add it after the boundary.
	return 'multipart/form-data; charset=utf-8; boundary=' + this.boundary;
};
