/**
 * Any mobile-specific js for file page goes here.
 * @author Liz Lee
 * @todo once VID-555 is fixed, look into adding tracking for the global usage section
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
				options.push( { label: 'wiki-usage' } );
				track.event.apply( track, options );
				break;
			case 'metadata':
				options.push( { label: 'metadata' } );
				track.event.apply( track, options );
				break;
			case 'globalusage':
				options.push( { label: 'global-usage' } );
				track.event.apply( track, options );
				break;
		}
	});
} );