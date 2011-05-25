/**
 * Javascript code to be used with extension SemanticForms for popup forms.
 *
 * @author Stephan Gambke
 *
 */

// initialise 
jQuery(function(){

	// register eventhandlers on 'edit' links and buttons

	// register formlink with link
	jQuery('a.popupformlink').click(function(evt){
		return ext.popupform.handlePopupFormLink( this.getAttribute('href'), this );
	});

	// register formlink with button
	jQuery( 'form.popupformlink[method!="post"] input' ).each(function() {
		
		var input = jQuery(this);

		// Yay, IE 4 lines, FF 0 lines
		var target = String (this.getAttribute("onclick"));
		var start = target.indexOf("window.location.href='") + 22;
		var stop = target.indexOf("'", start);
		target = target.substring( start, stop );

		input.data( "target", target ) // extract link target from event handler
		.attr( "onclick", null ) // and remove event handler
		.click( function( evt ){
			return ext.popupform.handlePopupFormLink( jQuery( this ).data( "target" ), this);
		});
	})

	// register formlink with post button
	jQuery( 'form.popupformlink[method="post"]' ).submit(function(evt){
		return ext.popupform.handlePopupFormLink( this.getAttribute( 'action' ), this );
	});


	// register forminput
	jQuery( 'form.popupforminput' ).submit(function(evt){
		return ext.popupform.handlePopupFormInput( this.getAttribute( 'action' ), this );
	});

});

// create ext if it does not exist yet
if ( typeof( window[ 'ext' ] ) == "undefined" ) {
	window[ 'ext' ] = {};
}

