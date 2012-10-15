/**
 * JavasSript for the Semantic Image Input MediaWiki extension.
 * 
 * TODO: this was written in a sprint; could be made less evil.
 * 
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $, mw ) {
	
	$( document ).ready( function() {
		// Find all instant image inputs in the form. 
		$( '.instantImage' ).each( function( index, domElement ) {
			$e = $( domElement );
			
			// Those of type item bind to the first input in their multiple instance template.
			if ( $e.attr( 'data-item-type' ) === 'item' ) {
				$e.instantImage( {
					'iteminput': $e.closest( 'td' ).find( 'input' ).first(),
					'inputname': $e.attr( 'data-input-name' ),
					'imagewidth': $e.attr( 'data-image-width' )
				} );
			}
			else {
				// Those of type page do not bind to an input but have the image name as attribute.
				$e.instantImage( {
					'imagename': $e.attr( 'data-image-name' ),
					'inputname': $e.attr( 'data-input-name' ),
					'imagewidth': $e.attr( 'data-image-width' )
				} );
			}
		} );
		
		// This is a serious hack to initiate instant image inputs that get added via new multuple
		// instance templates. If there is a sane way to do this, it should be used.
		$( '.multipleTemplateAdder' ).click( function() {
			var $this = $( this );
			setTimeout(
				function() {
					$t = $this.closest( 'fieldset' ).find( '.multipleTemplateInstance' ).last();
					$e = $t.find( '.instantImage' ).first();
					
					$e.instantImage( {
						'iteminput': $t.find( 'input' ).first(),
						'inputname': $t.find( 'input[type=hidden]' ).last().attr( 'name' ),
						'imagewidth': $e.attr( 'data-image-width' )
					} );
				},
				100
			);
		} );
	} );

})( window.jQuery, window.mediaWiki );