/**
 * Position fixed availability for mobile platforms
 * @see https://github.com/jquery/jquery-mobile/blob/master/js/jquery.mobile.fixedToolbar.js
 *
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
Features.addTest('positionfixed', function(){
	var ua = navigator.userAgent,
		platform = navigator.platform,
		//Rendering engine is Webkit, and capture major version
		wkmatch = ua.match( /AppleWebKit\/([0-9]+)/ ),
		wkversion = !!wkmatch && wkmatch[ 1 ],
		ffmatch = ua.match( /Fennec\/([0-9]+)/ ),
		ffversion = !!ffmatch && ffmatch[ 1 ],
		operammobilematch = ua.match( /Opera Mobile\/([0-9]+)/ ),
		omversion = !!operammobilematch && operammobilematch[ 1 ],
		w = window;

	return !( //this ! is intended here as logic is inverted it finds browsers with no positionfixed support
	// iOS 4.3 and older : Platform is iPhone/Pad/Touch and Webkit version is less than 534 (ios5)
		( ( platform.indexOf( "iPhone" ) > -1 || platform.indexOf( "iPad" ) > -1  || platform.indexOf( "iPod" ) > -1 ) && wkversion && wkversion < 534 )
			||
			// Opera Mini
			( w.operamini && ({}).toString.call( w.operamini ) === "[object OperaMini]" )
			||
			( operammobilematch && omversion < 7458 )
			||
			//Android lte 2.1: Platform is Android and Webkit version is less than 534 (Android 2.2)
			( ua.indexOf( "Android" ) > -1 && wkversion && wkversion < 534 )
			||
			// Firefox Mobile before 6.0 -
			( ffversion && ffversion < 6 )
			||
			// WebOS less than 3
			( "palmGetResource" in window && wkversion && wkversion < 534 )
		);
});