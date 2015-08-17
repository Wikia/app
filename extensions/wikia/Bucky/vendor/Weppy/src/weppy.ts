/// <reference path="../weppy.d.ts"/>

// these seem not to be defined in window
interface Window {
	XMLHttpRequest?: XMLHttpRequest;
	XDomainRequest?: XMLHttpRequest;
	JSON?: JSON;
}

module WeppyImpl {

	var protocolVersion = 3,
		pathDelimiter = '.',
		namespaceDelimiter = '::',
		active = false,
		options: WeppySettings = {
			"host": '/weppy',
			"transport": 'url', // 'url' or 'post'
			"active": true,
			"sample": 0.01,
			"aggregationInterval": 1000,
			"maxInterval": 5000,
			"decimalPrecision": 3,
			"page": 'index',
			"context": {},
			"debug": false
		},
		initTime = +(new Date),
		queue, aggregationTimeout, maxTimeout, sentPerformanceData,
		now = () => {
			return window.performance && window.performance.now ? window.performance.now() : +(new Date);
		},
		log: any = () => {
			if (options.debug) {
				if (typeof options.debug === 'function') {
					options.debug.apply(window, arguments);
				} else {
					window.console && window.console.log && window.console.log.apply
						? window.console.log.apply(window.console, arguments) : void 0;
				}
			}
		},
		logError: any = () => {
			window.console && window.console.error && window.console.error.apply &&
				window.console.error.apply(window.console, arguments);
		};

	function round (num: number, precision = options.decimalPrecision): number {
		return Math.round(num * Math.pow(10, precision)) / Math.pow(10, precision)
	}

	function buildPath (path: string, subpath: string, glue: string = pathDelimiter) {
		return path + ( (path != '' && subpath != '') ? glue : '' ) + subpath;
	}

	function updateActive () {
		active = options.active && Math.random() < options.sample;
	}

	function extend (first: any, second: any) {
		var key;
		if (first && second) {
			for (key in second) {
				if (second.hasOwnProperty(key)) {
					first[key] = second[key];
				}
			}
		}
		return first || second;
	}

	function sortedJson (obj) {
		var keys = Object.keys(obj).sort(),
			i, ret = {};
		for (i = 0; i < keys.length; i++) {
			ret[keys[i]] = obj[keys[i]];
		}
		return JSON.stringify(ret);
	}

	export enum MetricType { Counter, Gauge, Timer }

	module QueueData {
		export interface Root {
			[key: string]: Node;
		}
		export interface Node {
			annotated?: AnnotatedKey;
			data?: Data;
		}
		export interface AnnotatedKey {
			[key: string]: AnnotatedValue;
		}
		export interface AnnotatedValue {
			[key: string]: Node;
			[key: number]: Node;
		}
		export interface Data {
			value: number;
			count?: number;
			rollingAverage?: boolean;
		}
	}
	class Queue {
		private all: QueueData.Root;
		private _empty: boolean;

		constructor () {
			this.clear();
		}

		clear () {
			this.all = {};
			this._empty = true;
		}

		empty () {
			return this._empty;
		}

		add (name: string, value: number, rollingAverage: boolean, annotations?) {
			var data: QueueData.Data = this.find(name, annotations);
			if (rollingAverage) {
				data.count = data.count || 0;
				data.count++;
				data.value += (value - data.value) / data.count;
				data.rollingAverage = true;
			} else {
				data.value += value;
			}
			this._empty = false;
		}

		private find (name: string, annotations?): QueueData.Data {
			var serializedAnnotations: any = annotations ? sortedJson(annotations) : false,
				scope = this.all[name] = this.all[name] || {}, data: QueueData.Data;
			if (serializedAnnotations) {
				scope = scope.annotated = scope.annotated || {};
				scope = scope[serializedAnnotations] = scope[serializedAnnotations] || {};
			}
			data = scope.data = scope.data || {value: 0};
			return data;
		}

