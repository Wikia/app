( function( mw ) { 

	mw.canvas = {
		/** 
		 * @return boolean
		 */
		isAvailable: function() {
			return !! ( document.createElement('canvas')['getContext'] );
		}

	};

} )( mediaWiki );
