require(
	['jquery', 'mw', 'wikia.window', 'wikia.tracker', 'wikia.geo'],
	function ($, mw, context, tracker, geo) {}
);

define(
	'wikia.awesomeModule',
	['jquery', 'mw', 'wikia.window', 'wikia.tracker', 'wikia.geo'],
	function ($, mw, context, tracker, geo) {}
);

function smallCompliantFunction(a, b, c, d) {}

function bigEvilFunction(a, b, c, d, e) {} // Noncompliant

var o = {
	smallCompliantMethod: function (a, b, c, d) {},
	bigEvilMethod: function (a, b, c, d, e) {} // Noncompliant
};

someCompliantAsyncThing.doStuffWithCallback(function (a, b, c, d) {});
someEvilAsyncThing.doStuffWithCallback(function (a, b, c, d, e) {}); // Noncompliant
