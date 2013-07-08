/**
 * Questions for Stanely:
 * - where to track?  ga / internal / both
 *
 * @todo find a global usage instance and track it - there's a bug where global usage is not showing up
 */

require( ['track', 'sections'], function( track, sections ) {

	/**
	 * Tracking
	 */

	sections.addEventListener( 'open', function() {
		var id = this.previousElementSibling.id,
			options = [
				'file-page',
				track.CLICK
			];

		switch( id ) {
			case 'filehistory':
				options.push( { label: 'history' } );
				track.event.apply( track, options );
				break;
			case 'filelinks':
				options.push( { label: 'usage' } );
				track.event.apply( track, options );
				break;
			case 'metadata':
				options.push( { label: 'metadata' } );
				track.event.apply( track, options );
				break;
		}
	});



	/*document.getElementById( 'mw-content-text' ).addEventListener( 'click', function( event ) {
		var t = event.target,
			id = t.id;

		switch( id ) {
			case 'filehistory':
				if ( sections.isOpen( t ) ) {
					console.log('history');
				}
			break;
		}

	})*/
} );