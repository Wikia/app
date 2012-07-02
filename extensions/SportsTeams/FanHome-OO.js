/**
 * JavaScript support functions for Special:FanHome -- the network page for an
 * individual network
 *
 * Status update stuff is the same that can be found at
 * /extensions/UserStatus/UserStatus.js, but in addition to that code, there's
 * also some code for Google Maps integration.
 *
 * @file
 */
var FanHome = {
	posted: 0,

	voteStatus: function( id, vote ) {
		var elem = document.getElementById( 'user-status-vote-' + id );
		sajax_request_type = 'POST';
		sajax_do_call( 'wfVoteUserStatus', [ id, vote ], elem );
	},

	/**
	 * Detect whether the enter key was pressed and if so, submit the status
	 * update.
	 *
	 * @param e Event
	 * @return Boolean: false if enter was pressed and the status update was
	 *                  added, true in most other cases
	 */
	detEnter: function( e ) {
		var keycode;
		if ( window.event ) {
			keycode = window.event.keyCode;
		} else if ( e ) {
			keycode = e.which;
		} else {
			return true;
		}
		if ( keycode == 13 ) {
			FanHome.addStatus();
			return false;
		} else {
			return true;
		}
	},

	addStatus: function() {
		var statusUpdateText = document.getElementById( 'user_status_text' ).value;
		if( statusUpdateText && !FanHome.posted ) {
			FanHome.posted = 1;

			sajax_request_type = 'POST';
			sajax_do_call(
				'wfAddUserStatusNetwork',
				[
					__sport_id__,
					__team_id__,
					encodeURIComponent( statusUpdateText ),
					__updates_show__
				],
				function( t ) {
					document.getElementById( 'network-updates' ).innerHTML = t.responseText;
					FanHome.posted = 0;
					document.getElementById( 'user_status_text' ).value = '';
				}
			);
		}
	},

	deleteMessage: function( id ) {
		if( confirm( 'Are you sure you want to delete this thought?' ) ) {
			sajax_request_type = 'POST';
			sajax_do_call( 'wfDeleteUserStatus', [ id ], function( t ) {
				//window.location = __user_status_link__;
				// Just remove the DOM node, no need to take the user to
				// Special:UserStatus, IMO
				// I wanted to use .remove() here to remove the DOM node too,
				// but I couldn't figure out how to do the animation to hide
				// the status message and *after* that remove the node.
				// Oh well, I suppose it doesn't matter too much because after
				// the call to wfDeleteUserStatus, the message is gone. (-;
				jQuery( 'span#user-status-vote-' + id ).parent().parent()
					.parent().hide( 1000 );
			});
		}
	},

	/**
	 * Generates markers for the higher zoom levels
	 */
	createTopMarker: function( point, caption, map ) {
		var marker = new GMarker( point );
		marker.map = map;

		jQuery( marker ).bind( 'mouseover', function() {
			var bb = this.map.getBounds();

			// if the point isn't visible in the map don't do anything
			if( !bb.contains( this.getPoint() ) ) {
				return;
			}

			// if the point is visible:
			// figure out the relative offset for the div and then pop it up
			var baseMapCoords = this.map.fromContainerPixelToLatLng( new GPoint( 0, 0 ), true );
			var baseDivPix = this.map.fromLatLngToDivPixel( baseMapCoords );
			var placemarkDivPix = this.map.fromLatLngToDivPixel( this.getPoint() );
			var c = new GPoint(
				placemarkDivPix.x - baseDivPix.x,
				placemarkDivPix.y-baseDivPix.y
			);

			var divLeft = c.x - 230 + 'px';
			var divTop = c.y - 105 + 'px';

			var gMapInfoElem = document.getElementById( 'gMapInfo' );
			gMapInfoElem.innerHTML = caption;

			gMapInfoElem.style.display = 'block';
			gMapInfoElem.style.left = divLeft;
			gMapInfoElem.style.top = divTop;
		});

		// hide the div on mouseout
		jQuery( marker ).bind( 'mouseout', function() {
			document.getElementById( 'gMapInfo' ).style.display = 'none';
		});

		// onClick - pan+zoom the map onto this marker
		jQuery( marker ).bind( 'click', function() {
			document.getElementById( 'gMapInfo' ).style.display = 'none';
			this.map.setCenter( this.getPoint(), 7 );
		});

		return marker;
	},

	// generates an icon for the current team/network
	getTeamIcon: function() {
		var icon = new GIcon();
		var iconImage = new Image();

		iconImage.src = "'" + __team_image__ + "'";

		// probably should fix this:
		// there should be an actual error when Image() fails
		if( iconImage.height <= 0 ) {
			return G_DEFAULT_ICON;
		}

		icon.image = "'" + __team_image__ + "'";

		// once we get shadows un-comment this and set the right shadow
		/* icon.shadow = 'http://www.eecs.tufts.edu/~adatta02/shadow-34_l.png';
		icon.shadowSize = new GSize( 100, 50 ); */

		icon.iconSize = new GSize( 50, ( 50 * iconImage.height ) / iconImage.width );
		icon.iconAnchor = new GPoint( 50, ( 50 * iconImage.height ) / iconImage.width >> 1 );

		return icon;
	},

	// generates markers for individual users
	createMarker: function( point, caption, URL, map ) {
		var marker = new GMarker( point, { icon: FanHome.getTeamIcon() } );
		marker.map = map;
		marker.url = URL;

		// just in case
		caption = caption.replace( /<script>/i, 'script' );

		jQuery( marker ).bind( 'mouseover', function() {
			var bb  = this.map.getBounds();

			// if the point isn't visible, just exit
			if( !bb.contains( this.getPoint() ) ) {
				return;
			}

			// figure out where to offset the info-div
			var baseMapCoords = this.map.fromContainerPixelToLatLng(
				new GPoint( 0, 0 ),
				true
			);
			var baseDivPix = this.map.fromLatLngToDivPixel( baseMapCoords );
			var placemarkDivPix = this.map.fromLatLngToDivPixel( this.getPoint() );
			var c = new GPoint(
				placemarkDivPix.x - baseDivPix.x,
				placemarkDivPix.y - baseDivPix.y
			);

			var divLeft = c.x - 260 + 'px';
			var divTop = c.y - 110 + 'px';

			var gMapInfoElem = document.getElementById( 'gMapInfo' );
			gMapInfoElem.innerHTML = caption;

			gMapInfoElem.style.display = 'block';
			gMapInfoElem.style.left = divLeft;
			gMapInfoElem.style.top = divTop;
		});

		// when the icon is clicked, load the fan's profile page
		jQuery( marker ).bind( 'click', function() {
			window.location = this.url;
		});

		// hide the info-div on mouse-out
		jQuery( marker ).bind( 'mouseout', function() {
			document.getElementById( 'gMapInfo' ).style.display = 'none';
		});

		return marker;
	}
};