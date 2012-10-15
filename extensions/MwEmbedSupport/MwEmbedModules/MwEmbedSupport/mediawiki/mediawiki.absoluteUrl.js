
( function( mw ) {
	/**
	 * makeAbsolute takes makes the given 
	 * document.URL or a contextUrl param
	 * 
	 * @param {String}
	 *            source path or url
	 * @param {String}
	 *            contextUrl The domain / context for creating an absolute url
	 *            from a relative path
	 * @return {=String} absolute url
	 */
	mw.absoluteUrl = function( source, contextUrl ) {
		try{
			var parsedSrc = new mw.Uri( source );
			if( parsedSrc.protocol )
				return source;
		} catch(e){ 
			// not already absolute
		};

		// Get parent Url location the context URL
		if( !contextUrl ) {
			contextUrl = document.URL;
		}
		var contextUrl = new mw.Uri( contextUrl );
	
		// Check for local windows file that does not flip the slashes:
		if( contextUrl.directory == '' && contextUrl.protocol == 'file' ){
			// pop off the file
			var fileUrl = contextUrl.split( '\\');
			fileUrl.pop();
			return fileUrl.join('\\') + '\\' + src;
		}
		// Check for leading slash:
		if( source.indexOf( '/' ) === 0 ) {
			return contextUrl.protocol + '://' + contextUrl.getAuthority() + source;
		}else{
			return contextUrl.protocol + '://' + contextUrl.getAuthority() + contextUrl.path + source;
		}
	};
	
} )( window.mediaWiki );