/**
 * Transliteration based keyboard for Tulu, based on Kannada
 * @author Santhosh Thottingal ([[user:Santhosh.thottingal]])
 * @date 2011-12-19
 * License: GPLv3
 */

// copy the rules from kannada transliteration.
tcy_scheme = $.narayam.getScheme( 'kn' );
tcy_scheme.namemsg = 'narayam-tcy';
jQuery.narayam.addScheme( 'tcy', tcy_scheme );

