var Orientation = Orientation || {};

(function() {
		
	LANDSCAPE = 'landscape',
	PORTRAIT = 'portrait',
	windowOrientation = 0,
	capable = null,
	func = null;
	
	function orientationChange() {
		window.addEventListener( "orientationchange", function() {
		    windowOrientation = window.orientation;
		    func();
		}, false);
	};
	
	function resize() {
		window.addEventListener( "resize", function() {
		   calculateOrientation( Orientation.getWidth() , Orientation.getHeight() );
		   func();
		}, false);
	};
	
	function calculateOrientation( screenWidth, screenHeight ) {
		if ( screenWidth >= screenHeight ) {
			windowOrientation = 90;
		} else {
			windowOrientation = 0;
		}
	};
	
	function setValues() {
		capable = "onorientationchange" in window;
		if( capable ) {
			windowOrientation = window.orientation;
		} else {
		   calculateOrientation( Orientation.getWidth() , Orientation.getHeight() );
		}
	};
	
	Orientation = {
		bindEventListener: function( callBack ){
			capable = "onorientationchange" in window;
			func = callBack;
			if ( capable ) {
				orientationChange();
			} else {
				resize();
			}
		},
		
		getOrientationDegrees: function() {
			if( capable === null ) {
				setValues();
			}
			return windowOrientation;
		},
		
		getOrientation: function() {
			if( capable === null ) {
				setValues();
			}
			if( windowOrientation === 0 ) {
				return PORTRAIT;
			} else {
				return LANDSCAPE;
			}
		},
		
		getHeight: function() {
			if( window.innerHeight ) {
				return window.innerHeight;
			} else if( document.body.clientHeight ) {
				return document.body.clientHeight;
			} else if ( screen.height ) {
				//I don't use document.documentElement.­clientHeight as it is illegal call in i.e. Chrome
				//Therefore I fall back to screen.height
				return screen.height;
			}
		},
		
		getWidth: function() {
			if( window.innerWidth ) {
				return window.innerWidth;
			} else if( document.body.clientWidth ) {
				return document.body.clientWidth;
			} else if ( screen.width ) {
				//I don't use document.documentElement.­clientWidth as it is illegal call in i.e. Chrome
				//Therefore I fall back to screen.width
				return screen.width;
			}
		}
	}
})();