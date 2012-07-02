/**
 * JavasSript for PAMELA listwidget.
 * @see http://www.mediawiki.org/wiki/Extension:PAMELA
 * 
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

jQuery(document).ready(function() {
	$( '.peoplelist' ).each( function() {
		$( this ).peoplelist();
	} );
});

(function( $ ){ $.fn.peoplelist = function() {
	
	var self = this;
	
	this.api = new pamela.API( {
		'url': this.attr( 'apiurl' )
	} );
	
	this.initInterfaceUpdate = function() {
		this.api.getAll(
			{},
			function( entities ) {
				updateInterface( entities );
			}
		);
	}
	
	function updateInterface( entities ) {
		self.text( entities.people.join( ',' )/* mediaWiki.msg( '', entities.people, entities.devices, entities.macs )*/ );
	}
	
	function doRepeatingUpdates() {
		self.initInterfaceUpdate();
		setTimeout( doRepeatingUpdates, parseInt( self.attr( 'interval' ) ) );
	}		
	
	doRepeatingUpdates();
	
	return this;
	
}; })( jQuery );