window.ext.popupform = new function() {

	var wrapper;
	var background;
	var container;
	var innerContainer;
	var iframe;
	var content;
	var waitIndicator;
	var instance = 0;

	var doc;

	var brokenBrowser, brokenChrome;

	var padding = 20;

	function handlePopupFormInput( ptarget, elem ) {

		showForm();

		iframe.one( 'load', function(){
			// attach event handler to iframe
			iframe.bind( 'load', handleLoadFrame );
			return false;
		})

		elem.target = 'popupform-iframe' + instance;
		return true;
	}

	function handlePopupFormLink( ptarget, elem ) {

		showForm();

		// attach event handler to iframe
		iframe.bind( 'load', handleLoadFrame );

		if ( elem.tagName == 'FORM' ) {

			elem.target = 'popupform-iframe' + instance;
			return true;
			
		} else {

			var delim = ptarget.indexOf( '?' );
			var form = document.createElement("form");

			form.target = 'popupform-iframe' + instance;

			// Do we have parameters?
			if ( delim > 0 ) {
				form.action = ptarget.substr( 0, delim );
				var params = String( ptarget.substr( delim + 1 ) ).split("&");
				for ( var i = 0; i < params.length; ++i ) {

					var input = document.createElement("input");
					var param = String( params[i] ).split('=');
					input.type = 'hidden';
					input.name = decodeURIComponent( param[0] );
					input.value = decodeURIComponent( param[1] );
					form.appendChild( input );
					
				}
			} else {
				form.action = ptarget;
			}

			document.getElementsByTagName('body')[0].appendChild(form);
			form.submit();
			document.getElementsByTagName('body')[0].removeChild(form);

			return false;
		}
	}

	function showForm() {

		instance++;

		brokenChrome =
		( navigator.userAgent.indexOf("Chrome") >= 0 &&
			navigator.platform.indexOf("Linux x86_64") >= 0 );

		brokenBrowser= jQuery.browser.msie || brokenChrome;

		var maxZIndex = 0;

		jQuery("*").each(function() {
			var curr = parseInt( jQuery( this ).css( "z-index" ) );
			maxZIndex = curr > maxZIndex ? curr : maxZIndex;
		});


		wrapper = jQuery( "<div class='popupform-wrapper' >" );
		background = jQuery( "<div class='popupform-background' >" );

		var waitIndicatorWrapper = jQuery(  "<div class='popupform-loading'>" );

		waitIndicator = jQuery(  "<div class='popupform-loadingbg'></div><div class='popupform-loadingfg'></div>" );

		var anchor = jQuery( "<div class='popupform-anchor' >" );

		container = jQuery( "<div class='popupform-container' >" );
		innerContainer = jQuery( "<div class='popupform-innercontainer' >" );
		iframe = jQuery( "<iframe class='popupform-innerdocument' name='popupform-iframe" + instance + "' id='popupform-iframe" + instance + "' >");

		var closeBtn = jQuery( "<div class='popupform-close'></div> " );

		// initially hide background and waitIndicator
		if (brokenChrome) background.css("background", "transparent");
		else background.css("opacity", 0.0);

		waitIndicator.hide();
		container.hide()

		// insert background and wait indicator into wrapper and all into document
		waitIndicatorWrapper
		.append( waitIndicator );

		innerContainer
		.append( iframe );

		container
		.append( closeBtn )
		.append( innerContainer );

		anchor
		.append(container);

		wrapper
		.css( "z-index", maxZIndex + 1 )
		.append( background )
		.append( waitIndicatorWrapper )
		.append( anchor )
		.appendTo( "body" );

		// fade background in
		if ( !brokenChrome ) background.fadeTo( 400, 0.3 );
		fadeIn( waitIndicator );

		// attach event handler to close button
		closeBtn.click( handleCloseFrame );

	}

	function handleLoadFrame( event ){
		
		var iframe = jQuery( event.target );
		var iframecontents = iframe.contents();
		
		if ( brokenChrome ) container[0].style.visibility = "hidden";
		else container[0].style.opacity = 0;

		container.show();

		// GuMaxDD has #content but keeps headlines in #gumax-content-body
		content = iframecontents.find("#gumax-content-body");

		// normal skins use #content (e.g. Vector, Monobook)
		if ( content.length == 0 ) content = iframecontents.find("#content");

		// some skins use #mw_content (e.g. Modern)
		if ( content.length == 0 ) content = iframecontents.find("#mw_content");

		// this is not a normal MW page (or it uses an unknown skin)
		if ( content.length == 0 ) content = iframecontents.find("body");

		// the huge left margin looks ugly in Vector, reduce it
		// (How does this look for other skins?)
		var siblings = content
		.css( {
			margin: 0,
			padding: padding,
			width: "auto",
			height: "auto",
			minWidth: "0px",
			minHeight:"0px",
			overflow: "visible",
			position: "absolute",
			top: "0",
			left: "0",
			border: "none"
		} )
		.parents().css( {
			margin: 0,
			padding: 0,
			width: "auto",
			height: "auto",
			minWidth: "0px",
			minHeight:"0px",
			overflow: "visible",
			background: "transparent"
		})
		.andSelf().siblings();

		if ( jQuery.browser.msie && jQuery.browser.version < "8" ) {
			siblings.hide();
		} else {
			siblings
			.each( function(){
				var elem = jQuery(this);

				// TODO: Does this really help?
				if ( getStyle(this, "display") != "none"
					&& ( getStyle( this, "width") != "0px" || getStyle( this, "height") != "0px" )
					&& ! (
						( this.offsetLeft + elem.outerWidth(true) < 0 ) ||		// left of document
						( this.offsetTop + elem.outerHeight(true) < 0 )  || // above document
						( this.offsetLeft > 100000 ) ||		// right of document
						( this.offsetTop > 100000 )  // below document
						)
					) {

					jQuery(this).hide();
				//					css({
				//						height : "0px",
				//						width : "0px",
				//						minWidth : "0px",
				//						minHeight : "0px",
				//						margin : "0px",
				//						padding : "0px"
				//						border : "none",
				//						overflow: "hidden"
				//					//position: "static"
				//					});
				}
				if ( ( this.offsetLeft + elem.outerWidth() < 0 ) ||
					( this.offsetTop + elem.outerHeight() < 0 )
					) {
					this.style.left = (-elem.outerWidth(true)) + "px";
					this.style.top = (-elem.outerHeight(true)) + "px";
				}
			});
		//.children().css("position", "static");
		}

		container.show();

		// adjust frame size to dimensions just calculated
		adjustFrameSize();

		// and attach event handler to adjust frame size every time the window
		// size changes
		jQuery( window ).resize( function() {
			adjustFrameSize();
		} );

		//interval = setInterval(adjustFrameSize, 100);

		var form = content.find("#sfForm");
		var innerwdw = window.frames['popupform-iframe' + instance];
		var innerJ = innerwdw.jQuery;

		if (form.length > 0) {

			var submitok = false;
			var innersubmitprocessed = false;

			// catch form submit event
			form
			.bind( "submit", function( event ){

				var interval = setInterval(function(){

					if ( innersubmitprocessed ) {
						clearInterval( interval );
						innersubmitprocessed = false;
						if ( submitok ) handleSubmitData( event );
					}

				}, 10)
				event.stopPropagation();
				return false;
				
			});

			// catch inner form submit event
			if ( innerJ ) {
				innerwdw.jQuery(form[0])
				.bind( "submit", function( event ) {
					submitok = event.result;
					innersubmitprocessed = true;
					return false;
				});
			} else {
				submitok = true;
				innersubmitprocessed = true;
			}
		}

		if (innerJ) {
			// FIXME: Why did I put this in?
			innerwdw.jQuery( innerwdw[0] ).unload(function (event) {
				return false;
			});
			
			//
			content.bind( 'click', function() {
				var foundQueue = false;
				innerJ('*', content[0]).each( function() {
					if ( innerJ(this).queue().length > 0 ) {
						foundQueue = true;
						innerJ(this).queue( function(){
							setTimeout( adjustFrameSize, 100, true );
							innerJ(this).dequeue();
						});
					}
				});
				if ( ! foundQueue ) {
					adjustFrameSize( true );
				}
				return true;
			});
		} else {
			content.bind( 'click', function() {
					adjustFrameSize( true );
			});
		}

		// find all links. Have to use inner jQuery so event.result below
		// reflects the result of inner event handlers. We (hopefully) come last
		// in the chain of event handlers as we only attach when the frame is
		// already completely loaded, i.e. every inner event handler is already
		// attached.
		var allLinks = (innerJ)?innerJ("a[href]"):jQuery("a[href]");

		// catch 'Cancel'-Link (and other 'back'-links) and close frame instead of going back
		var backlinks = allLinks.filter('a[href="javascript:history.go(-1);"]');
		backlinks.click(handleCloseFrame);

		// promote any other links to open in main window, prevent nested browsing
		allLinks
		.not('a[href*="javascript:"]') // scripted links
		.not('a[target]')              // targeted links
		.not('a[href^="#"]')           // local links
		.click(function(event){
			if ( event.result != false ) {  // if not already caught by somebody else
				closeFrameAndFollowLink( event.target.getAttribute('href') )
			}
			return false;
		});

		// finally show the frame
		fadeOut ( waitIndicator, function(){
			fadeTo( container, 400, 1 );
		});

		return false;
		
	}

	function handleSubmitData( event ){

		fadeOut( container, function() {
			fadeIn( waitIndicator );
		});

		var form = jQuery( event.target );
		var formdata = form.serialize() + "&wpSave=" + escape(form.find("#wpSave").attr("value"));

		// Send form data off. SF will send back a fake edit page
		//
		// Normally we should check this.action first and only if it is empty
		// revert to this.ownerDocument.URL. Tough luck, IE does not return an
		// empty action but fills in some bogus
		jQuery.post( event.target.ownerDocument.URL , formdata, handleInnerSubmit);

		return false;


		function handleInnerSubmit ( returnedData, textStatus, XMLHttpRequest ) {


			// find form in fake edit page
			var innerform = jQuery("<div>" + returnedData + "</div>").find("form");

			// check if we got an error page
			if ( innerform.length == 0 ) {

				form.unbind( event );

				var iframe = container.find("iframe");
				var doc = iframe[0].contentWindow || iframe[0].contentDocument;
				if (doc.document) {
					doc = doc.document;
				}

				doc.open();
				doc.write(returnedData);
				doc.close();

				return false;
			}

			// Send the form data off, we do not care for the returned data
			var innerformdata = innerform.serialize();
			jQuery.post( innerform.attr("action"), innerformdata );

			// build new url for outer page (we have to ask for a purge)

			var url = location.href;

			// does a querystring exist?
			var start = url.indexOf("action=");

			if ( start >= 0 ) {

				var stop = url.indexOf("&", start);

				if ( stop >= 0 ) url = url.substr( 0, start - 1 ) + url.substr(stop + 1);
				else url = url.substr( 0, start - 1 );

			}

			var form = jQuery('<form action="' + url + '" method="POST"><input type="hidden" name="action" value="purge"></form>')
			.appendTo('body');

			form
			.submit();

			fadeOut( container, function(){
				fadeIn( waitIndicator );
			});

			return false;

		}
	}

	function adjustFrameSize( animate ) {

		// set some inputs

		var oldFrameW = container.width();
		var oldFrameH = container.height();
		var oldContW = content.width();
		var oldContH = content.height();

		var availW = Math.floor( jQuery(window).width() * .8 );
		var availH = Math.floor( jQuery(window).height() * .8 );

		var emergencyW = Math.floor( jQuery(window).width() * .85 );
		var emergencyH = Math.floor( jQuery(window).height() * .85 );

		// FIXME: these might not be the true values
		var scrollW = 25;
		var scrollH = 25;


		// find the dimensions of the document

		var html = content.closest('html');

		var scrollTgt = html;
			
		if ( jQuery.browser.webkit || jQuery.browser.safari ) {
			scrollTgt = content.closest('body');
		}

		var scrollTop = scrollTgt.scrollTop()
		var scrollLeft = scrollTgt.scrollLeft();

		content
		.width( 'auto' )
		.height( 'auto' );

		// set max dimensions for layout of content
		iframe
		.width( emergencyW )
		.height( emergencyH );

		// get dimension values
		var docW = content.width();
		var docH = content.height();

		// set old dimensions for layout of content
		iframe
		.width( '100%' )
		.height( '100%' );

		content
		.width( oldContW )
		.height( oldContH );

		if ( jQuery.browser.msie ) {
			docW += 20;
			docH += 20;
		}

		var docpW = docW + 2 * padding;
		var docpH = docH + 2 * padding;

		// Flags

		var needsHScroll = docpW > emergencyW || ( docpW > emergencyW - scrollW && docpH > emergencyH );
		var needsVScroll = docpH > emergencyH || ( docpH > emergencyH - scrollH && docpW > emergencyW );

		var needsWStretch =
		( docpW > availW && docpW <= emergencyW ) && ( docpH <= emergencyH ) ||
		( docpW > availW - scrollW && docpW <= emergencyW - scrollW ) && ( docpH > emergencyH );

		var needsHStretch =
		( docpH > availH && docpH <= emergencyH ) && ( docpW <= emergencyW ) ||
		( docpH > availH - scrollH && docpH <= emergencyH - scrollH ) && ( docpW > emergencyW );

		// Outputs

		var frameW;
		var frameH;

		var contW;
		var contH;

		if ( needsWStretch ) {
			contW = docW;
			frameW = docpW;
		} else if ( docpW > availW ) { // form does not even fit with stretching
			contW = docW;
			frameW = availW;
		} else {
			//contW = Math.max( Math.min( 1.5 * docW, availW ), availW / 2 );
			contW = docW;
			frameW = docpW;
		}

		if ( needsVScroll ){
			frameW += scrollW;
		} else {
			scrollTop = 0;
		}

		if ( needsHStretch ) {
			contH = docH;
			frameH = docpH;
		} else if ( docpH > availH ) { // form does not even fit with stretching
			contH = docH;
			frameH = availH;
		} else {
			//contH = Math.min( 1.1 * docH, availH);
			contH = docH;
			frameH = docpH;
		}
		
		if ( needsHScroll ){
			frameH += scrollH;
		} else {
			scrollLeft = 0;
		}

		if ( frameW != oldFrameW || frameH != oldFrameH ) {

			if ( jQuery.browser.safari ) {
				html[0].style.overflow="hidden";
			} else {
				iframe[0].style.overflow="hidden";
			}

			if ( animate ) {

				content
				.width ( 'auto' )
				.height ( 'auto' );

				container.animate({
					width: frameW,
					height: frameH,
					top: Math.floor(( - frameH ) / 2),
					left: Math.floor(( - frameW ) / 2)
				}, {
					duration: 500,
					complete: function() {

						if ( jQuery.browser.safari ) {
							html[0].style.overflow="visible";
						} else if ( jQuery.browser.msie ) {
							iframe[0].style.overflow="auto";
						} else {
							iframe[0].style.overflow="visible";
						}

						if ( jQuery.browser.mozilla ) {
							content
							.width ( contW )
							.height ( contH );
						} else {
							content
							.width ( 'auto' )
							.height ( 'auto' );
						}
					}
				});

			} else {

				container
				.width( frameW )
				.height ( frameH );

				with ( container[0].style ) {
					top = (Math.floor(( - frameH ) / 2)) + "px";
					left = (Math.floor(( - frameW ) / 2)) + "px";
				}

				setTimeout(function(){

						if ( jQuery.browser.safari ) {
							html[0].style.overflow="visible";
						} else if ( jQuery.browser.msie ) {
							iframe[0].style.overflow="auto";
						} else {
							iframe[0].style.overflow="visible";
						}

				}, 100);

				if ( jQuery.browser.mozilla ) {
					content
					.width ( contW )
					.height ( contH );
				} else {
					content
					.width ( 'auto' )
					.height ( 'auto' );
				}

			}
		} else {
			content
			.width ( 'auto' )
			.height ( 'auto' );

			if ( jQuery.browser.safari ) { // Google chrome needs a kick

				// turn scrollbars off and on again to really only show them when needed
					html[0].style.overflow="hidden";

					setTimeout(function(){
						html[0].style.overflow="visible";
				}, 1);
			}
		}

		scrollTgt
		.scrollTop(Math.min(scrollTop, docpH - frameH))
		.scrollLeft(scrollLeft);

		return true;
	}

	function closeFrameAndFollowLink( link ){

		fadeOut( container, function(){
			fadeIn ( waitIndicator );
			window.location.href = link;
		});

	}

	function handleCloseFrame( event ){

		jQuery(window).unbind( "resize", adjustFrameSize )

		fadeOut( container, function(){
			background.fadeOut( function(){
				wrapper.remove();
			});
		});
		return false;
	}

	// Saw it on http://robertnyman.com/2006/04/24/get-the-rendered-style-of-an-element
	// and liked it
	function getStyle(oElm, strCssRule){
		var strValue = "";
		if(document.defaultView && document.defaultView.getComputedStyle){
			strValue = document.defaultView.getComputedStyle(oElm, "").getPropertyValue(strCssRule);
		}
		else if(oElm.currentStyle){
			strCssRule = strCssRule.replace(/\-(\w)/g, function (strMatch, p1){
				return p1.toUpperCase();
			});
			strValue = oElm.currentStyle[strCssRule];
		}
		return strValue;
	}

	function fadeIn(elem, callback ) {
		// no fading for broken browsers
		if ( brokenBrowser ){

			elem.show();
			if ( callback ) callback();

		} else {

			// what an ugly hack
			if ( elem === waitIndicator ) elem.fadeIn( 200, callback );
			else elem.fadeIn( callback );

		}
	}

	function fadeOut(elem, callback ) {
		// no fading for broken browsers
		if ( brokenBrowser ){

			elem.hide();
			if ( callback ) callback();

		} else {

			// what an ugly hack
			if ( elem === waitIndicator ) elem.fadeOut( 200, callback );
			else elem.fadeOut( callback );

		}
	}

	function fadeTo(elem, time, target, callback) {
		// no fading for broken browsers
		if ( brokenBrowser ){

			if (target > 0) elem[0].style.visibility = "visible";
			else  elem[0].style.visibility = "hidden";

			if ( callback ) callback();

		} else {

			elem.fadeTo(time, target, callback);

		}

	}

	// export public funcitons
	this.handlePopupFormInput = handlePopupFormInput;
	this.handlePopupFormLink = handlePopupFormLink;
	this.adjustFrameSize = adjustFrameSize;

}
