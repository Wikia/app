var VideoTracker = {

	PROGRESS_ATTR: 'data-wikiaprogress',
	STARTED_ATTR: 'data-wikiastarted',
	PAUSED_ATTR: 'data-wikipaused',
	STATE_PLAY: 1,
	STATE_PAUSE: 2,
	STATE_FINISH: 0,
	videoList: [],
	trackingProgressPoints: [ 10, 20, 30, 40, 50, 60, 70, 80, 90, 100 ],

	init: function() {

		// identify number of YouTube Videos on page
		VideoTracker.videoList = $( "#WikiaArticle" ).find( "embed[src*=youtube]" ).each( function(){
			$( this ).attr( VideoTracker.PROGRESS_ATTR, 0 );
			$( this ).attr( VideoTracker.STARTED_ATTR, 0 );
			$( this ).attr( VideoTracker.PAUSED_ATTR, 0 );
			this.addEventListener( 'onStateChange', 'VideoTracker.statusChangeTracking' );
		});

		// add tracking if any video exist
		if ( VideoTracker.videoList.length > 0 ) {

			// progress tracking
			setInterval( VideoTracker.checkTime, 1000 );
		}
	},

	statusChangeTracking : function( playerState ){

		// state change tracking
		if ( playerState == VideoTracker.STATE_FINISH ){
			VideoTracker.track( '/action/finish' );
		}
		if ( playerState == VideoTracker.STATE_PLAY ){
			VideoTracker.track( '/action/continue' );
		}
		if ( playerState == VideoTracker.STATE_PAUSE ){
			VideoTracker.track( '/action/pause' );
		}
	},

	checkTime: function() {

		VideoTracker.videoList.each( function(){

			var currentTime = this.getCurrentTime();
			var totallTime = this.getDuration();

			if ( this.getPlayerState() == VideoTracker.STATE_PLAY ){

				if ( ( ( totallTime * currentTime ) >= 1  )){

					var tempProgress = ( currentTime / totallTime * 100 );
					var currentProgress = $( this ).attr( VideoTracker.PROGRESS_ATTR );
					if ( tempProgress > currentProgress ){

						if ( $( this ).attr( VideoTracker.STARTED_ATTR ) == 0 ){
							$( this ).attr( VideoTracker.STARTED_ATTR, 1 );
							VideoTracker.track( '/action/start/first' );
						}

						$.each( VideoTracker.trackingProgressPoints, function( index, value ){
							if ( tempProgress >= value && currentProgress < value ){
								VideoTracker.track( '/progress/' + value );
							}
						});

						$(this).attr( VideoTracker.PROGRESS_ATTR, tempProgress );
					}
				}
			}
		});
	},

	track: function( fakeUrl ) {
		window.jQuery.tracker.byStr('VideoPlayer/' + wgDBname + '/' + wgTitle + fakeUrl);
	}
};

$(function() {
	VideoTracker.init();
});