
/**
 * original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * revised by: Kankrelune (http://www.webfaktory.info/)
 * note 1: Uses an internal counter (in php_js global) to avoid collision
 * example 1: uniqid();
 * returns 1: 'a30285b160c14'
 * example 2: uniqid('foo');
 * returns 2: 'fooa30285b1cd361'
 * example 3: uniqid('bar', true);
 * returns 3: 'bara20285b23dfd1.31879087'
 */
define('wikia.uniqueId', function() {
	var uniqidSeed;

	 function formatSeed(seed, reqWidth) {
		seed = parseInt(seed, 10).toString(16); // to hex str
		if (reqWidth < seed.length) { // so long we split
			return seed.slice(seed.length - reqWidth);
		}
		if (reqWidth > seed.length) { // so short we pad
			return new Array(1 + (reqWidth - seed.length)).join('0') + seed;
		}
		return seed;
	}

	function uniqueId(prefix, more_entropy) {
		var retId;

		if (typeof prefix == 'undefined') {
			prefix = "";
		}

		if (typeof uniqidSeed === 'undefined') { // init seed with big random int
			uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
		}

		uniqidSeed++;

		retId = prefix; // start with prefix, add current milliseconds hex string
		retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);
		retId += formatSeed(uniqidSeed, 5); // add seed hex string
		if (more_entropy) {
			// for more entropy we add a float lower to 10
			retId += (Math.random() * 10).toFixed(8).toString();
		}

		return retId;
	}

	return uniqueId;
});
