/**
 * Any mobile-specific js for file page goes here.
 * @author Liz Lee
 * @todo once VID-555 is fixed, look into adding tracking for the global usage section
 */

require(['track', 'jquery'], function(track, $) {

	/**
	 * Tracking
	 */
	$(document).on('sections:open', function(){
		var id = this.previousElementSibling.id,
			label;

		switch(id) {
			case 'filehistory':
				label = 'history';
				break;
			case 'filelinks':
				label = 'wiki-usage';
				break;
			case 'metadata':
				label = 'metadata';
				break;
			case 'globalusage':
				label = 'global-usage';
				break;
		}

		track.event( 'file-page', track.CLICK, { label: label } );
	});
} );