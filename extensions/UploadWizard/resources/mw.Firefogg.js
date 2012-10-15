// Firefogg utilities not related to the upload handler or transport
mw.Firefogg = {
		
	firefoggInstallLinks: {
		'macosx': 'http://firefogg.org/macosx/Firefogg.xpi',
		'win32': 'http://firefogg.org/win32/Firefogg.xpi',
		'linux': 'http://firefogg.org/linux/Firefogg.xpi'
	},
	
	/**
	 * Get the URL for installing firefogg on the client OS
	 */
	getFirefoggInstallUrl: function() {
		var osLink = false;
		if( ! $.browser.mozilla ){
			return 'http://firefogg.org/';
		}
		if ( navigator.oscpu ) {
			if ( navigator.oscpu.search( 'Linux' ) >= 0 )
				osLink = this.firefoggInstallLinks['linux'];
			else if ( navigator.oscpu.search( 'Mac' ) >= 0 )
				osLink = this.firefoggInstallLinks['macosx'];
			else if (navigator.oscpu.search( 'Win' ) >= 0 )
				osLink = this.firefoggInstallLinks['win32'];
		}
		return osLink;
	},
	isInstalled: function() {
		return typeof( Firefogg ) != 'undefined' && Firefogg().version >= '2.8.05';
	}
};
