/**
 * German input method (umlauts and sz), using ~ as the compose key.
 * @author Erik Moeller ([[User:Eloquence]])
 * @date 2011-11-20
 * License: Public domain
 */

(function() {

var rules = [];
var chars = {A: 'Ä', O: 'Ö', U: 'Ü', a: 'ä', o: 'ö', u: 'ü', s: 'ß', S: 'ß'};
jQuery.each( chars, function( ascii, special ) {
	rules.push( [ '~' + ascii, '~' , special ] );
});

jQuery.narayam.addScheme( 'de', {
    'namemsg': 'narayam-de',
    'extended_keyboard': false,
    'lookbackLength': 1,
    'keyBufferLength': 1,
    'rules': rules
} );

})(jQuery);
