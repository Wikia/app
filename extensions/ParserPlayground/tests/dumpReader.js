var events = require('events'),
	util = require('util'),
	libxml = require('libxmljs'); // npm install libxmljs

function DumpReader() {
	events.EventEmitter.call(this);
}

util.inherits(DumpReader, events.EventEmitter);

/**
 * @param {Stream} stream input stream to read XML from
 */
DumpReader.prototype.read = function(stream) {
	var self = this;
	var complete = false;

	var stack = [{}],
		workspace = {},
		buffer = '';

	function flip(arr) {
		var obj = {};
		arr.forEach(function(val) {
			obj[val] = true;
		});
		return obj;
	}
	var textNodes = flip(['id', 'text', 'title', 'minor', 'comment', 'username', 'timestamp']),
		boolNodes = flip(['minor', 'redirect']),
		ignoreNodes = flip(['mediawiki', 'siteinfo', 'upload', 'thread']);

	var parser = new libxml.SaxPushParser(function(cb) {
		cb.onStartElementNS(function(elem, attrs, prefix, uri, namespaces) {
			if (elem in ignoreNodes) {
				// ...
			} else if (elem == 'page') {
				stack = [];
				workspace = {};
			} else if (elem == 'revision') {
				stack.push(workspace);
				workspace = {
					page: workspace
				};
			} else if (elem in textNodes || elem in boolNodes) {
				buffer = '';
			} else {
				stack.push(workspace);
				workspace = {};
			}
		});

		cb.onEndElementNS(function(elem, prefix, uri) {
			// ping something!
			if (elem == 'mediawiki') {
				self.complete = true;
				stream.pause();
				self.emit('end', {});
			} else if (elem == 'page') {
				self.emit('page', workspace);
				workspace = stack.pop();
			} else if (elem == 'revision') {
				self.emit('revision', workspace);
				workspace = stack.pop();
			} else if (elem in textNodes) {
				workspace[elem] = buffer;
			} else if (elem in boolNodes) {
				workspace[elem] = true;
			} else {
				var current = workspace;
				workspace = stack.pop();
				workspace[elem] = current;
			}
		});
		cb.onCharacters(function(chars) {
			buffer += chars;
		});
		cb.onCdata(function(cdata) {
			buffer += cdata;
		});
		cb.onEndDocument(function() {
			// This doesn't seem to run...?
			self.complete = true;
			stream.pause();
			self.emit('end', {});
		})
		cb.onError(function(err) {
			self.emit('error', err);
			// Should we.... stop reading now or what?
		});

		// Now, start reading the file in :D
		stream.on('data', function(buffer) {
			parser.push(buffer); // @fixme does this want bytes or chars?
		});
		stream.on('end', function() {
			if (!complete) {
				// uh-oh!
				//self.emit('error', 'End of file before end of XML stream.');
			}
		});
		stream.on('error', function(err) {
			self.emit('error', err);
		});
	});
};


module.exports.DumpReader = DumpReader;

if (module === require.main) {
	var reader = new DumpReader();
	reader.on('end', function() {
		console.log('done!');
		process.exit();
	});
	reader.on('error', function(err) {
		console.log('error!', err);
		process.exit(1);
	});
	reader.on('page', function(page) {
		console.log('page', page);
	});
	reader.on('revision', function(revision) {
		revision.text = revision.text.substr(0, 40);
		console.log('revision', revision);
	});
	console.log('Reading!');
	process.stdin.setEncoding('utf8');
	process.stdin.resume();
	reader.read(process.stdin);
}
