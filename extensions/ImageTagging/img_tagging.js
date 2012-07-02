var kBoxRatio = .28;
var kBoxMinDim = 84;
var kBoxBorderWidth = 4;

var tagStatusDiv = null;
var tagEditFieldDiv = null;
var tagBoxDiv = null;
var tagBoxInnerDiv = null;
var imageElem = null;
var taggingBusy = false;

var kMessageAddingTag = 'addingtagmessage';
var kMessageRemovingTag = 'removingtagmessage';
var kMessageAddTagSuccess = 'addtagsuccessmessage';
var kMessageRemoveTagSuccess = 'removetagsuccessmessage';
var kMessageOneActionAtATime = 'oneactionatatimemessage';
var kMessageCantEditNeedLogin = 'canteditneedloginmessage';
var kMessageCantEditOther = 'canteditothermessage';
var kMessageOneUniqueTag = 'oneuniquetagmessage';

function gid( id ) {
	return document.getElementById( id );
}

function setupImageTagging() {
	var imgDiv = gid( 'file' );
	imgDiv.onclick = function( e ) {

		if ( !e ) {
			var e = window.event;
		}
		//var tg = (window.event) ? e.srcElement : e.target;
		//if (tg.nodeName != 'DIV') return;

		// Mouseout took place when mouse actually left layer
		var imgDivAbsLoc = getElemAbsPosition( imgDiv );

		clickAt( e.clientX - imgDivAbsLoc.x, e.clientY - imgDivAbsLoc.y );

		if( e.preventDefault ) {
			e.preventDefault();
		} else {
			e.returnResult = false;
		}

		if( e.stopPropagation ) {
			e.stopPropagation();
		} else {
			e.cancelBubble = true;
		}
	};
}

function tearDownImageTagging() {
	var imgDiv = gid( 'file' );

	imgDiv.onclick = function( e ) {
		e.stopPropagation();
		e.preventDefault();
	}
}

function addImageTags() {
	if ( gid( 'canEditPage' ) == null ) { /* page isn't editable */
		var result = false;

		if ( gid( 'userLoggedIn' ) == null ) {
			result = confirm( gid( kMessageCantEditNeedLogin ).value );
		} else {
			alert( gid( kMessageCantEditOther ).value );
		}

		if ( result ) {
			var articleName = gid( 'imgName' ).value;

			var loginPageURL = 'http://' + domain;
			if ( articleName && articleName.length > 0 ) {
				loginPageURL += wgScriptPath + '/index.php?title=Special:UserLogin&returnto=Image:' + articleName;
			} else {
				loginPageURL += wgScriptPath + '/Special:UserLogin';
			}

			window.location.href = loginPageURL;
		}

		return;
	}

	if ( !tagStatusDiv ) {
		tagStatusDiv = document.getElementById( 'tagStatusDiv' );

		var bodyContent = gid( 'bodyContent' ) || gid( 'content') || document;
		bodyContent.insertBefore( tagStatusDiv, gid( 'file' ) );
	}

	tagStatusDiv.style.display = 'block';
	setupImageTagging();
}

function doneAddingTags() {
	tagStatusDiv.style.display = 'none';
	hideTagBox();
	tearDownImageTagging();
}

function typeTag( event ) {
	//suggestKeyDown( event );
	/*switch ( event.keyCode ) {
		case 13: // return
		case 3: // enter
			submitTag();
			break;
		default:
			suggestKeyDown( event );
			break;
	}*/
}

function createRequest() {
	if ( taggingBusy ) {
		alert( gid( kMessageOneActionAtATime ).value );
		return null;
	}

	var request = null;
	try {
		request = new XMLHttpRequest();
	} catch ( trymicrosoft ) {
		try {
			request = new ActiveXObject( 'Msxml2.XMLHTTP' );
		} catch ( othermicrosoft ) {
			try {
				request = new ActiveXObject( 'Microsoft.XMLHTTP' );
			} catch ( failed ) {
				request = null;
			}
		}
	}

	if ( !request ) {
		alert( 'Error initializing XMLHttpRequest in img_tagging.js!' );
	}

	return request;
}

function setTaggingStatus( msg, busy ) {
	gid( 'progress_wheel' ).style.display = busy ? 'block' : 'none';
	gid( 'tagging_message' ).innerHTML = gid( msg ).getAttribute( 'value' );
}

