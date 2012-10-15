/**
 * JavasSript for the Contest MediaWiki extension.
 * @see https://www.mediawiki.org/wiki/Extension:Contest
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {

	$( document ).ready( function() {

		var _this = this;
		
		this.contestConfig = mw.config.get( 'ContestConfig' );

		$( '.mw-htmlform-submit' ).button();

		$rules = $( '#contest-rules' );

		$div = $( '<div />' ).attr( {
			'style': 'display:none'
		} ).html( $( '<div />' ).attr( { 'id': 'contest-rules-div' } ).html( this.contestConfig['rules_page'] ) );

		$a = $( "label[for='contest-rules']" ).find( 'a' );
		$a.attr( { 'href': '#contest-rules-div' } );

		$rules.closest( 'td' ).append( $div );

		$a.fancybox( {
			'width'         : '85%',
			'height'        : '85%',
			'transitionIn'  : 'none',
			'transitionOut' : 'none',
			'type'          : 'inline',
			'autoDimensions': false
		} );
		
		$( '#mw-input-wpcontestant-email' ).contestEmail();
		
	} );

})( window.jQuery, window.mediaWiki );
