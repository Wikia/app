/**
 * Any mobile-specific js for file page goes here.
 * @author Liz Lee
 * @todo once VID-555 is fixed, look into adding tracking for the global usage section
 */

require(['track', 'jquery'], function(track, $) {

	// Play video
	var filePageContainer = document.getElementById('file');
	if(filePageContainer && window.playerParams) {
		new VideoBootstrap(filePageContainer, window.playerParams, 'filePage');
	}

	/**
	 * Tracking
	 */
	$(document).on('sections:open', function(event, section){
		var id = section.previousElementSibling.id,
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