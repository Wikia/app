/**
 * Transliteration regular expression rules table for Tifinagh script
 * Based on Moroccan keyboards: http://www.ircam.ma/fr/index.php?soc=telec&rd=2
 * @date 2011-11-22
 */

var rules = [
['a', '', 'ⴰ'],
['b', '', 'ⴱ'],
['c', '', 'ⵛ'],
['d', '', 'ⴷ'],
['D', '', 'ⴹ'],
['e', '', 'ⴻ'],
['f', '', 'ⴼ'],
['F', '', 'ⴼⵯ'],
['g', '', 'ⴳ'],
['G', '', 'ⴳⵯ'],
['h', '', 'ⵀ'],
['i', '', 'ⵉ'],
['j', '', 'ⵊ'],
['k', '', 'ⴽ'],
['K', '', 'ⴽⵯ'],
['l', '', 'ⵍ'],
['m', '', 'ⵎ'],
['n', '', 'ⵏ'],
['o', '', 'ⵄ'],
['p', '', 'ⵃ'],
['q', '', 'ⵇ'],
['Q', '', 'ⵈ'],
['r', '', 'ⵔ'],
['R', '', 'ⵕ'],
['s', '', 'ⵙ'],
['S', '', 'ⵚ'],
['t', '', 'ⵜ'],
['T', '', 'ⵟ'],
['v', '', 'ⵖ'],
['u', '', 'ⵓ'],
['w', '', 'ⵡ'],
['y', '', 'ⵢ'],
['x', '', 'ⵅ'],
['z', '', 'ⵣ'],
['Z', '', 'ⵥ'],
];

jQuery.narayam.addScheme( 'ber-tfng', {
	'namemsg': 'narayam-ber-tfng',
	'extended_keyboard': false,
	'lookbackLength': 0,
	'keyBufferLength': 0,
	'rules': rules
} );
