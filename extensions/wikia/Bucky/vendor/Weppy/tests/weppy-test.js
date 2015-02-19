var async = QUnit.assert.async,
	_console = window.console,
	consoleMock = {},
	consoleCalls = {};
QUnit.module('Weppy tests');

/* propEqual copy from QUnit without adding an assertion */
var hasOwn = Object.prototype.hasOwnProperty,
	objectValues = function (obj) {
		var key, val,
			vals = QUnit.is("array", obj) ? [] : {};
		for (key in obj) {
			if (hasOwn.call(obj, key)) {
				val = obj[key];
				vals[key] = val === Object(val) ? objectValues(val) : val;
			}
		}
		return vals;
	},
	equivObjects = function (a, b) {
		a = objectValues(a);
		b = objectValues(b);
		return QUnit.equiv(a, b);
	};
/* end of propEqual copy */


for (var k in _console) {
	if (typeof _console[k] == 'function') {
		consoleMock[k] = (function (k) {
			return function () {
				consoleCalls[k] = consoleCalls[k] || [];
				consoleCalls[k].push(Array.prototype.slice.apply(arguments, [0]));
				return _console[k].apply(_console, arguments);
			}
		})(k);
	} else {
		consoleMock[k] = _console[k];
	}
}

window.console = consoleMock;

function runWeppyReportTest(test) {
	var done,
		options = {
			debug: false,
			host: '/weppy',
			sample: 100,
			active: 1,
			aggregationInterval: 0,
			maxInterval: 0,
			decimalPrecision: 3,
			transport: function (data) {
				if (test.check && test.check(data) !== false) {
					done();
				}
			},
			context: {}
		};
	if (!test.sync) {
		done = async();
	}
	Weppy.setOptions(options);
	test.setup(done);
}

function mockXMLHttpRequest(check) {
	var _open = XMLHttpRequest.prototype.open,
		_send = XMLHttpRequest.prototype.send,
		url, data;
	XMLHttpRequest.prototype.open = function () {
		url = arguments[1];
		return _open.apply(this, arguments);
	};
	XMLHttpRequest.prototype.send = function () {
		data = arguments[0];
		XMLHttpRequest.prototype.open = _open;
		XMLHttpRequest.prototype.send = _send;
		check(url, data);
	};
}

function clearConsoleLog() {
	consoleCalls = {};
}

function getConsoleLog() {
	var currentLog = consoleCalls;
	clearConsoleLog();
	return currentLog;
}

QUnit.test('Report simple single point', function () {
	runWeppyReportTest({
		setup: function () {
			Weppy.timer.send('axyz', 1.2);
		},
		check: function (data) {
			propEqual(data['data'], {
				axyz: [[1.2]]
			}, 'axyz');
		}
	})
});

QUnit.test('Report global context', function () {
	runWeppyReportTest({
		setup: function () {
			Weppy.setOptions({
				context: {
					asd: 12
				}
			});
			Weppy.timer.send('axyz', 1.2);
		},
		check: function (data) {
			// reported data
			propEqual(data['data'], {
				axyz: [[1.2]]
			});
			// context
			propEqual(data['context'], {
				asd: 12
			}, 'context');
		}
	})
});


QUnit.test('Report average of two times', function () {
	runWeppyReportTest({
		setup: function () {
			Weppy.timer.send('axyz', 1.2);
			Weppy.timer.send('axyz', 1.8);
		},
		check: function (data) {
			propEqual(data['data'], {
				axyz: [[1.5]]
			});
		}
	})
});

QUnit.test('Report sum of two counts', function () {
	runWeppyReportTest({
		setup: function () {
			Weppy.count('axyz', 2);
			Weppy.count('axyz', 6);
		},
		check: function (data) {
			propEqual(data['data'], {
				axyz: [[8]]
			});
		}
	})
});

QUnit.test('Report metric once', function () {
	var step = 1;
	runWeppyReportTest({
		setup: function () {
			Weppy.count('axyz', 2);
		},
		check: function (data) {
			if (step == 1) {
				propEqual(data['data'], {
					axyz: [[2]]
				});
				step = 2;
				Weppy.count('azzz', 5);
				return false;
			} else {
				equal(typeof data['data']['axyz'], 'undefined', 'axyz is not reported twice');
				propEqual(data['data'], {
					azzz: [[5]]
				});
			}
			return true;
		}
	})
});

QUnit.test('Report single annotated point', function () {
	runWeppyReportTest({
		setup: function () {
			Weppy.timer.send('axyz', 1.2, {size: 200});
		},
		check: function (data) {
			propEqual(data['data'], {
				axyz: [
					[1.2, {size: 200}]
				]
			});
		}
	})
});