		get () {
			var measurements = {}, value, measurement, names, data, annotated, i, k;

			function addMeasurement (name, data, annotations) {
				if (data) {
					value = data.value;
					if (data.rollingAverage) {
						value = round(value);
					}
					measurement = [value];
					if (annotations) {
						measurement.push(annotations);
					}
					measurements[name].push(measurement);
				}
			}

			names = Object.keys(this.all);
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
			return measurements;
		}
	}
	queue = new Queue();

	function enqueue (type: MetricType, name: string, value: number, annotations?) {
		var rollingAverage;
		if (!active) {
			return;
		}
		rollingAverage = type != MetricType.Counter;
		queue.add(name, value, rollingAverage, annotations);
		scheduleSending();
	}

	function scheduleSending () {
		clearTimeout(aggregationTimeout);
		aggregationTimeout = setTimeout(sendQueue, options.aggregationInterval);
		if (!maxTimeout) {
			maxTimeout = setTimeout(sendQueue, options.maxInterval);
		}
	}

	function clearSchedule () {
		clearTimeout(aggregationTimeout);
		clearTimeout(maxTimeout);
		aggregationTimeout = null;
		maxTimeout = null;
	}


	function sendQueue () {
		var allMeasurements, allData;
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
		allMeasurements = queue.get();
		queue.clear();
		allData = {
			context: options.context,
			data: allMeasurements
		};
		log('Weppy: sending', allData);
		sendData(allData);
	}

	function sendData (data) {
		var url;
		if (typeof options.transport == 'function') {
			options.transport(data);
			return;
		}
		url = options.host + '/v' + protocolVersion + '/send';
		if (options.transport == 'url') {
			url += '?p=' + encodeURIComponent(JSON.stringify(data));
			sendRequest(url, null);
		} else if (options.transport == 'post') {
			sendRequest(url, JSON.stringify(data));
		}
	}

	function sendRequest (url, data) {
		var corsSupport = window.XMLHttpRequest && (XMLHttpRequest['defake'] || (new XMLHttpRequest()).withCredentials),
			sameOrigin = true, match, req, contentType;

		match = /^(https?:\/\/[^\/]+)/i.exec(url);
		if (match && match[1] != document.location.protocol + '//' + document.location.host) {
			sameOrigin = false;
		}

		if (!sameOrigin && !corsSupport && window.XDomainRequest) {
			req = new XDomainRequest();
		} else {
			req = new XMLHttpRequest();
		}

		contentType = data == null ? 'text/plain' : 'application/json';

		req.weppy = req.bucky = {track: false};
		req.open('POST', url, true);
		req.setRequestHeader('Content-Type', contentType);
		req.send(data);
		return req;
	}

	export class Namespace implements WeppyNamespace {
		public timer: NamespaceTimer;

		constructor (private _root: string, private _path: string) {
			this.timer = new NamespaceTimer(this);
		}

		namespace (root: string, path?: string) {
			return new Namespace(root, path || '');
		}

		into (subpath: string) {
			return new Namespace(this._root, buildPath(this._path, subpath))
		}

		private key (name: string) {
			return buildPath(this._root, buildPath(this._path, name), namespaceDelimiter);
		}

		send (type: MetricType, name: string, value: number, annotations?: WeppyContext) {
			name = this.key(name);
			enqueue(type, name, value, annotations);
			log('Weppy: queued', {
				type: MetricType[type],
				name: name,
				value: value,
				annotations: annotations
			});
		}

		count (name: string, value: number = 1, annotations?: WeppyContext) {
			this.send(MetricType.Counter, name, value, annotations);
		}

		store (name: string, value: number, annotations?: WeppyContext) {
			this.send(MetricType.Gauge, name, value, annotations);
		}

		flush () {
			sendQueue();
		}

		setOptions (opts: WeppySettings) {
			var key;
			for (key in opts) {
				if (opts.hasOwnProperty(key)) {
					options[key] = opts[key];
				}
			}
			if ('sample' in opts || 'active' in opts) {
				updateActive();
			}
		}