function submitTag() {
	var tagValue = gid( 'articleTag' ).value;
	// if tag already exists
	if ( gid( tagValue + '-tag' ) != null ) {
		alert( gid( kMessageOneUniqueTag ).value );
		return null;
	}

	var request = createRequest();
	if ( request ) {
		taggingBusy = true;

		var imgValue = gid( 'imgName' ).value;
		var url = '?action=addTag';
		var args = 'rect=' + getStringTagRect() + '&imgName=' +
			escape( imgValue ) + '&tagName=' +
			encodeURIComponent( tagValue ) +
			'&wpEditToken=' + gid( 'wpEditToken' ).value;
		request.open( 'GET', url + '&' + args, true );
		request.onload = function( e ) {
			if ( request && request.responseText ) {
				gid( 'tagListDiv' ).innerHTML = request.responseText;

				setTaggingStatus( kMessageAddTagSuccess, false );
				taggingBusy = false;
			}
		};

		//alert("adding tag with name: " + tagValue + ", rectStr: " + getStringTagRect() + ", imgName: " + imgValue + ", and maybe editToekn: " + gid('wpEditToken').value);
		request.send( null );
		setTaggingStatus( kMessageAddingTag, true );
		hideTagBox();
	}
}

function removeTag( tagID, elem, tagValue ) {
	var request = createRequest();
	if ( request ) {
		taggingBusy = true;

		var url = '?action=removeTag';
		var args = 'rect=' + getStringTagRect() + '&tagID=' + tagID +
			'&imgName=' + escape( gid( 'imgName' ).value ) +
			'&tagName=' + encodeURIComponent( tagValue );
		request.open( 'GET', url + '&' + args, true );
		request.onload = function( e ) {
			if ( request && request.responseText ) {
				//alert("removeTag response: " + request.responseText);
				gid( 'tagListDiv' ).innerHTML = request.responseText;
				hideTagBox();

				taggingBusy = false;
			}
		};
		request.send( null );

		var removeTagMsg = gid( kMessageRemovingTag ).getAttribute( 'value' );
		elem.setAttribute( 'onclick', null );
		elem.innerHTML = '&nbsp;' + removeTagMsg;

		if ( elem.parentNode ) {
			var progressElem = document.createElement( 'img' );
			progressElem.src = gid( 'imgPath' ).value + '/progress-wheel.gif';
			progressElem.setAttribute( 'style', 'vertical-align: bottom;' );
			elem.parentNode.insertBefore( progressElem, elem );
		}
	}
}

function getStringTagRect() {
	var tagBoxFrame = getElemFrame( tagBoxDiv, true );
	var imgDivFrame = getElemAbsPosition( gid( 'file' ) );
	var imgFrame = getImgFrame( findChild( gid( 'file' ), 'img' ) );

	//alert("getStringTagRect, tagBoxFrame: " + tagBoxFrame.x + ", " + tagBoxFrame.y + ", w/h: " + tagBoxFrame.width + ", " + tagBoxFrame.height + ", imgDivFrame: " + imgDivFrame.x + ", " + imgDivFrame.y + ", diff: " + (tagBoxFrame.x - imgDivFrame.x) + ", " + (tagBoxFrame.y - imgDivFrame.y) + ", imgFrame: " + imgFrame.width + ", " + imgFrame.height);

	tagBoxFrame.x = tagBoxFrame.x - imgDivFrame.x;
	tagBoxFrame.y = tagBoxFrame.y - imgDivFrame.y;

	var percentX = ( tagBoxFrame.x + tagBoxFrame.width / 2.0 ) / imgFrame.width;
	var percentY = ( tagBoxFrame.y + tagBoxFrame.height / 2.0 ) / imgFrame.height;

	//alert("percents " + percentX + ", " + percentY);

	return escape( percentX + ',' + percentY );
}

function tagBoxPercent( xPercent, yPercent, showEditUI ) {
	var imgRect = getImgFrame( findChild( gid( 'file' ), 'img' ) );
	tagBoxAt( xPercent * imgRect.width, yPercent * imgRect.height, showEditUI );
}

function tagBoxAt( boxCenterX, boxCenterY, showEditUI ) {
	var imgDiv = gid( 'file' );

	if ( !tagBoxDiv ) {
		tagBoxDiv = document.createElement( 'div' );
		tagBoxDiv.style.border = kBoxBorderWidth + 'px solid gray';
		tagBoxDiv.style.display = 'block';
		tagBoxDiv.style.position = 'absolute';

		tagBoxInnerDiv = document.createElement( 'div' );
		tagBoxInnerDiv.style.border = Math.floor( kBoxBorderWidth / 2.0 ) + 'px solid white';
		tagBoxInnerDiv.style.display = 'block';
		tagBoxInnerDiv.style.position = 'absolute';
		tagBoxInnerDiv.style.left = '0px';
		tagBoxInnerDiv.style.top = '0px';

		tagBoxDiv.appendChild( tagBoxInnerDiv );
		imgDiv.appendChild( tagBoxDiv );
	}

	var imgRect = getImgFrame( findChild( gid( 'file' ), 'img' ) );
	var boxDim = kBoxRatio * Math.min( imgRect.width, imgRect.height );
	if ( boxDim < kBoxMinDim ) {
		boxDim = kBoxMinDim;
	}

	var boxX = boxCenterX - boxDim / 2.0;
	var boxY = boxCenterY - boxDim / 2.0;
	if ( boxX + boxDim >= imgRect.width ) {
		boxX = imgRect.width - boxDim;
	}
	if ( boxX <= 0 ) {
		boxX = 0;
	}
	if ( boxY + boxDim >= imgRect.height ) {
		boxY = imgRect.height - boxDim;
	}
	if ( boxY <= 0 ) {
		boxY = 0;
	}

	boxX += imgDiv.offsetLeft;
	boxY += imgDiv.offsetTop;

	boxCenterX = boxX + boxDim / 2.0;
	boxCenterY = boxY + boxDim / 2.0;

	setTagBoxRect( boxX, boxY, boxDim, boxDim );
	tagBoxDiv.style.display = 'block';

	if ( !tagEditFieldDiv ) {
		tagEditFieldDiv = gid( 'tagEditField' );
	}

	if ( showEditUI ) {
		var tagEditFrame = getElemFrame( tagEditFieldDiv );
		setElemPosition(
			tagEditFieldDiv,
			boxCenterX - tagEditFrame.width / 2.0,
			boxCenterY + boxDim / 2.0 + 10
		);

		if ( tagEditFieldDiv.style.display != 'block' ) {
			gid( 'articleTag' ).value = '';
		}
		tagEditFieldDiv.style.display = 'block';

		gid( 'articleTag' ).focus();
	}
}