QUnit.test('Report merged point for points with the same annotations', function () {
	runWeppyReportTest({
		setup: function () {
			Weppy.timer.send('axyz', 1.2, {size: 200});
			Weppy.timer.send('axyz', 1.4, {size: 200});
			Weppy.count('uuu', 2, {size: 100});
			Weppy.count('uuu', 5, {size: 100});
		},
		check: function (data) {
			propEqual(data['data'], {
				axyz: [
					[1.3, {size: 200}]
				],
				uuu: [
					[7, {size: 100}]
				]
			});
		}
	})
});

QUnit.test('Report annotated points separately', function () {
	runWeppyReportTest({
		setup: function () {
			Weppy.timer.send('axyz', 1.1);
			Weppy.timer.send('axyz', 1.2, {size: 200});
			Weppy.timer.send('axyz', 1.3, {size: 100});
		},
		check: function (data) {
			propEqual(data['data'], {
				axyz: [
					[1.1],
					[1.2, {size: 200}],
					[1.3, {size: 100}]
				]
			});
		}
	})
});

QUnit.test('Use "active" setting', function () {
	var sent = false;
	runWeppyReportTest({
		setup: function (done) {
			Weppy.setOptions({active: false});
			Weppy.timer.send('axyz', 1.2);
			setTimeout(function () {
				equal(sent, false, 'data was not sent');
				done();
			}, 10);
		},
		check: function (data) {
			sent = true;
			return false;
		}
	})
});

QUnit.test('Use "sample" setting', function () {
	var sent = false;
	runWeppyReportTest({
		setup: function (done) {
			Weppy.setOptions({sample: 0});
			Weppy.timer.send('axyz', 1.2);
			setTimeout(function () {
				equal(sent, false, 'data was not sent');
				done();
			}, 10);
		},
		check: function (data) {
			sent = true;
			return false;
		}
	})
});

QUnit.test('Use "aggregationInterval" setting', function () {
	var start = +(new Date);
	runWeppyReportTest({
		setup: function (done) {
			Weppy.setOptions({aggregationInterval: 20, maxInterval: 50});
			Weppy.timer.send('axyz', 1.2);
			setTimeout(function () {
				Weppy.timer.send('axyz', 1.2);
			}, 10);
		},
		check: function (data) {
			var delay = (+(new Date)) - start;
			ok(delay >= 30 && delay < 50, '30ms <= delay < 50ms');
		}
	})
});

QUnit.test('Use "maxInterval" setting', function () {
	var sent = 0, reported = false;
	runWeppyReportTest({
		setup: function (done) {
			expect(0);
			Weppy.setOptions({aggregationInterval: 20, maxInterval: 5});
			Weppy.timer.send('axyz', 1.2);
			setTimeout(function () {
				Weppy.timer.send('axyz', 1.5);
			}, 10);
			setTimeout(function () {
				if (!reported) {
					ok(false, 'only one report within 40ms');
				}
			}, 40)
		},
		check: function (data) {
			sent++;
			if (sent == 2) {
				reported = true;
				return true;
			} else if (sent > 2) {
				ok(false, 'too many reports');
			}
			return false;
		}
	})
});

QUnit.test('Use "transport" setting = "url"', function () {
	var sent = 0, reported = false;
	runWeppyReportTest({
		setup: function (done) {
			Weppy.setOptions({host: '/weppy-url-test', transport: "url"});
			mockXMLHttpRequest(function (url, data) {
				equal(data, null, "data is empty");
				equal(url, '/weppy-url-test/v3/send?p=%7B%22context%22%3A%7B%7D%2C%22data%22%3A%7B%22a%22%3A%5B%5B1%5D%5D%7D%7D', "data encoded in url");
				done();
			});
			Weppy.count('a', 1);
		}
	})
});

QUnit.test('Use "transport" setting = "post"', function () {
	var sent = 0, reported = false;
	runWeppyReportTest({
		setup: function (done) {
			Weppy.setOptions({host: '/weppy-post-test', transport: "post"});
			mockXMLHttpRequest(function (url, data) {
				equal(data, '{"context":{},"data":{"a":[[1]]}}', "data is empty");
				equal(url, '/weppy-post-test/v3/send', "data encoded in url");
				done();
			});
			Weppy.count('a', 1);
		}
	})
});

QUnit.test('Resolve .into() correctly', function () {
	runWeppyReportTest({
		setup: function () {
			Weppy.count('aaa', 1);
			Weppy.into('test1').count('aab', 2);
			Weppy.into('test1').into('test2').count('aac', 3);
		},
		check: function (data) {
			propEqual(data['data'], {
				aaa: [[1]],
				'test1.aab': [[2]],
				'test1.test2.aac': [[3]]
			});
		}
	})
});