		sendPagePerformance () {
			var self, readyState, timing, start, key, time, data: WeppyContext = {}, name;
			if (!window.performance || !window.performance.timing || sentPerformanceData) {
				return false;
			}

			self = this;
			readyState = document.readyState;
			if (readyState == 'uninitialized' || readyState == 'loading') {
				if (document.addEventListener) {
					document.addEventListener("DOMContentLoaded", () => {
						self.sendPagePerformance();
					}, false);
				}
				return false;
			}

			sentPerformanceData = true;
			timing = window.performance.timing;
			start = timing.navigationStart;
			for (key in timing) {
				time = timing[key];
				if (time && typeof time == 'number') {
					data[key] = (time - start);
				}
			}
			delete data['navigationStart'];

			name = options.page;
			self.namespace('PAGELOAD').timer.send(name, start, data);

			return true
		}
	}

	export class NamespaceTimer implements WeppyNamespaceTimer {
		private PARTIALS;

		constructor (private _namespace: Namespace) {
			this.PARTIALS = {}
		}

		send (name: string, duration: number, annotations?: WeppyContext) {
			this._namespace.send(MetricType.Timer, name, duration, annotations);
		}

		start (name: string, annotations?: WeppyContext) {
			this.PARTIALS[name] = [now(), annotations];
			return new Timer(this, name);
		}

		stop (name: string, annotations?: WeppyContext) {
			var duration;
			if (!this.PARTIALS[name]) {
				logError("Timer " + name + " ended without having been started");
				return;
			}
			duration = now() - this.PARTIALS[name][0];
			annotations = extend(annotations, this.PARTIALS[name][1]);
			this.PARTIALS[name] = false;
			this.send(name, duration, annotations);
		}

		annotate (name: string, annotations: WeppyContext) {
			if (!this.PARTIALS[name]) {
				logError("Timer " + name + " received annotation without having been started");
				return;
			}
			this.PARTIALS[name][1] = annotations;
		}

		time (name: string, action, scope, args, annotations?: WeppyContext) {
			var self = this,
				done = (annotations?) => {
					self.stop(name, annotations);
				};
			this.start(name, annotations);
			args = args ? args.slice(0) : [];
			args.splice(0, 0, done);
			return action.apply(scope, args);
		}

		timeSync (name: string, action, scope, args, annotations?: WeppyContext) {
			var ret;
			this.start(name, annotations);
			ret = action.apply(scope, args);
			this.stop(name);
			return ret;
		}

		wrap (name: string, action, scope, annotations?: WeppyContext) {
			var self = this;
			return () => {
				return self.timeSync(name, action, scope || this, arguments, annotations);
			};
		}

		mark (name: string, annotations?: WeppyContext) {
			this.send(name, now() - this.navigationStart(), annotations);
		}

		private navigationStart () {
			return (window.performance && window.performance.timing && window.performance.timing.navigationStart) ||
				initTime;
		}
	}

	export class Timer implements WeppyTimer {
		constructor (private _timer: NamespaceTimer, private name: string) {
		}

		stop (annotations?) {
			this._timer.stop(this.name, annotations);
		}

		annotate (annotations) {
			this._timer.annotate(this.name, annotations);
		}
	}

	function bindNamespaceFunction (fn, scope, callWrapNamespace) {
		return callWrapNamespace ?
			() => {
				return wrapNamespaceObject(fn.apply(scope, arguments));
			} :
			() => {
				return fn.apply(scope, arguments);
			}
	}

	function wrapNamespaceObject (obj: WeppyNamespace) {
		var weppyObject: WeppyObject = <WeppyObject>((subpath: string) => {
			return subpath ? weppyObject.into(subpath) : weppyObject;
		}), k;
		for (k in obj) {
			if (typeof obj[k] == 'function') {
				weppyObject[k] = bindNamespaceFunction(obj[k], obj,
					k == 'into' || k == 'namespace');
			} else {
				weppyObject[k] = obj[k];
			}
		}
		return weppyObject;
	}

	export function getRootObject () {
		return wrapNamespaceObject(new Namespace('', ''));
	}

	updateActive();
}

var Weppy: WeppyNamespace = WeppyImpl.getRootObject();
