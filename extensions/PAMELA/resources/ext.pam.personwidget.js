/**
 * JavasSript for PAMELA personwidget.
 * @see http://www.mediawiki.org/wiki/Extension:PAMELA
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

jQuery(document).ready(function() {
	$( '.personwidget' ).each( function() {
		$( this ).personwidget();
	} );
});

(function( $ ){ $.fn.personwidget = function() {
	
	var self = this;
	var loaded = false;
	var onlineSpan = null;
	
	this.api = new pamela.API( {
		'url': this.attr( 'apiurl' )
	} );
	
	this.initInterfaceUpdate = function() {
		this.api.getEntityData(
			{
				'name': this.attr( 'person' ),
				'groups': 'people'
			},
			function( personData ) {
				updateInterface( personData );
			}
		);
	}
	
	function updateInterface( personData ) {
		if ( !loaded ) {
			loaded = true;
			onlineSpan = $( '<span />' ).attr( 'class', 'personwidget' ).text( mediaWiki.msg( 'pamela-personwidget-online' ) );
			self.html( onlineSpan );
		}
		onlineSpan.css( 'display', ( personData && personData.isPresent)  ? 'block' : 'none' );		
	}
	
	function doRepeatingUpdates() {
		self.initInterfaceUpdate();
		setTimeout( doRepeatingUpdates, parseInt( self.attr( 'interval' ) ) );
	}
	
	doRepeatingUpdates();		
	
	return this
	
}; })( jQuery );