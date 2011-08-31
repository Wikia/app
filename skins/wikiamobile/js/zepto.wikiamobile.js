(function( $ ){
		
  $.fn.contents = function() {
		
		return this[0].childNodes;
  };
  
})( Zepto );

Zepto.getSassCommonURL = function( scssFilePath, params ) {
	return wgCdnRootUrl + wgAssetsManagerQuery.replace('%1$s', 'sass').replace('%4$d', wgStyleVersion).replace('%3$s', escape($.param(params ? params : sassParams))).replace('%2$s', scssFilePath);
}

Zepto.getScript = function( resource, onComplete ) {
	var scriptElement = document.createElement( 'script' );
	scriptElement.src = resource;
	scriptElement.onload = onComplete;
	document.head.appendChild( scriptElement );
};

Zepto.getCSS = function( resource, onComplete ) {
	var styleElement = document.createElement( 'link' );
	styleElement.type = "text/css";
	styleElement.href = resource;
	styleElement.rel = "stylesheet";
	styleElement.onload = onComplete;
	document.head.appendChild( styleElement );
};

Zepto.getResources = function( resources, callback ) {
	var isJs = /.js(\?(.*))?$/,
		isCss = /.css(\?(.*))?$/,
		isSass = /.scss/,
		remaining = length = resources.length;

	var onComplete = function() {
		--remaining;
		// all files have been downloaded
		if (remaining == 0) {
			if (typeof callback == 'function') {
					console.log(callback);
				callback();
			}
		}
	};
	
	// download files
	for ( var n = 0; n < length; n++ ) {
		var resource = resources[n];
		if ( isJs.test( resource ) ) {
			$.getScript( resource, onComplete );
		}
		else if ( isCss.test( resource ) || isSass.test( resource ) ) {
			$.getCSS( resource, onComplete );
		}
	};
};