QUnit.test('Resolve .namespace() correctly', function () {
	runWeppyReportTest({
		setup: function () {
			Weppy.count('aaa', 1);
			Weppy.namespace('', 'test1').count('aab', 2);
			Weppy.namespace('Feature', 'test2').count('aac', 3);
		},
		check: function (data) {
			propEqual(data['data'], {
				aaa: [[1]],
				'test1.aab': [[2]],
				'Feature::test2.aac': [[3]]
			});
		}
	})
});


QUnit.test('Option "debug" is respected when false', function () {
	clearConsoleLog();
	runWeppyReportTest({
		setup: function () {
			Weppy.setOptions({debug: false});
			Weppy.count('aaa', 1, {test: 1});
			Weppy.timer.send('tmm', 1.2);
		},
		check: function (data) {
			var logCalls = getConsoleLog().log || [];
			console.log(logCalls);
			var receivedLogs = {}, i;
			for (i = 0; i < logCalls.length; i++) {
				var logText = logCalls[i][0], logData = logCalls[i][1];
				if (logText.indexOf('Weppy') < 0) continue;
				if (logText.indexOf('queued') >= 0 && QUnit.is('object', logData)) {
					if (logData.type == 'Counter' && logData.name == 'aaa' && logData.value == 1 && equivObjects(logData.annotations, {test: 1}))
						receivedLogs['aaa'] = true;
					if (logData.type == 'Timer' && logData.name == 'tmm' && logData.value == 1.2 && equivObjects(logData.annotations, {}))
						receivedLogs['tmm'] = true;
				}
				if (logText.indexOf('sending') >= 0)
					receivedLogs['sending'] = true;
			}
			ok(!receivedLogs['aaa'], "Counter aaa debug");
			ok(!receivedLogs['tmm'], "Timer tmm debug");
			ok(!receivedLogs['sending'], "Sending debug");
		}
	})
});

QUnit.test('Option "debug" is respected when true', function () {
	clearConsoleLog();
	runWeppyReportTest({
		setup: function () {
			Weppy.setOptions({debug: true});
			Weppy.count('aaa', 1, {test: 1});
			Weppy.timer.send('tmm', 1.2);
		},
		check: function (data) {
			var logCalls = getConsoleLog().log || [];
			console.log(logCalls);
			var receivedLogs = {}, i;
			for (i = 0; i < logCalls.length; i++) {
				var logText = logCalls[i][0], logData = logCalls[i][1];
				if (logText.indexOf('Weppy') < 0) continue;
				if (logText.indexOf('queued') >= 0 && QUnit.is('object', logData)) {
					if (logData.type == 'Counter' && logData.name == 'aaa' && logData.value == 1 && equivObjects(logData.annotations, {test: 1}))
						receivedLogs['aaa'] = true;
					if (logData.type == 'Timer' && logData.name == 'tmm' && logData.value == 1.2 && equivObjects(logData.annotations, {}))
						receivedLogs['tmm'] = true;
				}
				if (logText.indexOf('sending') >= 0)
					receivedLogs['sending'] = true;
			}
			ok(receivedLogs['aaa'], "Counter aaa debug");
			ok(receivedLogs['tmm'], "Timer tmm debug");
			ok(receivedLogs['sending'], "Sending debug");
		}
	})
});

QUnit.test('Option "debug" is respected when function', function () {
	var _logCalls = [],
		_logFunction = function () {
			_logCalls.push(Array.prototype.slice.call(arguments, 0));
		};
	clearConsoleLog();
	runWeppyReportTest({
		setup: function () {
			Weppy.setOptions({debug: _logFunction});
			Weppy.count('aaa', 1, {test: 1});
			Weppy.timer.send('tmm', 1.2);
		},
		check: function (data) {
			var logCalls = getConsoleLog().log || [];
			equal(logCalls.length, 0, 'no calls to console.log()');
			logCalls = _logCalls;
			var receivedLogs = {}, i;
			for (i = 0; i < logCalls.length; i++) {
				var logText = logCalls[i][0], logData = logCalls[i][1];
				if (logText.indexOf('Weppy') < 0) continue;
				if (logText.indexOf('queued') >= 0 && QUnit.is('object', logData)) {
					if (logData.type == 'Counter' && logData.name == 'aaa' && logData.value == 1 && equivObjects(logData.annotations, {test: 1}))
						receivedLogs['aaa'] = true;
					if (logData.type == 'Timer' && logData.name == 'tmm' && logData.value == 1.2 && equivObjects(logData.annotations, {}))
						receivedLogs['tmm'] = true;
				}
				if (logText.indexOf('sending') >= 0)
					receivedLogs['sending'] = true;
			}
			ok(receivedLogs['aaa'], "Counter aaa debug");
			ok(receivedLogs['tmm'], "Timer tmm debug");
			ok(receivedLogs['sending'], "Sending debug");
		}
	})
});
