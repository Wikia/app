/**
 * Transliteration regular expression rules table for Sinhala (Singlish)
 * @author Junaid P V ([[user:Junaidpv]])
 * @date 2011-02-23
 * @credits With help from Nishantha Anuruddha (si.wikipedia.org/wiki/user:බිඟුවා)
 * License: GPLv3
 */

// Normal rules
var rules = [
//['ඬ්හ්a', '', 'ඳ'],	// nndha
['ඬ්h', '', 'ඳ්'], // nndh
['න්න්d', '', 'ඬ්'], 	// nnd
['න්න්g', '', 'ඟ්'],	// nng
['ශ්‍රිi', '', 'ශ්‍රී'],	// shrii
['ශ්‍රi', '', 'ශ්‍රි'],	// shri
['ශ්r', '', 'ශ්‍ර'],	// shr

['([\\u0D9A-\\u0DC6])්\\u200Dර්u', '', '$1ෘ'],    // <consonant>ru
['([\\u0D9A-\\u0DC6])ෘu', '', '$1ෲ'],    // <consonant>ruu

['([\\u0D9A-\\u0DC6])්a', '', '$1'],    // <consonant>a
['([\\u0D9A-\\u0DC6])a', '', '$1ා'],    // <consonant>aa
['([\\u0D9A-\\u0DC6])්A', '', '$1ැ'],    // <consonant>A
['([\\u0D9A-\\u0DC6])ැa', '', '$1ෑ'],    // <consonant>Aa
['([\\u0D9A-\\u0DC6])්i', '', '$1ි'],    // <consonant>i
['([\\u0D9A-\\u0DC6])ි[ei]', '', '$1ී'],    // <consonant>ie
['([\\u0D9A-\\u0DC6])්u', '', '$1ු'],    // <consonant>u
['([\\u0D9A-\\u0DC6])ුu', '', '$1ූ'],    // <consonant>u
['([\\u0D9A-\\u0DC6])්e', '', '$1ෙ'],    // <consonant>e
['([\\u0D9A-\\u0DC6])ෙ[ai]', '', '$1ේ'],    // <consonant>ei
['([\\u0D9A-\\u0DC6])්o', '', '$1ො'],    // <consonant>o
['([\\u0D9A-\\u0DC6])ොe', '', '$1ෝ'],    // <consonant>oe
['([\\u0D9A-\\u0DC6])u', '', '$1ෞ'],    // <consonant>au
['([\\u0D9A-\\u0DC6])්I', '', '$1ෛ'],    // <consonant>I

['([\\u0D9A-\\u0DC6]්)r', '', '$1\u200Dර්'],    // <consonant>r

['ළුu', '', 'ළුු'], // Luu

['(ක්h|K)', '', 'ඛ්'],  // kh K
['(ග්h|G)', '', 'ඝ්'],  // gh G
['ස්h', '', 'ශ්'],  // sh
['ch', '', 'ච්'],
['Ch', '', 'ඡ්'],
['Sh', '', 'ෂ්'],
['ඝ්N', '', 'ඥ්'],  // GN
['ඨ්h', '', 'ථ්'],  // Th
['ඛ්N', '', 'ඤ්'],  // KN
['ට්h', '', 'ත්'],  // th
['ඪ්h', '', 'ධ්'],  // Dh
['ඩ්h', '', 'ද්'],  // dh
['(ප්h|P)', '', 'ඵ්'],  // ph P
['ළ්u', '', 'ළු'],  // Lu
['බ්h', '', 'භ්'],  // bh

['(\\\\r|R)', '', 'ර්‍'],   // \r R
['(\\\\y|Y)', '', '‍ය්'],   // \y Y


['අ(a|\\))', '', 'ආ'],  // aa a)
['ඇ(a|\\))', '', 'ඈ'],  // Aa A) ae
['(ඉ[i\\)e]|එe)', '', 'ඊ'], // ii i) ie ee
['එ[a\\)i]', '', 'ඒ'], // ea e) ei
['ඔ[e\\)]', '', 'ඕ'], // oe o)
['(උ[u\\)]|ඔo)', '', 'ඌ'],  // uu u) oo
['අu', '', 'ඖ'], // au

['\\\\n', '', 'ං'],
['\\\\h', '', 'ඃ'],
['\\\\N', '', 'ඞ'],
['\\\\R', '', 'ඍ'],

['a', '', 'අ'],
['A', '', 'ඇ'],
['i', '', 'ඉ'],
['e', '', 'එ'],
['o', '', 'ඔ'],
['u', '', 'උ'],

['k', '', 'ක්'],
['b', '', 'බ්'],
['B', '', 'ඹ්'],
['g', '', 'ග්'],
['m', '', 'ම්'],
['y', '', 'ය්'],
['j', '', 'ජ්'],
['r', '', 'ර්'],
['T', '', 'ඨ්'],
['f', '', 'ෆ්'],
['t', '', 'ට්'],
['l', '', 'ල්'],
['D', '', 'ඪ්'],
['d', '', 'ඩ්'],
['(w|v)', '', 'ව්'],
['s', '', 'ස්'],
['q', '', 'ඣ්'],
['h', '', 'හ්'],
['n', '', 'න්'],
['N', '', 'ණ්'],
['p', '', 'ප්'],
['L', '', 'ළ්']
];

jQuery.narayam.addScheme( 'si-singlish', {
	'namemsg': 'narayam-si-singlish',
	'extended_keyboard': false,
	'lookbackLength': 5,
	'keyBufferLength': 2,
	'rules': rules
} );
