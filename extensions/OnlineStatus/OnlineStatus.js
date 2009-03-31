var OnlineStatusCreated = false;

function OnlineStatus(){
	var status = document.getElementById( 'pt-status' );
	if( typeof status == 'object' ){
		var link = status.firstChild;
		link.onmousedown = status.onkeypress = ShowOnlineToggle;
	}
}

function ShowOnlineToggle(){
	if( !OnlineStatusCreated ){
		var div = document.createElement( 'div' );
		div.id = 'online-status-js';
		div.className = 'online-status-js';

		// Taken from skins/common/mwsuggest.js of core
		// Credit: Robert Stojnić
		var left = 0;
		var top = this.offsetHeight;
		var elem = this;
		while( elem ){
			left += elem.offsetLeft;
			top += elem.offsetTop;
			elem = elem.offsetParent;
		}
		if( navigator.userAgent.indexOf( 'Mac' ) != -1 && typeof document.body.leftMargin != 'undefined' ){
			left += document.body.leftMargin;
			top += document.body.topMargin;
		}

		div.style.left = left + "px";
		div.style.top = top + "px";
		var table = document.createElement( 'table' );
		sajax_do_call( 'OnlineStatus::Ajax', ['get'], function( x ){
			if( x.status == 200 ){
				var resp = x.responseText;
				// A bit unsafe, but...
				var json = eval( resp );
				for( i = 0; i < json.length; i++ ){
					var status = json[i];
					var tr = document.createElement( 'tr' );
					var td = document.createElement( 'td' );
					if( status[2] ){
						td.appendChild( document.createTextNode( status[1] ) );
					} else {
						var a = document.createElement( 'a' );
						a.status = status[0];
						a.onmousedown = a.onkeypress = ChangeOnlineStatus;
						a.appendChild( document.createTextNode( status[1] ) );
						td.appendChild( a );
					}
					tr.appendChild( td );
					table.appendChild( tr );
				}
			}
		} );
		div.appendChild( table );
		div.visible = true;
		document.body.appendChild( div );
		OnlineStatusCreated = true;
	} else {
		var div = document.getElementById( 'online-status-js' );
		div.parentNode.removeChild( div );
		OnlineStatusCreated = false;
	}
}

function ChangeOnlineStatus(){
	var status = this.status;
	sajax_do_call( 'OnlineStatus::Ajax', ['set', status], function( x ){
		if( x.status == 200 ){
			var resp = x.responseText;
			jsMsg( resp, 'watch' );
			// Force update
			var div = document.getElementById( 'online-status-js' );
			div.parentNode.removeChild( div );
			OnlineStatusCreated = false;
		}
	} );
}

hookEvent( 'load', OnlineStatus );