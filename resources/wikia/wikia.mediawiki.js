(function( mw, $) {

	if ( mw.loader && typeof mw.loader.use == 'undefined' ) {
	    mw.loader.use = function( modules ) {
	        var deferred = $.Deferred();
	        try {
	            mw.loader.using(modules, function() {
	                deferred.resolve();
	            }, function() {
	                deferred.reject();
	            });
	        } catch (e) {
	            mw.log(e.toString());
	            deferred.reject();
	        }
	        return deferred.promise();
	    }
	}

})(window.mediaWiki, jQuery);