function clickAt( xLocation, yLocation ) {
	if ( !imageElem ) {
		var imgFileDiv = gid( 'file' );
		imageElem = findChild( imgFileDiv, 'img' );
	}

	var imgRect = getImgFrame( findChild( gid( 'file' ), 'img' ) );
	tagBoxPercent( xLocation / imgRect.width, yLocation / imgRect.height, true );
}

function setElemFrame( elem, newFrame ) {
	setElemPosition( elem, newFrame.x, newFrame.y );
	elem.style['width'] = newFrame.width + 'px';
	elem.style['height'] = newFrame.height + 'px';
}

function setElemRect( elem, x, y, width, height ) {
	setElemFrame( elem, { x: x, y: y, width: width, height: height} );
}

function setElemPosition( elem, x, y ) {
	elem.style['left'] = x + 'px';
	elem.style['top'] = y + 'px';
}

function getImgFrame( img ) {
	return { x: 0, y: 0, width: img.width, height: img.height };
}

function getElemAbsPosition( elem ) {
	var curleft = 0, curtop = 0;
	var obj = elem;
	if ( obj.offsetParent ) {
		while ( obj.offsetParent ) {
			curleft += obj.offsetLeft;
			curtop += obj.offsetTop;
			obj = obj.offsetParent;
		}
	} else if ( obj.y ) {
		curtop += obj.y;
		curleft += obj.x;
	}

	return { x: curleft, y: curtop };
}

function getElemFrame( elem, globalPos ) {
	var style = elem.style;
	var x, y, width, height;

	if ( elem == document ) {
		x = 0;
		y = 0;
		width = window.width;
		height = window.height;
	} else {
		if ( globalPos ) {
			var t = getElemAbsPosition( elem );
			x = t.x;
			y = t.y;
		} else {
			x = parseFloat( style['left'] );
			y = parseFloat( style['top'] );
		}

		width = parseFloat( style['width'] );
		height = parseFloat( style['height'] );
	}

	return { x: x, y: y, width: width, height: height };
}

function findChild( element, nodeName ) {
	var child;
	for ( child = element.firstChild; child != null; child = child.nextSibling ) {
		if ( child.nodeName.toLowerCase() == nodeName ) {
			return child;
		}
	}
	return null;
}

function setTagBoxRect( boxX, boxY, boxDim, boxDim ) {
	setElemRect( tagBoxDiv, boxX, boxY, boxDim, boxDim );
	setElemRect( tagBoxInnerDiv, 0, 0, boxDim - kBoxBorderWidth, boxDim - kBoxBorderWidth );
}

function hideTagBox() {
	tagBoxDiv.style.display = 'none';
	gid( 'tagEditField' ).style.display = 'none';
}

function tagUIVisible() {
	return ( tagBoxDiv.style.display != 'none' );
}

function focusInstructions() {
	window.location.hash = 'tagging_instructions';
}

function imageMouseUp() {
	if ( tagging ) {
		gid( 'name' ).focus();
		gid( 'name' ).select();
	}
}

function imageMouseDown( event, image, tagsID ) {
	if ( tagging ) {
		activeImageMouseX = mousePosX( event ) - findX( image );
		activeImageMouseY = mousePosY( event ) - findY( image );

		updateFrame( image, activeImageMouseX, activeImageMouseY );
		return false;
	}
}

function frameMouseDown( event ) {
	if ( tagging ) {
		image = ge( 'myphoto' );
		activeImageMouseX = mousePosX( event ) - findX( image );
		activeImageMouseY = mousePosY( event ) - findY( image );
		updateFrame( image, activeImageMouseX, activeImageMouseY );
	}
}

function frameMouseUp() {
	if ( tagging ) {
		gid( 'name' ).focus();
		gid( 'name' ).select();
	}
}