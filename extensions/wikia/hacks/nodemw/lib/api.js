(function(exports) {

	var api = function(options) {
		this.server = options.server;
		this.proxy = options.proxy;
		this.debug = options.debug;

		this.cookieJar = '';

		this.http = require('http');
		this.formatUrl = require('url').format;

		this.userAgent = 'nodemw (node.js ' + process.version + ')';
	}

	api.prototype = {
		log: function(obj) {
			if (this.debug) {
				console.log(obj);
			}
		},

		call: function(params, callback, method) {
			var self = this;

			params = params || {};
			method = method || 'GET';

			// force JSON format
			params.format = 'json';

			// add additional headers
			var headers = {
				'User-Agent': this.userAgent,
				'Content-Length': 0
			};

			if (this.cookieJar) {
				headers['Cookie'] = this.cookieJar;
			}

			// @see http://nodejs.org/api/url.html
			var url = this.formatUrl({
				protocol: 'http',
				hostname: this.server,
				pathname: '/api.php',
				query: params
			});

			this.log('URL: ' + url);

			// form the request
			var req = this.http.request({
				host: this.proxy || this.server,
				method: method,
				headers: headers,
				path: url
			}, function(res) {
				res.body = '';

				// request was sent, now wait for the response
				res.on('data', function(chunk) {
					res.body += chunk;
				});

				res.on('end', function() {
					self.log(res.body);

					// store cookies
					var cookies = res.headers['set-cookie'];
					if (cookies) {
						cookies.forEach(function(cookie) {
							cookie = cookie.split(';').shift();
							self.cookieJar += (cookie + ';');
						});
					}

					// parse response
					try {
						var data = JSON.parse(res.body);
						callback((data && data[params.action]) || false);
					}
					catch(e) {}
				});
			});

			req.on('error', function(e) {
				self.log(e.stack);
			});

			// finish sending a request
			req.end();
		}
	};

	exports.api = api;

})(exports);
