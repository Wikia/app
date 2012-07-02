/**
 * this is a progress bar for monitoring multiple objects, giving summary view
 */
mw.GroupProgressBar = function( selector, text, uploads, successStates, errorStates, progressProperty, weightProperty ) {
	var _this = this;

	// XXX need to figure out a way to put text inside bar
	_this.$selector = $j( selector );
	_this.$selector.html( 
		'<div class="mwe-upwiz-progress">'
		+   '<div class="mwe-upwiz-progress-bar-etr-container">'
		+     '<div class="mwe-upwiz-progress-bar-etr" style="display: none">'
		+       '<div class="mwe-upwiz-progress-bar"></div>'
		+       '<div class="mwe-upwiz-etr"></div>'
		+     '</div>'
		+   '</div>'
		+   '<div class="mwe-upwiz-count"></div>'
		+ '</div>'
	);

	_this.$selector.find( '.mwe-upwiz-progress-bar' ).progressbar( { value : 0 } );

	_this.uploads = uploads;
	_this.successStates = successStates;
	_this.errorStates = errorStates;
	_this.progressProperty = progressProperty;
	_this.weightProperty = weightProperty;
	_this.beginTime = undefined;

};

mw.GroupProgressBar.prototype = {

	/**
	 * Show the progress bar 
         */
	showBar: function() {
		this.$selector.find( '.mwe-upwiz-progress-bar-etr' ).fadeIn( 200 );
	},

	/** 
	 * loop around the uploads, summing certain properties for a weighted total fraction
	 */
	start: function() {
		var _this = this;

		var totalWeight = 0.0;
		$j.each( _this.uploads, function( i, upload ) {
			totalWeight += upload[_this.weightProperty];
		} );

		_this.setBeginTime();
		var shown = false;

		var displayer = function() {	
			var fraction = 0.0;
			var successStateCount = 0;
			var errorStateCount = 0;
			var hasData = false;
			$j.each( _this.uploads, function( i, upload ) {
				if ( $j.inArray( upload.state, _this.successStates ) !== -1 ) {
					successStateCount++;
				}
				if ( $j.inArray( upload.state, _this.errorStates ) !== -1 ) {
					errorStateCount++;
				}
				if (upload[_this.progressProperty] !== undefined) {
					fraction += upload[_this.progressProperty] * ( upload[_this.weightProperty] / totalWeight );
					if (upload[_this.progressProperty] > 0 ) {
						hasData = true;
					}
				}
			} );

			// sometimes, the first data we have just tells us that it's over. So only show the bar
			// if we have good data AND the fraction is less than 1.
			if ( hasData && fraction < 1.0 ) {
				if ( ! shown ) {
					_this.showBar();
					shown = true;
				}
				_this.showProgress( fraction );
			}
			_this.showCount( successStateCount );

			if ( successStateCount + errorStateCount < _this.uploads.length ) {
				setTimeout( displayer, 200 );
			} else {
				_this.showProgress( 1.0 );
				setTimeout( function() { _this.hideBar(); }, 500 ); 
			}
		};
		displayer();
	},


	/**
	 * Hide the progress bar with a slideup motion
	 */
	hideBar: function() {
		this.$selector.find( '.mwe-upwiz-progress-bar-etr' ).fadeOut( 200 );
	},
	
	/**
	 * sets the beginning time (useful for figuring out estimated time remaining)
	 * if time parameter omitted, will set beginning time to now
	 *
	 * @param time  optional; the time this bar is presumed to have started (epoch milliseconds)
	 */ 
	setBeginTime: function( time ) {
		this.beginTime = time ? time : ( new Date() ).getTime();
	},


	/**
	 * Show overall progress for the entire UploadWizard
	 * The current design doesn't have individual progress bars, just one giant one.
	 * We did some tricky calculations in startUploads to try to weight each individual file's progress against 
	 * the overall progress.
	 * @param fraction the amount of whatever it is that's done whatever it's done
	 */
	showProgress: function( fraction ) {
		var _this = this;

		_this.$selector.find( '.mwe-upwiz-progress-bar' ).progressbar( 'value', parseInt( fraction * 100, 10 ) );

		var remainingTime = _this.getRemainingTime( fraction );
		
		if ( remainingTime !== null ) {
			var t = mw.seconds2Measurements( parseInt( remainingTime / 1000, 10 ) );
			var timeString;
			if (t.hours === 0) {
				if (t.minutes === 0) {
					if (t.seconds === 0) { 
						timeString = gM( 'mwe-upwiz-finished' );
					} else {
						timeString = gM( 'mwe-upwiz-secs-remaining', t.seconds );
					}
				} else {
					timeString = gM( 'mwe-upwiz-mins-secs-remaining', t.minutes, t.seconds );
				}
			} else {
				timeString = gM( 'mwe-upwiz-hrs-mins-secs-remaining', t.hours, t.minutes, t.seconds );
			}
			_this.$selector.find( '.mwe-upwiz-etr' ).html( timeString );
		}
	},

	/**
	 * Calculate remaining time for all uploads to complete.
	 * 
	 * @param fraction	fraction of progress to show
	 * @return 		estimated time remaining (in milliseconds)
	 */
	getRemainingTime: function ( fraction ) {
		var _this = this;
		if ( _this.beginTime ) {
			var elapsedTime = ( new Date() ).getTime() - _this.beginTime;
			if ( fraction > 0.0 && elapsedTime > 0 ) { // or some other minimums for good data
				var rate = fraction / elapsedTime;
				return parseInt( ( 1.0 - fraction ) / rate, 10 ); 
			}
		}
		return null;
	},


	/**
	 * Show the overall count as we upload
	 * @param count  -- the number of items that have done whatever has been done e.g. in "uploaded 2 of 5", this is the 2
	 */
	showCount: function( count ) {
		var _this = this;
		_this.$selector
			.find( '.mwe-upwiz-count' )
			.html( gM( 'mwe-upwiz-upload-count', [ count, _this.uploads.length ] ) );
	}


};


