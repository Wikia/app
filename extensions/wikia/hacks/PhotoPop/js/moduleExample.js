// example of module used in web and titanium
// there has to be check if exports exist to make it work

var exports = exports || {};
define.call(exports, {
	a: "b"
});