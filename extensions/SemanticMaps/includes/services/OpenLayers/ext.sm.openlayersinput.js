/**
 * JavaScript for the OpenLayers form input in the Semantic Maps extension.
 * @see https://www.mediawiki.org/wiki/Extension:Semantic_Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */
(function( $ ) {

	$( document ).ready( function() {

		$( '.sminput-openlayers' ).each( function() {
			var $this = $( this );
			$this.openlayersinput( $this.attr( 'id' ), jQuery.parseJSON( $this.find( 'div').text() ) );
		} );

	} );

})( window.jQuery );