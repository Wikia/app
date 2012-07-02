/**
 * Rule tables for Esperanto x-code transcription.
 * @author Brion Vibber ([[user:Brion VIBBER]])
 * @date 2011-04-05
 * License: GPLv3
 */

(function() {

var rules = [];
var chars = {C: 'Ĉ', G: 'Ĝ', H: 'Ĥ', J: 'Ĵ', S: 'Ŝ', U: 'Ŭ',
             c: 'ĉ', g: 'ĝ', h: 'ĥ', j: 'ĵ', s: 'ŝ', u: 'ŭ'};
jQuery.each(chars, function(ascii, accented) {
	rules.push([ascii + '[Xx]', ascii, accented]);
	rules.push([accented + '([Xx])', '[Xx]', ascii + '$1']);
});

jQuery.narayam.addScheme( 'eo', {
    'namemsg': 'narayam-eo',
    'extended_keyboard': false,
    'lookbackLength': 1,
    'keyBufferLength': 1,
    'rules': rules
} );

})(jQuery);
