/*
 * timeago: a jQuery plugin, version: 0.9.3 (2011-01-21)
 * @requires jQuery v1.2.3 or later
 *
 * Timeago is a jQuery plugin that makes it easy to support automatically
 * updating fuzzy timestamps (e.g. "4 minutes ago" or "about 1 day ago").
 *
 * For usage and examples, visit:
 * http://timeago.yarp.com/
 *
 * Licensed under the MIT:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright (c) 2008-2011, Ryan McGeary (ryanonjavascript -[at]- mcgeary [*dot*] org)
 *
 * Test it using: $('<time datetime="2012-07-06T14:23:57Z">').timeago()
 */
(function ($) {
	function distance(date) {
		return (new Date().getTime() - date.getTime());
	}

	function inWords(date) {
		return $t.inWords(distance(date));
	}

	function refresh() {
		var data = prepareData(this);
		if (!isNaN(data.datetime)) {
			$(this).text(inWords(data.datetime));
		}
		return this;
	}

	function prepareData(element) {
		element = $(element);
		if (!element.data("timeago")) {
			element.data("timeago", { datetime:$t.datetime(element) });
			var text = $.trim(element.text());
			if (text.length > 0) {
				element.attr("title", text);
			}
		}
		return element.data("timeago");
	}

	$.timeago = function (timestamp) {
		if (timestamp instanceof Date) {
			return inWords(timestamp);
		} else if (typeof timestamp === "string") {
			return inWords($.timeago.parse(timestamp));
		} else {
			return inWords($.timeago.datetime(timestamp));
		}
	};

	var $t = $.timeago;

	$.extend($.timeago, {
		settings:{
			refreshMillis:60000,
			allowFuture:true, // Wikia change (BugId: 30226)
			strings:window.wgTimeAgoi18n || {} // Wikia change
		},
		inWords:function (distanceMillis) {
			var $l = this.settings.strings,
				isFuture = false;
			if (this.settings.allowFuture) {
				if (distanceMillis < 0) {
					isFuture = true;
				}
				distanceMillis = Math.abs(distanceMillis);
			}

			var seconds = distanceMillis / 1000;
			var minutes = seconds / 60;
			var hours = minutes / 60;
			var days = hours / 24;
			var years = days / 365;

			function substitute(key, number) {
				var string = $l[isFuture ? (key + '-from-now') : key] || '';
				return string.replace(/%d/i, number);
			}

			var words = (seconds < 45 && substitute('seconds', Math.round(seconds))) ||
				(seconds < 90 && substitute('minute', 1)) ||
				(minutes < 45 && substitute('minutes', Math.round(minutes))) ||
				(minutes < 90 && substitute('hour', 1)) ||
				(hours < 24 && substitute('hours', Math.round(hours))) ||
				(hours < 48 && substitute('day', 1)) ||
				(days < 30 && substitute('days', Math.floor(days))) ||
				(days < 60 && substitute('month', 1)) ||
				(days < 365 && substitute('months', Math.floor(days / 30))) ||
				(years < 2 && substitute('year', 1)) ||
				substitute('years', Math.floor(years));

			return words;
		},
		parse:function (iso8601) {
			var s = $.trim(iso8601);
			s = s.replace(/\.\d\d\d+/, ""); // remove milliseconds
			s = s.replace(/-/, "/").replace(/-/, "/");
			s = s.replace(/T/, " ").replace(/Z/, " UTC");
			s = s.replace(/([\+\-]\d\d)\:?(\d\d)/, " $1$2"); // -04:00 -> -0400
			return new Date(s);
		},
		datetime:function (elem) {
			var node = $(elem);

			// jQuery's `is()` doesn't play well with HTML5 in IE
			var isTime = node.get(0).tagName.toLowerCase() === "time"; // $(elem).is("time");
			var iso8601 = isTime ? node.attr("datetime") : node.attr("title");
			return $t.parse(iso8601);
		}
	});

	$.fn.timeago = function () {
		var self = this;
		self.each(refresh);

		var $s = $t.settings;
		if ($s.refreshMillis > 0) {
			setInterval(function () {
				self.each(refresh);
			}, $s.refreshMillis);
		}
		return self;
	};

	// fix for IE6 suckage
	document.createElement("abbr");
	document.createElement("time");
}(jQuery));
