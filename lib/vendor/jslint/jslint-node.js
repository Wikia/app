// jslint.js node integration
// add it at the end of jslint.js (just before "return itself")

	/* Wikia change - begin */
	/* change for nodejs */
	if (typeof exports !== "undefined") {
		exports.JSLINT = itself;
	}
	/* Wikia change - end */
