/// <reference path="../weppy.d.ts"/>
define(["require", "exports"], function (require, exports) {
    var WeppyImpl;
    (function (WeppyImpl) {
        var PROTOCOL_VERSION = 3, PATH_DELIMITER = '.', NAMESPACE_DELIMITER = '::', active = false, options = {
            "host": '/weppy',
            "transport": 'url',
            "active": true,
            "sample": 0.01,
            "aggregationInterval": 1000,
            "maxInterval": 5000,
            "decimalPrecision": 3,
            "page": 'index',
            "context": {},
            "debug": false
        }, initTime = +(new Date), queue, aggregationTimeout, maxTimeout, sentPerformanceData, now = function () {
            return window.performance && window.performance.now ? window.performance.now() : +(new Date);
        }, log = function () {
            if (options.debug)
                if (typeof options.debug == 'function')
                    options.debug.apply(window, arguments);
                else
                    window.console && window.console.log && window.console.log.apply ? window.console.log.apply(window.console, arguments) : void 0;
        }, logError = function () {
            window.console && window.console.error && window.console.error.apply && window.console.error.apply(window.console, arguments);
        };
        function round(num, precision) {
            if (precision === void 0) { precision = options.decimalPrecision; }
            return Math.round(num * Math.pow(10, precision)) / Math.pow(10, precision);
        }
        function buildPath(path, subpath, glue) {
            if (glue === void 0) { glue = PATH_DELIMITER; }
            return path + (path != '' && subpath != '' ? glue : '') + subpath;
        }
        function updateActive() {
            active = options.active && Math.random() < options.sample;
        }
        function extend(first, second) {
            if (first && second) {
                for (var key in second) {
                    if (second.hasOwnProperty(key)) {
                        first[key] = second[key];
                    }
                }
            }
            return first || second;
        }
        function sortedJson(obj) {
            var keys = Object.keys(obj).sort(), i, ret = {};
            for (i = 0; i < keys.length; i++) {
                ret[keys[i]] = obj[keys[i]];
            }
            return JSON.stringify(ret);
        }
        (function (MetricType) {
            MetricType[MetricType["Counter"] = 0] = "Counter";
            MetricType[MetricType["Gauge"] = 1] = "Gauge";
            MetricType[MetricType["Timer"] = 2] = "Timer";
        })(WeppyImpl.MetricType || (WeppyImpl.MetricType = {}));
        var MetricType = WeppyImpl.MetricType;
        var Queue = (function () {
            function Queue() {
                this.clear();
            }
            Queue.prototype.clear = function () {
                this.all = {};
                this._empty = true;
            };
            Queue.prototype.empty = function () {
                return this._empty;
            };
            Queue.prototype.add = function (name, value, rollingAverage, annotations) {
                var data = this.find(name, annotations);
                if (rollingAverage) {
                    data.count = data.count || 0;
                    data.count++;
                    data.value += (value - data.value) / data.count;
                    data.rollingAverage = true;
                }
                else {
                    data.value += value;
                }
                this._empty = false;
            };
            Queue.prototype.find = function (name, annotations) {
                var serializedAnnotations = annotations ? sortedJson(annotations) : false, scope = this.all[name] = this.all[name] || {}, data;
                if (serializedAnnotations) {
                    scope = scope.annotated = scope.annotated || {};
                    scope = scope[serializedAnnotations] = scope[serializedAnnotations] || {};
                }
                data = scope.data = scope.data || { value: 0 };
                return data;
            };
            Queue.prototype.get_clear = function () {
                var measurements = {};
                function addMeasurement(name, data, annotations) {
                    if (data) {
                        var value = data.value;
                        if (data.rollingAverage) {
                            value = round(value);
                        }
                        var measurement = [value];
                        if (annotations) {
                            measurement.push(annotations);
                        }
                        measurements[name].push(measurement);
                    }
                }
                var names = Object.keys(this.all), data, annotated, i, k;
                for (i = 0; i < names.length; i++) {
                    measurements[names[i]] = [];
                    data = this.all[names[i]].data;
                    annotated = this.all[names[i]].annotated;
                    if (data) {
                        addMeasurement(names[i], data, null);
                    }
                    if (annotated) {
                        for (k in annotated) {
                            if (annotated.hasOwnProperty(k)) {
                                addMeasurement(names[i], annotated[k].data, JSON.parse(k));
                            }
                        }
                    }
                }
                this.clear();
                return measurements;
            };
            return Queue;
        })();
        queue = new Queue();
        function enqueue(type, name, value, annotations) {
            if (!active) {
                return;
            }
            var rollingAverage = type != 0 /* Counter */;
            queue.add(name, value, rollingAverage, annotations);
            scheduleSending();
        }
        function scheduleSending() {
            clearTimeout(aggregationTimeout);
            aggregationTimeout = setTimeout(sendQueue, options.aggregationInterval);
            if (!maxTimeout) {
                maxTimeout = setTimeout(sendQueue, options.maxInterval);
            }
        }
        function clearSchedule() {
            clearTimeout(aggregationTimeout);
            clearTimeout(maxTimeout);
            aggregationTimeout = null;
            maxTimeout = null;
        }
        function sendQueue() {
            clearSchedule();
            if (queue.empty()) {
                return;
            }
            if (!active) {
                log("Weppy: would send queue but inactive");
                return;
            }
            if (!window.JSON || !JSON.stringify) {
                queue.clear();
                return;
            }
            var all_measurements = queue.get_clear();
            var all_data = {
                context: options.context,
                data: all_measurements
            };
            log('Weppy: sending', all_data);
            sendData(all_data);
        }
        function sendData(data) {
            if (typeof options.transport == 'function') {
                options.transport(data);
                return;
            }
            var url = options.host + '/v' + PROTOCOL_VERSION + '/send';
            if (options.transport == 'url') {
                url += '?p=' + encodeURIComponent(JSON.stringify(data));
                sendRequest(url, null);
            }
            else if (options.transport == 'post') {
                sendRequest(url, JSON.stringify(data));
            }
        }
        function sendRequest(url, data) {
            var corsSupport = window.XMLHttpRequest && (XMLHttpRequest['defake'] || (new XMLHttpRequest()).withCredentials);
            var sameOrigin = true;
            var match = /^(https?:\/\/[^\/]+)/i.exec(url);
            if (match && match[1] != document.location.protocol + '//' + document.location.host) {
                sameOrigin = false;
            }
            var req;
            if (!sameOrigin && !corsSupport && window.XDomainRequest) {
                req = new XDomainRequest();
            }
            else {
                req = new XMLHttpRequest();
            }
            var contentType = data == null ? 'text/plain' : 'application/json';
            req.weppy = req.bucky = { track: false };
            req.open('POST', url, true);
            req.setRequestHeader('Content-Type', contentType);
            req.send(data);
            return req;
        }
        var Namespace = (function () {
            function Namespace(_root, _path) {
                this._root = _root;
                this._path = _path;
                this.timer = new NamespaceTimer(this);
            }
            Namespace.prototype.namespace = function (root, path) {
                return new Namespace(root, path || '');
            };
            Namespace.prototype.into = function (subpath) {
                return new Namespace(this._root, buildPath(this._path, subpath));
            };
            Namespace.prototype.key = function (name) {
                return buildPath(this._root, buildPath(this._path, name), NAMESPACE_DELIMITER);
            };
            Namespace.prototype.send = function (type, name, value, annotations) {
                name = this.key(name);
                enqueue(type, name, value, annotations);
                log('Weppy: queued', {
                    type: MetricType[type],
                    name: name,
                    value: value,
                    annotations: annotations
                });
            };
            Namespace.prototype.count = function (name, value, annotations) {
                if (value === void 0) { value = 1; }
                this.send(0 /* Counter */, name, value, annotations);
            };
            Namespace.prototype.store = function (name, value, annotations) {
                this.send(1 /* Gauge */, name, value, annotations);
            };
            Namespace.prototype.flush = function () {
                sendQueue();
            };
            Namespace.prototype.setOptions = function (opts) {
                var key;
                for (key in opts) {
                    if (opts.hasOwnProperty(key)) {
                        options[key] = opts[key];
                    }
                }
                if ('sample' in opts || 'active' in opts) {
                    updateActive();
                }
            };
            Namespace.prototype.sendPagePerformance = function () {
                if (!window.performance || !window.performance.timing || sentPerformanceData) {
                    return false;
                }
                var self = this, readyState = document.readyState;
                if (readyState == 'uninitialized' || readyState == 'loading') {
                    if (document.addEventListener) {
                        document.addEventListener("DOMContentLoaded", function () {
                            self.sendPagePerformance();
                        }, false);
                    }
                    return false;
                }
                sentPerformanceData = true;
                var timing = window.performance.timing, start = timing.navigationStart, key, time, data = {};
                for (key in timing) {
                    time = timing[key];
                    if (time && typeof time == 'number') {
                        data[key] = (time - start);
                    }
                }
                delete data['navigationStart'];
                var name = options.page;
                self.namespace('PAGELOAD').timer.send(name, start, data);
                return true;
            };
            return Namespace;
        })();
        WeppyImpl.Namespace = Namespace;
        var NamespaceTimer = (function () {
            function NamespaceTimer(_namespace) {
                this._namespace = _namespace;
                this.PARTIALS = {};
            }
            NamespaceTimer.prototype.send = function (name, duration, annotations) {
                this._namespace.send(2 /* Timer */, name, duration, annotations);
            };
            NamespaceTimer.prototype.start = function (name, annotations) {
                this.PARTIALS[name] = [now(), annotations];
                return new Timer(this, name);
            };
            NamespaceTimer.prototype.stop = function (name, annotations) {
                if (!this.PARTIALS[name]) {
                    logError("Timer " + name + " ended without having been started");
                    return;
                }
                var duration = now() - this.PARTIALS[name][0];
                annotations = extend(annotations, this.PARTIALS[name][1]);
                this.PARTIALS[name] = false;
                this.send(name, duration, annotations);
            };
            NamespaceTimer.prototype.annotate = function (name, annotations) {
                if (!this.PARTIALS[name]) {
                    logError("Timer " + name + " received annotation without having been started");
                    return;
                }
                this.PARTIALS[name][1] = annotations;
            };
            NamespaceTimer.prototype.time = function (name, action, scope, args, annotations) {
                this.start(name, annotations);
                var self = this, done = function (annotations) {
                    self.stop(name, annotations);
                };
                args = args ? args.slice(0) : [];
                args.splice(0, 0, done);
                return action.apply(scope, args);
            };
            NamespaceTimer.prototype.timeSync = function (name, action, scope, args, annotations) {
                this.start(name, annotations);
                var ret = action.apply(scope, args);
                this.stop(name);
                return ret;
            };
            NamespaceTimer.prototype.wrap = function (name, action, scope, annotations) {
                var _this = this;
                var self = this;
                return function () {
                    return self.timeSync(name, action, scope || _this, arguments, annotations);
                };
            };
            NamespaceTimer.prototype.mark = function (name, annotations) {
                this.send(name, now() - this.navigationStart(), annotations);
            };
            NamespaceTimer.prototype.navigationStart = function () {
                return (window.performance && window.performance.timing && window.performance.timing.navigationStart) || initTime;
            };
            return NamespaceTimer;
        })();
        WeppyImpl.NamespaceTimer = NamespaceTimer;
        var Timer = (function () {
            function Timer(_timer, name) {
                this._timer = _timer;
                this.name = name;
            }
            Timer.prototype.stop = function (annotations) {
                this._timer.stop(this.name, annotations);
            };
            Timer.prototype.annotate = function (annotations) {
                this._timer.annotate(this.name, annotations);
            };
            return Timer;
        })();
        WeppyImpl.Timer = Timer;
        function bindNamespaceFunction(fn, scope, callWrapNamespace) {
            return callWrapNamespace ? function () {
                return wrapNamespaceObject(fn.apply(scope, arguments));
            } : function () {
                return fn.apply(scope, arguments);
            };
        }
        function wrapNamespaceObject(obj) {
            var weppyObject = (function (subpath) {
                return subpath ? weppyObject.into(subpath) : weppyObject;
            }), k;
            for (k in obj) {
                if (typeof obj[k] == 'function') {
                    weppyObject[k] = bindNamespaceFunction(obj[k], obj, k == 'into' || k == 'namespace');
                }
                else {
                    weppyObject[k] = obj[k];
                }
            }
            return weppyObject;
        }
        function getRootObject() {
            return wrapNamespaceObject(new Namespace('', ''));
        }
        WeppyImpl.getRootObject = getRootObject;
        updateActive();
    })(WeppyImpl || (WeppyImpl = {}));
    var Weppy = WeppyImpl.getRootObject();
    return Weppy;
});
