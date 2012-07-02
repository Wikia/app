/**
 * JavasSript for PAMELA openwidget.
 * @see http://www.mediawiki.org/wiki/Extension:PAMELA
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

jQuery(document).ready(function() {
	$( '.openwidget' ).each( function() {
		$( this ).openwidget();
	} );
});

(function( $ ){ $.fn.openwidget = function() {
	
	var self = this;
	var loaded = false;
	var bannerSpan = null;
	
	this.api = new pamela.API( {
		'url': this.attr( 'apiurl' )
	} );	
	
	this.initInterfaceUpdate = function() {
		this.api.isOpen(
			{},
			function( isOpen ) {
				updateInterface( isOpen );
			}
		);
	}
	
	function updateInterface( isOpen ) {
		if ( !loaded ) {
			loaded = true;
			bannerSpan = $( '<span />' ).attr( 'class', 'openbanner' ).text( mediaWiki.msg( 'pamela-list-open' ) );
			self.html( bannerSpan );
		}
		bannerSpan.css( 'display', isOpen ? 'block' : 'none' );
	}
	
	function doRepeatingUpdates() {
		self.initInterfaceUpdate();
		setTimeout( doRepeatingUpdates, parseInt( self.attr( 'interval' ) ) );
	}
	
	doRepeatingUpdates();	
	
	return this
	
}; })( jQuery );